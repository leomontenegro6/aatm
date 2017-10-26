<?php
class alternativaDao extends abstractDao{
	
	public function __construct(){
		$this->campos = array(
			'enquete'=>array(
				'tipo'=>'int',
				'required'=>true
			),
			'texto'=>array(
				'tipo'=>'string',
				'required'=>true,
				'normalize'=>false
			)
		);
		
		parent::__construct('aatm', 'alternativas');
	}
}