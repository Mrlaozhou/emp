<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reply extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Reply_model','R');
	}

	/**
	 * [add_reply_do 回复]
	 */
	public function do_replay() 
	{
		$result = $this->R->add_replay();

		echo $result;
	}
}