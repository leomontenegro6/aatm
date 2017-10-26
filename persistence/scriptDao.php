<?php
class scriptDao extends abstractDao{
	
	public function __construct(){
		$this->campos = array(
			'caso'=>array(
				'tipo'=>'int',
				'required'=>true
			),
			'idioma'=>array(
				'tipo'=>'int',
				'required'=>true
			),
			'arquivo_original'=>array(
				'tipo'=>'string',
				'required'=>true,
				'normalize'=>false
			),
			'arquivo_traduzido'=>array(
				'tipo'=>'string',
				'normalize'=>false
			)
		);
		
		parent::__construct('aatm', 'scripts');
	}
}