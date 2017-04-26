<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Comment_model','C');
	}

	/**
	 * [index 主页显示话题列表]
	 * @return [type] [description]
	 */
	public function index()
	{

		dump($this->C->all());
	}

	/**
	 * [show_comment 显示话题专栏页面]
	 */
	public function show_comment() 
	{
		$this->show();
	}

	/**
	 * [do_comment 发表评论]
	 */
	public function do_comment() 
	{
		$result = $this->C->add_comment();
		if( $result )
		{
			echo 'Ok';
		}
		else
		{
			echo 'Bad';
		}
	}

	/**
	 * [nice_incre description]
	 * @return [type] [description]
	 */
	public function nice_incre() 
	{
		$result = $this->set_nice_incre();
		if ( $result )
		{
			echo 'Ok';
		}
		else
		{
			echo 'No';
		}
	}

	/**
	 * [bad_incre description]
	 * @return [type] [description]
	 */
	public function bad_incre() 
	{
		$result = $this->set_bad_incre();
		if ( $result )
		{
			echo 'Ok';
		}
		else
		{
			echo 'No';
		}
	}
}