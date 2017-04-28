<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Replay_model extends LZ_Model
{
	private static $_table = 'replay';
	private static $_rules = array(
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
		$data = $this->input->post(array('com_id','content'));

		/**///数据验证
		$this->load->library('from_validation');
		$this->from_validation->set_rules( self::$_rules );
		if ( $this->from_validation->run == FALSE )
			return FALSE;

		/**///添加动作
		return $this->add( self::$table, $data );
	}

	/**
	 * [_before_add description]
	 * @param  [type] &$data [description]
	 * @return [type]        [description]
	 */
	protected function _before_add( &$data ) {}

	protected function _after_add( $id ) {}

	public function set_nice_incre() 
	{
		/**///接收数据
		$data =	$this->input->post();

		/**///判断
		if ( ! like_int( $data['id'] ) )
			return FASLE;

		$newNum = $this->_get_auto_value( $pk, $field = null );

		return $this->save( self::$_table, array('id'=>$data['id'],'nice'=>$newNum) );
	}

	public function set_bad_incre() {}
}
