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
		$data['cssList'] = array('login.css');
		$data['jsList'] = array();

		$this->load->view('Login/login.html',$data);
	}

	public function do_login()
	{
		if ( ! $this->U->login() )
			echoJson( array('status'=>FALSE,'error'=>$this->U->error) );
		echoJson( array('status'=>TRUE) );
	}

	public function out_login()
	{
		//摧毁
		$this->session->unset_userdata('home_id');
		$this->session->unset_userdata('home_username');
		jump('退出成功！',U(),2);
	}
}