<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Toolbox MODULE ADMIN CONTROLLER
 *
 * @author  : İskender TOTOĞLU | Altı ve Bir Bilişim Teknolojileri | http://www.altivebir.com.tr
 */
class Toolbox extends Module_Admin
{
    /**
     * Controller URL
     *
     * @var string (with admin url)
     */
    protected $controller_url;

    /**
     * Controller View Folder
     *
     * @var string
     */
    protected $controller_folder = 'admin/toolbox/';

    /**
     * Constructor
     *
     * @access	public
     * @return	void
     */
    public function construct()
    {
        // Set Controller URL
        $this->controller_url = admin_url() . 'module/toolbox/toolbox/';
    }

    // ------------------------------------------------------------------------

    /**
     * Index of Toolbox module
     */
    public function index()
    {

        if(Authority::can('access', 'module/toolbox/admin'))
        {
            $this->template['toolbox'] = Modules()->get_module_config("toolbox");

            $this->output($this->controller_folder . 'index');
        }
        else
        {
            self::_alert('danger', FALSE, lang('module_toolbox_permission_access'));
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Save items to config file
     */
    function save()
    {
        if(Authority::can('access', 'module/toolbox/admin'))
        {
            // Posted Config Items
            $posted_configs = $this->input->post();

            $this->load->model('config_model', '');

            $moduleConfigs = Modules()->get_module_config("toolbox");

            /**
             * Set boolean keys
             */
            $config = array(
                'minify' => array('minify_development', 'minify_compress', 'minify_local_compiler'),
                'qrcode' => array('qr_cacheable', 'qr_quality'),
                'recaptcha' => array(),
            );

            /**
             * Set boolean value
             * If key undefined set default value to '0'
             */
            if( ! empty($config[$posted_configs['form']]) )
                foreach($config[$posted_configs['form']] as $key => $value)
                    if( empty($posted_configs[$value]))
                        $posted_configs[$value] = '0';

            /**
             * Set Config Values
             */
            foreach($posted_configs as $key => $value)
                if ( isset($moduleConfigs[$key]) )
                    if ($this->config_model->change('config.php', $key, $value, 'toolbox') == FALSE)
                        $this->error(lang('ionize_message_error_writing_ionize_file'));

            // UI panel to update after saving
            $this->update[] = array(
                'element' => 'mainPanel',
                'url' => $this->controller_url . 'index'
            );

            $this->success(lang('ionize_message_settings_saved'));
        }
        else
        {
            self::_alert('danger', FALSE, lang('module_toolbox_permission_access'));
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Get Alert View
     *
     * @param bool $type types :: success,danger,warning,info
     * @param bool $title
     * @param bool $text
     */
    function _alert($type = FALSE, $title = FALSE, $text = FALSE)
    {
        $this->template['type'] = (($title != FALSE) ? $type : 'danger');
        $this->template['title'] = (($title != FALSE) ? '<h4>' . $title . '</h4>' : '');
        $this->template['text'] = (($text != FALSE) ? '<p>' . $text . '</p>' : '');

        $this->output($this->controller_folder . 'alert');
    }
}