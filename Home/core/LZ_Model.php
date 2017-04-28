<?php defined('BASEPATH') OR exit('No direct script access allowed');

class LZ_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	##############
	### select ###
	##############
	/**
	 * [get_all 查询所有]
	 * @param  string $table  [表名]
	 * @param  [type] $where  [条件]
	 * @param  [type] $limit  [首键]
	 * @param  [type] $offset [偏移量]
	 * @return [type]         [description]
	 */
	public function get_all( $table = '', $where = NULL, $limit = NULL, $offset = NULL ) 
	{
		return $this->db->get_where( $table, $where, $limit, $offset  );
	}

	##############
	### insert ###
	##############
	/**
	 * [add 添加]
	 * @param [type]  $table   [表名]
	 * @param [type]  $data    [插入数据]
	 * @param boolean $isBatch [是否多条数据]
	 */
	public function add( $table, $data, $isBatch = FALSE)
	{
		if( $isBatch )
		{
			//添加前置
			$this->_before_insert( $data );
			//添加
			$result = $this->db->insert_batch( $table, $data );
			
			//添加后置
			$id = $this->db->insert_id();
			$this->_after_insert($id);

			return $result;
		}

		//添加前置
		$this->_before_add( $data );
		//添加
		$result = $this->db->insert( $table, $data );
		//添加后置
		$id = $this->db->insert_id();
		$this->_after_add($id);

		return $result;
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


	##############
	### update ###
	##############
	
	/**
	 * [save description]
	 * @param  [type]  $table   [description]
	 * @param  [type]  $data    [description]
	 * @param  boolean $isBatch [description]
	 * @return [type]           [description]
	 */
	public function save( $table, $data, $isBatch = FALSE )
	{
		if( $isBatch )
		{
			//修改前置
			$this->_before_save( $data );
			//执行
			$result = $this->db->update_batch( self::$_table, $data );
			//修改后置
			$this->_after_save($data['id']);
			return $result;
		}	

		//修改前置
		$this->_before_save( $data );
		//执行
		$result = $this->db->update( self::$_table, $data );
		//修改后置
		$this->_after_save($data['id']);

		return $result;
	}

	/**
	 * [_before_save description]
	 * @param  [type] &$data [description]
	 * @return [type]        [description]
	 */
	protected function _before_save( &$data ) {}

	/**
	 * [_insert_save description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	protected function _after_save( $id ) {}


	/**
	 * [_get_auto_value 自增减]
	 * @param  [type]  $pk    [主键值]
	 * @param  [type]  $field [目标字段]
	 * @param  integer $num   [偏移量]
	 * @return [type]         [description]
	 */
	protected function _get_auto_value( $pk, $field = null, $num = 1 ) 
	{
		//原有值
		$_num = 0;

		//主键
		if( $pk <= 0 )
			return FALSE;

		//目标字段
		if( ( $field === null ) || empty( $field ) )
			return FALSE;

		//获取原有值
		$info = $this->get_all( self::$_table, array('id'=>$pk) );

		$_num = (int)$info[$field];

		return ($_num+(int)$num);
	}
}