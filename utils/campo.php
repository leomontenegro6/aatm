<?php
class campo{
	
	public static function data($nome, $valor, $data_inicio, $data_fim, $datas_desativadas, $campos_adicionais){ 
		if (strpos($valor, "-")) {
			$valor = mensagens::encodeData($valor);
		}
		if (strpos($data_inicio, "-")) {
			$data_inicio = mensagens::encodeData($data_inicio);
		}
		if (strpos($data_fim, "-")) {
			$data_fim = mensagens::encodeData($data_fim);
		}
		if (!is_array($datas_desativadas)) {
			$data_tmp = $datas_desativadas;
			$tmp = explode(",", str_replace(" ", "", $data_tmp));
			$datas_desativadas = array();
			$datas_desativadas = $tmp;
		}
		for ($i = 0; $i < count($datas_desativadas); $i++) {
			if (strpos($datas_desativadas[$i], "-")) {
				$datas_desativadas[$i] = mensagens::encodeData($datas_desativadas[$i]);
			}
		}
		$id = $nome;
		$id = str_replace('[', '_', $id);
		$id = str_replace(']', '', $id);
		?> 
		<input type="text" 
				class="calendario_campo"
				data-minima="<?php echo $data_inicio; ?>" 
				data-maxima="<?php echo $data_fim; ?>" 
				data-desativadas="<?php echo implode(",", $datas_desativadas); ?>"
				<?php echo $campos_adicionais; ?>
				name="<?php echo $nome; ?>" 
				id="<?php echo $id; ?>" 
				size="13" 
				maxlength="10" 
				onkeydown="return mascaraData(this, event)" 
				value="<?php echo $valor; ?>" />
		<script>
		$(function(){
			$('#<?php echo $id; ?>').change(function(){
				if (validaFormatoData(this)) {
					var data = $(this).val();
					if ($(this).attr('data-maxima') != '' && comparaDataMaior(this.value, $(this).attr('data-maxima'))) {
						$('#<?php echo $id; ?>').val( $(this).attr('data-maxima') ).focus();
						aviso('<?php echo $id; ?>', 'A data informada tem que ser igual ou inferior a data: '+$(this).attr('data-maxima'), 7, 't')
					} 
					else if ($(this).attr('data-minima') != '' && comparaDataMenor(this.value, $(this).attr('data-minima'))) {
						$('#<?php echo $id; ?>').val('').focus();
						aviso('<?php echo $id; ?>', 'A data informada tem que ser igual ou superior a data: '+$(this).attr('data-minima'), 7, 't')
					}
					else if ($(this).attr('data-desativadas') != '') {
						var datas = $(this).attr('data-desativadas').split(',');
						for (var i = 0; i < datas.length; i++) {
							if ($(this).val() == datas[i]) {
								$('#<?php echo $id; ?>').val('').focus();
								aviso('<?php echo $id; ?>', 'A data '+datas[i]+' não está entre as datas disponíveis', 7, 't');
								break;
							}
						} 
					}
					<?php
					?>
				}
			});
		})
		</script>
		<img id="imagem_calendario_<?php echo $id; ?>" 
			 class="calendario_imagem"
			 src="../common/icones/calendar.png" alt="Calendário" 
			 onClick="return showCalendar('<?php echo $id; ?>', 'dd/mm/y');" 
			  />
		<?php
	}
	
	public static function dataInicioFim($nome_inicio, $nome_fim, $valor_inicio, $valor_fim, $data_inicio, $data_fim, $datas_desativadas, $campos_adicionais){ 
		if (strpos($valor_inicio, "-")) {
			$valor_inicio = mensagens::encodeData($valor_inicio);
		}
		if (strpos($valor_fim, "-")) {
			$valor_fim = mensagens::encodeData($valor_fim);
		}
		if (strpos($data_inicio, "-")) {
			$data_inicio = mensagens::encodeData($data_inicio);
		}
		if (strpos($data_fim, "-")) {
			$data_fim = mensagens::encodeData($data_fim);
		}
		if (!is_array($datas_desativadas)) {
			$data_tmp = $datas_desativadas;
			$tmp = explode(",", str_replace(" ", "", $data_tmp));
			$datas_desativadas = array();
			$datas_desativadas = $tmp;
		}
		for ($i = 0; $i < count($datas_desativadas); $i++) {
			if (strpos($datas_desativadas[$i], "-")) {
				$datas_desativadas[$i] = mensagens::encodeData($datas_desativadas[$i]);
			}
		}
		$id_inicio = $nome_inicio;
		$id_inicio = str_replace('[', '_', $id_inicio);
		$id_inicio = str_replace(']', '', $id_inicio);
		
		$id_fim = $nome_fim;
		$id_fim = str_replace('[', '_', $id_fim);
		$id_fim = str_replace(']', '', $id_fim);
		?>
		<label class="rotulo_calendario_campo" for="<?php echo $id_inicio; ?>">De</label>
		<input type="text" 
				class="calendario_campo"
				data-minima="<?php echo $data_inicio; ?>" 
				data-maxima="<?php echo $data_fim; ?>" 
				data-desativadas="<?php echo implode(",", $datas_desativadas); ?>"
				<?php echo $campos_adicionais; ?>
				name="<?php echo $nome_inicio; ?>" 
				id="<?php echo $id_inicio; ?>" 
				size="13" 
				maxlength="10" 
				onkeydown="return mascaraData(this, event)" 
				value="<?php echo $valor_inicio; ?>" />
		<script>
		$(function(){
			$('#<?php echo $id_inicio; ?>').change(function(){
				
				if (validaFormatoData(this)) {
					var data = $(this).val();
					if ($(this).attr('data-maxima') != '' && comparaDataMaior(this.value, $(this).attr('data-maxima'))) {
						$('#<?php echo $id_inicio; ?>').val( $(this).attr('data-maxima') ).focus();
						aviso('<?php echo $id_inicio; ?>', 'A data informada tem que ser igual ou inferior a data: '+$(this).attr('data-maxima'), 7, 't')
					} 
					else if ($(this).attr('data-minima') != '' && comparaDataMenor(this.value, $(this).attr('data-minima'))) {
						$('#<?php echo $id_inicio; ?>').val('').focus();
						aviso('<?php echo $id_inicio; ?>', 'A data informada tem que ser igual ou superior a data: '+$(this).attr('data-minima'), 7, 't')
					}
					else if ($(this).attr('data-desativadas') != '') {
						var datas = $(this).attr('data-desativadas').split(',');
						for (var i = 0; i < datas.length; i++) {
							if ($(this).val() == datas[i]) {
								$('#<?php echo $id_inicio; ?>').val('').focus();
								aviso('<?php echo $id_inicio; ?>', 'A data '+datas[i]+' não está entre as datas disponíveis', 7, 't');
								break;
							}
						} 
					}
					else {
						$('#<?php echo $id_fim; ?>').attr("data-minima", $('#<?php echo $id_inicio; ?>').val());
					}
					<?php
					?>
				}
			});
		});
		</script>
		<label class="rotulo_calendario_campo" for="<?php echo $id_fim; ?>">Até</label>
		<input type="text" 
				class="calendario_campo"
				data-minima="<?php echo $data_inicio; ?>" 
				data-maxima="<?php echo $data_fim; ?>" 
				data-desativadas="<?php echo implode(",", $datas_desativadas); ?>"
				<?php echo $campos_adicionais; ?>
				name="<?php echo $nome_fim; ?>" 
				id="<?php echo $id_fim; ?>" 
				size="13" 
				maxlength="10" 
				onkeydown="return mascaraData(this, event)" 
				value="<?php echo $valor_fim; ?>" />
		<script>
		$(function(){
			$('#<?php echo $id_fim; ?>').change(function(){
				if (validaFormatoData(this)) {
					var data = $(this).val();
					if ($(this).attr('data-maxima') != '' && comparaDataMaior(this.value, $(this).attr('data-maxima'))) {
						$('#<?php echo $id_fim; ?>').val( $(this).attr('data-maxima') ).focus();
						aviso('<?php echo $id_fim; ?>', 'A data informada tem que ser igual ou inferior a data: '+$(this).attr('data-maxima'), 7, 't')
					} 
					else if ($(this).attr('data-minima') != '' && comparaDataMenor(this.value, $(this).attr('data-minima'))) {
						$('#<?php echo $id_fim; ?>').val('').focus();
						aviso('<?php echo $id_fim; ?>', 'A data informada tem que ser igual ou superior a data: '+$(this).attr('data-minima'), 7, 't')
					}
					else if ($(this).attr('data-desativadas') != '') {
						var datas = $(this).attr('data-desativadas').split(',');
						for (var i = 0; i < datas.length; i++) {
							if ($(this).val() == datas[i]) {
								$('#<?php echo $id_fim; ?>').val('').focus();
								aviso('<?php echo $id_fim; ?>', 'A data '+datas[i]+' não está entre as datas disponíveis', 7, 't');
								break;
							}
						} 
					}
					else {
						$('#<?php echo $id_inicio; ?>').attr("data-maxima", $('#<?php echo $id_fim; ?>').val());
					}
					<?php
					?>
				}
			});
		});
		</script>
		<img id="imagem_calendario_<?php echo $id_inicio; ?>" 
			 class="calendario_imagem"
			 src="../common/icones/calendar.png" alt="Calendário" 
			 onClick="return showCalendar(['<?php echo $id_inicio; ?>', '<?php echo $id_fim; ?>'], 'dd/mm/y');" 
			  />
		<?php
	}
	
	public static function select ($quantidade_maxima, $nome, $valores, $textos, $valor_atual='', $atributos_opcionais = '') {
		if ($quantidade_maxima > 1) {
			$nome_campo = $nome."[]";
		} else {
			$nome_campo = $nome;
		}
		if (!is_array($valor_atual)) {
			$valor_atual = array($valor_atual);
		}
		$total_valores = count($valores);
		?>
		<div class='campo_multiplo' data-aceita-valores-duplicados='false' data-quantidade-maxima='<?php echo $quantidade_maxima ?>'>
			<table class="conteiner">
				<tr>
					<td class="corpo"></td>
					<td class="acoes" valign="top">
						<button type="button" class="adicionar" title="Adicionar">
							<img src="../common/icones/plus.png" />
						</button>
						<button type="button" class="remover" title="Remover">
							<img src="../common/icones/iconec04.png" />
						</button>
					</td>
				</tr>
			</table>
			<div class="template">
				<select data-nome="<?php echo $nome ?>" name="<?php echo $nome_campo ?>" class="select_<?php echo $nome ?>" id="<?php echo $nome ?>{iterador}" <?php echo $atributos_opcionais ?>>
					<?php for($i=0; $i<$total_valores; $i++){ ?>
						<option value="<?php echo $valores[$i] ?>"><?php echo $textos[$i] ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="valores">
				<?php
				$valores_json = array();
				foreach($valor_atual as $i=>$valor){
					$valores_json[] = array(
						$nome=>$valor
					);
				}
				echo json_encode($valores_json);
				?>
			</div>
		</div>
		<?php
	}
	
	/** Cria um campo texto autocomplete
	 * 
	 * @param integer $quantidade_maxima
	 * @param string $nome (nome do campo)
	 * @param array $valor_nome
	 * @param array $valor_id
	 * @param string $pagina_autocomplete
	 * @param string $atributos_opcionais (opcional)
	 * @param string $callback (opcional)
	 * @param string $valores_duplicados (opcional - se aceita valor duplicado)
	 */
	public static function autocomplete($quantidade_maxima, $nome, $valor_nome, $valor_id, $pagina_autocomplete, $atributos_opcionais = "", $callback="", $valores_duplicados = false) {
		if ($quantidade_maxima > 1) {
			$nome_campo = $nome."[]";
		} else {
			$nome_campo = $nome;
		}
		if (!is_array($valor_nome)) {
			$valor_nome = array($valor_nome);
		}
		if (!is_array($valor_id)) {
			$valor_id = array($valor_id);
		}
		
		if($valores_duplicados === true){
			$valores_duplicados = 'true';
		} else {
			$valores_duplicados = 'false';
		}
		?>
		<div class='campo_multiplo' data-quantidade-maxima='<?php echo $quantidade_maxima ?>' data-aceita-valores-duplicados="<?php echo $valores_duplicados ?>">
			<table class="conteiner">
				<tr>
					<td class="corpo"></td>
					<td class="acoes" valign="top">
						<?php if($quantidade_maxima > 1){ ?>
							<button type="button" class="adicionar" title="Adicionar">
								<img src="../common/icones/plus.png" />
							</button>
							<button type="button" class="remover" title="Remover">
								<img src="../common/icones/iconec04.png" />
							</button>
						<?php } ?>
					</td>
				</tr>
			</table>
			<div class="template">
				<select data-nome="<?php echo $nome ?>" name="<?php echo $nome_campo ?>" class="select_<?php echo $nome ?>" id="<?php echo $nome ?>{iterador}"
					data-pagina="<?php echo $pagina_autocomplete ?>" data-limite-caracteres="0" onchange="<?php echo $callback ?>"
					<?php echo $atributos_opcionais ?> style="width: 250px">
					<option value="">Todos</option>
				</select>
			</div>
			<div class="valores">
				<?php
				$valores_json = array();
				foreach($valor_nome as $i=>$valor){
					$id = $valor_id[$i];
					$valores_json[] = array(
						$nome=>array(
							'id'=>$id,
							'valor'=>$valor
						)
					);
				}
				echo json_encode($valores_json);
				?>
			</div>
		</div>
		<?php
	} 
	
	public static function autocompleteMaisSelect($quantidade_maxima, $nome, $valor_nome, $valor_id, $pagina_autocomplete, $atributos_opcionais = "", $ids_select, $labels_select, $nome_select, $valores_select, $select_vira_input = false) {
		if ($quantidade_maxima > 1) {
			$nome_campo_autocomplete = $nome."[]";
			$nome_campo_select = $nome_select."[]";
		} else {
			$nome_campo_autocomplete = $nome;
			$nome_campo_select = $nome_select;
		}
		if (!is_array($valor_nome)) {
			$valor_nome = array($valor_nome);
		}
		if (!is_array($valor_id)) {
			$valor_id = array($valor_id);
		}
		if (!is_array($valores_select)) {
			$valores_select = array($valores_select);
		}
		$total_valores = count($ids_select);
		?>
		<div class='campo_multiplo' data-quantidade-maxima='<?php echo $quantidade_maxima ?>'>
			<table class="conteiner">
				<tr>
					<td class="corpo"></td>
					<td class="acoes" valign="top">
						<?php if($quantidade_maxima > 1){ ?>
							<button type="button" class="adicionar" title="Adicionar">
								<img src="../common/icones/plus.png" />
							</button>
							<button type="button" class="remover" title="Remover">
								<img src="../common/icones/iconec04.png" />
							</button>
						<?php } ?>
					</td>
				</tr>
			</table>
			<div class="template">
				<select data-nome="<?php echo $nome ?>" name="<?php echo $nome_campo_autocomplete ?>" class="select_autocomplete_<?php echo $nome ?>" id="<?php echo $nome ?>{iterador}"
					data-pagina="<?php echo $pagina_autocomplete ?>" data-limite-caracteres="0" <?php echo $atributos_opcionais ?> style="width: 250px">
					<option value="">Todos</option>
				</select>
				<select data-nome="<?php echo $nome_select ?>" name="<?php echo $nome_campo_select ?>" class="select_<?php echo $nome ?>" id="<?php echo $nome_select ?>{iterador}">
					<?php for($i=0; $i<$total_valores; $i++){ ?>
						<option value="<?php echo $ids_select[$i] ?>"><?php echo $labels_select[$i] ?></option>
					<?php } ?>
				</select>
				<?php if($select_vira_input){ ?>
					<input type="text" data-nome="input_<?php echo $nome_select ?>" name="input_<?php echo $nome_campo_select ?>" class="input_<?php echo $nome ?>" id="input_<?php echo $nome_select ?>{iterador}"
						style="display: none;" />
					<button type="button" class="pequeno" title="Ativa / desativa digitação manual" onclick="campoMultiplo.alteraSelectInput('<?php echo $nome_select ?>{iterador}')">
						<img src="../common/icones/table_add.png" />
					</button>
				<?php } ?>
			</div>
			<div class="valores">
				<?php
				$valores_json = array();
				foreach($valor_nome as $i=>$valor){
					$id = $valor_id[$i];
					$valor_select = $valores_select[$i];
					
					$valores_json[] = array(
						$nome=>array(
							'id'=>$id,
							'valor'=>$valor
						),
						$nome_select=>$valor_select
					);
				}
				echo json_encode($valores_json);
				?>
			</div>
		</div>
		<?php
	}
	
	public static function autocompleteDuplo($quantidade_maxima, $nome, $valor_nome, $valor_id, $pagina_autocomplete, $outros_atributos, $nome_2, $valor_nome_2, $valor_id_2, $pagina_autocomplete_2, $outros_atributos_2, $valores_duplicados=false) {
		if ($quantidade_maxima > 1) {
			$nome_campo = $nome."[]";
			$nome_campo_2 = $nome_2."[]";
		} else {
			$nome_campo = $nome;
			$nome_campo_2 = $nome_2;
		}
		if (!is_array($valor_nome)) {
			$valor_nome = array($valor_nome);
		}
		if (!is_array($valor_id)) {
			$valor_id = array($valor_id);
		}
		if (!is_array($valor_nome_2)) {
			$valor_nome_2 = array($valor_nome_2);
		}
		if (!is_array($valor_id_2)) {
			$valor_id_2 = array($valor_id_2);
		}
		
		if($valores_duplicados === true){
			$valores_duplicados = 'true';
		} else {
			$valores_duplicados = 'false';
		}
		?>
		<div class='campo_multiplo' data-quantidade-maxima='<?php echo $quantidade_maxima ?>' data-aceita-valores-duplicados="<?php echo $valores_duplicados ?>">
			<table class="conteiner">
				<tr>
					<td class="corpo"></td>
					<td class="acoes" valign="top">
						<?php if($quantidade_maxima > 1){ ?>
							<button type="button" class="adicionar" title="Adicionar">
								<img src="../common/icones/plus.png" />
							</button>
							<button type="button" class="remover" title="Remover">
								<img src="../common/icones/iconec04.png" />
							</button>
						<?php } ?>
					</td>
				</tr>
			</table>
			<div class="template">
				<select data-nome="<?php echo $nome ?>" name="<?php echo $nome_campo ?>" class="select_<?php echo $nome ?>" id="<?php echo $nome ?>{iterador}"
					data-pagina="<?php echo $pagina_autocomplete ?>" data-limite-caracteres="0" <?php echo $outros_atributos ?> style="width: 250px">
					<option value="">Todos</option>
				</select>
				<select data-nome="<?php echo $nome_2 ?>" name="<?php echo $nome_campo_2 ?>" class="select_<?php echo $nome_2 ?>" id="<?php echo $nome_2 ?>{iterador}"
					data-pagina="<?php echo $pagina_autocomplete_2 ?>" data-limite-caracteres="0" <?php echo $outros_atributos_2 ?> style="width: 250px">
					<option value="">Todos</option>
				</select>
			</div>
			<div class="valores">
				<?php
				$valores_json = array();
				foreach($valor_nome as $i=>$valor){
					$id = $valor_id[$i];
					$id_2 = $valor_id_2[$i];
					$valor_2 = $valor_nome_2[$i];
					$valores_json[] = array(
						$nome=>array(
							'id'=>$id,
							'valor'=>$valor
						),
						$nome_2=>array(
							'id'=>$id_2,
							'valor'=>$valor_2
						)
					);
				}
				echo json_encode($valores_json);
				?>
			</div>
		</div>
		<?php
	}
	
	public static function selectMaisRadio($quantidade_maxima, $nome_select, $nome_radio, $colunas_select, $colunas_radio, $valores_ordenacao, $atributos_opcionais = ''){
		if ($quantidade_maxima > 1) {
			if(false){ // Se não tiver colchetes no nome do campo, inseri-los
				$nome_campo_select = $nome_select . '[{iterador}]';
			} else {
				$nome_campo_select = $nome_select;
			}
			if(false){ // Se não tiver colchetes no nome do campo, inseri-los
				$nome_campo_radio = $nome_radio . '[{iterador}]';
			} else {
				$nome_campo_radio = $nome_radio;
			}
		} else {
			$nome_campo_select = $nome_select;
			$nome_campo_radio = $nome_radio;
		}
		$data_nome_campo_select = str_replace(array('[', ']'), '_', $nome_select);
		$data_nome_campo_select = str_replace('{iterador}', '', $data_nome_campo_select);
		$data_nome_campo_radio = str_replace(array('[', ']'), '_', $nome_radio);
		$data_nome_campo_radio = str_replace('{iterador}', '', $data_nome_campo_radio);
		?>
		<div class='campo_multiplo' data-aceita-valores-duplicados='true' data-quantidade-maxima='<?php echo $quantidade_maxima ?>'>
			<table class="conteiner">
				<tr>
					<td class="corpo"></td>
					<td class="acoes" valign="top">
						<button type="button" class="adicionar" title="Adicionar">
							<img src="../common/icones/plus.png" />
						</button>
						<button type="button" class="remover" title="Remover">
							<img src="../common/icones/iconec04.png" />
						</button>
					</td>
				</tr>
			</table>
			<div class="template">
				<select data-nome="<?php echo $data_nome_campo_select ?>" name="<?php echo $nome_campo_select ?>"
					id="<?php echo $data_nome_campo_select ?>{iterador}" <?php echo $atributos_opcionais ?>>
					<?php foreach($colunas_select as $valor=>$coluna){ ?>
						<option value="<?php echo $valor ?>"><?php echo $coluna ?></option>
					<?php } ?>
				</select>
				<?php
				$i = 0;
				foreach($colunas_radio as $valor=>$coluna){ ?>
					<div class="radio radio-success alinhadoVertical">
						<input type="radio" data-nome="<?php echo $data_nome_campo_radio ?>" name="<?php echo $nome_campo_radio ?>"
							id="<?php echo $data_nome_campo_radio . '_{iterador}_' . $i ?>" value="<?php echo $valor ?>" <?php if($i == 0) echo 'checked' ?> />
						<label for="<?php echo $data_nome_campo_radio . '_{iterador}_' . $i ?>"><?php echo $coluna ?></label>
					</div>
					<?php
					$i++;
				} ?>
			</div>
			<div class="valores">
				<?php
				$valores_json = array();
				foreach($valores_ordenacao as $valor){
					$coluna = $valor['coluna'];
					$filtragem = $valor['filtragem'];
					
					$valores_json[] = array(
						$data_nome_campo_select=>$coluna,
						$data_nome_campo_radio=>$filtragem
					);
				}
				echo json_encode($valores_json);
				?>
			</div>
		</div>
		<?php
	}
	
	public static function ordenarFiltragem($quantidade_maxima, $colunas_select, $valores_ordenacao=array()) {
		$nome_select = 'ordenacao[{iterador}][coluna]';
		$nome_radio = 'ordenacao[{iterador}][filtragem]';
		$colunas_radio = array(
			'a'=>'Ascendente',
			'd'=>'Descendente'
		);
		return self::selectMaisRadio($quantidade_maxima, $nome_select, $nome_radio, $colunas_select, $colunas_radio, $valores_ordenacao, '');
	}
	
	public static function filtroTextoDinamico($quantidade_maxima=5, $nome_campo='filtro_texto', $valores=array(), $tem_intervalo=true, $atributos_opcionais=''){
		?>
		<div class="campo_multiplo" data-aceita-valores-duplicados='true' data-quantidade-maxima="<?php echo $quantidade_maxima ?>">
			<table class="conteiner">
				<tr>
					<td class="corpo"></td>
					<td class="acoes" valign="top">
						<?php if($quantidade_maxima > 1){ ?>
							<button type="button" class="adicionar" title="Adicionar">
								<img src="../common/icones/plus.png" />
							</button>
							<button type="button" class="remover" title="Remover">
								<img src="../common/icones/iconec04.png" />
							</button>
						<?php } ?>
					</td>
				</tr>
			</table>
			<div class="template">
				<select data-nome="tipo_busca" name="<?php echo $nome_campo ?>[{iterador}][tipo_busca]" <?php if($tem_intervalo){ ?>onchange="toggleCampoTextoFinal(this)"<?php } ?>>
					<option value="co">Contém</option>
					<option value="i">É igual a</option>
					<option value="cc">Começa com</option>
					<option value="tc">Termina com</option>
					<?php if($tem_intervalo){ ?>
						<option value="se">Situa-se entre</option>
					<?php } ?>
				</select>
				<input type="text" data-nome="texto_inicial" name="<?php echo $nome_campo ?>[{iterador}][texto_inicial]" class="<?php echo $nome_campo ?> texto_inicial" <?php echo $atributos_opcionais ?> />
				<?php if($tem_intervalo){ ?>
					<input type="text" data-nome="texto_final" name="<?php echo $nome_campo ?>[{iterador}][texto_final]" class="<?php echo $nome_campo ?> texto_final" <?php echo $atributos_opcionais ?> />
				<?php } ?>
			</div>
			<div class="valores">
				<?php
				$valores_formatados = array();
				foreach($valores as $valor_row){
					$texto_inicial = (isset($valor_row['texto_inicial'])) ? ($valor_row['texto_inicial']) : ('');
					$texto_final = (isset($valor_row['texto_final'])) ? ($valor_row['texto_final']) : ('');
					
					$valores_formatados[] = array(
						'tipo_busca'=>$valor_row['tipo_busca'],
						'texto_inicial'=>$texto_inicial,
						'texto_final'=>$texto_final
					);
				}
				echo json_encode($valores_formatados);
				?>
			</div>
		</div>
		<?php
	}

	public static function radiobutton($nome, $opcoes, $valor_selecionado='', $atributos_input='', $atributos_div=''){
		$i = 0;
		if(is_bool($valor_selecionado)){
			$valor_selecionado = ($valor_selecionado) ? ('true') : ('false');
		}
		foreach($opcoes as $valor=>$texto){
			if(empty($texto)){
				$texto = '&nbsp';
			}
			if($valor == $valor_selecionado){
				$checked = 'checked';
			} else {
				$checked = '';
			}
			$nome_sem_colchetes = str_replace(array('[', ']'), '_', $nome);
			
			$id = $nome_sem_colchetes . $i;
			?>
			<div class="radio radio-success" <?php echo $atributos_div ?>>
				<input type="radio" id="<?php echo $id ?>" name="<?php echo $nome ?>" value="<?php echo $valor ?>"
					<?php echo $checked ?> <?php echo $atributos_input ?> />
				<label for="<?php echo $id ?>"><?php echo $texto ?></label>
			</div>
			<?php
			$i++;
		}
	}
	
	public static function checkbox($nome, $opcoes, $valores_selecionados=array(), $atributos_input='', $atributos_div=''){
		$i = 0;
		if(is_bool($valores_selecionados)){
			$valores_selecionados = ($valores_selecionados) ? ('true') : ('false');
		}
		foreach($opcoes as $valor=>$texto){
			if(empty($texto)){
				$texto = '&nbsp';
			}
			if(is_array($valores_selecionados)){
				if(in_array($valor, $valores_selecionados)){
					$checked = 'checked';
				} else {
					$checked = '';
				}
			} else {
				if($valor == $valores_selecionados){
					$checked = 'checked';
				} else {
					$checked = '';
				}
			}
			$nome_sem_colchetes = str_replace(array('[', ']'), '_', $nome);
			
			$id = $nome_sem_colchetes . $i;
			?>
			<div class="checkbox checkbox-success" <?php echo $atributos_div ?>>
				<input type="checkbox" id="<?php echo $id ?>" name="<?php echo $nome ?>" value="<?php echo $valor ?>"
					<?php echo $checked ?>  <?php echo $atributos_input ?> />
				<label for="<?php echo $id ?>"><?php echo $texto ?></label>
			</div>
			<?php
			$i++;
		}
	}
	
	public static function icone($nome, $valor='', $conjunto_icones='fatcow_16x16', $linhas=6, $colunas=6, $podeAlterarConjuntoIcones=false){
		$id = str_replace(array('[', ']'), '_', $nome);
		if($podeAlterarConjuntoIcones){
			$podeAlterarConjuntoIcones = 'true';
		} else {
			$podeAlterarConjuntoIcones = 'false';
		}
		?>
		<button id="<?php echo $id ?>" name="<?php echo $nome ?>" type="button" class="btn btn-default iconpicker" value="<?php echo $valor ?>"
			data-conjunto-icones="<?php echo $conjunto_icones ?>" data-linhas="<?php echo $linhas ?>" data-colunas="<?php echo $colunas ?>"
			data-pode-alterar-conjunto-icones="<?php echo $podeAlterarConjuntoIcones ?>"></button>
		<?php
	}
}