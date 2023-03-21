<?php

@session_start();
require_once("../../conexao.php");

$id = $_POST['id-container'];
$cliente = $_POST['cliente'];
$numero = $_POST['numero'];
$tipo = $_POST['tipo'];
$categoria = $_POST['categoria'];
$status_container = $_POST['status_container'];
$data = date('Y-m-d H:i:s');
$modificado = date('Y-m-d H:i:s');
$usuario = $_SESSION['id_usuario'];

// Se id vazio, novo registro senão é edição
if ($id == "") {

	$res = $pdo->prepare("INSERT INTO container SET
		cliente = :cliente,
		numero = :numero,
		tipo = :tipo,
		status_container = :status_container,
		categoria = :categoria,
		data = :data,
		usuario = :usuario");
	$res->bindValue(":cliente", $cliente);
	$res->bindValue(":numero", $numero);
	$res->bindValue(":tipo", $tipo);
	$res->bindValue(":status_container", $status_container);
	$res->bindValue(":categoria", $categoria);
	$res->bindValue(":data", $data);
	$res->bindValue(":usuario", $usuario);
	$res->execute();

} else {

	$res = $pdo->prepare("UPDATE container SET
		cliente = :cliente,
		numero = :numero,
		tipo = :tipo,
		status_container = :status_container,
		categoria = :categoria,
		modificado = :modificado,
		usuario = :usuario
		WHERE id = :id");
	$res->bindValue(":id", $id);
	$res->bindValue(":cliente", $cliente);
	$res->bindValue(":numero", $numero);
	$res->bindValue(":tipo", $tipo);
	$res->bindValue(":status_container", $status_container);
	$res->bindValue(":categoria", $categoria);
	$res->bindValue(":modificado", $modificado);
	$res->bindValue(":usuario", $usuario);
	$res->execute();

}

echo "Salvo com Sucesso!";

?>