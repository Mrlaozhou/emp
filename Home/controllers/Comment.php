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
	public function show_comment() {}

	/**
	 * [do_comment 发表评论]
	 */
	public function do_comment() {}
}