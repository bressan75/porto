<?php

@session_start();
require_once('../conexao.php');
require_once('verificar-permissao.php');

@$nome_busca = $_POST['nome_busca'];

if (!empty($nome_busca)) {
	$sql = "SELECT * FROM clientes WHERE ((nome LIKE '%$nome_busca%' OR doc LIKE '%$nome_busca%' OR email LIKE '%$nome_busca%') AND status != 'Removido') ORDER BY nome ASC";
}else{
	$sql = "SELECT * FROM clientes WHERE status != 'Removido' ORDER BY nome";
}

?>
<?php

//PUXAR DADOS DO BANCO
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
				<h6 class="text-white text-capitalize ps-3"><i class="fa fa-male me-sm-1"></i> Clientes <?php echo (($nome_busca) ? 'Localizados' : 'Cadastrados'); ?> (<?php echo @$total_reg ?>)</h6>
			</div>
			<!-- topo -->
			<div class="col-6 d-flex flex-row-reverse bd-highlight">
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cliente</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Contato</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Endereço</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
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
                            <p class="text-xs text-secondary mb-0">Doc.: <?php echo $res[$i]['doc'] ?></p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0"><?php echo $res[$i]['telefone'] ?></p>
                        <p class="text-xs text-secondary mb-0"><?php echo $res[$i]['email'] ?></p>
                      </td>
                      <td class="align-middle text-center text-xs">
                        <?php echo $res[$i]['endereco'] ?>
                      </td>
                      <td class="align-middle text-center text-sm">
                          <?php
                          	$gradiente = '';
                          	if ($res[$i]['status'] == 'Ativo') {
                          		$gradiente = 'bg-gradient-success';
                          	}else{
                          		$gradiente = 'bg-gradient-danger';
                          	}
                          ?>
                        <span class="badge badge-sm <?php echo $gradiente; ?>"><?php echo $res[$i]['status'] ?></span>
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
  $query = $pdo->query("SELECT * FROM clientes WHERE id = '$_GET[id]' AND status !='Removido'");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  $total_reg = @count($res);
  if ($total_reg > 0) {
    $nome = $res[0]['nome'];
    $doc = $res[0]['doc'];
    $rg_ie = $res[0]['rg_ie'];
    $telefone = $res[0]['telefone'];
    $email = $res[0]['email'];
    $endereco = $res[0]['endereco'];
    $observacao = $res[0]['observacao'];
    $status = $res[0]['status'];
  }

} else {
  $titulo_modal = 'Inserir Registro';
}

?>


<div class="modal fade" tabindex="-1" id="modalCadastrar-cliente" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $titulo_modal ?></h5>
        <button type="button" class="btn btn-dark btn-sm fas fa-times" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" id="form-cliente">
        <div class="modal-body">

          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <label class="form-label">Nome / Razão Social</label>
                <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm text-capitalize" style="border: 1px solid #ccc;" id="nome-cliente" name="nome-cliente" value="<?php echo @$nome ?>" required>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">CPF / CNPJ</label>
                <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="doc-cliente" name="doc-cliente" value="<?php echo @$doc ?>">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">RG / Ins.Estadual</label>
                <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm text-capitalize" style="border: 1px solid #ccc;" id="rg-cliente" name="rg-cliente" value="<?php echo @$rg_ie ?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Telefone</label>
                <input type="text" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="telefone" name="telefone-cliente" value="<?php echo @$telefone ?>">
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" class="form-control px-2 py-1 border-radius-lg text-sm" style="border: 1px solid #ccc;" id="email-cliente" name="email-cliente" value="<?php echo @$email ?>">
              </div>
            </div>
          </div>


          <div class="mb-3">
            <label class="form-label">Endereço</label>
            <textarea class="form-control px-2 py-1 border-radius-lg text-sm text-strtoupper" style="border: 1px solid #ccc;" id="endereco-cliente" name="endereco-cliente" style="overflow: hidden;"><?php echo @$endereco ?></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Observações</label>
            <textarea class="form-control px-2 py-1 border-radius-lg text-sm text-strtoupper" style="border: 1px solid #ccc;" id="observacao-cliente" name="observacao-cliente" style="overflow: hidden;"><?php echo @$observacao ?></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select px-2 border-radius-lg text-sm" style="border: 1px solid #ccc;" aria-label="Default select example" name="status">

              <option <?php if(@$status == 'Ativo'){ ?> Ativo <?php } ?>  value="Ativo">Ativo</option>

              <option <?php if(@$status == 'Inativo'){ ?> selected <?php } ?>  value="Inativo">Inativo</option>

            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" id="btn-fechar-cliente" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-salvar-cliente" id="btn-salvar-cliente" type="submit" class="btn btn-primary">Salvar</button>
          <input type="hidden" name="id-cliente" value="<?php echo @$_GET['id'] ?>">
          <input type="hidden" name="antigo-cliente" value="<?php echo @$doc ?>">
        </div>
      </form>

    </div>
  </div>
</div>



<div class="modal fade" tabindex="-1" id="modalDeletar-cliente" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" id="form-excluir-cliente">
        <div class="modal-body">

          <p>Deseja realmente excluir o registro?</p>

        </div>
        <div class="modal-footer">
          <button type="button" id="btn-fechar-cliente" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-excluir-cliente" id="btn-excluir-cliente" type="submit" class="btn btn-danger">Excluir</button>
          <input type="hidden" name="id-cliente" value="<?php echo @$_GET['id'] ?>">
        </div>
      </form>

    </div>
  </div>
</div>




<!-- ABRIR MODAL CADASTRAR E EDITAR -->
<?php
if ( (@$_GET['funcao'] == "novo") || (@$_GET['funcao'] == "editar") ) {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar-cliente'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>


<!-- ABRIR MODAL DELETAR -->
<?php
if (@$_GET['funcao'] == "deletar") {  ?>
  <script type="text/javascript">
    var myModal = new bootstrap.Modal(document.getElementById('modalDeletar-cliente'), {
      backdrop: 'static'
    });
    myModal.show();
  </script>
<?php } ?>



<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
  $("#form-cliente").submit(function () {
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

          $('#btn-fechar-cliente').click();
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
  $("#form-excluir-cliente").submit(function () {
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

          $('#btn-fechar-cliente').click();
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