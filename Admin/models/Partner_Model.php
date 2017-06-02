<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Partner_Model extends LZ_Model
{
	public $error = null;
	protected static $_table = 'partner';
	protected static $_rules = array(
							array(
							'field'		=>	'name',
							'label'		=>	'合作商名称',
							'rules'		=>	'required|max_length[5]',
							'errors'	=>	array(
											'required'		=>	'名称不能为空',
											'max_length'	=>	'名称长度在1-5个汉字',
											),
								),
			);
	public function __construct()
	{
		parent::__construct();
	}

	public function add_partner()
	{
		$data = $this->input->post();

		$this->form_validation->set_rules( self::$_rules, $data );

		if( $this->form_validation->run() === FALSE )
		{
			$this->error = validation_errors();
			return FALSE;
		}

		return $this->add( self::$_table, $data );
	}

	public function del_partner()
	{
		$data = $this->input->post( array('id') );
		
		return $this->del( self::$_table, $data );
	}

	public function save_partner( $config )
	{
		$this->form_validation->set_rules( self::$_rules, $config );

		if( $this->form_validation->run() === FALSE )
		{
			$this->error = validation_errors();
			return FALSE;
		}
		return $this->save( self::$_table, $config );
	}

	public function get_partner()
	{
		return $this->get_all( self::$_table )->result_array();
	}

	public function get_info( $config )
	{
		return $this->get_all( self::$_table, array('id'=>(int)$config['id']) )->row_array();
	}

	protected function _before_add( &$data ) {}

	protected function _after_add( $id ) {}
}