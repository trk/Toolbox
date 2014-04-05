<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Module Settings
 */
$config['module']['toolbox'] = array
(
    // Module Configs
    'module'                => "Toolbox",
    'name'                  => "Toolbox",
    'description'           => "Ionize Toolbox includes 'reCAPTCHA, PHP QR Code, Minify' Libraries.<br /><b>Version : </b>0.9.-beta<br /><b>Author : </b>İskender TOTOĞLU<br/><b>Company : </b>ALTI VE BIR IT.<br/><b>Website : </b>http://www.altivebir.com.tr",
    'author'                => "İskender TOTOĞLU | ALTI VE BIR IT.",
    'version'               => "0.9.-beta",
    'uri'                   => 'toolbox',
    'has_admin'             => TRUE,
    'has_frontend'          => TRUE,
    'minify_build_dir'      => 'build',
    'minify_development'    => '1',
    'minify_local_compiler' => '0',
    'minify_compress'       => '1',
    'minify_assets_dir'     => 'assets',
    'minify_css_dir'        => 'css',
    'minify_js_dir'         => 'js',
    'recaptcha_public_key'  => '',
    'recaptcha_private_key' => '',
    'recaptcha_theme'       => 'red',   // Set Recaptcha theme, default red (red/white/blackglass/clean)
    'qr_cacheable'          => '1',    // boolean, the default is TRUE
    'qr_cachedir'           => '',      // string, the default is application/cache/
    'qr_errorlog'           => '',      // string, the default is application/logs/
    'qr_quality'            => '1',    // boolean, the default is TRUE
    'qr_size'               => '',      // interger, the default is 1024
    'qr_black'              => '',      // will convert string to array, default is array(255,255,255)
    'qr_white'              => '',      // will convert string to array, default is array(0,0,0)
);

return $config['module']['toolbox'];