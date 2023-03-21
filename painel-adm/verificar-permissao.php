<?php

// verifica permissões de login do usuário
if (@$_SESSION['nivel_usuario' != 'Administrador']) {
  echo "<script language='javascript'>window.location='../index.php'</script>";
}

?>