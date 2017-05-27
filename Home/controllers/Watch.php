<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Watch extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->output->cache(30);
	}
	
	public function index()
	{
		$data['title'] = 'e直播【e美评官网】';
		$data['cssList'] = array('live.css');
		$data['jsList'] = array();
		$this->load->view('header.html',$data);
		$this->load->view('Watch/live.html');
		$this->load->view('footer.html');
	}

	public function lst()
	{
		$data['title'] = 'e直播_e美评';
		$data['cssList'] = array('live-list.css');
		$data['jsList'] = array();
		$this->load->view('header.html',$data);
		$this->load->view('Watch/live-list.html');
		$this->load->view('footer.html');
	}
}
