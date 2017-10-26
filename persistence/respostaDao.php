<?php
class respostaDao extends abstractDao{
	
	public function __construct(){
		$this->campos = array(
			'usuario'=>array(
				'tipo'=>'int',
				'required'=>true
			),
			'alternativa'=>array(
				'tipo'=>'int',
				'required'=>true
			)
		);
		
		parent::__construct('aatm', 'respostas');
	}
}