<?php

// Carrega o arquivo de conexão com o banco de dados
require_once('conexao.php');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo SISTEMA ?> | Recuperar Senha</title>

	<!-- JQuery -->
	<script type="text/javascript" src="vendor/jquery/jquery-3.6.0.min.js"></script>

	<!-- Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

	<!-- Font Awesome -->
	<link href="vendor/fontawesome/css/all.css" rel="stylesheet">

	<!-- FONTS -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="vendor/css/main.css">

	<!-- AUT -->
	<link rel="stylesheet" type="text/css" href="vendor/css/autenticacao.css">

	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.png" />
</head>

<body class="bg-gray-200">

	<main class="main-content  mt-0">
		<div class="page-header align-items-start min-vh-100" style="background-image: url('./img/bg-login.jpg'); background-size: cover;">
			<div class="container my-auto">
				<div class="row">
					<div class="col-lg-4 col-md-8 col-12 mx-auto">
						<div class="card z-index-0 fadeIn3 fadeInBottom">
							<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-primary-login shadow-primary border-radius-lg px-3 py-3">
									<img src="./img/logo.jpg" class="w-100 border-radius-lg">
								</div>

								<div class="card-body">

									<form role="form" class="text-start" method="POST" action="recuperarsenha.php">

									<!-- Quando o formulário é enviado pelo método POST o arquivo de recuperacao de senha (recuperarsenha.php) é executado -->

										<div class="input-group input-group-outline my-3">
											<label class="form-label">E-mail do Cadastro</label>
											<input type="text" class="form-control text-uppercase" name="email" required>
										</div>

										<div class="text-center">
											<button type="submit" class="btn bg-gradient-primary-login w-100 my-4 mb-2 text-white">Enviar</button>

											<p class="mt-3 small"><a href="index.php">Clique aqui</a> e retorne ao formulário de login.</p>

										</div>
									</form>

								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</main>

		<footer class="footer position-absolute bottom-2 py-2 w-100">
			<div class="container d-flex justify-content-center">
				<div class="row align-items-center justify-content-lg-between">
					<div class="col-12 col-md-12 my-auto">
						<div class="copyright text-center text-sm text-black-50 text-lg-start">
							© <?php echo date('Y'); ?> Desenvolvido com <i class="fa fa-cloud"></i> por
							<a href="https://<?php echo SITE_EMPRESA ?>" class="font-weight-bold text-black-50" target="_blank"><?php echo NOME_EMPRESA ?></a>.
						</div>
					</div>
				</div>
			</div>
		</footer>

		<script src="./vendor/js/plugins/perfect-scrollbar.min.js"></script>
		<script src="./vendor/js/plugins/smooth-scrollbar.min.js"></script>

		<script>
			var win = navigator.platform.indexOf('Win') > -1;
			if (win && document.querySelector('#sidenav-scrollbar')) {
				var options = {
					damping: '0.5'
				}
				Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
			}
		</script>

		<script src="./vendor/js/main.min.js"></script>
		<script src="./vendor/js/mostra-senha.js"></script>
	</body>
	</html>