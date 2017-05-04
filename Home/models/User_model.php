<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends LZ_Model
{
	private static $_table = 'User';
	private static $_rules = array(
								array(
										'field'		=>	'username',
										'label'		=>	'username',
										'rules'		=>	'required|min_length[6]|max_length[18]',
										'errors'	=>	array(
												'required'			=>	'nothing',	
												'min_length'		=>	'too short',
												'max_length'		=>	'too long',
											),
									),
								array(
										'field'		=>	'password',
										'label'		=>	'password',
										'rules'		=>	'required|min_length[8]|max_length[30]',
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

	public function register()
	{
		/**///接收数据
		$data = $this->input->post(array('username','password'));

		/**///设置验证规则
		$this->form_validation->set_rules( self::$_rules );

		/**///验证
		if ( $this->form_validation->run() == FALSE )
		{
			$this->error = validation_errors();
			return FALSE;
		}

		/**///检验是否存在
		if( $this->_check_user_exists( $data['username'] ) )
		{
			$this->error = '用户已存在！';
			return TRUE;
		}

		//注册
		return $this->add( self::$_table, $data );

	}

	/**
	 * [_before_add description]
	 * @param  [type] &$data [description]
	 * @return [type]        [description]
	 */
	protected function _before_add( &$data ) 
	{
		$data['create_time'] = time();
	}

	public function login()
	{
		//接收数据
		$data = $this->input->post(array('username','password'));

		//验证数据
		$this->form_validation->set_rules( self::$_rules );
		if ( $this->form_validation->run() == FALSE )
		{
			$this->error = validation_errors();
			return FALSE;
		}

		//验证是否存在
		$info = $this->_check_user_exists( $data['username'] );
		if( ! $info )
		{
			$this->error = '用户名不存在！';
			return FALSE;
		}

		if( $info['password'] !=  $data['password'] )
			return FALSE;
		$this->session->set_userdata('home_id',$info['id']);
		return FALSE;
	}

	/**
	 * [_check_user_exists description]
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 */
	private function _check_user_exists( $user )
	{
		return $this->get_all( $table = self::$_table, $where = $user )->row_array();
	}
}