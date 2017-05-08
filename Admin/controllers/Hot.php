<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Hot extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Hot_Model','H');
	}

	public function add()
	{
		$data['title'] = '添加Hot';
		$this->load->view( 'Hot/add.html', $data );
	}

	public function do_add()
	{
		// dump($_FILES);
		$result = $this->H->add_hot();
		if ( $result )
		{
			jump( '添加成功！', U('Hot/add',2), 2 );
		}
		// dump($this->H->error);
		jump( $this->H->error, U('Hot/add',2), 2 );
	}

	public function lst()
	{
		//提取数据
		$data['data'] = $this->H->get_hot(  )->result_array();
		$data['title'] = 'Hot列表';
		// dump($data);
		$this->load->view('Hot/lst.html',$data);
	}

	public function del()
	{
		//接收参数
		if ( $data = $this->input->post(array('id')) )
		{
			$result = $this->H->del_hot( $data );
			if ( $result !== FALSE )
				echoJson(array('status'=>TRUE));
			echoJson(array('status'=>FALSE,'info'=>$this->H->error));
		}
		else
		{
			echoJson(array('status'=>FALSE));
		}
	}
}