<?php
class database{

    private $pdo;
    private $dsn;
    private $username;
    private $password;
    private $dbname;
	private $showError = 't';
	private $timeout = 2;
	public static $transacoes = array();

	public function __construct($dbname='aatm'){
		if(file_exists('dbconfig.php')){
			include_once('dbconfig.php');
		}
		if(!isset($dbconfig)){
			$dbconfig = array(
				'dsn'=>'mysql:host=localhost;port=3306;dbname=' . $dbname,
				'username'=>'root',
				'password'=>'123456'
			);
		}
		 
		$this->dbname = $dbname;
		$this->dsn = $dbconfig['dsn'];
		$this->username = $dbconfig['username'];
		$this->password = $dbconfig['password'];
        
        $this->options = array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_CASE => PDO::CASE_LOWER,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
            PDO::ATTR_TIMEOUT=>$this->timeout,
            PDO::MYSQL_ATTR_DIRECT_QUERY=>TRUE);
	}

	private function connect(){
		try {
			$this->pdo = new PDO($this->dsn, $this->username, $this->password, $this->options);
		} catch (PDOException $e) {
			$this->trataException($e);
		}
    }

    private function disconnect(){
		unset($this->pdo);
		if(isset($this->pdo)){
			return false;
		}else{
			return true;
		}
    }

    public function get($parametro){
		$this->connect();
		$select = $parametro;
		try {
			//echo $select."<br />";// <-Descomentar para Debug
			$query = $this->pdo->query($select);			
			$this->disconnect();
			return $query;
		} catch (PDOException $e) {
			$this->trataException($e);
			$this->disconnect();
			return false;
		}
    }
	
	public function getAutoincrement($dbname, $tabela){
		$this->connect();
		try {
			$query = $this->pdo->query("SELECT AUTO_INCREMENT AS id
				FROM INFORMATION_SCHEMA.TABLES
				WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = '$tabela'");
			$this->disconnect();
			$rs = $query->fetchAll();
			if (count($rs) == 0) {
				return FALSE;
			} else {
				return $rs[0]['id'];
			}
		} catch (PDOException $e) {
			$this->trataException($e);
			$this->disconnect();
			return false;
		}
    }

	public function set($parametro,$tabela, $commit=true){
		if (strpos($tabela, ".") === false) {
			$tabela = $this->dbname.".".$tabela;
		}
		$select = 'INSERT INTO ' . $tabela . ' ' . $parametro;
        //echo $select;
		return $this->addConsulta($select, $commit);
	}

    public function update($parametro, $tabela, $id, $commit=true){
		if (strpos($tabela, ".") === false) {
			$tabela = $this->dbname.".".$tabela;
		}
		$select = 'UPDATE '.$tabela.' SET '. $parametro . ' WHERE id = '. $id;
		//echo $select;
		return $this->addConsulta($select, $commit);
    }
	
	public function delete($tabela, $id, $commit=true){
		return $this->deleteByCampo($tabela, 'id', $id, $commit);
	}
	
	public function deleteByCampo($tabela, $campo, $valor, $commit=true){
		if (strpos($tabela, ".") === false) {
			$tabela = $this->dbname.".".$tabela;
		}
		$select = 'DELETE FROM '.$tabela.' WHERE '.$campo.'='.$valor;
		return $this->addConsulta($select, $commit);
	}

    /**  Executa uma transação no banco com auditoria.
     *  
     * @param array $array_sql Array com consultas SQL.
     * @return string|boolean
     */
	public function makeTransaction($array_sql){
		$this->connect();
		$ambiente = mensagens::getAmbienteDesenvolvimento();
		try {            
			$this->pdo->beginTransaction();
			$total_transacoes = count($array_sql);
			if($total_transacoes > 0){
				// ***** É OBRIGATÓRIO INFORMAR O SCHEMA NOS SQL's *****
				depuracao::limparConsultasSessao();
				for ($i=0; $i<$total_transacoes;$i++){
					$select = $array_sql[$i]['sql'];
					
					depuracao::salvarConsultaSessao($select);
					
                    $operacao = strtoupper(substr($select, 0, 6));
                    
                    if ($operacao == "DELETE") {
                        $str = substr($select, stripos($select, "FROM") + 4);
						$str = preg_replace("/\s+/", " ", $str);
                        $esquema = trim(substr($str, 0, stripos($str, ".")));                        
                        $str = substr($str, stripos($str, ".") + 1);
                        $tabela = trim(substr($str, 0, stripos($str, " ")));
                        $alias = "";
                        $str = substr($str, stripos($str, " "));
                        $alias = trim(substr($str, 0, stripos($str, "WHERE")));
						if (stripos($str, "WHERE")) {
							$condicao = substr($str, stripos($str, "WHERE") + 6); 
						} else {
							$condicao = "true";
						}
                    }else if ($operacao == "UPDATE") {
                        $str = substr($select, stripos($select, "UPDATE") + 6);
						$str = preg_replace("/\s+/", " ", $str);
                        $esquema = trim(substr($str, 0, stripos($str, ".")));
                        $str = substr($str, stripos($str, ".") + 1);
                        $tabela = trim(substr($str, 0, stripos($str, " ")));
                        $alias = "";
                        $str = substr($str, stripos($str, " "));
                        $alias = trim(substr($str, 0, stripos($str, "SET ")));
                        $str = substr($str, stripos($str, "SET ") + 4);
                        $tmp = $str;
                        $x = 0;
						
						while (stripos($tmp, "WHERE") > stripos($tmp, "(")) {
							$tmp = substr($tmp, stripos($tmp, "(") + 1);
                            $x++;
                            while ($x > 0) {
                                if (stripos($tmp, ")") > stripos($tmp, "(") && strpos($tmp, "(") > 0) {
                                    $tmp = substr($tmp, stripos($tmp, "(") + 1);
                                    $x++;
                                }
                                else {
                                    $tmp = substr($tmp, stripos($tmp, ")") + 1);
                                    $x--;
                                }
                            }  
                        }
                        $condicao = trim(substr($tmp, stripos($tmp, "WHERE ") + 5));
                    }else if ($operacao == "INSERT") {
                        $str = substr($select, stripos($select, "INTO") + 4);
						$str = preg_replace("/\s+/", " ", $str);
                        $esquema = trim(substr($str, 0, stripos($str, ".")));
                        $str = substr($str, stripos($str, ".") + 1);
                        $tabela = trim(substr($str, 0, stripos($str, " "))); 
                        $dados_anteriores[] = ' ';
					}
                    $stmt = $this->pdo->exec($select);
					
					if($stmt!==false){
						$this->setLog(($esquema.".".$tabela),$select,'T','S',$dados_anteriores);
                        unset($dados_anteriores);
						$status = true;
					}else{						
						$this->pdo->rollback();
                        $this->setLog(($esquema.".".$tabela),$select,'T','F',$dados_anteriores);
                        unset($dados_anteriores);
						$this->disconnect();
						return false;
					}
				}
			}else{
				$status = false;
			}
            unset($dados_anteriores);
			if ($status){
				$this->pdo->commit();	                
				$this->disconnect();
				return true;
			}else{
				$this->pdo->rollback();	                
				$this->disconnect();
				return 'Não há instruções a serem processadas!';
			}
		} catch (PDOException $e) {
			$this->trataException($e);
			unset ($dados_anteriores);
			$this->disconnect();
			return $this->getErro($e->getCode());
		}
	}

	private function getErro($erro=0){
		if ($erro == 23505){
			return 'Já existe um registro cadastrado com os dados informados!';
		}elseif ($erro == 23503){
			return 'Esse registro está sendo usado pelo sistema e não pode ser excluído!';
		}elseif ($erro == 23502){
			return 'Valores nulos não são permitidos!';
		}elseif ($erro == 22007){
			return 'Formato de data inválido!';
		}elseif ($erro == 42601){
			return 'Formato do dado incorreto!';
		}elseif ($_SERVER['HTTP_HOST'] == 'localhost') { 
			if ($erro == 42501){
				return '(DEV) Permissão negada!';			
			}elseif ($erro == 42703){
				return '(DEV) Campo de tabela desconhecido ou incorreto!';			
			}elseif ($erro == 22021){
				return '(DEV) Caractere inválido!';			
			}elseif ($erro == 55000){
				return '(DEV) Sequencia inválida!';
			}else{
				return 'Erro desconhecido! ('.$erro.')';
			}
		}else{			
			return 'Erro desconhecido! ('.$erro.')';
		}
	}
	
	private function trataException($e){
		if($this->showError == 't'){
			echo 'Erro: '.$e->getMessage().'<br />';
			//echo "***".$e->getCode()."***";
		}
	}
	
	public function commit() {
		return $this->makeTransaction(database::$transacoes);
	}
	
	public function addConsulta($sql, $commit = false) {
		$i = count(database::$transacoes);
		database::$transacoes[$i]['sql'] = $sql;
		if ($commit === true) {
			return $this->commit();
		} else {
			return true;
		}
	}
	
	public function getTransactionsForDebug(){
		$ambiente = mensagens::getAmbienteDesenvolvimento();
		if ($ambiente == 'D' || $ambiente == 'H') {
			return database::$transacoes;
		} else {
			return array();
		}
	}
}
