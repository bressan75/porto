<?php

@session_start();
require_once("../../conexao.php");

$id = $_POST['id'];
$modificado = date('Y-m-d H:i:s');
$status = 'Removido';
$usuario = $_SESSION['id_usuario'];

$query_con = $pdo->query("SELECT * FROM usuarios WHERE id = '$id'");
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);

// BUSCAR A IMAGEM PARA EXCLUIR DA PASTA
$imagem = $res_con[0]['foto'];
if ( $imagem != "sem-foto.jpg" ) {
	unlink('../../img/usuarios/'.$imagem);
}

/*$query_con = $pdo->query("DELETE FROM usuarios WHERE id = '$id'");
echo "Excluido com Sucesso!"; */
$res = $pdo->prepare("UPDATE usuarios SET modificado = :modificado, status = :status, usuario = :usuario WHERE id = :id");
$res->bindValue(":id", $id);
$res->bindValue(":modificado", $modificado);
$res->bindValue(":status", $status);
$res->bindValue(":usuario", $usuario);
$res->execute();

echo "Excluido com Sucesso!";
?>