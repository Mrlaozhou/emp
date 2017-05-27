<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Topic extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Topic_Model','T');
	}

	public function add() 
	{
		//提取分类信息
		$data['cate'] = $this->T->get_cate()->result_array();
		
		$data['title'] = '添加话题';
		$this->load->view( 'Topic/add.html', $data );
	}

	public function do_add() 
	{
		if ( ! $this->T->add_topic() )
			jump( $this->T->error, U('Topic/add', 2), 2 );
			//dump($this->T->error);
		jump( '添加成功！', U('Topic/lst', 2), 2 );
	}

	public function lst() 
	{
		$data['title'] = '话题列表';
		$data['data']  = $this->T->get_topic()->result_array();

		$this->load->view( 'Topic/lst.html', $data );
	}

	public function del()
	{
		if ( ! $this->T->del_topic() )
			echoJson(array('status'=>FALSE));
		echoJson(array('status'=>TRUE));
	}

	public function save()
	{
		$data['title'] = '修改话题';
		//提取分类信息
		$data['cate'] = $this->T->get_cate()->result_array();
		//提取此条信息
		$data['info'] = $this->T->get_info();

		$this->load->view( 'Topic/save.html', $data );
	}

	public function do_save()
	{
		//接受参数
		$data = $this->input->post();
		
		if ( ! $this->T->save_topic( $data ) )
			jump( $this->T->error, U('Topic/save?id='.$data['id'],2), 2 );
		jump( '修改成功！', U('Topic/lst',2), 2 );
	}

}