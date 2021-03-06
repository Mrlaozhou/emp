<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Goodscate_model extends LZ_Model
{
	public $error = null;
	protected static $_table = 'goodscate';
	protected static $_rules = array(
					array(
						'field'		=>	'name',
						'label'		=>	'name',
						'rules'		=>	'required|max_length[30]',
						'errors'		=>	array(
										'required'	=>	'分类名称不能为空',
										'max_length'=>	'名称小于30个字符',	
									),
						),
					
					array(
						'field'		=>	'pid',
						'label'		=>	'pid',
						'rules'		=>	'required',
						'errors'		=>	array(
										'required'	=>	'缺少上级分类信息',
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

	public function get_info( $id )
	{
		//获取所有数据
		$this->db->select( 'id,name,pid' );
		$all = $this->get_all( self::$_table )->result_array();

		//数据结构  =》 排序形  获取子ID
		$all = get_sort( $all, $id, 0, TRUE );

		if( $all )
		{
			$all['ids'][] = $id;
			$notIds = implode(',',$all['ids']);	
		}
		else
		{
			$notIds = $id;
		}

		//根据子ID  排除子集
		$sql = "SELECT id,name,pid FROM emp_goodscate WHERE id not in({$notIds})";
		$pids = $this->db->query($sql)->result_array();
		//排序
		$pids = get_sort( $pids, 0, 0, TRUE );
		unset( $pids['ids'] );	

		//单条数据
		$info = $this->get_all( self::$_table, array('id'=>$id) )->row_array();

		return array( 'info'=>$info,'pids'=>$pids );
	}

	public function get_pid_sort()
	{
		$this->db->select('id,name,pid');
		$pids = $this->get_all( self::$_table )->result_array();
		return get_sort( $pids );
	}

	public function add_cate()
	{
		//接收数据
		$data = $this->input->post( array('name','remark','is_valid','pid') );

		//dump($data);
		//设置验证规则
		$this->form_validation->set_rules( self::$_rules );

		//验证
		if( $this->form_validation->run() === FALSE )
		{
			$this->error = validation_errors();
			return FALSE;
		}

		return $this->add( self::$_table, $data );
	}

	public function del_cate()
	{
		$data = $this->input->post( array('id') );
		
		return $this->del( self::$_table, $data );
	}

	protected function _before_del( $where ) 
	{
		//获取原始数据
		$data = $this->get_cate();

		//排序数据
		$sorts = get_sort( $data, (int)$where['id'] );

		if( ! $sorts )
			return ;

		//ID集
		$ids = $sorts['ids'];

		// dump($ids);
		$this->db->where_in( 'id', $ids );

		return $this->db->delete( self::$_table );
	}


	protected function _after_del( $where ) {}


	public function save_cate( $data )
	{
		//设置验证规则
		$this->form_validation->set_rules( self::$_rules );

		//验证
		if( $this->form_validation->run() === FALSE )
		{
			$this->error = validation_errors();
			return FALSE;
		}

		return $this->save( self::$_table, $data );
	}
}