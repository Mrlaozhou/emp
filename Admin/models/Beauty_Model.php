<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Beauty_Model extends LZ_Model
{
	public $error = null;
	private static $_table = 'beauty';
	private static $_rules = array(
					array(
							'field'	=>	'',
							'label'	=>	'',
							'rules'	=>	'',
							'error'	=>	array(

								),
						),
			);
	public function __construct()
	{
		parent::__construct();
	}

	/********************/
	public function get_beauty()
	{
		return $this->get_all( self::$_table )->result_array();
	}
}