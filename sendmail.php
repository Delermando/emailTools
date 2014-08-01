<?php
  // *** Seu e-mail (e-mail de quem envia)
  $remetente_nome     = 'Delermando';
  $remetente_email    = 'delermando.miranda@pcvideo.com.br';
 
  // *** Seu alvo (e-mail para quem envia) 
  $destinatario_nome  = 'Rafael';
  $destinatario_email = 'rafael.lima@pcvideo.com.br';
 
  // *** Outros dados a persistir e HASH (identificador)
  $hash               = md5(rand());
  $assunto            = 'Links layouts produtoras';
  $datahora_envio     = date('Y-m-d H:i:s');
 
  // Faz a conexão com o banco de dados
  $link = mysql_connect('186.202.152.127', 'pcvideo7', 'jun23saiu') or die('Falhou ao conectar ao banco de dados.'); 
  mysql_select_db('pcvideo7') or die('Falhou ao selecionar o banco de dados');  
 
  // Monta a SQL e insere no banco de dados

  $sql = 'INSERT INTO eml_emailsEnviados (env_hash, env_assunto,env_remetente, env_destinatario)VALUES ("'.$hash.'", "'.$assunto.'","'.$remetente_email.'", "'.$destinatario_email.'")';
  mysql_query($sql);
 
  // *** Mensagem a ser enviada
  $mensagem     = '
    <html lang="pt-br">
      <head> 
        <meta charset="iso-8859-1" />    
        <title>'.$assunto.'</title>
      </head>
      <body>
        <div><a href="http://www.vertscomunicacao.com.br/paginas/sobre.html" shape="rect" target="_blank">http://www.vertscomunicacao.com.br/paginas/sobre.html</a>&nbsp;</div>
<div><a href="http://bestprodutora.com/website/">http://bestprodutora.com/website/</a></div>
<div>http://www.longplay360.com.br/</div>
<div>http://www.aocubofilmes.com.br/</div>
<div><a href="http://www.mixer.com.br/">http://www.mixer.com.br/</a></div>
<div><a href="http://www.socci.com.br/home" shape="rect" target="_blank">http://www.socci.com.br/home</a><span>&nbsp;</span></div>
<div><a href="http://kshfilmes.com.br/portfolio/video-de-treinamento-pes-2014-konami/" shape="rect" target="_blank">http://kshfilmes.com.br/portfolio/video-de-treinamento-pes-2014-konami/</a><span>&nbsp;</span></div>
<div><span>http://www.w5.com.br/</span></div>
<div><a href="http://www.agenciaopp.com.br/#!mini" shape="rect" target="_blank">http://www.agenciaopp.com.br/#!mini</a><span>&nbsp;</span></div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>
<div><a href="http://www.templatemonster.com/wordpress-themes/50500.html" shape="rect" target="_blank">http://www.templatemonster.com/wordpress-themes/50500.html</a>&nbsp;</div>
<div><a href="http://www.templatemonster.com/wordpress-themes/49626.html" shape="rect" target="_blank">http://www.templatemonster.com/wordpress-themes/49626.html</a>&nbsp;</div>
<p>&nbsp;</p>
</div>
        <img src="http://pcvideo.com.br/emailTools/teste.php?hash='.$hash.'" />
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