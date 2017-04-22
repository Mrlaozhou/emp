<?php defined('BASEPATH') OR exit('No direct script access allowed');

class LZ_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
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
		return $this->db->get_where( $table, $where, $limit, $offset  );
	}
}