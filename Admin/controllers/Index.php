<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function homepage()
	{
		$data['title'] = '主页';
		$this->load->view('Index/homepage.html',$data);
	}

	public function login()
	{
		$data['title'] = '登录';
		$this->load->view('Index/login.html',$data);
	}

	public function do_login()
	{
		
	}
}