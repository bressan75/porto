<?php

@session_start();
require_once("../../conexao.php");

$id = $_POST['id-container'];
$modificado = date('Y-m-d H:i:s');
$status = 'Removido';
$usuario = $_SESSION['id_usuario'];

$res = $pdo->prepare("UPDATE movimentacoes SET modificado = :modificado, status = :status, usuario = :usuario WHERE id = :id");
$res->bindValue(":id", $id);
$res->bindValue(":modificado", $modificado);
$res->bindValue(":status", $status);
$res->bindValue(":usuario", $usuario);
$res->execute();

echo "Excluido com Sucesso!";

?>