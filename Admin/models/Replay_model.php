<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Replay_model extends LZ_Model
{
	private static $_table = 'replay';
	private static $_rules = array(
								array(
										'field'		=>	'user_id',
										'label'		=>	'user_id',
										'rules'		=>	'required|integer',
										'errors'	=>	array(
												'required'			=>	'nothing',	
												'integer'			=>	'not int',	
											),
									),
								array(
										'field'		=>	'com_id',
										'label'		=>	'com_id',
										'rules'		=>	'required|integer',
										'errors'	=>	array(
												'required'			=>	'nothing',	
												'integer'			=>	'not int',	
											),
									),
								array(
										'field'		=>	'content',
										'label'		=>	'content',
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
	}

	/**
	 * [add_replay description]
	 */
	public function add_replay() 
	{
		/**///收集数据
		$data = $this->input->post(array('user_id','com_id','content'));

		/**///数据验证
		$this->load->library('form_validation');
		$this->form_validation->set_rules( self::$_rules );
		if ( $this->form_validation->run() == FALSE )
			return FALSE;
		
		/**///添加动作
		return $this->add( self::$_table, $data );
	}

	/**
	 * [_before_add description]
	 * @param  [type] &$data [description]
	 * @return [type]        [description]
	 */
	protected function _before_add( &$data ) 
	{
		$data['time'] = time();
	}

	protected function _after_add( $id ) {}

	public function set_nice_incre() 
	{
		/**///接收数据
		$data =	$this->input->post();

		/**///判断
		if ( ! like_int( $data['id'] ) )
			return FASLE;

		$newNum = $this->_get_auto_value( self::$_table, $data['id'], 'nice' );

		return $this->save( self::$_table, array('id'=>$data['id'],'nice'=>$newNum) );
	}

	public function set_bad_incre() 
	{
		/**///接收数据
		$data = $this->input->post();

		/**///判断
		if ( ! like_int( $data['id'] ) )
			return FASLE;

		$newNum = $this->_get_auto_value( self::$_table, $data['id'], 'bad' );

		return $this->save( self::$_table, array('id'=>$data['id'],'bad'=>$newNum) );
	}
}
