<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Comment_model extends LZ_Model
{
	protected static $_table = 'comment';		//绑定表
	private static $_pk	   = null;			//主键
	private static $_rules = array(
								// array(
								// 		'field'		=>	'title',
								// 		'label'		=>	'title',
								// 		'rules'		=>	'required|min_length[6]|max_length[300]',
								// 		'errors'	=>	array(
								// 				'required'			=>	'nothing',	
								// 				'min_length'		=>	'too short',
								// 				'max_length'		=>	'too long',
								// 			),
								// 	),
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
	 * [Com_all 获取评论结果集]
	 * @return [type] [description]
	 */
	private function Com_all( $topic_id )
	{
		$this->db->where( 'topic_id', $topic_id );
		return $this->get_all(self::$_table);
	}

	/**
	 * [Replay_all 获取回复结果集]
	 * @param [type] $topic_id [description]
	 */
	public function Replay_all( $topic_id )
	{
		$this->db->where( 'topic_id', $topic_id );
		return $this->get_all( 'emp_replay' );
	}

	public function get_CR()
	{
		//接收数据
		$data = $this->input->get( array('id') );
		$topic_id = $data['id'];

		//判断参数合法性
		if( ! like_int( $topic_id ) || $topic_id == 0 )
			return FALSE;

		//根据参数提取数据
		$comment = $this->Com_all( $topic_id )->result_array();
		$replay = $this->Replay_all( $topic_id )->result_array();

		//数据集合
		$result = array();

		foreach( $comment as $k => $v )
		{
			foreach( $replay as $kk => $vv )
			{
				if ( $v['id'] == $vv['com_id'] )
				{
					$v['replay'][] = $vv;
				}	
				unset( $replay[$kk] );
			}
			$result[] = $v;
			unset( $comment[$k] );
		}
		return array('result'=>$result,'tid'=>$topic_id);
	}

	/**
	 * [add_comment 添加评论]
	 * @param [type] $data [数据]
	 */
	public function add_comment( $data = null )
	{
		//传值添加
		if( $data !== null )
			return $this->add( self::$_table, $data );

		//表单添加
		$data = $this->input->post(null,TRUE);
		// dump($data);
		//字段验证
		$this->load->library('form_validation');

		//设置验证规则
		$rules = $this->form_validation->set_rules(self::$_rules);
		
		if( $this->form_validation->run() == FALSE ) 
		{
			return FALSE;
		}
		else
		{
			return $this->add( self::$_table, $data );
		}
	}

	/**
	 * [_before_add description]
	 * @param  [type] &$data [description]
	 * @return [type]        [description]
	 */
	public function _before_add( &$data ) 
	{
		//添加时间字段
		$data['time']		 	= 	time();
		$data['user_id']		=	(int)$this->session->home_id;	
	}

	/**
	 * [set_nice_incre description]
	 */
	public function set_nice_incre()
	{
		//接受数据
		$data = $this->input->post();
		//判断数据合法性
		if ( ! like_int ( $data['id'] ) )
			return FALSE;

		$setNum = $this->_get_auto_value( self::$_table, (int)$data['id'], 'nice' );
		
		return $this->save( self::$_table, array('nice'=>(int)$setNum,'id'=>(int)$data['id']) );
	}

	public function set_bad_incre()
	{
		//接受数据
		$data = $this->input->post();

		if ( ! like_int( $data['id'] ) )
			return FALSE;

		$setNum = $this->_get_auto_value( self::$_table, $data['id'], 'bad' );

		return $this->save( self::$_table, array('id'=>(int)$data['id'],'bad'=>(int)$setNum) );
	}

	/**
	 * [_before_save description]
	 * @param  [type] &$data [description]
	 * @return [type]        [description]
	 */
	protected function _before_save( &$data ) {}

}
