<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Beautycategray extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Beautycategray_Model','B');
		//$this->output->cache(60);
	}

	public function add()
	{
		$data['pid'] = $this->B->get_pid_sort();
		//dump($data);
		unset($data['pid']['ids']);
		$data['title'] = '添加美妆分类';
		$this->load->view('Beautycategray/add.html', $data);
	}

	public function do_add()
	{
		if( $this->B->add_cate() )
		{
			jump('添加成功！',U('Beautycategray/lst',2),2);
		}
		jump($this->B->error,U('Beautycategray/add',2),2);
	}

	public function lst()
	{
		$data['title'] 	= '美妆分类列表';
		$data['data']	= $this->B->get_cate();

		$this->load->view('Beautycategray/lst.html', $data);
	}
	public function del()
	{
		if ( $this->B->del_cate() !== FALSE )
		{
			echoJson(array('status'=>TRUE));
		}
		echoJson(array('status'=>FALSE,'info'=>$this->B->error));
	}

	public function tree()
	{
		dump($this->B->get_pid_sort(), 2);
	}

}