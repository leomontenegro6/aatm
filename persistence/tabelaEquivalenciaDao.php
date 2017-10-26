<?php
class tabelaEquivalenciaDao extends abstractDao{
	
	public function __construct(){
		$this->campos = array(
			'jogo'=>array(
				'tipo'=>'int',
				'required'=>true
			),
			'codigo'=>array(
				'tipo'=>'int',
				'required'=>true
			),
			'nome_original'=>array(
				'tipo'=>'string',
				'required'=>true,
				'normalize'=>false
			),
			'nome_adaptado'=>array(
				'tipo'=>'string',
				'normalize'=>false
			)
		);
		
		parent::__construct('aatm', 'tabelas_equivalencias');
	}
}