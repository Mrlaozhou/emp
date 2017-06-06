<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends LZ_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model','U');
	}

	public function show_register()
	{
		$this->load->view('Register/register.html');
	}

	public function register()
	{
		$this->load->view( 'Register/register.html' );
	}

	public function mb_register()
	{
		$data = $this->input->post(array('tel'));
		$this->load->view( 'Register/register-tel.html', $data );
	}

	public function mail_register()
	{
		$this->load->view( 'Register/register-mail.html' );
	}

	/*************/

	public function do_register()
	{
		if( ! $this->U->register() )
			echoJson( array('status'=>FALSE, 'error'=>$this->U->error) );

		//注销session
		$this->session->unset_userdata('code');

		echoJson( array('status'=>TRUE) );
	}

	public function check_user()
	{
		//接收参数
		$data = $this->input->post( array('tel') );

		if( ! $data['tel'] )
			echoJson( array('status'=>FALSE,'error'=>'无效手机号') );

		//验证用户手机号是否合法
		if( ! $this->U->check_user( $data ) )
			echoJson( array('status'=>FALSE,'error'=>'此手机号已经注册！') );

		//发送验证码,返回数据
		if( $this->session->code )
			echoJson(array('status'=>FALSE, 'error'=>'验证码已经发送到您的手机，请注意查收'));

		$result = $this->send_msg( $data['tel'], 'code' );

		if( ! $result['status'] )
			echoJson(array('status'=>FALSE, 'error'=>$result['error']));
		echoJson( array( 'status'=>TRUE ) );
	}

	public function send_msg_again()
	{
		$data = $this->input->post( array('tel') );

		if( ! $data['tel'] )
			echoJson( array('status'=>FALSE,'error'=>'非法操作') );

		if( ! $this->session->code )
			echoJson( array('status'=>FALSE,'error'=>'非法操作') );

		$result = $this->send_msg( $data['tel'], 'code' );

		if( ! $result['status'] )
			echoJson( array('status'=>FALSE,'error'=>$result['error']) );

		echoJson( array('status'=>TRUE) );
	}

	/*private*/
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