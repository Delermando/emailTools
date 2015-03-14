<?php


  // Captura o HASH do e-mail visualizado
  $hash = trim(strip_tags(addslashes($_REQUEST['hash'])));
 
  // Faz a conexão com o banco de dados
  $link = mysql_connect('186.202.152.127', 'pcvideo7', 'jun23saiu') or die('Falhou ao conectar ao banco de dados.'); 
  mysql_select_db('pcvideo7') or die('Falhou ao selecionar o banco de dados');  
 
  // Monta a SQL e atualiza data de visualização do email e contador no banco de dados
  $sql = 'SELECT eml_hash FROM eml_maladireta WHERE eml_hash="'.$hash.'"';
  $res = mysql_query($sql);
  if (mysql_num_rows($res) > 0) {
    $sql = 'UPDATE eml_maladireta SET eml_datahora_visualizado="'.date('Y-m-d H:i:s').'", eml_contador=eml_contador+1 WHERE eml_hash="'.$hash.'"';  
    mysql_query($sql);
  }
 
  // Cria e exibe a imagem embutida ao email
  header("Content-type: image/png");
  $img = imagecreatefrompng("imagem.png");
  imagepng($img);
  //imagedestroy($img);
?>