<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Beautycategray_Model extends LZ_Model
{
	public $error = null;
	private static $_table = 'beautycategray';
	private static $_rules=	array(
								array(
									'field'		=>	'name',
									'label'		=>	'分类名称',
									'rules'		=>	'required|min_length[1]|max_length[5]',
									'errors'	=>	array(
													'required'		=>	'名称不能为空',
													'min_length'	=>	'名称长度在1-5个汉字',
													'max_length'	=>	'名称长度在1-5个汉字',
													),
									),
								array(
									'field'		=>	'intro',
									'label'		=>	'分类名称',
									'rules'		=>	'max_length[100]',
									'errors'	=>	array(
													'max_length'		=>	'介绍小于300汉字',
													),
									),
								array(
									'field'		=>	'is_show',
									'label'		=>	'显示',
									'rules'		=>	'required',
									'errors'	=>	array(
													'required'		=>	'请选择是否显示',
													),
									),
							);
	public function __construct()
	{
		parent::__construct();
	}

	public function get_cate()
	{
		return $this->get_all( self::$_table )->result_array();
	}

	public function get_pid_sort()
	{
		//获取原始数据
		$data = $this->get_all( self::$_table )->result_array();
		//处理数据-->递归排序
		return get_sort( $data,0,1,TRUE );
	}

	public function get_pid_tree()
	{
		$data = $this->get_all( self::$_table )->result_array();

		return get_tree( $data,0,1 );
	}

	private function _get_children_id( $id, $data )
	{
		$get = get_sort( $data, $id, 1,TRUE );

		$ids = $get['ids'];

		$ids[] = $id;

		return $ids;
	}

	public function add_cate()
	{
		//接收数据
		$data = $this->input->post(array('name','intro','is_show','pid'),TRUE);
		//验证数据
		$this->form_validation->set_rules(self::$_rules);

		if ( $this->form_validation->run() == FALSE )
		{
			$this->error = validation_errors();
			return FALSE;
		}
		return $this->add( self::$_table, $data );
	}

	public function del_cate()
	{
		//接收数据
		$data = $this->input->post(array('id'));

		return $this->del( self::$_table, $data );
	}
	
	/**
	 * [_before_insert description]
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	protected function _before_add( &$data ) {}

	/**
	 * [_after_insert description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	protected function _after_add( $id ) {}

}