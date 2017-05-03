<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends LZ_Model
{
	private static $_table = 'User';
	private static $_rules = array(
								array(
										'field'		=>	'username',
										'label'		=>	'username',
										'rules'		=>	'required|min_length[6]|max_length[300]',
										'errors'	=>	array(
												'required'			=>	'nothing',	
												'min_length'		=>	'too short',
												'max_length'		=>	'too long',
											),
									),
								array(
										'field'		=>	'password',
										'label'		=>	'password',
										'rules'		=>	'required|min_length[1]|max_length[1000]',
										'errors'	=>	array(
												'required'			=>	'nothing',	
												'min_length'		=>	'too short',
												'max_length'		=>	'too long',
											),
									),								
							);
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function check_register()
	{
		$data = $this->input->post(array('username','password'));

		$this->form_validation->set_rules( self::$_rules );

		if ( $this->form_validation->run() == FALSE )
			return FALSE;

		return  $this->_check_user_exists( $data['username'] )->row_array();

	}

	private function _check_user_exists( $user )
	{
		return $this->get_all( $table = self::$_table, $where = $user );
	}

}