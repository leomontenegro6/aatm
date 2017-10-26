<?php
//A assinatura dos métodos poder ser modificadas e caso mude os parâmetros
//pode acusar erro de "stric standards"
error_reporting(~E_STRICT);

/**
 * Classe abstrata que implementa as regras de negócio genéricas para todas as entidades.
 * Qualquer função pode ser sobrescrita sem problemas.
 * Método set() não está implementado aqui.
 * Na classe filha é OBRIGATÓRIO utilizar o método construtor abaixo:
 * public function __construct(){
	  parent::__construct(get_class($this));
   }
 * @author Felizardo Charles
 */
abstract class abstractBusiness{

	protected $dao;
	protected $campos = array();
	protected $nome_classe;
	protected static $retornos_funcoes = array();


	/** Função que realiza o auto carregamento da classe
     * @param String $class_name Nome da classe atual
     */
	function __autoload($class_name){
        if(file_exists($class_name . '.php')){
            require_once $class_name . '.php';
        }elseif(file_exists('../utils/'. $class_name . '.php')){
            require_once '../utils/'. $class_name . '.php';
        }else{
            require_once '../'.$class_name . '.php';
        }
    }

	/** Construtor da classe*/
	public function __construct($classe = null){
		if(empty($classe)) {
			$classe = get_class($this);
		}
		
		$this->nome_classe = $classe;
		$classeDao = $classe.'Dao';
		$this->dao = new $classeDao();
		$this->campos = $this->dao->campos;
    }

	/** Método mágico para obter ou atualizar um só campo com a finalidade de deixar o código mais limpo.
	 * OBS.: É OBRIGATÓRIO PASSAR O ID POIS A IMPLEMENTAÇÃO DE OO AQUI NÃO É COMPLETA, É TRATADA POR ARRAYS.
	 * Não é necessário redeclarar nas classes filhas.
	 *
	 * Sintaxe de chamada:
	 * getCampo(id);
	 * getCampo_resto(id);
	 *
	 * setCampo(valor,id);//Se o campo for String passar o valor entre aspas simples
	 * setCampo_resto(valor,id);
	 * OBS.: MÉTODO SET NÃO RETORNA MENSAGEM DE SUCESSO.
	 */
	public function __call($funcao, $parametros){
		if(isset($parametros) && !empty($parametros) && (count($parametros > 0))){
			$metodo  = substr($funcao, 0, 3);
			$campo = strtolower(substr($funcao, 3));
			if($metodo == 'get'){
				$id = $parametros[0];
				$formatoTexto = (isset($parametros[1])) ? ($parametros[1]) : ('');
				$retorno = $this->dao->get($campo, 'WHERE id = '.$id)->fetch(PDO::FETCH_ASSOC);
				if($retorno){
					if(is_string($retorno[$campo])){
						if(empty($formatoTexto)){
							$formatoTexto = 'c';
						}

						if($formatoTexto == 'c'){
							return mensagens::capitaliza($retorno[$campo]);
						} elseif($formatoTexto == 'u'){
							return mensagens::upper($retorno[$campo]);
						} else {
							return $retorno[$campo];
						}
					} else {
						return $retorno[$campo];
					}
				} else {
					return '';
				}
			}elseif(($metodo == 'set') && (count($parametros) > 1)){
				$valor = mensagens::ajustaParametro($parametros[0], $this->campos[$campo]['tipo']);
				$id = $parametros[1];
				if(isset($parametros[2])){
					$commit = $parametros[2];
				} else {
					$commit = true;
				}
				$retorno = $this->dao->setCampo("$campo = $valor", $id, $commit);
				if ($retorno === true){
					return true;
				} else {
					return 'Erro ao inserir! ' . $retorno;
				}
			}else{
				throw new Exception('Erro de Sintaxe: O método "' . $funcao . '" não existe ou os parâmetros não foram informados!');
			}
		}else{
			throw new Exception('Erro de Sintaxe: Parâmetros inválidos ou não informados!');
		}
	}

	/** Retorna todos os campos da tabela.
     * @return Matriz Result set.
     */
	public function getAll(){
        return $this->dao->get('','')->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Retorna linhas da tabela de acordo com os parâmetros especificados.
     * @param Array $parametro Parâmetros da busca.
     * @return Matriz Result set.
     */
	public function getByParameter($parametro){
        return $this->dao->get('',$parametro)->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Retorna campos da tabela de acordo com os campos e parâmetros
     * especificados.
     * @param Array $campos Campos desejados no retorno.
     * @param Array $parametro Parâmetros da busca.
     * @return Matriz Result set.
     */
	public function getFieldsByParameter($campos,$parametro){
        return $this->dao->get($campos,$parametro)->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Retorna o campo da tabela especificado pelo ID.
     * @param Inteiro $id Id do objeto buscado.
     * @return Array Linha da tabela.
     */
	public function get($id){
		return $this->dao->get('', 'where id = '.$id)->fetch(PDO::FETCH_ASSOC);
    }

	/** Retorna o total de registros, com base nos parametros passados.
	 * Feito para agilizar a performance das primeiras consultas das paginações.
	 * Declarada no abstractDao.
	 * @param Array $sql - Consulta sem os campos.
	 * @return total ou false em caso de erro.
	 */
	function getTotal($sql=''){
		$total_row = $this->dao->getTotal($sql)->fetch(PDO::FETCH_ASSOC);
		return $total_row['total'];
	}

    function checkUnicidadeComposta($post, $id='', $acao='cadastrar'){
        $unicidade = array();
        foreach ($this->campos as $nome => $metadados) {
            if(isset($metadados['unico_composto']) && $metadados['unico_composto'] === true){
                $unicidade[] = $nome;
            }
        }

        $total_unicidade = count($unicidade);
        if($total_unicidade > 0){
            $passou_o_campo = false;

            $condicao = "where ";
            if($acao == 'editar'){
                $condicao .= "id <> $id and ";
            }
            $cont = 0;
            $sql = '';
            foreach ($unicidade as $i => $campo) {
                if(isset($post[$campo])){
                    $passou_o_campo = true;
                    if($cont > 0){
                        $sql .= " and ";
                    }
                    $sql .= "$campo = '{$post[$campo]}'";
                    $cont++;
                }
            }

            if($passou_o_campo === true){
                $sql = $condicao . $sql;
                $classe_rs = $this->dao->get('*', $sql)->fetchAll(PDO::FETCH_ASSOC);
                if (count($classe_rs) > 0){
                    return "Erro ao $acao!<br /><br />Já existe um registro cadastrado com os valores informados.";
                }
            }
        }
        return true;
    }

	public function set($post, $commit=true) {
		$campos = "";
		$valores = "";

        $checkUnicidade = $this->checkUnicidadeComposta($post);
        if($checkUnicidade !== true){
            return $checkUnicidade;
        }

		foreach ($this->campos as $nome => $metadados) {
			if(isset($post[$nome])) {
				$valor = $post[$nome];
			} else {
				$valor = "";
			}

            // Depois de checar a unicidade composta, verificar a unicidade
            // específica do campo. Só alterei isso.
            if(isset($metadados['unico']) && $metadados['unico'] === true){
                $classe_rs = $this->dao->get('*', "where $nome = '$valor'")->fetchAll(PDO::FETCH_ASSOC);
                if (count($classe_rs) > 0){
                    return "Erro ao cadastrar!<br /><br />Já existe um registro cadastrado com o valor: \"$nome\"= \"$valor\".";
                }
            }

			$tipo = $metadados['tipo'];
			if(isset($metadados['default'])){
				$valor_padrao = $metadados['default'];
			} else {
				$valor_padrao = "NULL";
			}

			$checkObrigatorio = (isset($metadados['required']) && $metadados['required'] === true);
			if(isset($metadados['normalize'])){
				$checkNormalizar = ($metadados['normalize'] === true);
			} else {
				$checkNormalizar = true;
			}

			if (!empty($campos)) {
				$campos .= ",";
				$valores .= ",";
			}
			$campos .= $nome;

			$valor_ajustado = mensagens::ajustaParametro($valor, $tipo, $checkNormalizar);
			if ($valor_ajustado == "NULL" && !empty($valor_padrao)) {
				$valor_ajustado = $valor_padrao;
			}
			if ($checkObrigatorio && $valor_ajustado == "NULL") {
				return "Preencha todos os campos obrigatórios!<br /><br />Campo não preenchido: \"$nome\".";
			}
			$valores .= $valor_ajustado;
		}
		return $this->dao->set($campos, $valores, $commit);
	}

	public function update($post, $id, $commit=true) {
		if (empty($id)) {
			return "Objeto não foi identificado!";
		}

        $checkUnicidade = $this->checkUnicidadeComposta($post, $id, 'editar');
        if($checkUnicidade !== true){
            return $checkUnicidade;
        }

		$parametro = "";
		foreach ($this->campos as $nome => $metadados) {
			if(isset($post[$nome])) {
				$valor = $post[$nome];

                // Depois de checar a unicidade composta, verificar a unicidade
                // específica do campo
                if(isset($metadados['unico']) && $metadados['unico'] === true){
                    $classe_rs = $this->dao->get('*', "where id <> $id and $nome = '$valor'")->fetchAll(PDO::FETCH_ASSOC);
                    if (count($classe_rs) > 0){
                        return "Erro ao editar!<br /><br />Já existe um registro cadastrado com o valor: \"$nome\"= \"$valor\".";
                    }
                }

				$tipo = $metadados['tipo'];
				if(isset($metadados['default'])){
					$valor_padrao = $metadados['default'];
				} else {
					$valor_padrao = "NULL";
				}

				$checkObrigatorio = (isset($metadados['required']) && $metadados['required'] === true);
				if(isset($metadados['normalize'])){
					$checkNormalizar = ($metadados['normalize'] === true);
				} else {
					$checkNormalizar = true;
				}

				$valor_ajustado = mensagens::ajustaParametro($valor, $tipo, $checkNormalizar);
				if ($valor_ajustado == "NULL" && !empty($valor_padrao)) {
					$valor_ajustado = $valor_padrao;
				}
				if ($checkObrigatorio && $valor_ajustado == "NULL") {
					return "Preencha todos os campos obrigatórios!<br /><br />Campo não preenchido: \"$nome\".";
				}

				if (!empty($parametro)) {
					$parametro .= ",";
				}
				$parametro .= $nome."=".$valor_ajustado;
			}
		}
		return $this->dao->update($parametro, $id, $commit);
	}

	/** Exclui linha da tabela.
	 * @param Inteiro $id - identificador do objeto a ser excluído.
	 * @param Boolean $commit - Define se a consulta será imediatamente executada, ou se esta fará parte de uma transação.
	 * @return Boolean True ou False
	 */
	public function delete($id, $commit=true){
		return $this->dao->delete($id, $commit);
	}

	/** Exclui linha da tabela, com base no nome de um campo da tabela.
	 * @param Inteiro $campo - nome do campo a usar como base na remoção.
	 * @param Inteiro $valor - valor do campo a usar como base na remoção.
	 * @param Boolean $commit - Define se a consulta será imediatamente executada, ou se esta fará parte de uma transação.
	 * @return Boolean True ou False
	 */
	public function deleteByCampo($campo, $valor, $commit=true){
		if(!empty($campo) && !empty($valor)){
			return $this->dao->deleteByCampo($campo, $valor, $commit);
		} else {
			return 'Os parâmetros de campo ou valor não forma fornecidos.';
		}
    }

	/** Retorna id do próximo elemento a ser inserido na tabela.
	* @return Inteiro $id
	*/
	public function getNextid() {
		return $this->dao->getNextid();
	}

	/** Executa o commit da fila de consultas.
	* @return Boolean True ou False
	*/
	public function commit() {
		return $this->dao->commit();
	}

	/** Retorna todas as consultas adicionadas através do método "addConsulta".
    *  O método funciona apenas no ambiente de desenvolvimento, retornando um array
    *  vazio caso chamado a partir de outros ambientes.
	* @return Array contendo todas as consultas SQL
	*/
	public function getTransactionsForDebug(){
		return $this->dao->getTransactionsForDebug();
	}
}