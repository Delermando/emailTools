<?php
class emailTools{
    public function rastreamentoEmail(){
        $protocolo = strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL']));
        $location = $protocolo.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $hash = md5(rand());
        return "<img src='".$location."/hash=".$hash."' />"; 
    }
    public function rastreamentoLinks($url, $nomeLink){
        $protocolo = strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL']));
        $location = $protocolo.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $hash = md5(rand());

         return "<a href='".$location."/redirect=".$url."&hash=".$hash."' />".$nomeLink."</a>"; 
    }
    
    public function gerarImagem($imagemRastreamento){
        header("Content-type: image/png");
        $img = imagecreatefrompng($imagemRastreamento);
        return imagepng($img);
    } 
}