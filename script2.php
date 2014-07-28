<?php
  // Inicializa e trata os parâmetros de entrada
  $destinatario_email = trim(strip_tags(addslashes($_REQUEST['email'])));
  $destinatario_nome  = trim(strip_tags(addslashes($_REQUEST['destinatario'])));
  $assunto            = trim(strip_tags(addslashes($_REQUEST['assunto'])));       
 
  // Faz a conexão com o banco de dados (AJUSTE SUA CONEXÃO)
  $link = mysql_connect('186.202.152.127', 'pcvideo', 'jun23siau') or die('Falhou ao conectar ao banco de dados.'); 
  mysql_select_db('pcvideo7') or die('Falhou ao selecionar o banco de dados');
 
  // Monta a SQL e insere no banco de dados, caso email ainda não exista, ou atualiza contador se existir
  $sql = 'SELECT eml_email FROM eml_maladireta WHERE eml_email="'.$destinatario_email.'"';
  $res = mysql_query($sql);
  if (mysql_num_rows($res) > 0) {
    $sql = 'UPDATE eml_maladireta SET eml_datahora_visualizado="'.date('Y-m-d H:i:s').'", eml_contador=contador+1 WHERE eml_email="'.$destinatario_email.'"';    
  }
  else {
    $sql = 'INSERT INTO eml_maladireta VALUES (null, "'.$destinatario_email.'", "'.$destinatario_nome.'", "'.$assunto.'", "'.date('Y-m-d H:i:s').'", null, 0)';
  }
  mysql_query($sql);
 
  // Cria e exibe a imagem embutida ao email
  header("Content-type: image/png");
  $img = imagecreatefrompng("imagem.png");
  imagepng($img);
  imagedestroy($img);
