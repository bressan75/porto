<?php


require_once("conexao.php");
require_once("src/PHPMailer.php");
require_once("src/SMTP.php");
require_once("src/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

//@session_start();

// Atribui os dados obtido pelo método POST à variáveis
// Os Dados vem do formulário de Login
$email = $_POST['email'];

// Procura correspondência entre os dados obtidos e os dados já disponíveis no Banco de Dados
$query_con = $pdo->prepare("SELECT * from usuarios WHERE email = :email AND status = 'Ativo'");
$query_con->bindValue(":email", $email);
$query_con->execute();
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);


// Se houver correspondências é envio os dados para o email do usuário
if(@count($res_con) > 0){
	$nivel = $res_con[0]['nivel'];

	$nome = $res_con[0]['nome'];
	$email_usuario = $res_con[0]['email'];
	$login = $res_con[0]['login'];
	$senha = $res_con[0]['senha'];
	$data_envio = date('d/m/Y');
	$hora_envio = date('H:i');

	// enviar email ver biblioteca ::::
	try {
		$mail->isSMTP();
		//$mail->SMTPDebug = 2;
		$mail->Host = HOST;
		$mail->SMTPAuth = true;
		$mail->Username = USERNAME;
		$mail->Password = PASSWORD;
		$mail->Port = PORTA;

		$mail->setFrom(USERNAME, SISTEMA);
		$mail->addAddress($email_usuario, $nome);

		$mail->isHTML(true);
		$mail->Subject = 'Reenvio de senha acesso ao sistema';

		$corpo = "Segue senha de acesso ao sistema solicitado em ".$data_envio.' às '.$hora_envio."<br><br>";
		$corpo .= "<strong>Senha:</strong> ".$senha."<br><br>";
		$corpo .= "Caso não tenha solicitado, entre em contato conosco!<br><br>";
		$corpo .= NOME_EMPRESA."<br>";
		$corpo .= SISTEMA."<br>";
		$corpo .= SITE_EMPRESA;

		// com config html no cliente de email
		$mail->Body = $corpo;
		// caso cliente de email não aceite html
		$mail->AltBody = 'Senha de acesso: '.$senha;

		if($mail->send()) {
			echo 'Email enviado com sucesso';
			echo "<script language='javascript'>window.location='index.php'</script>";
		} else {
			echo 'Email nao enviado';
		}
	} catch (Exception $e) {
		echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
	}

    //echo "<script language='javascript'>window.location='index.php'</script>";

	// Se Não houver correspondência nos dados enviados, Exibi-se a mensagem 'Usuário não localizado!'
}else{

	echo "<script language='javascript'>window.alert('Usuário não localizado!')</script>";
	echo "<script language='javascript'>window.location='recuperar.php'</script>";
}

?>