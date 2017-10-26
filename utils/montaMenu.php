<?php
class montaMenu{

	public static function geraMenu($modulo, $iduser, $admin){
		global $menu;
		$funcionalidade = new funcionalidade();

		if ($admin) {
			if($modulo == 1){
				$param = "f LEFT JOIN paginas p ON (f.id = p.funcionalidade AND p.inicial IS TRUE) WHERE f.menu IS TRUE AND pai IS NULL ORDER BY ordem, nome";
			} else {
				$param = "f LEFT JOIN paginas p ON (f.id = p.funcionalidade AND p.inicial IS TRUE) WHERE f.menu IS TRUE AND pai IS NULL AND (f.id IN (SELECT funcionalidade FROM funcionalidades_modulos WHERE modulo = $modulo) OR tipo = 'D') ORDER BY ordem, nome";
			}
		} else {
			$param = "f LEFT JOIN paginas p ON (f.id = p.funcionalidade AND p.inicial IS TRUE) WHERE menu IS TRUE AND pai IS NULL AND (f.id IN (SELECT funcionalidade FROM funcionalidades_modulos WHERE modulo = $modulo AND id IN (SELECT funcionalidade_modulo FROM permissoes WHERE usuario = $iduser)) OR tipo= 'D') ORDER BY ordem, nome";
		}

		$rs = $funcionalidade->getFieldsByParameter("f.id, f.nome, f.pai, f.menu, f.icone, f.ordem, f.tipo, f.descricao, p.pagina, p.target", $param);
		$total = count($rs);
		$conta = 1;
		$menu = "[";
		for($i=0; $i< $total; $i++){
            $row_rs = $rs[$i];
			$menu = $menu. "['<img src=\"../common/icones/".$row_rs['icone']."\"/>','".$row_rs['nome']."','".$row_rs['pagina']."','".$row_rs['target']."',null";
			if (self::checkFilhos($row_rs['id'], $funcionalidade, $modulo, $iduser, $admin)){
				self::pegaFilhos($row_rs['id'], $funcionalidade, $modulo, $iduser, $admin);
			}
			if ($conta < $total) {
				$menu = $menu . "],";
			} else {
				$menu = $menu . "]";
			}
			$conta++;
		}
		$menu = $menu . "]";
		unset($rs);
		return $menu;
	}
	// Funções de manipulação do Menu

	private static function checkFilhos($id, $funcionalidade, $modulo, $iduser, $admin){
		if ($admin) {
			if($modulo == 1){
				$parame = "WHERE pai = $id AND menu IS TRUE ORDER BY ordem, nome";
			} else {
				$parame = "WHERE pai = $id AND menu IS TRUE AND id IN (SELECT funcionalidade FROM funcionalidades_modulos WHERE modulo = $modulo) ORDER BY ordem, nome";
			}
		} else {
			$parame = "WHERE pai=$id AND menu IS TRUE AND id IN (SELECT funcionalidade FROM funcionalidades_modulos WHERE modulo = $modulo AND id IN (SELECT funcionalidade_modulo FROM permissoes WHERE usuario = $iduser)) ORDER BY ordem, nome";
		}

		$rs = $funcionalidade->getFieldsByParameter("*", $parame);
		if (count($rs)>0) {
			return true;
		} else {
			return false;
		}
	}

	private static function pegaFilhos($id, $funcionalidade, $modulo, $iduser, $admin){
		global $menu;
		if ($admin) {
			if($modulo == 1){
				$paramt = "f LEFT JOIN paginas p ON (f.id = p.funcionalidade AND p.inicial IS TRUE) WHERE pai=$id AND menu IS TRUE ORDER BY ordem, nome";
			} else {
				$paramt = "f LEFT JOIN paginas p ON (f.id = p.funcionalidade AND p.inicial IS TRUE) WHERE pai=$id AND menu IS TRUE AND f.id IN (SELECT funcionalidade FROM funcionalidades_modulos WHERE modulo = $modulo) ORDER BY ordem, nome";
			}
		} else {
			$paramt = "f LEFT JOIN paginas p ON (f.id = p.funcionalidade AND p.inicial IS TRUE) WHERE pai=$id AND menu IS TRUE AND f.id IN (SELECT funcionalidade FROM funcionalidades_modulos WHERE modulo = $modulo AND id IN (SELECT funcionalidade_modulo FROM permissoes WHERE usuario = $iduser)) ORDER BY ordem, nome";
		}

		$rs = $funcionalidade->getFieldsByParameter("f.id, f.nome, f.pai, f.menu, f.icone, f.ordem, f.tipo, f.descricao, p.pagina, p.target", $paramt);
		$total = count($rs);
        for($i=0; $i< $total; $i++){
            $row_rs = $rs[$i];
            $menu = $menu . ",['<img src=\"../common/icones/".$row_rs['icone']."\"/>','".$row_rs['nome']."','".$row_rs['pagina']."','".$row_rs['target']."',null";
			if (self::checkFilhos($row_rs['id'], $funcionalidade, $modulo, $iduser, $admin)){
				self::pegaFilhos($row_rs['id'], $funcionalidade, $modulo, $iduser, $admin);
				$menu = $menu . "],";
			} else {
				$menu = $menu . "]";
			}
		}
	}
}