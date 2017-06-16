<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['title'] = 'e保障_e美评【官网】';
		$data['cssList'] = array('butler.css');
		$data['jsList'] = array();
		$this->load->view('header.html',$data);
		$this->load->view('Manager/index.html');
		$this->load->view('footer.html');
	}

	/**
	 * [esafe e保障]
	 * @return [type] [description]
	 */
	public function esafe() 
	{
		$data['title'] = 'e保障_e美评【官网】';
		$data['cssList'] = array('guarantee.css');
		$data['jsList'] = array();
		$this->load->view('header.html',$data);
		$this->load->view('Manager/esafe.html');
		$this->load->view('footer.html');
	}

	/**
	 * [ehelper e保姆]
	 * @return [type] [description]
	 */
	public function ehelper() 
	{
		$data['title'] = 'e助手_e美评【官网】';
		$data['cssList'] = array('index.css');
		$data['jsList'] = array();
		$this->load->view('header.html',$data);
		$this->load->view('Index/index.html');
		$this->load->view('footer.html');
	}
}
