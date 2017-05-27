<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Topiccategray_Model extends LZ_Model
{
	public $error			 	= null;
	private static $_table 		= 'topiccategray';
	private static $_rules 		= array(
				array(
						'field'		=>	'name',
						'label'		=>	'name',
						'rules'		=>	'required|min_length[2]|max_length[10]',
						'errors'	=>	array(
							'required'		=>	'分类名不能为空',
							'min_length'	=>	'分类名称为 2-10 个汉字',
							'max_length'	=>	'分类名称为 2-10 个汉字',
							)
					),
				array(
						'field'		=>	'remark',
						'label'		=>	'remark',
						'rules'		=>	'max_length[300]',
						'errors'	=>	array(
							'max_length'	=>	'备注信息少于100汉字',
							)
					),
			);
	public function __construct()
	{
		parent::__construct();
	}

	public function get_cate()
	{
		return $this->get_all( self::$_table );
	}

	public function add_cate()
	{
		//接受表单数据
		$data = $this->input->post(array('name','is_valid','remark'));

		//设置验证规则
		$this->form_validation->set_rules(self::$_rules);

		//验证
		if ( $this->form_validation->run() == FALSE )
		{
			$this->error = validation_errors();
			return FALSE;
		}

		//添加信息
		return $this->add( self::$_table, $data );
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

	public function del_cate()
	{
		//接受数据
		$data = $this->input->post( array('id') );

		//删除
		return $this->del( self::$_table, $data );
	}
}