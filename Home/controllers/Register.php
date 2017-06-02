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
			jump($this->U->error,U('Register/show_register.html'));
		jump('注册成功！','/');
	}

	public function register()
	{
		$this->load->view( 'Register/register.html' );
	}

	public function mb_register()
	{
		$this->load->view( 'Register/register-tel.html' );
	}

	public function mail_register()
	{
		$this->load->view( 'Register/register-mail.html' );
	}
}