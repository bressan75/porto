<?php

@session_start();
require_once('../conexao.php');
require_once('verificar-permissao.php');


$query = $pdo->query("SELECT * FROM clientes WHERE status != 'Removido'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_clientes = @count($res);

$query = $pdo->query("SELECT * FROM container WHERE status != 'Removido'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_container = @count($res);

$query = $pdo->query("SELECT * FROM movimentacoes WHERE status != 'Removido'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_movimentacoes = @count($res);

?>

<div class="container-fluid pt-4 pb-3">

  <div class="row">

    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
            <i class="fas fa-male"></i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0">Clientes</p>
            <h4 class="mb-0"><?php echo (empty($total_clientes)) ? '0' : $total_clientes ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0"><span class="text-success text-sm font-weight-bolder">...</p>
        </div>
      </div>
    </div>

    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
          <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
            <i class="fas fa-cube"></i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0 ">Containers</p>
            <h4 class="mb-0"><?php echo (empty($total_container)) ? '0' : $total_container ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0"><span class="text-success text-sm font-weight-bolder">...</p>
        </div>
      </div>
    </div>

    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
            <i class="fas fa-ship"></i>
          </div>
          <div class="text-end pt-1">
            <p class="text-sm mb-0">Movimentações</p>
            <h4 class="mb-0"><?php echo (empty($total_movimentacoes)) ? '0' : $total_movimentacoes ?></h4>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
          <p class="mb-0">...</p>
        </div>
      </div>
    </div>

  </div>

</div>