<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privative extends CI_Controller
{
	/**
	 * [index description]
	 * @return [type] [description]
	 */
	public function index()
	{
		$data['title'] = 'e订制【e美评官网】';
		$this->load->view('header.html',$data);
		$this->load->view('privative/index');
		$this->load->view('footer.html');
	}

	public function fetch_userinfo_not_login()
	{
		/**///
	}
}