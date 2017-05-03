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
		$this->show('Register/register.html',$data);
	}

	public function do_register()
	{
		
	}
}