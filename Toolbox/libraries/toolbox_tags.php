<?php

/**
 * Toolbox Module's TagManager
 *
 * @author  : İskender TOTOĞLU | Altı ve Bir Bilişim Teknolojileri | http://www.altivebir.com.tr
 */
class Toolbox_Tags extends TagManager {

    /**
     * Tags declaration
     * To be available, each tag must be declared in this static array.
     *
     * @var array
     *
     * @usage	<ion:toolbox:tag... />
     *
     */
    public static $tag_definitions = array
    (
        'toolbox:minify'        => 'tag_minify',
        'toolbox:qrcode'        => 'tag_qrcode',
        'toolbox:recaptcha'     => 'tag_recaptcha'
    );

    // ------------------------------------------------------------------------

    /**
     * Base module tag
     *
     * @usage	<ion:toolbox />
     *
     */
    public static function index(FTL_Binding $tag)
    {
        $str = $tag->expand();
        return $str;
    }

    // ------------------------------------------------------------------------

    /**
     * Minify Tag
     *
     * !NOTE : Filenames and output filenames not need extention, write filenames without extentions..
     *
     * @usage   <ion:toolbox:minify type="css|js" files="files, you, want, to, minify, with, file, extention" output_name="your_output_file_name" />
     *
     * @param FTL_Binding $tag
     * @return mixed
     */
    public static function tag_minify(FTL_Binding $tag) {

        $type           = $tag->getAttribute('type', NULL);
        $files          = $tag->getAttribute('files', NULL);
        $outputName     = $tag->getAttribute('output', 'template');
        $url            = ((strtoupper($tag->getAttribute('url', FALSE)) != TRUE) ? FALSE : TRUE);

        if( ! is_null($type) && ($type == 'css' || $type == 'js') && ! is_null($files) )
        {

            // Get Files as Array
            $files = explode(',', str_replace(', ', ',', $files));

            // Get Module Configs
            $moduleConfigs = Modules()->get_module_config("toolbox");

            $assets_dir     = ($moduleConfigs['minify_assets_dir'] != '') ? Theme::get_theme_path() . $moduleConfigs['minify_assets_dir'] . DIRECTORY_SEPARATOR : '';
            $assets_path    = DOCPATH . $assets_dir;
            $build_dir      = ($moduleConfigs['minify_build_dir'] != '') ? $moduleConfigs['minify_build_dir'] . DIRECTORY_SEPARATOR : '';
            $js_dir         = ($moduleConfigs['minify_js_dir'] != '') ? $moduleConfigs['minify_js_dir'] . DIRECTORY_SEPARATOR : '';
            $js_path        = $assets_path . $js_dir;
            $js_build_dir   = ($moduleConfigs['minify_js_dir'] != '') ? $moduleConfigs['minify_js_dir'] . DIRECTORY_SEPARATOR . $build_dir : $js_dir;
            $js_build_path  = $js_path . $build_dir;
            $css_dir        = ($moduleConfigs['minify_css_dir'] != '') ? $moduleConfigs['minify_css_dir'] . DIRECTORY_SEPARATOR : $assets_dir;
            $css_path       = $assets_path . $css_dir;
            $css_build_dir  = ($moduleConfigs['minify_css_dir'] != '') ? $moduleConfigs['minify_css_dir'] . DIRECTORY_SEPARATOR . $build_dir : $css_dir;
            $css_build_path = $css_path . $build_dir;

            unset($configs);

            // Set Module Configs to Array
            $configs = array(
                'development' => ($moduleConfigs['minify_development'] == '1') ? TRUE : FALSE,
                'compress' => ($moduleConfigs['minify_compress'] == '1') ? TRUE : FALSE,
                'local_compiler' => ($moduleConfigs['minify_local_compiler'] == '1') ? TRUE : FALSE,
                'assets_dir' => $assets_dir,
                'assets_path' => $assets_path,
                'js_dir' => $js_dir,
                'js_path' => $js_path,
                'js_build_dir' => $js_build_dir,
                'js_build_path' => $js_build_path,
                'css_dir' => $css_dir,
                'css_path' => $css_path,
                'css_build_dir' => $css_build_dir,
                'css_build_path' => $css_build_path,
                'type' => $type,
                'files' => $files,
                'output' => $outputName . '.' . $type,
                'output_min' => $outputName . '.min.' . $type,
                'url' => $url
            );

            // Load Toolbox Model
            self::load_model('toolbox_model', '');

            // Check Files Log Missing files
            $configs = self::$ci->toolbox_model->check_files($configs, $type);

            /**
             * Compare file timestamps
             *
             * Return Changed Files
             *
             * @TODO Change "$configs['output_min']" minified file with normal file, compare not compressed files and compare
             */
            $compare_files = self::$ci->toolbox_model->check_filetime($configs[$type . '_build_path'], $files, $configs[$type . '_path'] . $configs['output_min']);

            log_message('ERROR', '#compare_files :: ' . print_r($compare_files, TRUE));

            if( $type == 'js' && ! empty($configs['files']) )
            {
                if( $configs['development'] != TRUE && ! empty($compare_files) && $configs['compress'] == TRUE && $configs['local_compiler'] == TRUE && self::$ci->toolbox_model->_check_local_compiler() )
                {
                    log_message('ERROR', 'JS:STEP::1');
                    return self::$ci->toolbox_model->local_closure_compiler($configs);
                }
                elseif( $configs['development'] != TRUE && ! empty($compare_files) && $configs['compress'] == TRUE && $configs['local_compiler'] == FALSE )
                {
                    log_message('ERROR', 'JS:STEP::2');
                    return self::$ci->toolbox_model->minify_js($configs);
                }
                elseif( $configs['development'] != TRUE && empty($compare_files) && file_exists($configs['js_path'] . $configs['output']) )
                {
                    log_message('ERROR', 'JS:STEP::3');
                    return self::$ci->toolbox_model->_script_tag($configs['assets_dir'] . $configs['js_dir'], $configs['output'], $configs['url']);
                }
                else
                {
                    log_message('ERROR', 'JS:STEP::4');
                    return self::$ci->toolbox_model->minify_js($configs, FALSE);
                }

            }
            if( $type == 'css' )
            {
                if(  $configs['development'] != TRUE && ! empty($compare_files) && $configs['compress'] == TRUE )
                {
                    log_message('ERROR', 'CSS:STEP::1');
                    return self::$ci->toolbox_model->minify_css($configs);
                }
                else
                {
                    log_message('ERROR', 'CSS:STEP::2');
                    return self::$ci->toolbox_model->minify_css($configs, FALSE);
                }
            }

            return self::show_tag_error($tag, 'You need to define file name or file names. Ex.: "files="my_css|my_other_css" or files="my_js|my_other_js".');

        }

        return self::show_tag_error($tag, 'Type is NULL or Type has wrong value. Available values "type="css" or type="js"."');

    }

    // ------------------------------------------------------------------------

    /**
     * @usage   <ion:toolbox:qrcode />
     *
     * @param FTL_Binding $tag
     * @return mixed
     */
    public static function tag_qrcode(FTL_Binding $tag) {

        $parent         = $tag->getAttribute('parent', FALSE);
        $data           = $tag->getAttribute('data', NULL);
        $level          = $tag->getAttribute('level', NULL);
        $size           = $tag->getAttribute('size', NULL);


        /**
         * If "Recaptcha" Class not Loaded, Load "Recaptcha" Class
         */
        if ( ! class_exists('ciqrcode') )
        {
            $config = array(
                'qr_file_path'      => 'files' . DIRECTORY_SEPARATOR . '.qrcode' . DIRECTORY_SEPARATOR,
                'qr_libraries_path'    => MODPATH . 'Toolbox' . DIRECTORY_SEPARATOR . 'libraries' . DIRECTORY_SEPARATOR,
                'cachedir'  => 'files' . DIRECTORY_SEPARATOR . '.qrcode' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR,
                'errorlog' => 'files' . DIRECTORY_SEPARATOR . '.qrcode' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR,
            );

            self::_check_qr_folder($config);

            self::$ci->load->library('ciqrcode', $config);
        }

        $getParent = $tag->get($parent);

        $qrData = '';

        if( ! empty($getParent) )
        {
            $data = explode('|', $data);
            // trace($tag->get('article'));
            foreach($data as $key => $value) {
                (( ! empty($getParent[$value]) ) ? $qrData .= $getParent[$value] . "\n" : '');
                log_message('ERROR', '#value :: ' . $value);
            }


        }

        $params['data']     = $qrData;
        $params['level']    = $level; // L - M - Q - H
        $params['size']     = $size; // 1 - 2 - 3 - 4 - 5 - 6 - 7 - 8 - 9 - 10

        $qrcode_file_path = 'files' . DIRECTORY_SEPARATOR . '.qrcode' . DIRECTORY_SEPARATOR;

        if( ! file_exists(DOCPATH . $qrcode_file_path) )
            @mkdir(DOCPATH . $qrcode_file_path, 0777);

        $params['savename'] = DOCPATH . $qrcode_file_path . 'test.png';

        self::$ci->ciqrcode->generate($params);

        return '<img src="' . base_url() . $qrcode_file_path . 'test.png" />';
    }

    // ------------------------------------------------------------------------

    function _check_qr_folder($params=array()) {

        /**
         * Check Folders Exist, If not create folders
         */
        if( ! file_exists(DOCPATH . $params['qr_file_path']) )
            @mkdir(DOCPATH . $params['qr_file_path'], 0777);

        if( ! file_exists(DOCPATH . $params['cachedir']) )
            @mkdir(DOCPATH . $params['cachedir'], 0777);

        if( ! file_exists(DOCPATH . $params['errorlog']) )
            @mkdir(DOCPATH . $params['errorlog'], 0777);

        return;
    }

    // ------------------------------------------------------------------------

    /**
     * @usage   <ion:toolbox:recaptcha />
     *
     * @param FTL_Binding $tag
     * @return mixed
     */
    public static function tag_recaptcha(FTL_Binding $tag) {

        /**
         * If "Recaptcha" Class not Loaded, Load "Recaptcha" Class
         */
        if ( ! class_exists('recaptcha') )
        {
            self::$ci->load->library('recaptcha');
        }

        return self::$ci->recaptcha->recaptcha_get_html();
    }
}
