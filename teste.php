<?php
//ini_set("allow_url_fopen", 1);
include 'classes/emailTools.class.php';
include 'classes/informacoesUsuario.class.php';
$email = new emailTools();
$informacoes = new obterInformacoes();
//echo $email->restreamentoEmail();
//echo $email->rastreamentoLinks("deler", "teste");
//$email->gerarImagem("imagem.png");


var_dump($informacoes->userInformation()); 
echo "<br />";
var_dump($informacoes->userClienteInformation($_SERVER['HTTP_USER_AGENT'])); 
echo "<br />";
echo "<br />";
echo "<br />";
$array = $informacoes->geolocalizacaoInformation(""."152.245.56.15");
var_dump($array);
