<?php
class mensagens{

	public static function dataExtenso(){
		putenv("LANG=pt_BR.UTF-8");
		$oldlocale = setlocale(LC_ALL, NULL);
        setlocale(LC_ALL, 'pt_BR');
        return ucfirst(strftime(" &nbsp;&nbsp; %d/%m/%Y, %A", strtotime(date('Y/m/d'))));
        setlocale(LC_ALL, $oldlocale);
    }

	public static function capitaliza($inputString){
		$retorno = array();
		$outputString    = utf8_decode($inputString);
		$outputString    = strtolower($outputString);
		$outputString    = utf8_encode($outputString);
		$table = array(
			'À'=>'à', 'Á'=>'á', 'Â'=>'â', 'Ã'=>'ã', 'Ä'=>'ä', 'Ç'=>'ç', 'È'=>'è', 'É'=>'é', 'Ê'=>'ê', 'Ë'=>'ë',
			'Ì'=>'ì', 'Í'=>'í', 'Î'=>'î', 'Ï'=>'ï', 'Ñ'=>'ñ', 'Ò'=>'ò', 'Ó'=>'ó', 'Ô'=>'ô', 'Õ'=>'õ', 'Ö'=>'ö',
			'Ù'=>'ù', 'Ú'=>'ú', 'Û'=>'û', 'Ỳ'=>'ỳ', 'Ý'=>'ý', 'Ÿ'=>'ÿ', 'Ŕ'=>'ŕ',
		);
		$outputString = strtr($outputString, $table);
		$string = strtolower(trim(preg_replace("/\s+/", " ", $outputString)));
		$palavras = explode(" ", $string);

		$retorno[] = ucfirst($palavras[0]);
		unset($palavras[0]);

		foreach ($palavras as $palavra){
			if (preg_match("/^([ivx]?[xiv][xiv][xiv]?[xiv]?[:]?[.]?)$/i", $palavra)){ // Verifica se a palavra possui número(s) em algarismo romano seguido ou não de ':' ou '.'
				$palavra = strtoupper($palavra);
			}else if (!preg_match("/^([dn]?[aeou][s]?|em|para|ao|aos|sobre|com|por|que)$/i", $palavra)){ // Verifica se a palavra não possui preposições
				$palavra = ucfirst($palavra);
			}
			$retorno[] = $palavra;
		}
		return implode(" ", $retorno);
	}

	public static function capitalizaParagrafo($inputString){
		$outputString    = utf8_decode($inputString);
		$outputString    = strtolower($outputString);
		$primLetra       = substr($outputString, 0, 1);
		$primLetra       = strtoupper($primLetra);
		$outputString    = substr($outputString, 1);
		$outputString    = mensagens::lower(utf8_encode($outputString));
		$outputString    = $primLetra.$outputString;
		return $outputString;
	}

	public static function upper($inputString){
		$outputString    = utf8_decode($inputString);
		$outputString    = strtoupper($outputString);
		$outputString    = utf8_encode($outputString);
		$table = array(
			'à'=>'À', 'á'=>'Á', 'â'=>'Â', 'ã'=>'Ã', 'ä'=>'Ä', 'ç'=>'Ç', 'è'=>'È', 'é'=>'É', 'ê'=>'Ê', 'ë'=>'Ë',
			'ì'=>'Ì', 'í'=>'Í', 'î'=>'Î', 'ï'=>'Ï', 'ñ'=>'Ñ', 'ò'=>'Ò', 'ó'=>'Ó', 'ô'=>'Ô', 'õ'=>'Õ', 'ö'=>'Ö',
			'ù'=>'Ù', 'ú'=>'Ú', 'û'=>'Û', 'ỳ'=>'Ỳ', 'ý'=>'Ý', 'ÿ'=>'Ÿ', 'ŕ'=>'Ŕ',
		);
		$outputString = strtr($outputString, $table);
		return $outputString;
	}

	public static function lower($inputString){
		$outputString    = utf8_decode($inputString);
		$outputString    = strtolower($outputString);
		$outputString    = utf8_encode($outputString);
		$table = array(
			'À'=>'à', 'Á'=>'á', 'Â'=>'â', 'Ã'=>'ã', 'Ä'=>'ä', 'Ç'=>'ç', 'È'=>'è', 'É'=>'é', 'Ê'=>'ê', 'Ë'=>'ë',
			'Ì'=>'ì', 'Í'=>'í', 'Î'=>'î', 'Ï'=>'ï', 'Ñ'=>'ñ', 'Ò'=>'ò', 'Ó'=>'ó', 'Ô'=>'ô', 'Õ'=>'õ', 'Ö'=>'ö',
			'Ù'=>'ù', 'Ú'=>'ú', 'Û'=>'û', 'Ỳ'=>'ỳ', 'Ý'=>'ý', 'Ÿ'=>'ÿ', 'Ŕ'=>'ŕ',
		);
		$outputString = strtr($outputString, $table);
		return $outputString;
	}

	public static function normalize($string){ //Substitui os caracteres especiais por seus respectivos caracteres normais equivalentes ou remove-os
		$table = array(
			'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
			'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
			'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
			'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
			'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
			'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
			'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
			'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', '*'=>'', ';'=>'', '.'=>'', '\''=>'', '´'=>'', '_'=>' ',
		);
		return strtr($string, $table);
	}

	public static function formataSexo($sexo){
		switch ($sexo){
			case "M":
				$sexo_novo = "Masculino";
				break;
			case "F":
				$sexo_novo = "Feminino";
				break;
			case "I":
				$sexo_novo = "Indefinido";
				break;
			default:
				$sexo_novo = "Indefinido";
				break;
		}
		return $sexo_novo;
	}

	public static function formataDiaSemana($dia){ //recebe dia em valor numérico e retorna por extenso
		switch ($dia){
			case "1":
				$extenso = "Dom";
				break;
			case "2":
				$extenso = "Seg";
				break;
			case "3":
				$extenso = "Ter";
				break;
			case "4":
				$extenso = "Qua";
				break;
			case "5":
				$extenso = "Qui";
				break;
			case "6":
				$extenso = "Sex";
				break;
			case "7":
				$extenso = "Sab";
				break;
		}
		return $extenso;
	}

	public static function formataDiaSemanaCompleto($dia){ //recebe dia em valor numérico e retorna por extenso
		switch ($dia){
			case "1":
				$extenso = "Domingo";
				break;
			case "2":
				$extenso = "Segunda";
				break;
			case "3":
				$extenso = "Terça";
				break;
			case "4":
				$extenso = "Quarta";
				break;
			case "5":
				$extenso = "Quinta";
				break;
			case "6":
				$extenso = "Sexta";
				break;
			case "7":
				$extenso = "Sábado";
				break;
		}
		return $extenso;
	}
	
	public static function formataDiaSemanaCompletoPorData($data){
		$dia_semana = date('w', strtotime($data)) + 1;
		
		return self::formataDiaSemanaCompleto($dia_semana);
	}
	
	public static function formataTamanho($tamanho){
		if($tamanho < 1024){
			$tamanho_formatado = str_replace(".", ",", $tamanho) . " Kbytes";
		} else {
			$tamanho = number_format($tamanho / 1024, 2);
			$tamanho_formatado = str_replace(".", ",", $tamanho) . " Mbytes";
		}
		return $tamanho_formatado;
	}

	public static function encodeCpf($cpf){
		$tamanho_cpf = strlen($cpf);
		for ($i=$tamanho_cpf;$i<11;$i++){
			$cpf = "0".$cpf;
		}
		$parte1 = substr($cpf, 0, 3);
		$parte2 = substr($cpf, 3, 3);
		$parte3 = substr($cpf, 6, 3);
		$digito = substr($cpf, 9, 2);
		$cpf_string = $parte1.".".$parte2.".".$parte3."-".$digito;
		return $cpf_string;
	}

	public static function encodeFone($fone){
		$ddd = substr($fone, 0, 2);
		$prefixo = substr($fone, 2, 4);
		$sufixo = substr($fone, 6, 4);
		$fone_string = "(".$ddd.") ".$prefixo."-".$sufixo;
		return $fone_string;
	}

	public static function encodeCep($cep){
		$tamanho_cep = strlen($cep);
		for ($i=$tamanho_cep;$i<8;$i++){
			$cep = "0".$cep;
		}
		$parte1 = substr($cep, 0, 5);
		$parte2 = substr($cep, 5, 3);
		$cep_string = $parte1."-".$parte2;
		return $cep_string;
	}

	public static function dataSistemas(){
		$dd = date("d");
		$dia = date("D");
		$mes = date("m");
		$ano = date("Y");
		$mesext = array(1 =>"janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
		$diaext = array("Sun" => "Domingo", "Mon" => "Segunda-Feira", "Tue" => "Terça-Feira", "Wed" => "Quarta-Feira", "Thu" => "Quinta-Feira", "Fri" => "Sexta-Feira", "Sat" => "Sábado");
		$dataSistema = $dd . "/" . $mes . "/" . $ano . ",&nbsp;" . $diaext[$dia];
		return $dataSistema;
	}
    public static function dataExtensoCompleto($data=''){
        if($data == ''){
            $dd = date("d");
            $mes = date("m");
            $ano = date("Y");
        }else{
            $d = explode("-",$data);
            $dd = $d[2];
            $mes = $d[1];
            $ano = $d[0];
        }
		
		$mesext = array(1 =>"janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
		$dataSistema = $dd . " de " . $mesext[intval($mes)] . " de " . $ano;
		return $dataSistema;
	}
	
	public static function encodeFloatToTime($float, $arredondarSegundos=false){
		if($arredondarSegundos){
			$fraction = round(fmod($float, 1) * 60);
		} else {
			$fraction = fmod($float, 1) * 60;
		}
		
		return sprintf('%02d:%02d', (int)$float, $fraction);
	}

	public static function encodeData($data){
        if(empty($data)){
			return $data;
		}
		if(strpos($data, '/') === false){
            $data_hora = explode(' ', $data);
            $data = (isset($data_hora[0])) ? ($data_hora[0]) : ('');
			$data_encode = $data;
            $d = explode("-",$data);
            $data_encode = $d[2].'/'. $d[1] .'/'.$d[0];
		}else{
			return $data;
		}
		return $data_encode;
	}
	
	public static function encodeDataHora($data_hora){
        $d = explode("-",$data_hora);
        $data_encode = substr($d[2], 0, 2)."/". $d[1] ."/".$d[0];
		$hora = substr($d[2], 3);
		$h = explode(":", $hora);
		$hora_encode = $h[0].":".$h[1];
		$data_hora_encode = $data_encode." - ".$hora_encode;
		return $data_hora_encode;
	}
	
	public static function encodeMonetario($input,$casas=2){
		$separador = substr($input, ($casas*(-1)), 1);
		if($separador == ","){
			$input = str_replace(".", "", $input);
			$input = str_replace(",", ".", $input);
		}elseif($separador == "."){
			$input = $input;
		}else{
            $zeros = '0';
            for($i=0;$i<$casas;$i++){
                $zeros .= '0';
            }
			$casas_decimais = substr($input, ($casas*(-1)), $casas);
			if(($casas_decimais != ",$zeros")||($casas_decimais != ".$zeros")){
				$input .= ".$zeros";
			}
		}
		$quebra = explode(".", $input);
		if((int)$quebra[0] > 0){
			$numero = ltrim($quebra[0], '0');
		} else {
			$numero = $quebra[0];
		}
		$tamanho_numero = strlen($numero);
		$dezena = $quebra[1];
		while (strlen($dezena) < $casas) {
			$dezena = $dezena."0";
		}
		$milhares = intval($tamanho_numero/3);
		$unidades = $tamanho_numero % 3;
		$inicio = 0;
		$valor = 0;
		$cont = 1;
		$escreve = "";
		if($tamanho_numero <= 3){
			$moeda = $numero.",".$dezena;
		}elseif($tamanho_numero > 3){
			for ($r = 0; $r < $milhares; $r++) {
				if($milhares > $cont){
					$inicio = $tamanho_numero - ($cont * 3);
					$valor = substr($numero,$inicio,3);
					$escreve = ".".$valor.$escreve;
				}elseif($milhares == $cont and $unidades > 0){
					$inicio = $unidades;
					$valor = substr($numero,$inicio,3);
					$escreve = ".".$valor.$escreve;
					$valor = substr($numero,0,$unidades);
					$escreve = $valor.$escreve;
				}elseif($milhares == $cont and $unidades == 0){
					$inicio = $unidades;
					$valor = substr($numero,$inicio,3);
					$escreve = $valor.$escreve;
				}
				$cont++;
			}
			$moeda = $escreve.",".$dezena;
		}
		return $moeda;
	}
	
	public static function decodeMonetario($input){
		$input = str_replace(".", "", $input);
		$input = str_replace(",", ".", $input);
		return $input;
	}

	public static function decodeData($data){
		$data_decode = $data;
		if(!empty ($data)){
			$d = explode("/",$data);
			$data_decode = $d[2]."-". $d[1] ."-".$d[0];
		}
		return $data_decode;
	}
	
	public static function decodeDataHora($data_hora){
		$data_hora_decode = $data_hora;
		if(!empty ($data_hora)){
			$dh = explode(' ',$data_hora);
			$d = explode('/', $dh[0]);
			$h = explode(':', $dh[1]);
			
			$ano = $d[2];
			$mes = $d[1];
			$dia = $d[0];
			$hora = $h[0];
			$minuto = $h[1];
			if(isset($h[2])){
				$segundo = $h[2];
			} else {
				$segundo = '00';
			}
			
			$data_decode = $ano . '-' . $mes . '-' . $dia;
			$hora_decode = $hora . ':' . $minuto . ':' . $segundo;
			$data_hora_decode = $data_decode . ' ' . $hora_decode;
		}
		return $data_hora_decode;
	}

	public static function decodeInteger($inputString){
		$table = array(
			'.'=>'', '('=>'', ')'=>'', ' '=>'', '-'=>'', '/'=>'',
		);
		$outputInteger = strtr($inputString, $table);
		//$outputInteger = (int)$outputInteger;
		return $outputInteger;
	}

	public static function ordenaArray($nome_array, $campo_array, $order='desc') {
		foreach($nome_array as $apelida_array => $temp)
		$parcial[$apelida_array] = strtolower( $temp[$campo_array] );
		if($order === 'desc')
			arsort($parcial);
		else
			asort($parcial);
		foreach($parcial as $chave => $val)
		$final[$chave] = $nome_array[$chave];
		return $final;
	}
	
	public static function file_upload_error_message($error_code) {
		switch ($error_code) {
			case UPLOAD_ERR_INI_SIZE:
				return 'O tamanho da imagem ultrapassa o limite permitido. Limite menor que 3Mb';
			case UPLOAD_ERR_FORM_SIZE:
				return 'O arquivo enviado excede o tamanho máximo permitido';
			case UPLOAD_ERR_PARTIAL:
				return 'O arquivo foi apenas parcialmente carregado';
			case UPLOAD_ERR_NO_FILE:
				return 'Nenhum arquivo foi enviado';
			case UPLOAD_ERR_NO_TMP_DIR:
				return 'Faltando uma pasta temporária';
			case UPLOAD_ERR_CANT_WRITE:
				return 'Falha ao gravar arquivo em disco';
			case UPLOAD_ERR_EXTENSION:
				return 'Arquivo de upload parou por extensão';
			default:
				return 'Erro de upload Desconhecido';
		}
	}
	
	public static function formataNomeArquivo($nome_completo){
		$quebra_arquivo = explode(".",$nome_completo);
		$nome_inicio = $quebra_arquivo[0];
		$outputString    = utf8_decode($nome_inicio);
		$outputString    = strtolower($outputString);
		$outputString    = utf8_encode($outputString);
		$table = array(
			'À'=>'a', 'Á'=>'a', 'Â'=>'a', 'Ã'=>'a', 'Ä'=>'a',
			'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
			'È'=>'e', 'É'=>'e', 'Ê'=>'e', 'Ë'=>'e',
			'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e',
			'Ì'=>'i', 'Í'=>'i', 'Î'=>'i', 'Ï'=>'i',
			'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i',
			'Ò'=>'o', 'Ó'=>'o', 'Ô'=>'o', 'Õ'=>'o', 'Ö'=>'o',
			'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o',
			'Ù'=>'u', 'Ú'=>'u', 'Û'=>'u',
			'ù'=>'u', 'ú'=>'u', 'û'=>'u',
			'Ç'=>'c', 'ç'=>'c',
			'ª'=>'', 'º'=>'', '\''=>'', '\"'=>'', '´'=>'', '`'=>'', '-'=>'', '+'=>'', '*'=>'',
			'?'=>'', '!'=>'', '@'=>'', '#'=>'', '$'=>'', '%'=>'', '&'=>'', '('=>'', ')'=>'', '{'=>'', '}'=>'',
			'['=>'', ']'=>'', ','=>'', ':'=>'', ';'=>'', '<'=>'', '>'=>'', '-'=>'', ' '=>'',
		);
		$outputString = strtr($outputString, $table);
		$nome = mensagens::lower($outputString);
		return $nome;
	}
	
	public static function getExtensaoByNomeArquivo($nome_completo){
		$quebra_nome = explode(".", $nome_completo);
		$posicao_extensao = count($quebra_nome) - 1;
		$extensao = $quebra_nome[$posicao_extensao];
		return $extensao;
	}
	
	public static function renomearArquivo($nome,$extensao){
		$timestamp = time();
		$nomear = $nome.$timestamp;
		$renomear =  md5($nomear).".".$extensao;
		return $renomear;
	}
	
	public static function removerArquivosTemporarios(){
		$data_atual = strtotime('now');
		// Laço que percorrerá todos os arquivos da pasta /tmp cujo nome terminam com "_wsmart_tmp",
		// e que lá se acumularam por conta de insersões incompletas. Estes arquivos serão removidos,
		// caso sejam antigos.
		foreach (glob("/tmp/*_wsmart_tmp") as $nome_arquivo) {
			$data_arquivo = filemtime($nome_arquivo);
			$diferenca = $data_atual - $data_arquivo;
			$duracao_sessao = ini_get('session.gc_maxlifetime');
			if($diferenca > $duracao_sessao){
				// Se o arquivo percorrido form mais antigo que a duração da sessão, o mesmo será removido.
				unlink($nome_arquivo);
			}
		}
	}
	
	public static function gerarPdf ($titulo='relatorio',$orientacao='L') {
		echo "<form method='post' name='formulariopdf' action='../common/relatorios/gerar_pdf.php' id='formulariopdf' target='_blank'>";
	//	echo "<a href=# onclick='html.value = conteudo.innerHTML; formulariopdf.submit();'><img src='../common/icones/page_white_acrobat.png' alt='Gerar PDF' /><br />Gerar PDF [Novo]</a>";
	//	echo "<input type='hidden' id='html' name='html' />";
		if($titulo == ''){
			$titulo='relatorio';
		}
		echo "<input type='hidden' id='titulo' name='titulo' value='$titulo' />";
		echo "<input type='hidden' id='orientacao' name='orientacao' value='$orientacao' />";
		echo "<a name='pdf' href=#pdf
			onclick=\"
				ocultaAcoes();
				var cont = 0, total = 0, elemento;
				
				while (total <= document.getElementById('conteudo').innerHTML.length) {
					elemento = 'html'+cont;
					document.getElementById(elemento).value = document.getElementById('conteudo').innerHTML.substr(total, 90000);
					total += 90000;
					cont++;
				}
				mostraAcoes();
				formulariopdf.submit();
			\"><img src='../common/icones/page_white_acrobat.png' alt='Gerar PDF' /><br />Gerar PDF</a>";

		// Há limite para enviar uma variável via post, por isso é enviado cada uma com 90.000 caracteres
		for ($i = 0; $i < 500; $i++) {
			echo "<input type='hidden' id='html$i' name='html$i' />";
		}
		echo "</form>";
	}
	
	public static function checaStringContemPalavras($string, $array_palavras){
		$count = 0;
		foreach ($array_palavras as $substring) {
			 $count += substr_count( $string, $substring);
		}
		if($count > 0){
			return true;
		} else {
			return false;
		}
	}
	
	public static function historico () {
		/*  TROCAR O BOTÃO VOLTAR PELA FUNÇÃO VOLTAR */

		if (isset($_SESSION['bloqueado']) && $_SESSION['bloqueado'] === 1) {
			$_SESSION['bloqueado'] = 0;
		} 
		else {
			$prefixo = 'http://';
			$pagina = $prefixo.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			
			//echo $pagina;//descomentar para vizualizar a url acima da página
			
			if (!isset($_SESSION['0_pagina'])) {
				$_SESSION['0_pagina'] = $pagina;
				$_SESSION['1_pagina'] = 'inicial.php';
				$_SESSION['2_pagina'] = "inicial.php";
				$_SESSION['3_pagina'] = "inicial.php";
				$_SESSION['4_pagina'] = "inicial.php";
				$_SESSION['5_pagina'] = "inicial.php";
				$_SESSION['0_get'] = array();
				$_SESSION['0_post'] = array();
				$_SESSION['1_get'] = array();
				$_SESSION['1_post'] = array();
				$_SESSION['2_get'] = array();
				$_SESSION['2_post'] = array();
				$_SESSION['3_get'] = array();
				$_SESSION['3_post'] = array();
				$_SESSION['4_get'] = array();
				$_SESSION['4_post'] = array();
				$_SESSION['5_get'] = array();
				$_SESSION['5_post'] = array();
				if (count($_GET) > 0) {
					foreach($_GET as $nome => $valor) {
						$_SESSION['0_get'][$nome] = $valor;
						//array_push($_SESSION['1_get'], $nome, $valor);
					}
				}
				if (count($_POST) > 0) {
					foreach($_POST as $nome => $valor) {
						$_SESSION['0_post'][$nome] = $valor;
						//array_push($_SESSION['1_post'], $nome, $valor);
					}
				}
			}
			else {
				if (isset($_GET['acao']) || isset($_GET['dado']) || isset($_POST['acao']) || isset($_POST['dado'])) {
					// Não armazena no histórico da sessão as páginas que contiverem os parametros get/post acima.
					// Isso inclui páginas específicas para realização de operações de inserção, edição ou remoção.
					return;
				} else if(false && isset($_GET['ate']) || isset($_POST['ate'])){
					// Não armazena no histórico da sessão as páginas que contiverem informações de estados da paginação.
					// Com essa condição, o usuário voltará sempre à primeira página da paginação.
					return;
				}else {	
					$inicio_parametros = strpos($pagina, '?');
					if($inicio_parametros > 0){
						$url_sem_paramentros = substr($pagina, 0, $inicio_parametros);
					}else{
						$url_sem_paramentros = $pagina;
					}
					if($_SESSION['0_pagina'] == $pagina || $_SESSION['0_pagina'] == $url_sem_paramentros){
						$paginas_iguais = 'sim';
					} else {
						$paginas_iguais = 'não';
					}
					
					$gets['gets'] = array();
					$posts['posts'] = array();
					function iguais($array1, $array2) {
						$iguais = true;
						foreach($array1 as $nome => $valor) {
							if (isset($array2[$nome])) {
								if (is_array($valor)) {
									if (!iguais($valor, $array2[$nome])) {
										$iguais = false;
									}
								}
								if ($array2[$nome] != $valor) {
									$iguais = false;
								}
							}
							else {
								$iguais = false;
							}
						}
						return $iguais;
					}
					if (count($_GET) > 0) {
						if(iguais($_GET, $_SESSION['0_get'])){
							$gets_iguais = 'sim';
						} else {
							$gets_iguais = 'não';
						}
					}else{
						$gets_iguais = 'sim';
					}
					if (count($_POST) > 0) {
						if(iguais($_POST, $_SESSION['0_post'])){
							$posts_iguais = 'sim';
						} else {
							$posts_iguais = 'não';
						}
					}else{
						$posts_iguais = 'sim';
					}
					if( ($paginas_iguais == 'sim') && ( ($gets_iguais == 'sim') && ($posts_iguais == 'sim') ) ){
						// Não grava porque pode ser um refresh/F5
					}else{
						if($_SESSION['1_pagina'] == $pagina || $_SESSION['1_pagina'] == $url_sem_paramentros){
							$paginas_iguais = 'sim';
						} else {
							$paginas_iguais = 'não';
						}
						if (count($_GET) > 0) {
							if(iguais($_GET, $_SESSION['1_get'])){
								$gets_iguais = 'sim';
							} else {
								$gets_iguais = 'não';
							}
						}else{
							$gets_iguais = 'sim';
						}
						if(count($_POST) > 0){
							if(iguais($_POST, $_SESSION['1_post'])){
								$posts_iguais = 'sim';
							} else {
								$posts_iguais = 'não';
							}
						} else {
							$posts_iguais = 'sim';
						}
						if(($paginas_iguais == 'sim') &&  (($gets_iguais == 'sim') && ($posts_iguais == 'sim'))){
							// Pressionou o botão "voltar" no navegador
							for ($i = 0; $i < 5; $i++) {
								$proximo = $i + 1;
								if (isset($_SESSION[$proximo.'_pagina'])) {
									$_SESSION[$i.'_pagina'] = $_SESSION[$proximo.'_pagina'];
									$_SESSION[$i.'_get'] = $_SESSION[$proximo.'_get'];
									$_SESSION[$i.'_post'] = $_SESSION[$proximo.'_post'];
								}
								else {
									$_SESSION[$i.'_pagina'] = "inicio.php";
									$_SESSION[$i.'_get'] = array();
									$_SESSION[$i.'_post'] = array();
								}
							}
							$_SESSION['5_pagina'] = "inicio.php";
							$_SESSION['5_get'] = array();
							$_SESSION['5_post'] = array();
							return;
						} else {
							for ($i = 4; $i >= 0; $i--) {
								$proximo = $i + 1;
								$_SESSION[$proximo."_pagina"] = $_SESSION[$i."_pagina"];
								$_SESSION[$proximo."_get"] = $_SESSION[$i."_get"];
								$_SESSION[$proximo."_post"] = $_SESSION[$i."_post"];
							}
						}
					} 
					$_SESSION['0_pagina'] = $pagina;
					$_SESSION['0_get'] = array();
					$_SESSION['0_post'] = array();
					if (count($_GET) > 0) {
						foreach($_GET as $nome => $valor) {
							if (is_array($valor)) {
								foreach ($valor as $i => $v){
									$_SESSION['0_get'][$nome."[".$i."]"] = $v;
								}
							}
							else {
								$_SESSION['0_get'][$nome] = $valor;
							}								
							//array_push($_SESSION['1_get'], $nome, $valor);
						}
					}
					if (count($_POST) > 0) {
						foreach($_POST as $nome => $valor) {
							if (isset($nome) && isset($valor)) {
								if (is_array($valor)) {
									foreach ($valor as $i => $v){
										$_SESSION['0_post'][$nome."[".$i."]"] = $v;
									}
								}
								else {
									$_SESSION['0_post'][$nome] = $valor;
								}
								//array_push($_SESSION['1_post'], $nome, $valor);
							}
						}
					}
				}
			}
		}			
	}
	
	/*
	 * Função que retorna o ambiente em que o sistema está sendo executado.
	 */
	public static function getAmbienteDesenvolvimento(){
		$http_host = $_SERVER['HTTP_HOST'];
		if ($http_host == 'localhost') {
			$ambiente = 'D'; // Desenvolvimento
		} elseif ($http_host == 'sisar.esy.es') {
			$ambiente = 'H'; // Homologação
		} else {
			$ambiente = 'P'; // Produção
		}
		return $ambiente;
	}
	
	public static function getEnderecoPagina(){
		$endereco = $_SERVER['SCRIPT_NAME'];
		$barra = substr_count($endereco, '/');
		$endereco = explode('/',$endereco);
		return $endereco[$barra];
	}
	
	public static function ajustaParametro($valor, $tipo, $normalizar=true) {
		// Se valor for nulo, retornar "NULL" imediatamente (exceto para tipos numéricos)
		if (empty($valor) && (!in_array($tipo, array('int', 'decimal')))) {
			return "NULL";
		}
		
		// Ajustando valor para tipo string
		if ($tipo == 'string') {
			if((trim($valor) == '') || ($valor == "NULL")){
				return "NULL";
			}
			if($normalizar){
				$valor = mensagens::upper($valor);
			}
		}
		
		// Ajustando valor para tipo decimal
		if ($tipo == 'decimal') {
			if (is_numeric($valor)) {
                return $valor;
			} else {
				$valor = str_replace(",", ".", $valor);
                if (is_numeric($valor)) {
                    return $valor;
                } else {
					return "NULL";
				}
			}
		}
		
		// Ajustando valor para tipo int
		if ($tipo == 'int') {			
			if(is_numeric($valor)){
				return $valor;
            }elseif(is_string($valor) && (strlen($valor) >=7)){
                if(($valor == 'currval' || $valor == 'CURRVAL')){
                    return $valor;
                }else{
                    $setePrimeirosCaracteres = substr($valor, 0, 7);
                    $contemCurrval = (mensagens::upper($setePrimeirosCaracteres) == 'CURRVAL');
                    if($contemCurrval === true){
                        return $valor;
                    }
                }
			}
            return "NULL";
		}
		
		// Ajustando valor para tipo boolean
		if ($tipo == 'boolean') {
			$valor = strtolower($valor);
			if ($valor == 1 || $valor == "t" || $valor == "true" || $valor === true) {
				return "TRUE";
			}
			if ($valor === 0 || $valor == "f" || $valor == "false" || $valor === false) {
				return "FALSE";
			}
			else {
				return "NULL";
			}
		}
		
		// Ajustando valor para tipo date
		if ($tipo == 'date') {
			if (strpos($valor, "/") !== false) {
				return "'".mensagens::decodeData($valor)."'";
			}
			else if (strpos($valor, "-") !== false) {
				return "'".$valor."'";
			}
			else {
                return "NULL";
			}
		}
		
		// Retornando valor ajustado
		return "'".$valor."'";
	}
    
    public static function mesPorExtenso($mes){
		$meses = array(1=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
		return $meses[$mes];
	}
    
    public static function numeroExtenso($valor){
		$moedaSing = 'real';
		$moedaPlur = 'reais';
		$centSing = 'centavo';
		$centPlur = 'centavos';
		$valorExt = '';
		$centenas = array( 0,
			array(0, 'cento',        'cem'),
			array(0, 'duzentos',     'duzentos'),
			array(0, 'trezentos',    'trezentos'),
			array(0, 'quatrocentos', 'quatrocentos'),
			array(0, 'quinhentos',   'quinhentos'),
			array(0, 'seiscentos',   'seiscentos'),
			array(0, 'setecentos',   'setecentos'),
			array(0, 'oitocentos',   'oitocentos'),
			array(0, 'novecentos',   'novecentos'));
		$dezenas = array( 0,
				 'dez',
				 'vinte',
				 'trinta',
				 'quarenta',
				 'cinqüenta',
				 'sessenta',
				 'setenta',
				 'oitenta',
				 'noventa');
		$unidades = array( 0,
				 'um',
				 'dois',
				 'três',
				 'quatro',
				 'cinco',
				 'seis',
				 'sete',
				 'oito',
				 'nove');
		$excecoes = array( 0,
				 'onze',
				 'doze',
				 'treze',
				 'quatorze',
				 'quinze',
				 'dezeseis',
				 'dezesete',
				 'dezoito',
				 'dezenove');
		$extensoes = array( 0,
			array(0, '',       ''),
			array(0, 'mil',    'mil'),
			array(0, 'milhão', 'milhões'),
			array(0, 'bilhão', 'bilhões'),
			array(0, 'trilhão','trilhões'));
		$valorForm = trim(number_format($valor,2,'.',','));
		$inicio = 0;
		if($valor <= 0){
		   return ('Zero');
		}
		for($conta = 0; $conta <= strlen($valorForm)-1; $conta++){
		   if(strstr(',.',substr($valorForm, $conta, 1))){
			  $partes[] = str_pad(substr($valorForm, $inicio, $conta-$inicio),3,' ',STR_PAD_LEFT);
			  if(substr($valorForm, $conta, 1) == '.'){
				 break;
			  }
			  $inicio = $conta + 1;
		   }
		}
		$centavos = substr($valorForm, strlen($valorForm)-2, 2);
		if(!(count($partes) == 1 and intval($partes[0]) == 0)){
		   for ($conta=0; $conta <= count($partes)-1; $conta++){
			  $centena = intval(substr($partes[$conta], 0, 1));
			  $dezena  = intval(substr($partes[$conta], 1, 1));
			  $unidade = intval(substr($partes[$conta], 2, 1));
			  if($centena > 0){
				 $valorExt .= $centenas[$centena][($dezena+$unidade>0 ? 1 : 2)].( $dezena+$unidade>0 ? ' e ' : '');
			  }
			  if($dezena > 0){
				 if($dezena>1){
					$valorExt .= $dezenas[$dezena].($unidade>0 ? ' e ' : '');
				 }elseif($dezena == 1 and $unidade == 0){
					$valorExt .= $dezenas[$dezena];
				 }else{
					$valorExt .= $excecoes[$unidade];
				 }
			  }
			  if($unidade > 0 and $dezena != 1){
				 $valorExt .= $unidades[$unidade];
			  }
			  if(intval($partes[$conta]) > 0){
				 $valorExt .= ' '.$extensoes[(count($partes)-1)-$conta+1][(intval($partes[$conta])>1 ? 2 : 1)];
			  }
			  if((count($partes)-1) > $conta and intval($partes[$conta])>0){
				 $conta3 = 0 ;
				 for($conta2 = $conta+1; $conta2 <= count($partes)-1; $conta2++){
					$conta3 += (intval($partes[$conta2])>0 ? 1 : 0) ;
				 }
				 if($conta3 == 1 and intval($centavos) == 0){
					$valorExt .= ' e ';
				 }elseif($conta3>=1){
					$valorExt .= ', ';
				 }
			  }
		   }
		   if(count($partes) == 1 and intval($partes[0]) == 1){
			  $valorExt .= $moedaSing;
		   }elseif(count($partes)>=3 and ((intval($partes[count($partes)-1]) + intval($partes[count($partes)-2]))==0)){
			  $valorExt .= ' de ' + $moedaPlur;
		   }else{
			  $valorExt = trim($valorExt) . ' ' . $moedaPlur;
		   }
		}

		if(intval($centavos) > 0){
		   $valorExt .= (!empty($valorExt) ? ' e ' : '');
		   $dezena  = intval(substr($centavos, 0, 1));
		   $unidade = intval(substr($centavos, 1, 1));
		   if($dezena > 0){
			  if($dezena>1){
				 $valorExt .= $dezenas[$dezena] . ( $unidade>0 ? ' e ' : '' );
			  }elseif( $dezena == 1 and $unidade == 0){
				 $valorExt .= $dezenas[$dezena];
			  }else{
				 $valorExt .= $excecoes[$unidade];
			  }
		   }
		   if($unidade > 0 and $dezena != 1){
			  $valorExt .= $unidades[$unidade];
		   }
		   $valorExt .= ' ' .(intval($centavos)>1 ? $centPlur : $centSing);
		}
		return ($valorExt);
	 }
     
    /**
    * A função recebe 3 ou 4 parâmetros.
       1º  data inicial
       2º  data final
       3º  O que se deseja calcular, ex. Ano, Mes, Dia, Hora, Minuto. Sendo o parâmetro a primeira letra ( ‘A’ = ano, ‘M’ = meses, etc …)
       4º  Parâmetro é opcional e só precisa ser passado se o separador for diferente de “-” (ex: 2010/04/10 neste caso deve ser passado o separador no parâmetro).

       O formato da data deve ser “Ano-Mês-Dia”, ex  2010-12-31, ou seja, $d1 = “2010-12-31″.
    */
    public static function diffDate($d1, $d2, $type='D', $sep='-'){
        $d1 = explode($sep, $d1);
        $d2 = explode($sep, $d2);
        switch ($type) {
            case 'A':
                $X = 31536000;
                break;
            case 'M':
                $X = 2592000;
                break;
            case 'D':
                $X = 86400;
                break;
            case 'H':
                $X = 3600;
                break;
            case 'MI':
                $X = 60;
                break;
            default:
                $X = 1;
        }
        $t1 = mktime(0, 0, 0, $d2[1], $d2[2], $d2[0]);
        $t2 = mktime(0, 0, 0, $d1[1], $d1[2], $d1[0]);
        $tr = $t1 - $t2;
        return floor($tr / $X);
    }
     
}