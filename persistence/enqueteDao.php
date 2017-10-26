<?php
class enqueteDao extends abstractDao{
	
	public function __construct(){
		$this->campos = array(
			'id'=>array(
				'tipo'=>'int'
			),
			'texto'=>array(
				'tipo'=>'string',
				'required'=>true,
				'normalize'=>false
			)
		);
		
		parent::__construct('aatm', 'enquetes');
	}
}