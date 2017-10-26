<?php
class relogio{
    var $stime;
    var $etime;
    function __construct(){
        $this->stime = $this->get_microtime();
    }
    function get_microtime() {
        $tmp = explode(' ',microtime());
        return $tmp[0]+$tmp[1];
    }
    function elapsed_time(){
        $this->etime = $this->get_microtime();
		$valor = $this->etime - $this->stime;
		$valor = number_format($valor, 3, '.', ' ');
        return $valor;
    }
}
?>