<?php

@session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once("../../conexao.php");

$id = $_POST['id-cliente'];
$nome = $_POST['nome-cliente'];
$doc = $_POST['doc-cliente'];
$rg_ie = $_POST['rg-cliente'];
$telefone = $_POST['telefone-cliente'];
$email = $_POST['email-cliente'];
$endereco = $_POST['endereco-cliente'];
$observacao = $_POST['observacao-cliente'];
$data = date('Y-m-d H:i:s');
$modificado = date('Y-m-d H:i:s');
$status = $_POST['status'];
$usuario = $_SESSION['id_usuario'];

$antigo = $_POST['antigo-cliente'];

// EVITAR DUPLICIDADE NO doc
if ($antigo != $doc) {

	$query_con = $pdo->prepare("SELECT * FROM clientes WHERE doc = :doc AND status != 'Removido'");
	$query_con->bindValue(":doc", $doc);
	$query_con->execute();
	$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
	if (@count($res_con) > 0) {
		echo "CPF ou CNPJ já cadastrado!";
		exit();
	}
}

if ($id == "") {

	$res = $pdo->prepare("INSERT INTO clientes SET nome = :nome, doc = :doc, rg_ie = :rg_ie, telefone = :telefone, email = :email, endereco = :endereco, observacao = :observacao, data = :data, status = :status, usuario = :usuario");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":doc", $doc);
	$res->bindValue(":rg_ie", $rg_ie);
	$res->bindValue(":telefone", $telefone);
	$res->bindValue(":email", $email);
	$res->bindValue(":endereco", $endereco);
	$res->bindValue(":observacao", $observacao);
	$res->bindValue(":data", $data);
	$res->bindValue(":status", $status);
	$res->bindValue(":usuario", $usuario);
	$res->execute();

} else {

	$res = $pdo->prepare("UPDATE clientes SET nome = :nome, doc = :doc, rg_ie = :rg_ie, telefone = :telefone, email = :email, endereco = :endereco, observacao = :observacao, modificado = :modificado, status = :status, usuario = :usuario WHERE id = :id");
	$res->bindValue(":id", $id);
	$res->bindValue(":nome", $nome);
	$res->bindValue(":doc", $doc);
	$res->bindValue(":rg_ie", $rg_ie);
	$res->bindValue(":telefone", $telefone);
	$res->bindValue(":email", $email);
	$res->bindValue(":endereco", $endereco);
	$res->bindValue(":observacao", $observacao);
	$res->bindValue(":modificado", $modificado);
	$res->bindValue(":status", $status);
	$res->bindValue(":usuario", $usuario);
	$res->execute();

}

echo "Salvo com Sucesso!";

?>