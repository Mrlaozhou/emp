<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Hosanddoc_Model extends CI_Model
{
	public $zxznz = null;

	public function __construct()
	{
		$this->zxznz = $this->Init_zxznz();
	}

	private function Init_zxznz()
	{
		return $this->load->database( 'zxznz', TRUE );
	}

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
		return $this->zxznz->get_where( $table, $where, $limit, $offset  );
	}

	/**
	 * [hos_list 获取医院列表数据]
	 * @return [type] [description]
	 */
	public function hos_list( $p )
	{
		$pagesize = 8;
		$start = ($p-1)*$p;
		$this->zxznz->select('id,name,logo');
		$where = array('is_show'=>'1');
		// return $this->get_all( 'hospital', $where )->result_array();
		return $this->zxznz->limit( $pagesize,$start )->get_where( 'hospital', $where )->result_array();
	}

	public function hos_info( $config )
	{
		$data['hospital'] = $this->get_all( 'hospital', $config )->row_array();
		$data['doctor'] = $this->doc_list( (int)$config['id'] );
		dump($data);
		return $data;
	}

	/**
	 * [doc_list description]
	 * @param  [type] $hos_id [description]
	 * @return [type]         [description]
	 */
	public function doc_list( $hos_id )
	{
		$where = array('hos_id'=>$hos_id,'is_show'=>'是');
		return $this->get_all( 'doctor', $where )->result_array();
	}

	public function doc_info( $config ) 
	{
		return $this->get_all( 'doctor', $config )->row_array();
	}

	/**
	 * [_get_auto_value 自增减]
	 * @param  [type]  $pk    [主键值]
	 * @param  [type]  $field [目标字段]
	 * @param  integer $num   [偏移量]
	 * @return [type]         [description]
	 */
	protected function _get_auto_value( $table, $pk, $field = null, $num = 1 ) 
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
		$info = $this->get_all( $table, array('id'=>$pk) )->row_array();

		$_num = (int)$info[$field];

		return ($_num+(int)$num);
	}
}