<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model','A');
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

		$result = $this->A->check_login();

		if ( $result )
		{
			jump('登录成功！', U('Index/homepage',2), 2);
		}
		
		jump($this->A->error, U('Index/login',2), 2);
	}

	public function out_login()
	{
		if ( ! $this->session->admin_id )
			jump('你还没有登录！',U('Index/login',2));

		$this->session->unset_userdata('admin_id');
		jump('退出成功！', U('Index/login',2), 1);
	}
}