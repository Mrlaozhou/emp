<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		$data['title'] = 'Test';
		$this->show('Test/index.html',$data);
	}
}