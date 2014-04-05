<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Toolbox model
 *
 * The model that handles actions
 *
 * @author	@author	İskender TOTOĞLU | Altı ve Bir Bilişim Teknolojileri | http://www.altivebir.com.tr
 */
class Toolbox_model extends Base_model
{
	/**
	 * Model Constructor
	 *
	 * @access	public
	 */
	public function __construct()
	{
		parent::__construct();
	}

    // ------------------------------------------------------------------------

    /**
     * Minify JS Files by using Online Google Closure compiler
     *
     * @param $configs
     * @param bool $compile
     * @return string
     */
    function minify_js($configs, $compile=TRUE)
    {

        $file_merge = self::_merge_files($configs);

        if( $file_merge != '' && file_exists($file_merge) && $compile == TRUE )
        {
            $handle   = fopen($file_merge, "r");
            $contents = fread($handle, filesize($file_merge));
            fclose($handle);

            $ch = curl_init('http://closure-compiler.appspot.com/compile');

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'output_info=compiled_code&output_format=text&compilation_level=SIMPLE_OPTIMIZATIONS&js_code=' . urlencode($contents));
            $output = curl_exec($ch);
            curl_close($ch);

            // Remove Old File
            if( file_exists($configs['js_path'] . $configs['output_min']) )
                @unlink($configs['js_path'] . $configs['output_min']);

            $file_compressed = $configs['js_path'] . $configs['output_min'];

            $fh = fopen($file_compressed, 'a');
            fwrite($fh, $output);
            fclose($fh);

            if( file_exists($configs['js_path'] . $configs['output_min']) )
            {
                return self::_script_tag($configs['assets_dir'] . $configs['js_dir'], $configs['output_min'], $configs['url']);
            }
            else
            {
                log_message('ERROR', "File could not compiled, merged file link created !");
                return self::_script_tag($configs['assets_dir'] . $configs['js_dir'], $configs['output'], $configs['url']);
            }
        }
        elseif($file_merge != '' && file_exists($file_merge) && $compile != TRUE)
        {
            return self::_script_tag($configs['assets_dir'] . $configs['js_dir'], $configs['output'], $configs['url']);
        }
        else
        {
            log_message('ERROR', 'Files could not merge, script tag for each file returned !');

            $script_tags = '';

            foreach($configs['files'] as $key => $file)
            {
                $script_tags .= self::_script_tag($configs['assets_dir'] . $configs['js_build_dir'], $file, $configs['url']);
            }

            return $script_tags;
        }
    }



    // ------------------------------------------------------------------------

    /**
     * Minify CSS Files by using Local cssmin v3 Compiler
     *
     * @param $configs
     * @param bool $compile
     * @return string
     */
    function minify_css($configs, $compile = TRUE)
    {
        $file_merge = self::_merge_files($configs);

        $this->load->helper('html');

        if( $file_merge != '' && $compile == TRUE && file_exists($file_merge) )
        {

            $file_compressed = $configs['css_path'] . $configs['output_min'];

            $handle   = fopen($file_merge, 'r');
            $contents = fread($handle, filesize($file_merge));
            fclose($handle);

            include_once(MODPATH . 'Toolbox' . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'cssmin-v3.0.1.php');

            $contents = CssMin::minify($contents);

            $handle   = fopen($file_compressed, 'w');
            fwrite($handle, $contents);
            fclose($handle);

            if( file_exists($configs['css_path'] . $configs['output_min']) )
            {
                return link_tag($configs['assets_dir'] . $configs['css_dir'] . $configs['output_min']);
            }
            else
            {
                log_message('ERROR', "File could not compiled, merged file link created !");

                return link_tag($configs['assets_dir'] . $configs['css_dir'] . $configs['output']);
            }
        }
        elseif ( $file_merge != '' && $compile != TRUE && file_exists($file_merge))
        {
            return link_tag($configs['assets_dir'] . $configs['css_dir'] . $configs['output']);
        }
        else
        {
            log_message('ERROR', 'Files could not merge, script tag for each file returned !');

            $link_tags = '';

            foreach($configs['files'] as $key => $file)
            {
                $link_tags .= link_tag($configs['assets_dir'] . $configs['css_build_dir'] . $file);
            }

            return $link_tags;
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Minify JS Files by using local Google Closure compiler
     *
     * @param array $configs
     * @return bool|string
     */
    function local_closure_compiler($configs)
    {

        $file_merge = self::_merge_files($configs);

        if( $file_merge != '' && file_exists($file_merge) )
        {
            if ( ! class_exists('closurecompiler') )
            {
                $this->load->library('closurecompiler');
            }

            $this->closurecompiler->setSourceBaseDir($configs['js_path']);
            $this->closurecompiler->setTargetBaseDir($configs['assets_path'] . $configs['js_dir']);
            $this->closurecompiler->setSourceFiles(array($configs['output']));
            $this->closurecompiler->setTargetFile($configs['output_min']);

            if($this->closurecompiler->compile() || file_exists($configs['js_path'] . $configs['output_min']) )
                return self::_script_tag($configs['assets_dir'] . $configs['js_dir'], $configs['output_min'], $configs['url']);
            else
            {
                log_message('ERROR', "Can't compile files, output file not created (Local JS Compiler) :: " . $configs['js_path'] . $configs['output_min']);
                return self::minify_js($configs, FALSE);

            }
        }
        else
        {
            log_message('ERROR', "Can't compile files, output file not created (Local JS Compiler) :: " . $configs['js_path'] . $configs['output_min']);
            return self::minify_js($configs, FALSE);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Generete Script Tag
     *
     * @param $path
     * @param $file
     * @param bool $url
     * @return string
     */
    function _script_tag($path, $file, $url=FALSE)
    {
        if($url == FALSE)
            $script_tag = "<script type=\"text/javascript\" src=\"" . base_url() . $path . $file . "\"></script>";
        else
            $script_tag = base_url() . $path . $file;

        return $script_tag;
    }

    // ------------------------------------------------------------------------

    /**
     * Merge Files
     *
     * @param $configs
     * @return string return merged file
     */
    private function _merge_files($configs)
    {
        $file_merged    = $configs[$configs['type'] . '_path'] . $configs['output'];

        // Remove Old File
        if( file_exists($file_merged) )
            @unlink($file_merged);

        if ( is_writable($configs[$configs['type'] . '_path']) )
        {
            foreach ($configs['files'] as $file)
            {
                $file_path      = $configs[$configs['type'] . '_build_path'] . $file;

                if (file_exists($file_path))
                {
                    $handle   = fopen($file_path, "r");
                    $contents = fread($handle, filesize($file_path));
                    fclose($handle);

                    $fh = fopen($file_merged, 'a');
                    fwrite($fh, $contents);
                    fclose($fh);
                }
                else
                {
                    log_message('ERROR', $file_path . 'File not exist !');
                }
            }

            return $file_merged;
        }
        else
        {
            log_message('ERROR', $configs[$configs['type'] . '_path'] . ' not writable !');
        }

        return '';
    }

    // ------------------------------------------------------------------------

    /**
     * Check files, if not exist remove file from list and set a log message for missing file
     *
     * @param array $configs
     * @param null $type
     * @return array
     */
    function check_files($configs=array(), $type=NULL)
    {
        if( ! empty($configs['files']) && ! is_null($type) )
        {
            $files = array();

            foreach($configs['files'] as $key => $file)
            {
                if( ! file_exists($configs[$type . '_build_path'] . $file) )
                    log_message('ERROR', 'Toolbox::Minify - File Not Exist :: ' . $configs[$type . '_build_path'] . $file);
                else
                    $files[] = $file;
            }

            $configs['files'] = $files;
        }

        return $configs;
    }

    // ------------------------------------------------------------------------

    /**
     * Compare Files timestamp with compressed file if exist
     *
     * @param $path
     * @param $files
     * @param $_file
     * @return array
     */
    function check_filetime($path, $files, $_file)
    {
        $_files = array();

        // Does the output file exist?  if so, check the timestamp, if not minify the scripts
        if( file_exists($_file) )
        {
            $minified_filemtime = filemtime($_file);
        }
        else
        {
            $minified_filemtime = 0;
        }

        // Loop through the files and see if any of them have been updated since our output file has
        foreach($files as $file)
        {
            if(file_exists($path . $file))
            {
                if( filemtime($path . $file) > $minified_filemtime )
                {
                    $_files[] = $file;
                }
            }
        }

        return $_files;
    }

    // ------------------------------------------------------------------------

    /**
     * Check Local Compiler File !
     */
    function _check_local_compiler()
    {
        $compiler_path = MODPATH . 'Toolbox' . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR . 'closure' . DIRECTORY_SEPARATOR;

        if( file_exists($compiler_path . 'compiler.jar'))
            return TRUE;

        log_message('ERROR', 'Local compiler file not exist, please download compiler file and copy downloaded file to "' . $compiler_path . '" and rename file "compiler.jar"');

        return FALSE;
    }

}