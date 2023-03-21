<?php

@session_start();
require_once('../conexao.php');
require_once('verificar-permissao.php');

// busca
@$nome_busca = $_POST['nome_busca'];

// filtro
@$dataInicial = $_POST['dataInicial'];
@$dataFinal = $_POST['dataFinal'];
@$status = $_POST['status'];
$apuracao = '';

// ordernação
@$order = $_GET['order'];

switch ($order) {
	case 'cliente_asc':
		$ordernacao = 'a.nome ASC';
	break;
	case 'cliente_desc':
		$ordernacao = 'a.nome DESC';
	break;
	case 'container_asc':
		$ordernacao = 'a.numero ASC';
	break;
	case 'container_desc':
		$ordernacao = 'a.numero DESC';
	break;
	case 'datainicio_asc':
		$ordernacao = 'b.datainicio ASC';
	break;
	case 'datainicio_desc':
		$ordernacao = 'b.datainicio DESC';
	break;
	case 'datafinal_asc':
		$ordernacao = 'b.datafim ASC';
	break;
	case 'datafinal_desc':
		$ordernacao = 'b.datafim DESC';
	break;
	case 'tipo_asc':
		$ordernacao = 'b.tipo ASC';
	break;
	case 'tipo_desc':
		$ordernacao = 'b.tipo DESC';
	break;
	default:
		$ordernacao = 'b.id DESC';
}

// input busca
if (!empty($nome_busca)) {
	$sql = "SELECT a.numero, b.*, date_format(b.datainicio, '%d/%m/%Y %Hh%i') as fmtdatainicio, date_format(b.datafim, '%d/%m/%Y %Hh%i') as fmtdatafim, c.nome, c.doc FROM container as a, movimentacoes as b, clientes as c
			WHERE a.id = b.container AND
			 a.cliente = c.id AND
			 ((a.numero LIKE '%$nome_busca%' OR
			 c.nome LIKE '%$nome_busca%' OR
			 c.doc LIKE '%$nome_busca%' OR
			 b.tipo LIKE '%$nome_busca%') AND
			 a.status != 'Removido' AND
			 b.status != 'Removido' AND
			 c.status != 'Removido')
			 ORDER BY b.id DESC";
}else{
	// se não utilizar o campo filtro tbm aplica a ordenação
	if ( ($dataInicial == '') || ($dataFinal == '') || ($status == '') ) {

		$sql = "SELECT a.numero, b.*, date_format(b.datainicio, '%d/%m/%Y %Hh%i') as fmtdatainicio, date_format(b.datafim, '%d/%m/%Y %Hh%i') as fmtdatafim, c.nome, c.doc FROM container as a, movimentacoes as b, clientes as c
				WHERE
				a.id = b.container AND
				a.cliente = c.id AND
				a.status != 'Removido' AND
				c.status != 'Removido' AND
				b.status != 'Removido'
				ORDER BY $ordernacao";

		$apuracao = 'Cadastradas';

	}else{

		$dtI = $dataInicial.' 00:00:00';
		$dtF = $dataFinal.' 23:59:59';

		$sql = "SELECT a.numero, b.*, date_format(b.datainicio, '%d/%m/%Y %Hh%i') as fmtdatainicio, date_format(b.datafim, '%d/%m/%Y %Hh%i') as fmtdatafim, c.nome, c.doc FROM container as a, movimentacoes as b, clientes as c
				WHERE
				a.id = b.container AND
				a.cliente = c.id AND
				a.status != 'Removido' AND
				b.status != 'Removido' AND
				c.status != 'Removido' AND
				b.datainicio >= '$dtI' AND
				b.datafim <= '$dtF' AND
				b.tipo = '$status'
				ORDER BY b.id DESC";

		$dataInicialF = implode('/', array_reverse(explode('-', $dataInicial)));
		$dataFinalF = implode('/', array_reverse(explode('-', $dataFinal)));
		$apuracao = $dataInicialF. ' à '. $dataFinalF. ' Tipo: '.$status;

	}
}

//echo $sql;

//Executa a busca de dados
$query = $pdo->query($sql);
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
?>
<div class="container-fluid pt-4">
  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-secondary shadow-secondary border-radius-lg pt-4 pb-3 d-flex justify-content-between container-fluid">
          	<div class="col-6">
            	<h6 class="text-white text-capitalize ps-3"><i class="fa fa-ship me-sm-1"></i> Movimentações <?php echo (($nome_busca) ? 'Localizadas' : $apuracao); ?> (<?php echo @$total_reg ?>)</h6>
            </div>
			<!-- topo -->
			<div class="col-6 d-flex flex-row-reverse bd-highlight">
                <div class="form-group mb-0">
                 	<a href="" type="button" data-bs-toggle="modal" data-bs-target="#ModalRelFilt" class="btn btn-outline-light btn-sm mb-0 ms-2"><i class="fa fa-filter me-sm-1"></i> Filtrar</a>
                </div>
				<div class="form-group mb-0">
					<?php if (empty($nome_busca)) { ?>
					<a href="index.php?pagina=<?php echo $pagina ?>&funcao=novo" type="button" class="btn btn-outline-light btn-sm mb-0 ms-5">Novo Cadastro</a>
                    <?php }else{ ?>
					<a href="index.php?pagina=<?php echo $pagina ?>" type="button" class="btn btn-outline-light btn-sm mb-0 ms-5">Voltar</a>
                    <?php } ?>
				</div>
				<div id="busca">
	                <form action="index.php?pagina=<?php echo $pagina ?>&funcao=buscar" method="POST" id="form-busca" name="form-busca" class="d-flex flex-row align-items-center flex-wrap">
		                <div class="col-md-9">
		                 <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm text-uppercase" style="border: 1px solid #ccc; color: #fff; height:35px" id="nome_busca" name="nome_busca" value="<?php echo @$nome_busca ?>">
		                </div>
		               	<div class="col-md-3">
		                  <button id="check" name="check" type="submit" class="btn btn-outline-light btn-sm mb-0 mx-2">Buscar</button>
		                </div>
	                 </form>
                 </div>
			</div>
			<!--/. end topo -->
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">

            <?php
            if ($total_reg > 0) {

              ?>

              <table id="table" class="table table-hover align-items-center mb-0">

                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cliente
                    <?php if ($order == 'cliente_asc') {?>
                    <a href="index.php?pagina=<?php echo $pagina ?>&order=cliente_desc" data-bs-toggle="tooltip" title="Ordenar Decrescente"><i class="fa fa-caret-down me-sm-1"></i></a>
                    <?php }else if($order == 'cliente_desc') {?>
                    <a href="index.php?pagina=<?php echo $pagina ?>&order=cliente_asc" data-bs-toggle="tooltip" title="Ordenar Crescente"><i class="fa fa-caret-up me-sm-1"></i></a>
                    <?php }else{ ?>
                    <a href="index.php?pagina=<?php echo $pagina ?>&order=cliente_desc" data-bs-toggle="tooltip" title="Ordenar Decrescente"><i class="fa fa-caret-down me-sm-1"></i></a>
                    <?php } ?>
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Container
                    <?php if ($order == 'container_asc') {?>
                    <a href="index.php?pagina=<?php echo $pagina ?>&order=container_desc" data-bs-toggle="tooltip" title="Ordenar Decrescente"><i class="fa fa-caret-down me-sm-1"></i></a>
                    <?php }else if($order == 'container_desc') {?>
                    <a href="index.php?pagina=<?php echo $pagina ?>&order=container_asc" data-bs-toggle="tooltip" title="Ordenar Crescente"><i class="fa fa-caret-up me-sm-1"></i></a>
                    <?php }else{ ?>
                    <a href="index.php?pagina=<?php echo $pagina ?>&order=container_desc" data-bs-toggle="tooltip" title="Ordenar Decrescente"><i class="fa fa-caret-down me-sm-1"></i></a>
                    <?php } ?>
                    </th>
                    <th class="text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Data Início
                    <?php if ($order == 'datainicio_asc') {?>
                    <a href="index.php?pagina=<?php echo $pagina ?>&order=datainicio_desc" data-bs-toggle="tooltip" title="Ordenar Decrescente"><i class="fa fa-caret-down me-sm-1"></i></a>
                    <?php }else if($order == 'datainicio_desc') {?>
                    <a href="index.php?pagina=<?php echo $pagina ?>&order=datainicio_asc" data-bs-toggle="tooltip" title="Ordenar Crescente"><i class="fa fa-caret-up me-sm-1"></i></a>
                    <?php }else{ ?>
                    <a href="index.php?pagina=<?php echo $pagina ?>&order=datainicio_desc" data-bs-toggle="tooltip" title="Ordenar Decrescente"><i class="fa fa-caret-down me-sm-1"></i></a>
                    <?php } ?>
                    </th>
                    <th class="text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Data Final
                    <?php if ($order == 'datafinal_asc') {?>
                    <a href="index.php?pagina=<?php echo $pagina ?>&order=datafinal_desc" data-bs-toggle="tooltip" title="Ordenar Decrescente"><i class="fa fa-caret-down me-sm-1"></i></a>
                    <?php }else if($order == 'datafinal_desc') {?>
                    <a href="index.php?pagina=<?php echo $pagina ?>&order=datafinal_asc" data-bs-toggle="tooltip" title="Ordenar Crescente"><i class="fa fa-caret-up me-sm-1"></i></a>
                    <?php }else{ ?>
                    <a href="index.php?pagina=<?php echo $pagina ?>&order=datafinal_desc" data-bs-toggle="tooltip" title="Ordenar Decrescente"><i class="fa fa-caret-down me-sm-1"></i></a>
                    <?php } ?>
                    </th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipo
                    <?php if ($order == 'tipo_asc') {?>
                    <a href="index.php?pagina=<?php echo $pagina ?>&order=tipo_desc" data-bs-toggle="tooltip" title="Ordenar Decrescente"><i class="fa fa-caret-down me-sm-1"></i></a>
                    <?php }else if($order == 'tipo_desc') {?>
                    <a href="index.php?pagina=<?php echo $pagina ?>&order=tipo_asc" data-bs-toggle="tooltip" title="Ordenar Crescente"><i class="fa fa-caret-up me-sm-1"></i></a>
                    <?php }else{ ?>
                    <a href="index.php?pagina=<?php echo $pagina ?>&order=tipo_desc" data-bs-toggle="tooltip" title="Ordenar Decrescente"><i class="fa fa-caret-down me-sm-1"></i></a>
                    <?php } ?>
                    </th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>

                <tbody>

                  <?php

                  for($i=0; $i < $total_reg; $i++){
                    foreach ($res[$i] as $key => $value)
                      {     }

                    ?>

                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm text-capitalize"><?php echo $res[$i]['nome'] ?></h6>
                            <p class="text-xs text-secondary mb-0">DOC: <?php echo $res[$i]['doc'] ?></p>
                          </div>
                        </div>
                      </td>
                      <td class="align-middle text-uppercase">
                        <?php echo $res[$i]['numero'] ?>
                      </td>
                      <td class="align-middle ">
                        <?php echo $res[$i]['fmtdatainicio'] ?>
                      </td>
                      <td class="text-uppercase">
                        <?php echo $res[$i]['fmtdatafim'] ?>
                      </td>
                      <td class="align-middle text-center">
                        <?php echo $res[$i]['tipo'] ?>
                      </td>
                      <td class="align-middle">
                        <a href="index.php?pagina=<?php echo $pagina ?>&funcao=editar&id=<?php echo $res[$i]['id'] ?>" data-bs-toggle="tooltip" title="Editar Registro"><i class="fas fa-edit mx-3"></i></a>

                        <a href="index.php?pagina=<?php echo $pagina ?>&funcao=deletar&id=<?php echo $res[$i]['id'] ?>" data-bs-toggle="tooltip" title="Excluir Registro"><i class="fas fa-trash-alt"></i></a>

                      </td>
                    </tr>

                  <?php } ?>

                </tbody>
              </table>

            <?php } else {
              echo '<p class="mx-4" >Não existem dados cadastrados para serem exibidos!</p>';
            } ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

if (@$_GET['funcao'] == "editar") {
  $titulo_modal = 'Editar Registro';
  $query = $pdo->query("SELECT * FROM movimentacoes WHERE id = '$_GET[id]' AND status != 'Removido'");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $total_reg = @count($res);
  if ($total_reg > 0) {
    $container = $res[0]['container'];
    $tipo = $res[0]['tipo'];
    $dtI = list($datainicio, $horainicio) = explode(' ',$res[0]['datainicio']);
    $dtF = list($datafim, $horafim) = explode(' ',$res[0]['datafim']);
  }

} else {
  $titulo_modal = 'Inserir Registro';
}

?>

<div class="modal fade" tabindex="-1" id="modalCadastrar-container" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $titulo_modal ?></h5>
        <button type="button" class="btn btn-dark btn-sm fas fa-times" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" id="form-container">
        <div class="modal-body">

          <div class="row">

	          <div class="mb-3">
	            <label class="form-label">Container</label>
	            <select class="form-select px-2 border-radius-lg text-sm text-uppercase" style="border: 1px solid #ccc;" aria-label="example" name="container" required>
	              <option value="" disabled selected>-- Selecione --</option>
	                <?php

	                $query = $pdo->query("SELECT * FROM container WHERE status != 'Removido' ORDER BY numero ASC");
	                $res = $query->fetchAll(PDO::FETCH_ASSOC);
	                $total_reg = @count($res);
	                if ($total_reg > 0) {

	                  for ($i = 0; $i < $total_reg; $i++) {
	                    foreach ($res[$i] as $key => $value) {
	                    }

	                ?>
	                    <option <?php if (@$container == $res[$i]['id']) { ?> selected <?php } ?> value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['numero'] ?></option>

	                <?php }
	                } else {

	                  echo '<option value="">Cadastre um container!</option>';
	                } ?>
	            </select>
	          </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Tipo</label>
		            <select class="form-select px-2 border-radius-lg text-sm text-uppercase" style="border: 1px solid #ccc;" aria-label="default" name="tipo" required>
                      <option value="" disabled selected>-- Selecione --</option>
		              <option <?php if(@$tipo == 'Embarque'){ ?> selected <?php } ?> value="Embarque">Embarque</option>
		              <option <?php if(@$tipo == 'Descarga'){ ?> selected <?php } ?> value="Descarga">Descarga</option>
		              <option <?php if(@$tipo == 'Gate In'){ ?> selected <?php } ?> value="Gate In">Gate In</option>
		              <option <?php if(@$tipo == 'Gate Out'){ ?> selected <?php } ?> value="Gate Out">Gate Out</option>
		              <option <?php if(@$tipo == 'Reposicionamento'){ ?> selected <?php } ?> value="Reposicionamento">Reposicionamento</option>
		              <option <?php if(@$tipo == 'Pesagem'){ ?> selected <?php } ?> value="Pesagem">Pesagem</option>
		              <option <?php if(@$tipo == 'Scanner'){ ?> selected <?php } ?> value="Scanner">Scanner</option>
		            </select>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Data Inicial</label>
                <input value="<?php echo ( (!empty($datainicio)) ? $datainicio : date('Y-m-d') ) ?>" type="date" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" name="dataInicial" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Hora Inicial</label>
                <input value="<?php echo ( (!empty($horainicio)) ? $horainicio : date('H:i') ) ?>" type="time" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" name="horaInicial" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Data Final</label>
                <input value="<?php echo ( (!empty($datafim)) ? $datafim : date('Y-m-d') ) ?>" type="date" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" name="dataFinal" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Hora Final</label>
                <input value="<?php echo ( (!empty($horafim)) ? $horafim : date('H:i') ) ?>" type="time" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" name="horaFinal" required>
              </div>
            </div>
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" id="btn-fechar-container" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-salvar-container" id="btn-salvar-container" type="submit" class="btn btn-primary">Salvar</button>
          <input type="hidden" name="id-movimento" value="<?php echo @$_GET['id'] ?>">
        </div>
      </form>

    </div>
  </div>
</div>


<div class="modal fade" tabindex="-1" id="modalDeletar-container" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" id="form-excluir-container">
        <div class="modal-body">

          <p>Deseja realmente excluir o registro?</p>

        </div>
        <div class="modal-footer">
          <button type="button" id="btn-fechar-container" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-excluir-container" id="btn-excluir-container" type="submit" class="btn btn-danger">Excluir</button>

          <input type="hidden" name="id-container" value="<?php echo @$_GET['id'] ?>">

        </div>
      </form>

    </div>
  </div>
</div>

<!--  Modal Rel Filtro -->
<div class="modal fade" tabindex="-1" id="ModalRelFilt" data-bs-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Filtro de Data</h5>
				<button type="button" class="btn btn-dark btn-sm fas fa-times" data-bs-dismiss="modal"></button>
			</div>
			<form action="index.php?pagina=movimentacoes" method="POST">

				<div class="modal-body">

					<div class="row">
						<div class="col-md-4">
							<div class="form-group mb-3">
								<label>Data Inicial</label>
								<input value="<?php echo (empty($dtFiltroInicial) ? date('Y-m-d') : $dtFiltroInicial); ?>" type="date" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" name="dataInicial" >
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group mb-3">
								<label>Data Final</label>
								<input value="<?php echo (empty($dtFiltroFinal) ? date('Y-m-d') : $dtFiltroFinal); ?>" type="date" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" name="dataFinal" >
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group mb-3">
								<label>Tipo Movimentação</label>
								<select class="form-select px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" name="status">
									<option value="">Todas</option>
									<option value="Embarque">Embarque</option>
									<option value="Descarga">Descarga</option>
									<option value="Gate In">Gate In</option>
									<option value="Gate Out">Gate Out</option>
									<option value="Reposicionamento">Reposicionamento</option>
									<option value="Pesagem">Pesagem</option>
									<option value="Scanner">Scanner</option>
								</select>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" >Gerar Filtro</button>
				</div>
			</form>

		</div>
	</div>
</div>


<!-- ABRIR MODAL CADASTRAR E EDITAR -->
<?php
if ( (@$_GET['funcao'] == "novo") || (@$_GET['funcao'] == "editar") ) {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar-container'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>


<!-- ABRIR MODAL DELETAR -->
<?php
if (@$_GET['funcao'] == "deletar") {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalDeletar-container'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS -->
<script type="text/javascript">
  $("#form-container").submit(function () {
    var pag = "<?=$pagina?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/inserir.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        if (mensagem.trim() == "Salvo com Sucesso!") {

          alert('Salvo com Sucesso');

          $('#btn-fechar-container').click();
          window.location = "index.php?pagina="+pag;

        } else {

          $.notify( mensagem, "error" );

        }
      },

      cache: false,
      contentType: false,
      processData: false
    });
  });
</script>



<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
  $("#form-excluir-container").submit(function () {
    var pag = "<?=$pagina?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/excluir.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        if (mensagem.trim() == "Excluido com Sucesso!") {

       	  alert('Excluido com Sucesso');

          $('#btn-fechar-container').click();
          window.location = "index.php?pagina="+pag;

        } else {

          $.notify( mensagem, "error" );

        }
      },

      cache: false,
      contentType: false,
      processData: false
    });
  });
</script>