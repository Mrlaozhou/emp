<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Topiccategray extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Topiccategray_Model','TC');
	}

	public function lst() 
	{
		$data['title'] = '话题分类列表';
		$data['data']	= $this->TC->get_cate()->result_array();
		
		$this->load->view('Topiccategray/lst.html', $data);
	}

	public function add() 
	{
		$data['title'] = '添加话题分类';
		$this->load->view('Topiccategray/add.html', $data);
	}

	public function do_add()
	{
		if ( ! $this->TC->add_cate() )
			jump($this->TC->error, U('Topiccategray/add',2));
		jump('添加成功！', U('Topiccategray/lst',2));
	}

	public function del()
	{
		if ( ! $this->TC->del_cate() )
			echoJSon( array('status'=>FALSE, 'info'=>'删除失败！') );
		echoJson( array('status'=>TRUE, 'info'=>'删除成功!') );
	}
}