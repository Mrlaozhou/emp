<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LZ_Controller extends CI_Controller
{
	public static $_c 			= null;
	public static $_m 			= null;
	public static $_templates 	= null;

	public function __construct()
	{
		parent::__construct();
	}


	public function show( $templates = null )
	{
		//判断是否默认
		if( $templates === null )
		{
			$this->_get_templates();

			if( file_exists(VIEWPATH.self::$_m.'.html') )
			{
				//在views下一及目录
				$templates = self::$_m.'.html';
			}
			elseif( file_exists(VIEWPATH.self::$_templates.'.html') )
			{
				$templates = self::$_templates.'.html';
			}
			else
			{
				return FALSE;			
			}
			
		}

		//判断文件是否存在


		$this->load->view('header.html');
		$this->load->view($templates);
		$this->load->view('footer.html');
	}

	public function _get_templates()
	{
		$uri = $this->uri->segments;
		self::$_c = ucwords(trim($uri[1]));
		self::$_m = trim($uri[2]);
		self::$_templates = self::$_c.'\\'.self::$_m;
		return;
	}
}