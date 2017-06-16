<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Hosanddoc extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model( 'Hosanddoc_Model', 'hd' );
	}

	public function index()
	{
		dump($this->hd->get_all('hospital'),2);
	}

	public function hos_list()
	{
		//接收分页参数
		$config = $this->input->get(array('p'));

		//页数
		$p = $config ? (int)$config['p'] : 1;

		//获取医院信息
		$hospital = $this->hd->hos_list( $p );
		dump($hospital,2);
	}

	public function hos_info() 
	{
		//接收ID
		$config = $this->input->get( array('id') );

		//获取数据
		$info = $this->hd->hos_info($config);
	}

	public function doc_info() 
	{
		//接受ID
		$config = $this->input->get( array('id') );

		//获取数据
		$info = $this->hd->doc_info( $config );

		dump($info);
	}

	public function get_province()
	{
		
	}
}