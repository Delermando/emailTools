<?php
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');
//ini_set("session.cookie_httponly",1);
//ini_set('session.cookie_secure',1);
ini_set("auto_detect_line_endings", "1");
ini_set('display_errors', 'on');
error_reporting(E_ALL);

require_once("classes/BD.class.php");
$conectar = new BD('186.202.152.127', 'pcvideo7', 'jun23saiu', 'pcvideo7');

require_once("classes/querysBD.class.php");
$query = new querysBD();

include 'classes/emailTools.class.php';
$emailTools = new emailTools();

include 'classes/informacoesUsuario.class.php';
$informacoes = new obterInformacoes();

require_once("includes/globals.php");


//switch ($action) {
//    case "":
//        $title = $arrayTitle['home'];
//        $caminho = 'actions/actHome.php';
//        break;
//    default :
//        $title = $arrayTitle['error'];
//        $caminho = 'actions/actErroMensage.php';
//}

