<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Index extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function homepage()
	{
		$data['title'] = 'e美评【官网】';
		$this->load->view('header.html',$data);
		$this->load->view('Index/index.html');
		$this->load->view('footer.html');
	}

	public function login() {}
	public function login_do() {}

	public function register() {}
	public function register_do() {}
}