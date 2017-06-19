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
		$data['title'] = 'test【e美评官网】';
		$data['cssList'] = array('order.css');
		$data['jsList'] = array();
		$this->load->view('header.html',$data);
		$this->load->view('privative/privative.php');
		$this->load->view('footer.html');
	}

	public function lst()
	{
		$data['title'] = 'test【e美评官网】';
		$data['cssList'] = array('order-list.css');
		$data['jsList'] = array();
		$this->load->view('header.html',$data);
		$this->load->view('privative/order-list.html');
		$this->load->view('footer.html');
	}

	public function detial()
	{
		$data['title'] = 'test【e美评官网】';
		$data['cssList'] = array('order-detial.css');
		$data['jsList'] = array();
		$this->load->view('header.html',$data);
		$this->load->view('privative/order-detial.html');
		$this->load->view('footer.html');
	}
}