<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Partner extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model( 'Partner_Model', 'P' );
	}

	public function add() 
	{
		$data['title'] = '添加合作商';
		$this->load->view( 'Partner/add.html',$data );
	}

	public function do_add() 
	{
		if( ! $this->P->add_partner() )
			jump( $this->P->error, U('Partner/add',2), 2 );
		jump( '添加成功！', U('Partner/lst',2), 2 );
	}

	public function lst() 
	{
		$data['title'] = '合作商列表';
		$data['data']  = $this->P->get_partner();
		$this->load->view( 'Partner/lst.html', $data );
	}

	public function del() 
	{
		if( ! $this->P->del_partner() )
			echoJson(array('status'=>FALSE,'info'=>$this->P->error));
		echoJson(array('status'=>TRUE));
	}

	public function save() 
	{
		$config = $this->input->get();
		$data['title'] = '修改赞助商信息';
		$data['info']  = $this->P->get_info( $config );

		$this->load->view( 'Partner/save.html', $data );
	}

	public function do_save() 
	{
		$config = $this->input->post();

		if( ! $this->P->save_partner( $config ) )
			jump( $this->P->error, U( 'Partner/save?id='.$config['id'],2 ), 2 );
		jump( '修改成功！', U( 'Partner/lst',2 ), 2 );
	}
}