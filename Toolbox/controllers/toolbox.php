<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Recaptcha MODULE Front CONTROLLER
 *
 * @author  : İskender TOTOĞLU | Altı ve Bir Bilişim Teknolojileri | http://www.altivebir.com.tr
 */
class Toolbox extends My_Module
{

	// ------------------------------------------------------------------------


	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}


	// ------------------------------------------------------------------------

    /**
     * Index of Controller
     *
     * Show Module Title
     */
    function index()
	{
		echo 'Toolkit Module';
	}
}