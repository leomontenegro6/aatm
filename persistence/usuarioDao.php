<?php
class usuarioDao extends abstractDao{
	
	public function __construct(){
		$this->campos = array(
			'login'=>array(
				'tipo'=>'string',
				'required'=>true,
				'normalize'=>false
			),
			'senha_sha1'=>array(
				'tipo'=>'string',
				'required'=>true,
				'normalize'=>false
			),
			'admin'=>array(
				'tipo'=>'boolean',
				'default'=>'false'
			)
		);
		
		parent::__construct('aatm', 'usuarios');
	}
}