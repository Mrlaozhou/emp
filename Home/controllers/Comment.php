<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Comment_model','C');
	}

	/**
	 * [index 主页显示话题分离、话题 列表]
	 * @return [type] [description]
	 */
	public function index()
	{
		$data['title'] = 'e美评【e美评官网】';
		$data['cssList'] = array('discuss.css');
		$data['jsList'] = array('common.js');
		$this->load->view('header.html',$data);
		$this->load->view('Comment/discuss.html');
		$this->load->view('footer.html');
	}
	
	/**
	 * [current 话题列表页]
	 * @return [type] [description]
	 */
	public function lst()
	{
		$data['title'] = '时尚潮流_e美评【e美评官网】';
		$data['cssList'] = array('current.css');
		$data['jsList'] = array();
		$this->load->view('header.html',$data);
		$this->load->view('Comment/lst.html');
		$this->load->view('footer.html');
	}

	/**
	 * [current 话题详情页]
	 * @return [type] [description]
	 */
	public function detial()
	{
		//接受ID
		$config = $this->input->get(array('id'));
		$return = $this->C->get_CR( $config );
		$data['CR']			= $return['result'];
		$data['tid']		= $return['tid'];
		$data['uid']		= $this->session->home_id;
		$data['title'] 		= '详情_时尚潮流_e美评【e美评官网】';
		$data['cssList'] 	= array('fashion-detail.css');
		$data['jsList'] 	= array();
		
		// dump($data);
		$this->load->view('header.html',$data);
		$this->load->view('Comment/detail.html');
		$this->load->view('footer.html');
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
		if( ! $this->session->home_id )
			echoJson(array('status'=>FALSE,'remark'=>'请先登录!'));
		
		$result = $this->C->add_comment();
		if( $result )
		{
			echoJson(array('status'=>TRUE,'info'=>$result));
		}
		else
		{
			echoJson(array('status'=>FALSE,'remark'=>$this->C->error));
		}
	}

	/**
	 * [nice_incre description]
	 * @return [type] [description]
	 */
	public function nice() 
	{
		$result = $this->C->set_nice_incre();
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
	public function bad() 
	{
		$result = $this->C->set_bad_incre();
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