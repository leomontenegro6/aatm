<?php
class usuarioScriptDao extends abstractDao{
	
	public function __construct(){
		$this->campos = array(
			'usuario'=>array(
				'tipo'=>'int',
				'required'=>true
			),
			'script'=>array(
				'tipo'=>'int',
				'required'=>true
			)
		);
		
		parent::__construct('aatm', 'usuarios_scripts');
	}
}