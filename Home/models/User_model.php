<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends LZ_Model
{
	private static $_table = 'User';
	private static $_rules = array(
								array(
										'field'		=>	'username',
										'label'		=>	'username',
										'rules'		=>	'required',
										'errors'	=>	array(
												'required'			=>	'手机号不能为空',	
											),
									),
								array(
										'field'		=>	'pwd1',
										'label'		=>	'pwd1',
										'rules'		=>	'required|min_length[6]|max_length[15]',
										'errors'	=>	array(
												'required'			=>	'请输入密码',	
												'min_length'		=>	'密码介于6-15个字符之间',
												'max_length'		=>	'密码介于6-15个字符之间',
											),
										),
								array(
										'field'		=>	'alias',
										'label'		=>	'alias',
										'rules'		=>	'required|max_length[24]',
										'errors'	=>	array(
												'required'			=>	'昵称不能为空',	
												'max_length'		=>	'昵称不能超过8个汉字',
											),
									),	
								array(
										'field'		=>	'sex',
										'label'		=>	'sex',
										'rules'		=>	'max_length[1]',
										'errors'	=>	array(
												'max_length'		=>	'性别传参出错',
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
		$data = $this->input->post(array('username','pwd1','pwd2','alias','captcha'));

		/**///检验是否存在
		if( $this->_check_user_exists( $data['username'] ) != FALSE )
		{
			$this->error = '用户已存在！';
			return FALSE;
		}
		
		//验证码验证
		if( $this->session->code != $data['captcha'] )
		{
			$this->error = '验证码错误，请重新输入';
			return FALSE;
		}

		/**///设置验证规则
		$this->form_validation->set_rules( self::$_rules );

		/**///验证
		if ( $this->form_validation->run() == FALSE )
		{
			$this->error = validation_errors();
			return FALSE;
		}

		//注册
		return $this->add( self::$_table, $data );
	}

	public function check_user( $data )
	{
		$info =  $this->_check_user_exists( $data['tel'] );
		
		return (! $info);
	}

	/**
	 * [_before_add description]
	 * @param  [type] &$data [description]
	 * @return [type]        [description]
	 */
	protected function _before_add( &$data ) 
	{
		$data['create_time'] = time();
		$data['password']	 = md5(addslashes($data['pwd1']));
		unset($data['pwd1']);
		unset($data['pwd2']);
		unset($data['captcha']);
	}

	public function login()
	{
		//接收数据
		$data = $this->input->post(array('username','password'));

		//验证是否存在
		$info = $this->_check_user_exists( $data['username'] );
		
		if( ! $info )
		{
			$this->error = '用户名未注册！';
			return FALSE;
		}

		
		if( $info['password'] !=  md5($data['password']) )
		{
			$this->error = '密码错误！';
			return FALSE;
		}

		$this->session->set_userdata('home_id',$info['id']);
		$this->session->set_userdata('home_username',$info['username']);
		return TRUE;
	}

	/**
	 * [_check_user_exists description]
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 */
	private function _check_user_exists( $user )
	{
		return $this->get_all( self::$_table, array('username'=>$user) )->row_array();
	}

	public function get_info_by_id( $id )
	{
		$this->db->where( 'id', (int)$id );
		return $this->get_all( self::$_table )->row_array();
	}

	public function save_msg( $data )
	{
		if( (count($data) > 1) )
		{
			//去除空项
			foreach( $data as $k => $v )
			{
				if( $v === '' )
					unset($data[$k]);
			}
			return $this->save( self::$_table, $data );
		}	
	}

	public function upload_avatar()
	{
		$base64_img = trim($_POST['image']);

		if( ! $base64_img )
		{
			$this->error = '请选择上传文件';
			return FALSE;
		}

		if( !($id = $this->session->home_id) )
		{
			$this->error = '非法操作';
			return FALSE;
		}

	    $up_dir = './Public/Upload/User/';
	 
	    if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result))
	    {
	        $type = $result[2];
	        if(in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png')))
	        {
	        	$filename = $id.'.'.$type;
	            $new_file = $up_dir.$filename;
	            if(file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_img))))
	            {
	            	//储存信息到数据库
	            	$data = array('id'=>$id,'pic'=>$filename);
	                if( $this->save_msg($data) )
	                {
	                	return $new_file;
	                }
	                $this->error = '操作有误，请联系管理员';
	                return FALSE;
	            }
	            $this->error = '上传出错';
	            return FALSE;
	        }
	        //文件类型错误
	        $this->error = '文件类型到了';
	        return FALSE;
	    }
	    //文件错误
	    $this->error = '文件出错';
	    return FALSE;
	}

	protected function _before_save( &$data ) {}


	protected function _after_save( $id ) {}

	public function reset( $data )
	{
		$info = $this->get_info_by_id( (int)$data['id'] );

		if( $info['password'] != md5($data['old']) )
		{
			$this->error = '原密码输入有误！';
			return FALSE;
		}

		if( $data['pwd1'] != $data['confirm'] )
		{
			$this->error = '两次新密码不一致';
		}

		$len = strlen($data['pwd1']);

		if( ($len < 6) || ( $len > 15 ) )
		{
			$this->error = '密码介于6-15个字符之间';
			return FALSE;
		}

		return $this->save( self::$_table, array('id'=>$data['id'], 'password'=>md5($data['pwd1'])) );
	}
}