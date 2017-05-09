<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Beauty extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function lst() {}



	public function add() {}

	public function do_add() {}



	public function categray_lst() 
	{
		$data['title'] = '添加美妆分类';
		$this->load->view('Beauty/categray_lst.html',$data);
	}

}