<?php
class casoDao extends abstractDao{
	
	public function __construct(){
		$this->campos = array(
			'jogo'=>array(
				'tipo'=>'int',
				'required'=>true
			),
			'nome'=>array(
				'tipo'=>'string',
				'required'=>true,
				'normalize'=>false
			)
		);
		
		parent::__construct('aatm', 'casos');
	}
}