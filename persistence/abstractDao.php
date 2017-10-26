<?php
error_reporting(~E_STRICT);

abstract class abstractDao{

	protected $database;
	protected $schema;
	protected $tabela;
	protected $dbname;
	private $prefixo_dbname = 'id3329027_';
	public $campos = array();

	function __autoload($class_name){
		if(file_exists($class_name . '.php')){
			require_once $class_name . '.php';
//		}elseif(file_exists('../persistence/'. $class_name . '.php')){
//			require_once '../persistence/'. $class_name . '.php';
		}elseif(file_exists('../utils/'. $class_name . '.php')){
			require_once '../utils/'. $class_name . '.php';
		}else{
			require_once '../'.$class_name . '.php';
		}
	}

	public function __construct($schema, $tabela, $dbname='aade'){
		$ambiente = mensagens::getAmbienteDesenvolvimento();
		if($ambiente == 'D'){
			$this->schema = $schema;
		} elseif($ambiente == 'H'){
			$this->schema = $this->prefixo_dbname . $schema;
		} else {
			$this->schema = $schema;
		}
		$this->tabela = $tabela;
		$this->dbname = $dbname;
		$this->database = new database($this->schema, $this->dbname);
	}

	/** Retorna os campos especificados, com base nos parametros passados.
	 * @param Array $campos - Vetor com o nome dos campos desejados.
	 * @param Array $parametro - Vetor com o nome dos parâmetros da busca.
	 * @return Matriz/false Matriz com result set ou false em caso de erro.
	 */
	function get($campos,$parametro){
		if(strlen($campos)<=0){
			$campos = '*';
		}
		$select = 'select '.$campos.' from '.$this->tabela. ' ' . $parametro;
		return $this->database->get($select);
	}

	/** Retorna o total de registros, com base nos parametros passados.
	 * Feito para agilizar a performance das primeiras consultas das paginações.
	 * @param Array $sql - Consulta sem os campos.
	 * @return total ou false em caso de erro.
	 */
	function getTotal($sql){
		$select = 'select count(*) as total from '.$this->tabela. ' ' . $sql;
		return $this->database->get($select);
	}

	/**
	 * Atualiza um só campo.
	 * Utilizado no método mágico do abstract business quando o método de chamada for set.
	 * Não foi utilizado o método update abaixo pois o mesmo às vezes é sobrescrito.
	 */
	function setCampo($parametro,$id,$commit=true){
		return $this->database->update($parametro, $this->schema.".".$this->tabela, $id, $commit);
	}

	/** Atualiza valores na tabela.
	 * @param Array $parametro - vetor de parâmetros para atualização.
	 * @param Inteiro $id - identificador do objeto a ser atualizado.
	 * @param Boolean $commit - define se a consulta será imediatamente executada, ou se esta fará parte de uma transação.
	 * @return String Mensagem de sucesso/erro na transação.
	 */
	function update($parametro, $id, $commit=true){
		return $this->database->update($parametro, $this->schema.".".$this->tabela, $id, $commit);
	}

	/** Exclui linha da tabela.
	 * @param Inteiro $id - identificador do objeto a ser excluído.
	 * @return String Mensagem de sucesso/erro na transação.
	 */
	function delete($id, $commit=true){
		return $this->database->delete($this->tabela, $id, $commit);
	}

	function deleteByCampo($campo, $valor, $commit=true){
        return $this->database->deleteByCampo($this->tabela, $campo, $valor, $commit);
    }

	function set($campos, $valores, $commit=true) {
		$parametro = "(".$campos.") VALUES (".$valores.")";
		return $this->database->set($parametro, $this->schema.".".$this->tabela, $commit);
	}

	/** Executa o commit da fila de consultas.
	* @return Boolean True ou False
	*/
	function commit() {
		return $this->database->commit();
	}

	/** Retorna o id do próximo elemento a ser inserido na tabela.
	* @return Inteiro $id
	*/
	function getNextid() {
		return $this->database->getAutoincrement($this->dbname, $this->tabela);
	}

	/** Retorna todas as consultas adicionadas através do método "addConsulta".
    *  O método funciona apenas no ambiente de desenvolvimento, retornando um array
    *  vazio caso chamado a partir de outros ambientes.
	* @return Array contendo todas as consultas SQL
	*/
	function getTransactionsForDebug(){
		return $this->database->getTransactionsForDebug();
	}
}