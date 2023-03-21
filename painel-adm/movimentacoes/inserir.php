<?php

@session_start();
require_once("../../conexao.php");

$id = $_POST['id-movimento'];
$container = $_POST['container'];
$tipo = $_POST['tipo'];
$dataInicial = implode('-', array_reverse(explode('/', $_POST['dataInicial'])));
$horaInicial = $_POST['horaInicial'];
$dataFinal = implode('-', array_reverse(explode('/', $_POST['dataFinal'])));
$horaFinal = $_POST['horaFinal'];
$modificado = date('Y-m-d H:i:s');
$usuario = $_SESSION['id_usuario'];

$datainicio = $dataInicial.' '.$horaInicial;
$datafim = $dataFinal.' '.$horaFinal;

// Se id vazio, novo registro senão é edição
if ($id == "") {

	$res = $pdo->prepare("INSERT INTO movimentacoes SET
		container = :container,
		tipo = :tipo,
		datainicio = :datainicio,
		datafim = :datafim,
		usuario = :usuario");
	$res->bindValue(":container", $container);
	$res->bindValue(":tipo", $tipo);
	$res->bindValue(":datainicio", $datainicio);
	$res->bindValue(":datafim", $datafim);
	$res->bindValue(":usuario", $usuario);
	$res->execute();

} else {

	$res = $pdo->prepare("UPDATE movimentacoes SET
		container = :container,
		tipo = :tipo,
		datainicio = :datainicio,
		datafim = :datafim,
		modificado = :modificado,
		usuario = :usuario
		WHERE id = :id");
	$res->bindValue(":id", $id);
	$res->bindValue(":container", $container);
	$res->bindValue(":tipo", $tipo);
	$res->bindValue(":datainicio", $datainicio);
	$res->bindValue(":datafim", $datafim);
	$res->bindValue(":modificado", $modificado);
	$res->bindValue(":usuario", $usuario);
	$res->execute();

}

echo "Salvo com Sucesso!";

?>