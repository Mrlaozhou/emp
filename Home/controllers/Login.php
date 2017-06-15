<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model( 'User_model','U' );
	}

	public function show_login()
	{
		$data['title'] = '登录【e美评官网】';
		$data['cssList'] = array('login.css');
		$data['jsList'] = array();

		$this->load->view('Login/login.html',$data);
	}

	public function do_login()
	{
		if ( ! $this->U->login() )
			echoJson( array('status'=>FALSE,'error'=>$this->U->error) );
		echoJson( array('status'=>TRUE) );
	}

	public function out_login()
	{
		//摧毁
		$this->session->unset_userdata('home_id');
		$this->session->unset_userdata('home_username');
		jump('退出成功！',U(),2);
	}


	public function userinfo()
	{
		if( ! ($id = $this->session->home_id) )
		{
			jump( '请先登录！', U('Login/show_login'), 2 );
		}

		$data['title'] = '用户中心【e美评官网】';
		$data['cssList'] = array('dashboard.css');
		$data['jsList'] = array('cropbox.js');

		$data['userinfo'] = $this->U->get_info_by_id( $id );
		$data['userinfo']['birthday'] = explode('-',$data['userinfo']['birthday']);
		// dump($data,2);


		$this->load->view( 'header.html', $data );
		$this->load->view( 'Login/dashboard.html' );
		$this->load->view( 'footer.html' );
	}

	public function save_msg()
	{
		if( $id = $this->session->home_id )
		{
			$data = $this->input->post();
			$data['id'] = $id;
			// dump($data);
			if( ! $this->U->save_msg( $data ) )
				echoJson( array('status'=>FALSE,'error'=>array('msg'=>$this->U->error) ));
			echoJson( array('status'=>TRUE,'data'=>array('nick'=>$data['alias'])) );
		}
	}

	public function upload_avatar()
	{
		if( ! ($path = $this->U->upload_avatar()) )
			echoJson( array( 'status'=>FALSE, 'error'=>array('msg'=>$this->U->error) ) );
		echoJson( array( 'status'=>TRUE, 'data'=>array( 'path'=>substr($path) ) ) );
	}

	public function reset_pass()
	{
		if( $id = $this->session->home_id )
		{
			$data = $this->input->post();
			$data['id'] = $id;
			// dump($data);
			if( ! $this->U->reset( $data ) )
				echoJson( array('status'=>FALSE,'error'=>array('msg'=>$this->U->error) ));
			echoJson( array('status'=>TRUE) );
		}
	}

	/*
	public function reset()
	{
		$data['title'] = '重置密码【e美评官网】';

		$this->load->view( 'Login/reset.html' );
	}
	*/

	public function back()
	{
		$data['title'] = '找回密码【e美评官网】';

		$this->load->view( 'Login/retrieve.html' );
	}

	public function do_back()
	{
		
	}

	public function back_send_msg()
	{
		$data = $this->input->post();
	}

	private function send_msg( $mobile, $key )
	{
		$url = 'http://106.ihuyi.com/webservice/sms.php?method=Submit';
        //账户、密码
        $account = 'C22986809';
        $password = '37454a5b2e36e986562439659c74c928';

        //生成随机验证码
        $rand = getRandStr(4,2);
        
        //拼接信息
        $post_data = "account={$account}&password={$password}&mobile={$mobile}&content=".rawurlencode("您的验证码是：{$rand}。请不要把验证码泄露给其他人。");
        $result = POST($post_data,$url);

        //处理xml字符串
        $result = simplexml_load_string($result);

        if( $result->code != 2 )
        	return array('status'=>FALSE,'error'=>'验证码发送失败!') ;

		//验证码存于session
    	$this->session->set_userdata($key,$rand);
    	return array('status'=>TRUE);
	}
}   