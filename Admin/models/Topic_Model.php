<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Topic_Model extends LZ_Model
{
	public 	$error 			= null;
	private static $_table 	= 'topic';
	private static $_rules	= array(
				array(
						'field'		=>	'title',
						'label'		=>	'title',
						'rules'		=>	'required|max_length[100]',
						'errors'	=>	array(
							'required'		=>	'标题不能为空',
							'max_length'	=>	'标题少于30个汉字',
							)
					),
				array(
						'field'		=>	'author',
						'label'		=>	'author',
						'rules'		=>	'required|max_length[20]',
						'errors'	=>	array(
							'required'		=>	'请输入作者信息',
							'max_length'	=>	'备注信息少于20字符',
							)
					),
				array(
						'field'		=>	'is_index',
						'label'		=>	'is_index',
						'rules'		=>	'required',
						'errors'	=>	array(
							'required'	=>	'显示信息不能为空',
							)
					),
				array(
						'field'		=>	'is_valid',
						'label'		=>	'is_valid',
						'rules'		=>	'required',
						'errors'	=>	array(
							'required'	=>	'有效信息不能为空',
							)
					),
				array(
						'field'		=>	'intro',
						'label'		=>	'intro',
						'rules'		=>	'required|max_length[300]',
						'errors'	=>	array(
							'required'	=>	'介绍不能为空',
							'max_length'=>	'介绍不能多于300汉字',
							)
					),
				
		);
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * [get_cate 取出话题分类信息]
	 * @return [type] [description]
	 */
	public function get_cate()
	{
		$this->db->select('id,name');
		return $this->get_all( 'Topiccategray', array('is_valid'=>'1') );
	}

	/**
	 * [get_topic 取出话题列表]
	 * @return [type] [description]
	 */
	public function get_topic() 
	{
		$this->db->select( 'id, title, cate_id' );
		return $this->get_all( self::$_table );
	}

	/**
	 * [get_info 取出单条话题信息]
	 * @return [type] [description]
	 */
	public function get_info()
	{
		//接收参数
		$data = $this->input->get( array('id') );

		return $this->get_all( self::$_table, $data )->row_array();
	}

	public function add_topic() 
	{
		//接收数据
		$data = $this->input->post( array('title', 'is_index', 'is_valid', 'cate_id', 'author', 'intro' ) );

		//设置验证规则
		 $this->form_validation->set_rules( self::$_rules );

		//验证
		if ( $this->form_validation->run() == FALSE )
		{
			$this->error = validation_errors();
			return FALSE;
		}

		return $this->add( self::$_table, $data );
	}

	/**
	 * [_before_insert description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	protected function _before_add( &$data ) 
	{
		$data['time'] = time();
		//dump($data);
	}

	/**
	 * [_after_insert description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	protected function _after_add( $id ) 
	{
		/**///更改上传机制，以id为索引
		if ( ! $id )
			return FALSE;

		//创建单元目录
		$path = TOPICS.$id.'/';
		@mkdir($path);

		$config['upload_path']		= $path;
        $config['allowed_types']    = '*';
        $config['max_size']     	= 0;
        $config['overwrite']     	= TRUE;
        $config['file_name']		= $id;

        $this->load->library( 'upload', $config );

        //上传html
        
        if ( isset( $_FILES['html'] ) && $_FILES['html']['error'] === 0 )
        {
        	if ( ! $this->upload->do_upload('html') )
        	{
        		$this->error = $this->upload->display_errors();
        		return FALSE;
        	}
        }
        else
        {
        	$this->error = 'html文件出错！';
        	return FALSE;
        }
		
        //上传图片
        
        if ( isset( $_FILES['pic'] ) && $_FILES['pic']['error'] === 0 )
        {
        	if ( ! $this->upload->do_upload('pic') )
        	{
        		$this->error = $this->upload->display_errors();
        		return FALSE;
        	}
        }
        else
        {
        	$this->error = 'pic文件出错！';
        	return FALSE;
        }

        //上传图片压缩包
        	
        if ( isset( $_FILES['imgs'] ) && $_FILES['imgs']['error'] === 0 )
        {
        	if ( ! $this->upload->do_upload('imgs') )
        	{
        		$this->error = $this->upload->display_errors();
        		return FALSE;
        	}

        	//解压压缩包,重命名文件夹
	        $filename = $path.$id.'.rar';
	        UnRar( $filename, $path, TRUE );
        }
        else
        {
        	$this->error = 'rar文件出错！';
        	return FALSE;
        }
	}

	public function del_topic()
	{
		//接收数据
		$data = $this->input->post();

		if ( !isset($data['id']) || ! like_int($data['id']) )
			return FALSE;

		return $this->del( self::$_table, $data );
	}

	protected function _before_del( $where ) 
	{
		$id = $where['id'];

		$path = TOPICS.$id.'/';

		remove_dir($path);
	}

	public function save_topic( $data )
	{
		
		//设置验证规则
		$this->form_validation->set_rules( self::$_rules, $data );

		//验证
		if ( $this->form_validation->run() == FALSE )
		{
			$this->error = validation_errors();
			return FALSE;
		}

		return $this->save( self::$_table, $data );
	}


	/**
	 * [_before_save description]
	 * @param  [type] &$data [description]
	 * @return [type]        [description]
	 */
	protected function _before_save( &$data ) 
	{
		$id = $data['id'];

		if ( ! $id )
		{
			$this->error = '缺少主键！';
			return FALSE;
		}

		//创建单元目录
		$path = TOPICS.$id.'/';
		@mkdir($path);

		$config['upload_path']		= $path;
        $config['allowed_types']    = '*';
        $config['max_size']     	= 0;
        $config['overwrite']     	= TRUE;
        $config['file_name']		= $id;

        $this->load->library( 'upload', $config );

        //上传html
        
        if ( isset( $_FILES['html'] ) && $_FILES['html']['error'] === 0 )
        {
        	if ( ! $this->upload->do_upload('html') )
        	{
        		$this->error = $this->upload->display_errors();
        		return FALSE;
        	}
        }
        
        //上传图片
        if ( isset( $_FILES['pic'] ) && $_FILES['pic']['error'] === 0 )
        {
        	if ( ! $this->upload->do_upload('pic') )
        	{
        		$this->error = $this->upload->display_errors();
        		return FALSE;
        	}
        }
        

        //上传图片压缩包	
        if ( isset( $_FILES['imgs'] ) && $_FILES['imgs']['error'] === 0 )
        {
        	if ( ! $this->upload->do_upload('imgs') )
        	{
        		$this->error = $this->upload->display_errors();
        		return FALSE;
        	}

        	//删除之前的文件夹
	        if( is_dir($path.'imgs/') )
	        	remove_dir($path.'imgs/');

			//解压压缩包,重命名文件夹
	        $filename = $path.$id.'.rar';
	        UnRar( $filename, $path, TRUE );
        }
	}

	/**
	 * [_insert_save description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	protected function _after_save( $id ) {}
}