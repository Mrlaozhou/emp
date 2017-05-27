<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model( 'User_model','U' );
	}

	public function show_login()
	{
		$data['title'] = '登录【e美评官网】';
		$data['cssList'] = array('general.css');
		$data['jsList'] = array();

		$this->load->view('Login/login.html',$data);
	}

	public function do_login()
	{
		if ( ! $this->U->login() )
			jump($this->U->error,U('Login/show_login'),2);
		jump('登录成功！',U(),2);
	}

	public function out_login()
	{
		//摧毁
		$this->session->unset_userdata('home_id');
		jump('退出成功！',U(),2);
	}
}