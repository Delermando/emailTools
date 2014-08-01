<?php
    $arrayTitle = array(
        'home' => 'Home',
        'error' => 'Ocorreu um erro'
    );

    if(isset($title)){
        $title = "";  
    }
    
    if(!isset($action)){
        $action = "";
    }
    
    if (!isset($sessao)) {
        $sessao = "";
    }  
        
    $enderecoSubmit = $_SERVER['PHP_SELF'];
    
   