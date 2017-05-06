<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends LZ_Model
{
	public $error = null;
	private static $_table = 'Admin';
	private static $_rules=	array(
								array(
									'field'		=>	'username',
									'label'		=>	'用户名',
									'rules'		=>	'required',
									'errors'	=>	array(
										'required'	=>	'用户名不能为空！',
										),
									),
								array(
									'field'		=>	'password',
									'label'		=>	'密码',
									'rules'		=>	'required',
									'errors'	=>	array(
										'required'	=>	'密码不能为空！',
										),
									),
		);
	public function __construct()
	{
		parent::__construct();
	}



	public function check_login()
	{
		//接收数据
		$data = $this->input->post(array('username','password'),FALSE);

		//设置验证规则
		$this->form_validation->set_rules(self::$_rules);

		//验证
		if ( $this->form_validation->run() == FALSE )
		{
			$this->error = $this->form_validation->error_string();
			return FALSE;
		}

		$result = $this->get_all( self::$_table, array('username'=>$data['username']) )->row_array();

		
		if ( ($data['username'] != $result['username']) || (md5($data['password']) != $result['password']) )
		{
			$this->error = '账号或密码错误！';
			return FALSE;
		}

		
		$this->session->set_userdata( 'admin_id', $result['id'] );

		return TRUE;
	}
}