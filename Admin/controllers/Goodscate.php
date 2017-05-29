<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Goodscate extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Goodscate_Model','GC');
	}

	public function add()
	{
		$pids = $this->GC->get_pid_sort();
		unset($pids['ids']);
		// dump($pids);
		$data['title'] 	= "添加商品分类";
		$data['pids']	= $pids;
		$this->load->view( 'Goodscate/add.html', $data );
	}

	public function do_add()
	{
		if( ! $this->GC->add_cate() )
			dump($this->GC->error);
		jump('添加成功！', U('Goodscate/lst',2), 2);
	}

	public function lst()
	{
		$cates = $this->GC->get_cate();
		$data['title'] 	= '商品分类列表';
		$data['data']	= $cates;	
		$this->load->view( 'Goodscate/lst.html', $data );
	}

	public function del()
	{
		if( ! $this->GC->del_cate() )
			echoJson(array('status'=>TRUE,'info'=>$this->GC->error));
		echoJson(array('status'=>TRUE));
	}
}