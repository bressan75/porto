<?php

@session_start();
require_once('../config.php');

$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];
$tipo = $_POST['tipo'];
$cliente = $_POST['cliente'];
$usuario = $_SESSION['id_usuario'];

//ALIMENTAR OS DADOS NO RELATÓRIO
$html = file_get_contents(ROOT_URL."rel/relMov.php?dataInicial=$dataInicial&dataFinal=$dataFinal&tipo=$tipo&cliente=$cliente&usuario=$usuario");

if($relatorio_pdf != 'SIM'){
	echo $html;
	exit();
}

//CARREGAR DOMPDF
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

//INICIALIZAR A CLASSE DO DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);

$pdf = new DOMPDF($options);

//Definir o tamanho do papel e orientação da página
$pdf->set_paper('A4', 'portrait'); //caso queira a folha em paisagem use landscape em vez de portrait

//CARREGAR O CONTEÚDO HTML
$pdf->load_html($html);

//RENDERIZAR O PDF
$pdf->render();

//NOMEAR O PDF GERADO
$pdf->stream(
	'Movimentacões_'.$tipo.'_'.$dataInicial.'_à_'.$dataFinal.'.pdf',
	array("Attachment" => false)
);