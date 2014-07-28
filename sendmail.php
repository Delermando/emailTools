<?php
  // *** Seu e-mail (e-mail de quem envia)
  $remetente_nome     = 'Deler';
  $remetente_email    = 'delermando.miranda@pcvideo.com.br';
 
  // *** Seu alvo (e-mail para quem envia) 
  $destinatario_nome  = 'Delermando';
  $destinatario_email = 'delsantos@hotmail.com.br';
 
  // *** Outros dados a persistir e HASH (identificador)
  $hash               = md5(rand());
  $assunto            = 'Testando a execução de script ao carregar imagem.';
  $datahora_envio     = date('Y-m-d H:i:s');
 
  // Faz a conexão com o banco de dados
  $link = mysql_connect('186.202.152.127', 'pcvideo7', 'jun23saiu') or die('Falhou ao conectar ao banco de dados.'); 
  mysql_select_db('pcvideo7') or die('Falhou ao selecionar o banco de dados');  
 
  // Monta a SQL e insere no banco de dados
  $sql = 'INSERT INTO eml_maladireta VALUES (null, "'.$hash.'", "'.$destinatario_email.'", "'.$destinatario_nome.'", "'.$assunto.'", "'.$datahora_envio.'", null, 0)';
  mysql_query($sql);
 
  // *** Mensagem a ser enviada
  $mensagem     = '
    <html lang="pt-br">
      <head>
        <meta charset="iso-8859-1" />    
        <title>'.$assunto.'</title>
      </head>
      <body>
      delermandode
        <img src="pcvideo.com.br/emailTools/script.php?hash='.$hash.'" />
      </body>
    </html>';
 
  // Cabeçalho informando que o conteúdo é do tipo HTML (para poder ler a tag IMG e executar o script)
  $header       = "MIME-Version: 1.0\n"; 
  $header      .= "Content-type: text/html; charset=iso-8859-1\n"; 
  $header      .= "From: ".(empty($remetente_nome) ? $remetente_email : '"'.$remetente_nome.'" <'.$remetente_email.'>')."\n";
 
  // Envia o e-mail
  
  $email = empty($destinatario_nome) ? $destinatario_email : '"'.$destinatario_nome.'" <'.$destinatario_email.'>';
  mail($email, $assunto, $mensagem, $header);
?>