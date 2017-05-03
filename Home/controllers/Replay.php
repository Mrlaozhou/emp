<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Replay extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Replay_model','R');
	}

	/**
	 * [add_reply_do 回复]
	 */
	public function do_replay() 
	{
		$result = $this->R->add_replay();

		echo $result;
	}

	/**
	 * [nice_incre description]
	 * @return [type] [description]
	 */
	public function nice()
	{
		$result = $this->R->set_nice_incre();

		if( $result )
		{
			echo 'ok';
		}
	}

	/**
	 * [bad_incre description]
	 * @return [type] [description]
	 */
	public function bad()
	{
		$result = $this->R->set_bad_incre();

		if( $result )
		{

		}
	}
}