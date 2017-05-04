<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model','U');
	}

	public function show_register()
	{
		$data['title'] = '注册【e美评官网】';
		$data['cssList'] = array('general.css');
		$data['jsList'] = array();
		$this->show('Register/register.html',$data);
	}

	public function do_register()
	{
		//注册
		if( ! $this->U->register() )
			jump(validation_errors(),U('Register/show_register.html'));
		jump('注册成功！','/');
	}

	public function show_login()
	{
		$data['title'] = '登录【e美评官网】';
		$data['cssList'] = array('general.css');
		$data['jsList'] = array();

		$this->show('Login/login.html',$data);
	}

	public function do_login()
	{
		$this->U->login();
	}
}