<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Goods extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Goods_Model','G');
	}

	public function add()
	{
		$data['title']	= '添加商品';
		$data['cates']	= $this->G->get_cate();
		unset($data['cates']['ids']);
		// dump($data);
		$this->load->view( 'Goods/add.html', $data );
	}

	public function do_add()
	{
		// dump($_POST,2);
		if( ! $this->G->add_goods() )
			jump( $this->G->error, U('Goods/add',2), 2 );
		jump( '添加成功！', U('Goods/lst',2), 2 );
	}

	public function lst()
	{
		$data['data']  = $this->G->get_goods();
		$data['title'] = "商品列表";

		$this->load->view( 'Goods/lst.html', $data );
	}

	public function del()
	{
		if( ! $this->G->del_goods() )
			echoJson(array('status'=>TRUE,'info'=>$this->GC->error));
		echoJson(array('status'=>TRUE));
	}

	public function save()
	{
		$data = $this->input->get();

		// dump($data);
		$data['title']	= '添加商品';
		$data['cates']	= $this->G->get_cate();
		$data['info']	= $this->G->get_info( $data );

		// dump($data,2);
		unset($data['cates']['ids']);
		$this->load->view( 'Goods/save.html',$data );
	}

	public function do_save()
	{
		$data = $this->input->post();
		// dump($data,2);
		if( ! $this->G->save_goods( $data ) )
			jump( $this->input->error, U('Goods/save?id='.(int)$data['id'],2), 2 );
		jump( '修改成功！',U( 'Goods/lst',2 ), 2 );
	}
}