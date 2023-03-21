<?php

@session_start();
require_once("../../conexao.php");

$id = $_POST['id'];
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$login = $_POST['login'];
$senha = $_POST['senha'];
$nivel = $_POST['nivel'];
$data = date('Y-m-d H:i:s');
$modificado = date('Y-m-d H:i:s');
$status = $_POST['status'];
$usuario = $_SESSION['id_usuario'];

$antigo = $_POST['antigo'];
$antigo2 = $_POST['antigo2'];


// EVITAR DUPLICIDADE NO CPF
if ($antigo != $cpf) {

	$query_con = $pdo->prepare("SELECT * FROM usuarios WHERE cpf = :cpf");
	$query_con->bindValue(":cpf", $cpf);
	$query_con->execute();
	$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
	if (@count($res_con) > 0) {
		echo "CPF já cadastrado!";
		exit();
	}
}

// EVITAR DUPLICIDADE NO LOGIN
if ($antigo2 != $login) {

	$query_con = $pdo->prepare("SELECT * FROM usuarios WHERE login = :login");
	$query_con->bindValue(":login", $login);
	$query_con->execute();
	$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
	if (@count($res_con) > 0) {
		echo "Login já cadastrado para outro usuário!";
		exit();
	}
}

//SCRIPT PARA SUBIR FOTO NO BANCO
$nome_img = date('d-m-Y H:i:s').'-'.@$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../img/usuarios/' .$nome_img;
if (@$_FILES['foto']['name'] == ""){
	$imagem = "sem-foto.jpg";
}else{
	$imagem = $nome_img;
}

$imagem_temp = @$_FILES['foto']['tmp_name'];
$ext = pathinfo($imagem, PATHINFO_EXTENSION);
if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){
	move_uploaded_file($imagem_temp, $caminho);
}else{
	echo 'Extensão de Imagem não permitida!';
	exit();
}


if ($id == "") {

	$res = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, cpf = :cpf, telefone = :telefone, email = :email, login = :login, senha = :senha, nivel = :nivel, foto = :foto, data = :data, status = :status, usuario = :usuario");
	$res->bindValue(":nome", $nome);
	$res->bindValue(":cpf", $cpf);
	$res->bindValue(":telefone", $telefone);
	$res->bindValue(":email", $email);
	$res->bindValue(":login", $login);
	$res->bindValue(":senha", $senha);
	$res->bindValue(":nivel", $nivel);
	$res->bindValue(":foto", $imagem);
	$res->bindValue(":data", $data);
	$res->bindValue(":status", $status);
	$res->bindValue(":usuario", $usuario);
	$res->execute();

} else {

	if ($imagem != "sem-foto.jpg") {
		$res = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, telefone = :telefone, email = :email, login = :login, senha = :senha, nivel = :nivel, foto = :foto, modificado = :modificado, status = :status, usuario = :usuario WHERE id = :id");
		$res->bindValue(":foto", $imagem);
	} else {
		$res = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, telefone = :telefone, email = :email, login = :login, senha = :senha, nivel = :nivel, modificado = :modificado, status = :status, usuario = :usuario WHERE id = :id");
	}


	$res->bindValue(":id", $id);
	$res->bindValue(":nome", $nome);
	$res->bindValue(":cpf", $cpf);
	$res->bindValue(":telefone", $telefone);
	$res->bindValue(":email", $email);
	$res->bindValue(":login", $login);
	$res->bindValue(":senha", $senha);
	$res->bindValue(":nivel", $nivel);
	$res->bindValue(":modificado", $modificado);
	$res->bindValue(":status", $status);
	$res->bindValue(":usuario", $usuario);
	$res->execute();

}

echo "Salvo com Sucesso!";

?>