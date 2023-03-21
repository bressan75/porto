<?php


require_once("conexao.php");
@session_start();

// Atribui os dados obtido pelo método POST à variáveis
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

// Procura correspondência entre os dados obtidos e os dados já disponíveis no Banco de Dados
$query_con = $pdo->prepare("SELECT * from usuarios WHERE login = :usuario and senha = :senha AND status = 'Ativo'");
$query_con->bindValue(":usuario", $usuario);
$query_con->bindValue(":senha", $senha);
$query_con->execute();
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);


// Se houver correspondências é definido as variáveis com base nos dados do banco
if(@count($res_con) > 0){
	$nivel = $res_con[0]['nivel'];

	$_SESSION['id_usuario'] = $res_con[0]['id'];
	$_SESSION['nome_usuario'] = $res_con[0]['nome'];
	$_SESSION['cpf_usuario'] = $res_con[0]['cpf'];
	$_SESSION['telefone_usuario'] = $res_con[0]['telefone'];
	$_SESSION['email_usuario'] = $res_con[0]['email'];
	$_SESSION['login_usuario'] = $res_con[0]['login'];
	$_SESSION['senha_usuario'] = $res_con[0]['senha'];
	$_SESSION['nivel_usuario'] = $res_con[0]['nivel'];
	$_SESSION['foto_usuario'] = $res_con[0]['foto'];


	// Verifica o nível de acesso para redirecionar para o Painel correto
	if($nivel == 'Administrador'){
		echo "<script language='javascript'>window.location='painel-adm'</script>";
	}

	// Se Não houver correspondência nos dados enviados, Exibi-se a mensagem 'Usuário ou Senha Incorretos!'
}else{

	echo "<script language='javascript'>window.alert('Usuário ou Senha Incorretos!')</script>";
	echo "<script language='javascript'>window.location='index.php'</script>";
}

?>