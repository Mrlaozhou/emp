<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Hot_Model extends LZ_Model
{
	public $error = null;
	private static $_table = 'Hot';
	private static $_rules = array(
							array(
								'field'		=>	'title',
								'label'		=>	'标题',
								'rules'		=>	'required|min_length[6]|max_length[60]',
								'errors'	=>	array(
										'required'		=>		'标题不能为空',
										'min_length'	=>		'标题长度为2-20个汉字',
										'max_length'	=>		'标题长度为2-20个汉字',
									),
								),
							array(
								'field'		=>	'action',
								'label'		=>	'行为',
								'rules'		=>	'required|min_length[2]|max_length[15]',
								'errors'	=>	array(
										'required'		=>		'行为不能为空',
										'min_length'	=>		'行为长度为2-15个字符',
										'max_length'	=>		'行为长度为2-20个字符',
									),
								),
							array(
								'field'		=>	'intro',
								'label'		=>	'介绍',
								'rules'		=>	'required|min_length[10]|max_length[1000]',
								'errors'	=>	array(
										'required'		=>		'介绍不能为空',
										'min_length'	=>		'介绍长度为10-600个汉字',
										'max_length'	=>		'介绍长度为10-600个汉字',
									),
								),
						);
	public function __construct()
	{
		parent::__construct();
	}

	public function add_hot()
	{
		//收集表单数据
		$data = $this->input->post( array('title','action','intro','is_show','is_index'), TRUE );
		// dump($data);
		//验证表单
		$this->form_validation->set_rules( self::$_rules );

		if ( $this->form_validation->run() == FALSE )
		{
			// $this->error = $this->form_validation->error_string();
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

        @mkdir('./Public/Upload/Hot/'.$data['action']);
		/**///上传html
		$config['upload_path']      = './Public/Upload/Hot/'.$data['action'].'/';
        $config['allowed_types']    = 'gif|jpg|png|zip|html|php|octet-stream|x-rar|rar';
        $config['max_size']     	= 10*1024;
        $config['overwrite']     	= TRUE;
        $config['file_name']     	= $data['action'];

        $this->load->library( 'upload', $config );
        //创建文件夹

        if ( isset( $_FILES['html']) && $_FILES['html']['error'] == 0 )
        {
        	$info = $this->upload->do_upload( 'html' );

        	if( ! $info )
        	{
        		$this->error = $this->upload->display_errors();
        		return FALSE;
        	}
        }
        else
        {
        	$this->error = '上传html出错！';
        	return FALSE;
        } 

        /**///上传pic
        
        if ( isset( $_FILES['pic']) && $_FILES['pic']['error'] == 0 )
        {
        	$info = $this->upload->do_upload( 'pic' );

        	if( ! $info )
        	{
        		$this->error = $this->upload->display_errors();
        		return FALSE;
        	}
        }
        else
        {
        	$this->error = '上传pic出错！';
        	return FALSE;
        }  

        /**///上传imgs

        if ( isset( $_FILES['imgs']) && $_FILES['imgs']['error'] == 0 )
        {
        	$info = $this->upload->do_upload( 'imgs' );

        	if( ! $info )
        	{
        		$this->error = $this->upload->display_errors();
        		return FALSE;
        	}
        }
        else
        {
        	$this->error = '上传imgs出错！';
        	return FALSE;
        }

        //解压压缩包
        $filename = './Public/Upload/Hot/'.$data['action'].'/'.$data['action'].'.rar';
        $savepath = './Public/Upload/Hot/'.$data['action'].'/';
        unRar( $filename, $savepath, TRUE );
	}

	/**
	 * [_after_insert description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	protected function _after_add( $id ) {}

	public function get_hot()
	{
		return $this->get_all( self::$_table );
	}

	public function del_hot( $where )
	{
		return $this->del($table = self::$_table,$where);
	}


	protected function _before_del( $where ) 
	{
		//提取库中信息
		$this->db->where('id',$where['id']);
		$info = $this->get_hot()->row_array();

		$action = $info['action'];
		//删除磁盘信息
		
		$rootdir = './Public/Upload/Hot/'.$action.'/';

		if ( is_dir( $rootdir ) )
		{
			if ( ! remove_dir($rootdir) )
			{
				$this->error = '删除磁盘信息出错！';
				return FALSE;
			}	
		}
	}

	protected function _after_del( $where ) {}

	public function unset_index()
	{
		$this->db->where( 'is_index', '1' );
		$this->save( self::$_table, array( 'is_index', '0' ) );
	}
}