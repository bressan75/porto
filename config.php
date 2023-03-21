<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Variáveis para conexão com banco de dados
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'bd_teste';

// Definições
define('SISTEMA', 'PORTO');
define('ROOT_URL', 'http://localhost/porto/');
define('NOME_EMPRESA', 'Porto S/A');
define('CNPJ_EMPRESA', '00.001.002/00001-99');
define('SITE_EMPRESA', 'www.sistemaporto.com.br');
define('ENDERECO_EMPRESA', 'Rua Xyz, 1234 - Bairro A - indaiatuba, SP');
define('TELEFONE_EMPRESA', '(11) 98786-7766');
define('NOME_DEV', 'Marcelo Bressan');
define('EMAIL_EMPRESA', 'marcelo@bressan.com.br');

$relatorio_pdf = 'SIM';
$cabecalho_img_rel = 'SIM';
$rodape_relatorios = 'Sistema Portuário - Dev by'. NOME_DEV;
?>