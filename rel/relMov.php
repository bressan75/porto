<?php

require_once("../conexao.php");

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));

$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];

$tipo = $_GET['tipo'];
$cliente = $_GET['cliente'];
$usuario = $_GET['usuario'];

$dataInicialF = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(explode('-', $dataFinal)));

if($dataInicial != $dataFinal){
	$apuracao = $dataInicialF. ' à '. $dataFinalF;
}else{
	$apuracao = $dataInicialF;
}

// trata o tipo de filtro selecionado no relatório
// não escolheu nem tipo e nem cliente, sql = geral
if ( (empty($tipo)) && (empty($cliente)) ){

	$dtI = $dataInicial.' 00:00:00';
	$dtF = $dataFinal.' 23:59:59';

	$sql = "SELECT a.nome, a.doc, b.numero, b.status_container, b.categoria, c.tipo, date_format(c.datainicio, '%d/%m/%Y %Hh%i') as fmtdatainicio, date_format(c.datafim, '%d/%m/%Y %Hh%i') as fmtdatafim FROM
			clientes as a, container as b, movimentacoes as c WHERE
			a.id = b.cliente AND
			b.id = c.container AND
			a.status != 'Removido' AND
			b.status != 'Removido' AND
			c.status != 'Removido' AND
			c.datainicio >= '$dtI' AND
			c.datafim <= '$dtF'
			ORDER BY a.nome ASC";

	$tipo_mov = 'Geral';
}

// não escolheu o tipo mas escolheu cliente, sql = por cliente
if ( (empty($tipo)) && ($cliente) ){

	$dtI = $dataInicial.' 00:00:00';
	$dtF = $dataFinal.' 23:59:59';

	$sql = "SELECT a.id, a.nome, a.doc, b.numero, b.status_container, b.categoria, c.tipo, date_format(c.datainicio, '%d/%m/%Y %Hh%i') as fmtdatainicio, date_format(c.datafim, '%d/%m/%Y %Hh%i') as fmtdatafim FROM
			clientes as a, container as b, movimentacoes as c WHERE
			a.id = b.cliente AND
			b.id = c.container AND
			a.status != 'Removido' AND
			b.status != 'Removido' AND
			c.status != 'Removido' AND
			c.datainicio >= '$dtI' AND
			c.datafim <= '$dtF' AND
			a.id = {$cliente}
			ORDER BY a.nome ASC";

	$tipo_mov = 'Por cliente';
}

// escolheu o tipo mas não escolheu cliente, sql = por tipo
if ( (empty($cliente)) && ($tipo) ){

	$dtI = $dataInicial.' 00:00:00';
	$dtF = $dataFinal.' 23:59:59';

	$sql = "SELECT a.id, a.nome, a.doc, b.numero, b.status_container, b.categoria, c.tipo, date_format(c.datainicio, '%d/%m/%Y %Hh%i') as fmtdatainicio, date_format(c.datafim, '%d/%m/%Y %Hh%i') as fmtdatafim FROM
			clientes as a, container as b, movimentacoes as c WHERE
			a.id = b.cliente AND
			b.id = c.container AND
			a.status != 'Removido' AND
			b.status != 'Removido' AND
			c.status != 'Removido' AND
			c.datainicio >= '$dtI' AND
			c.datafim <= '$dtF' AND
			c.tipo LIKE '%$tipo%'
			ORDER BY a.nome ASC";

	$tipo_mov = 'Por tipo';
}

// escolheu o tipo e cliente, sql = por tipo e cliente
if ( ($cliente) && ($tipo) ){

	$dtI = $dataInicial.' 00:00:00';
	$dtF = $dataFinal.' 23:59:59';

	$sql = "SELECT a.id, a.nome, a.doc, b.numero, b.status_container, b.categoria, c.tipo, date_format(c.datainicio, '%d/%m/%Y %Hh%i') as fmtdatainicio, date_format(c.datafim, '%d/%m/%Y %Hh%i') as fmtdatafim FROM
			clientes as a, container as b, movimentacoes as c WHERE
			a.id = b.cliente AND
			b.id = c.container AND
			a.status != 'Removido' AND
			b.status != 'Removido' AND
			c.status != 'Removido' AND
			c.datainicio >= '$dtI' AND
			c.datafim <= '$dtF' AND
			a.id = {$cliente} AND
			c.tipo = '{$tipo}'
			ORDER BY a.nome ASC";

	$tipo_mov = 'Por tipo e cliente';
}


//echo $sql;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Relatório de Movimentações</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<style>

		.cabecalho-topo {
			background-color: #ebebeb;
			padding:10px;
			margin-bottom:30px;
			width:100%;
			height:100px;
		}

		.cabecalho {
			padding:10px;
			margin-bottom:30px;
			width:100%;
			font-family:Times, "Times New Roman", Georgia, serif;
		}

		.titulo{
			margin:0;
			font-size:28px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;

		}

		.subtitulo{
			margin:0;
			font-size:12px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;
		}

		.areaTotais{
			border : 0.5px solid #bcbcbc;
			padding: 15px;
			border-radius: 5px;
			margin-right:25px;
			margin-left:25px;
			position:absolute;
			right:20;
		}

		.areaTotal{
			border : 0.5px solid #bcbcbc;
			padding: 15px;
			border-radius: 5px;
			margin-right:25px;
			margin-left:25px;
			background-color: #f9f9f9;
			margin-top:2px;
		}

		.pgto{
			margin:1px;
		}

		.fonte13{
			font-size:13px;
		}

		.esquerda{
			display:inline;
			width:50%;
			float:left;
		}

		.direita{
			display:inline;
			width:50%;
			float:right;
		}

		.table{
			padding:15px;
			font-family:Verdana, sans-serif;
			margin-top:20px;
		}

		.texto-tabela{
			font-size:12px;
		}

		.esquerda_float{

			margin-bottom:10px;
			float:left;
			display:inline;
		}

		.titulos{
			margin-top:10px;
		}

		.image{
			margin-top:-10px;
		}

		.margem-direita{
			margin-right: 80px;
		}

		.margem-direita50{
			margin-right: 50px;
		}

		.margem-superior{
			margin-top:30px;
		}

		.areaSubtituloCab{
			margin-top:15px;
			margin-bottom:15px;
		}

		.area-cab{
			display:block;
			width:100%;
			height:10px;
		}

		.coluna{
			margin: 0px;
			float:left;
			height:30px;
		}

		.area-tab{
			display:block;
			width:100%;
			height:30px;
		}

		@page {
			margin: 0px;

		}
		.footer {
			margin-top:20px;
			width:100%;
			background-color: #ebebeb;
			padding:10px;
			position:absolute;
			bottom:0;
			font-family:Verdana, sans-serif;
		}
		hr{
			margin:8px;
			padding:1px;
		}
		.titulorel{
			margin:0;
			font-size:25px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;
		}
		.borda {
			border: 1px dashed #b3b3b3;
		}
		.borda-esq {
			border-left: 1px dashed #b3b3b3;
		}
		.borda-dir {
			border-right: 1px dashed #b3b3b3;
		}
		.borda-top {
			border-top: 1px dashed #b3b3b3;
		}
		.borda-bot {
			border-button: 1px dashed #b3b3b3;
		}
		.cab {
			background-color: #ebebeb;
			font-family:Verdana, sans-serif;
		}
		.cab_bco {
			background-color: #ffffff;
			font-family:Verdana, sans-serif;
		}
		.linha_cab {
			padding:5px;
			text-align: left;
		}
		.linha_cab_cent {
			padding:5px;
			text-align: center;
		}
		.linha_cab_dir {
			padding:5px;
			text-align: right;
		}
		.linha_corp {
			padding:5px;
		}
		.linha_corp_dir {
			padding:5px;
			text-align: right;
		}
		.linha_div {
			padding:10px;
			margin-bottom:30px;
			width:100%;
			border-bottom: solid 1px #e3e3e3;
		}
	</style>

</head>

<body>

	<?php if($cabecalho_img_rel == 'SIM'){ ?>

		<div class="img-cabecalho my-4">
			<img src="<?php echo ROOT_URL ?>img/topo-relatorio.jpg" width="100%">
		</div>

	<?php }else{ ?>

		<!-- CABEÇALHO EM HTML -->

	<?php } ?>

	<div class="container">

		<div align="center" class="">
			<span class="titulorel">Relatório de Movimentações - <?php echo $tipo_mov  ?> </span>
		</div>
		<hr>
		<div class="mx-2" style="padding-top:15px ">

			<table width="100%" cellpadding="5" cellspacing="0" class="borda">
			    <thead>
			        <tr class="cab borda-bot">
						<th class="linha_cab borda-esq" style="width:24%">CLIENTE</th>
						<th class="linha_cab_cent borda-esq" style="width:10%">TIPO</th>
						<th class="linha_cab_cent borda-esq" style="width:10%">CONTAINER</th>
						<th class="linha_cab_cent borda-esq" style="width:10%">STATUS</th>
						<th class="linha_cab_cent borda-esq" style="width:10%">CATEGORIA</th>
						<th class="linha_cab_cent borda-esq" style="width:10%">DATA INICIAL</th>
						<th class="linha_cab_cent borda-esq" style="width:10%">DATA FINAL</th>
			        </tr>
			    </thead>
			    <tbody>

					<?php

					$importacao = 0;
					$exportacao = 0;

					$query = $pdo->query($sql);
					$res = $query->fetchAll(PDO::FETCH_ASSOC);
					$totalItens = @count($res);

					for ($i=0; $i < @count($res); $i++) {
						foreach ($res[$i] as $key => $value) {
						}

						if($res[$i]['status_container'] == 'Cheio'){
							$classe_tipo = 'text-success';
						}else{
							$classe_tipo = 'text-danger';
						}

						if($res[$i]['categoria'] == 'Importação'){
							$importacao += 1;
						}else{
							$exportacao += 1;
						}

						?>

						<tr>
							<td align="left" class="linha_corp"><?php echo $res[$i]['nome'] ?></td>
							<td align="left" class="linha_corp borda-esq"><?php echo $res[$i]['tipo'] ?></td>
							<td align="left" class="linha_corp_dir borda-esq"><?php echo $res[$i]['numero'] ?></td>
							<td align="center" class="linha_corp borda-esq"><p class="<?php echo $classe_tipo ?>"><?php echo $res[$i]['status_container'] ?></p></td>
							<td align="left" class="linha_corp_dir borda-esq"><?php echo $res[$i]['categoria'] ?></td>
							<td align="left" class="linha_corp_dir borda-esq"><?php echo $res[$i]['fmtdatainicio'] ?></td>
							<td align="left" class="linha_corp_dir borda-esq"><?php echo $res[$i]['fmtdatafim'] ?></td>
						</tr>

					<?php } ?>
				</tbody>
			</table>

		</div>


		<div class="cabecalho mt-3" style="border-bottom: solid 1px #c4c4c4">
		</div>

		<hr>

		<small>
			<div class="row">
				<div class="col-sm-8 esquerda">
					<span class=""> <b> Importação: </b> <span class="text-success"><?php echo $importacao ?></span> </span>
					<span class=""> <b> Exportação: </b> <span class="text-danger"><?php echo $exportacao ?></span> </span>
				</div>
				<div class="col-sm-4 direita" align="right">
					<span class=""> <b> Tipo: </b> <?php echo ( (empty($tipo)) ? 'Geral' : $tipo); ?></span>
				</div>
			</div>
		</small>

		<hr>

		<small>
			<div class="row">
				<div class="col-sm-6 esquerda">
					<span class=""> <b> Período da Movimentação: </b> </span>

					<span class=""> <?php echo $apuracao ?> </span>
				</div>
				<div class="col-sm-6 direita" align="right">
					<span class=""><b>Gerado: </b>  <?php echo $data_hoje ?></span>
				</div>
			</div>
		</small>

		<hr>
	</div>

	<div class="footer">
		<p style="font-size:14px" align="center"><?php echo $rodape_relatorios ?></p>
	</div>

</body>
</html>
