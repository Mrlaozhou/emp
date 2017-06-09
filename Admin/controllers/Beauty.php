<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Beauty extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function lst() 
	{
		$data['title'] = '美妆列表';
		$this->load->view('Beauty/lst.html',$data);
	}



	public function add() 
	{
		$data['title'] = '添加美妆';
		$this->load->view('Beauty/add.html',$data);
	}

	public function do_add() {}



	public function categray_lst() 
	{
		$data['title'] = '添加美妆分类';
		$this->load->view('Beauty/categray_lst.html',$data);
	}

}