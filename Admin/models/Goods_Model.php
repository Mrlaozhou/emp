<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Goods_Model extends LZ_Model
{
	public $error = null;
	protected static $_table = 'goods';
	protected static $_rules = array(
					array(
						'field'		=>	'name',
						'label'		=>	'name',
						'rules'		=>	'required|max_length[60]',
						'errors'		=>	array(
										'required'	=>	'产品名称不能为空',
										'max_length'=>	'名称小于60个字符',	
									),
						),
					array(
						'field'		=>	'price',
						'label'		=>	'price',
						'rules'		=>	'required',
						'errors'		=>	array(
										'required'	=>	'产品价格不能为空',
									),
						),
					array(
						'field'		=>	'price',
						'label'		=>	'price',
						'rules'		=>	'required',
						'errors'		=>	array(
										'required'	=>	'产品价格不能为空',
									),
						),
					array(
						'field'		=>	'href',
						'label'		=>	'href',
						'rules'		=>	'required',
						'errors'		=>	array(
										'required'	=>	'链接地址不能为空',
									),
						),
				);
	public function __construct()
	{
		parent::__construct();
		$this->load->model( 'Goodscate_Model', 'GC' );
	}

	public function get_cate()
	{
		return get_sort($this->GC->get_cate());
	}

	public function get_goods()
	{
		$this->db->select( 'id,name,cate_id,is_valid,is_promate' );
		return $this->get_all( self::$_table )->result_array();
	}


	public function get_info( $config )
	{
		$id = (int)$config['id'];

		return $this->get_all( self::$_table, array('id'=>$id) )->row_array();
	}

	public function add_goods()
	{
		$data = $this->input->post();

		$this->form_validation->set_rules( self::$_rules );

		if( $this->form_validation->run() === FALSE )
		{
			$this->error = validation_errors();
			return FALSE;
		}

		return $this->add( self::$_table, $data );
	}


	protected function _before_add( &$data ) 
	{
		if( (int)$data['cate_id'] === 0 )
		{
			$this->error = "请选择分类";
			return FALSE;
		}

		if( (int)$data['s_id'] === 0 )
		{
			$this->error = "请选择合作商";
			return FALSE;
		}

		$config['upload_path']		= GOODS;
        $config['allowed_types']    = '*';
        $config['max_size']     	= 0;
        $config['overwrite']     	= TRUE;
        $config['encrypt_name']		= TRUE;
        

        $this->load->library( 'upload', $config );

        //上传html
        // dump($_FILES);
        if ( isset( $_FILES['pic'] ) && $_FILES['pic']['error'] === 0 )
        {
        	if ( ! $this->upload->do_upload('pic') )
        	{
        		$this->error = $this->upload->display_errors();
        		return FALSE;
        	}

        	// dump($this->upload->data('file_name'));
        	$data['pic'] = $this->upload->data('file_name'); 

        	return ;
        }
        else
        {
        	$this->error = '图片文件出错！';
        	return FALSE;
        }
	}

	protected function _after_add( $id ) {}

	public function del_goods()
	{
		$data = $this->input->post( array('id') );
		
		return $this->del( self::$_table, $data );
	}

	protected function _before_del( $where ) 
	{
		$info = $this->get_info($where);

		// dump($info);
		//删除磁盘文件
		$filename = GOODS.$info['pic'];

		if( is_file( $filename ) )
			@unlink($filename);
		return ;
	}

	public function save_goods( $config )
	{
		$this->form_validation->set_rules( self::$_rules, $config );

		if( $this->form_validation->run() == FALSE )
		{
			$this->error = validation_errors();
			return FALSE;
		}

		return $this->save( self::$_table, $config );
	}

	protected function _before_save( &$data ) 
	{
		if( (int)$data['cate_id'] === 0 )
		{
			$this->error = "请选择分类";
			return FALSE;
		}

		if( (int)$data['s_id'] === 0 )
		{
			$this->error = "请选择合作商";
			return FALSE;
		}

        //上传html
        // dump($_FILES);
        if ( isset( $_FILES['pic'] ) && $_FILES['pic']['error'] === 0 )
        {
        	$config['upload_path']		= GOODS;
	        $config['allowed_types']    = '*';
	        $config['max_size']     	= 0;
	        $config['overwrite']     	= TRUE;
	        $config['encrypt_name']		= TRUE;
	        

	        $this->load->library( 'upload', $config );

        	if ( ! $this->upload->do_upload('pic') )
        	{
        		$this->error = $this->upload->display_errors();
        		return FALSE;
        	}

        	//删除原文件
        	$info = $this->get_info( $data );
        	@unlink(GOODS.$info['pic']);

        	// dump($this->upload->data('file_name'));
        	$data['pic'] = $this->upload->data('file_name'); 

        	return ;
        }

	}

	protected function _after_save( $id ) {}
}
