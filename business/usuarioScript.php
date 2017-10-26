<?php
class usuarioScript extends abstractBusiness{

	public function getTotalByListagem($texto){
		return $this->getTotal("WHERE texto LIKE '%$texto%'");
	}

	public function getByListagem($texto, $ordenacao='id', $filtragem='ASC', $limit=15, $offset=0){
		return $this->getFieldsByParameter("id, texto", "WHERE texto LIKE '%$texto%' ORDER BY $ordenacao $filtragem LIMIT $limit OFFSET $offset");
	}
}