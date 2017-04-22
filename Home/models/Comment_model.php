<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_model extends LZ_Model
{
	private static $_table = 'comment';		//绑定表
	
	public function __construct()
	{
		parent::__construct();
	}

	
	public function all()
	{
		return $this->get_all(self::$_table);
	}
}
