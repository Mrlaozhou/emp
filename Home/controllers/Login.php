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

	public function reset()
	{
		$data['title'] = '重置密码【e美评官网】';
		$data['cssList'] = array('reset.css');
		$data['jsList'] = array('');

		$this->load->view( 'header.html', $data );
		$this->load->view( 'Login/reset.html' );
		$this->load->view( 'footer.html' );
	}

	public function back()
	{
		$data['title'] = '找回密码【e美评官网】';
		$data['cssList'] = array('retrieve.css');
		$data['jsList'] = array('');

		$this->load->view( 'header.html', $data );
		$this->load->view( 'Login/retrieve.html' );
		$this->load->view( 'footer.html' );
	}
}   