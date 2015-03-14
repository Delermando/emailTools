<?php
//ini_set("allow_url_fopen", 1);
include 'includes/header.php';
//echo $email->restreamentoEmail();
//echo $email->rastreamentoLinks("deler", "teste");
//$email->gerarImagem("imagem.png");


$hash = trim(strip_tags(addslashes($_REQUEST['hash'])));
$camposRetorno = array("env_id");
$hashFromBD = $query->select("eml_emailsEnviados", $camposRetorno, "env_hash", "=", $hash);
$email = array(
    'id' => $hashFromBD[0]['env_id']
);
$userClienteInformation = $informacoes->userClienteInformation($_SERVER['HTTP_USER_AGENT']); 
$userInformation  = $informacoes->userInformation();
$geolocalizacaoInformation = $informacoes->geolocalizacaoInformation($_SERVER['REMOTE_ADDR']);
$arrayInformacoesUsuario = array_merge($email, $userClienteInformation, $userInformation, $geolocalizacaoInformation);

$keys = array_keys($arrayInformacoesUsuario);
for($a=0;sizeof($arrayInformacoesUsuario) >$a; $a++){   
    if($arrayInformacoesUsuario[$keys[$a]] == null){
        $dados["informacoes$a"][] = 0;
    }else{
        $dados["informacoes$a"][] = $arrayInformacoesUsuario[$keys[$a]];
    }
}

$campos = array("est_idFromSendingEmails","est_isMobile","est_plataform","est_browser","est_version","est_ip","est_host",
                "eml_refer","eml_port","est_userAgent","est_city","est_region","est_countryName",
                "est_continenteCode","est_latitude","est_longitude","est_regionName");

$query->insert('eml_estatiscasEmails', $campos, $dados);

//echo $email->restreamentoEmail();
//echo $email->rastreamentoLinks("deler", "teste");
//$email->gerarImagem("imagem.png");
//    
$emailTools->rastreamentoEmail();
//$email->rastreamentoLinks("deler", "teste");
$emailTools->gerarImagem("imagem.png");
