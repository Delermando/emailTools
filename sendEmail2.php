<?php
  // *** Seu e-mail (e-mail de quem envia)
  $remetente_nome     = 'Anônimo';
  $remetente_email    = 'delermando.miranda@pcvideo.com.br';
 
  // *** Seu alvo (e-mail para quem envia) 
  $destinatario_nome  = 'Mario Bross';
  $destinatario_email = 'delsantos@hotmail.com.br';
 
  // *** Assunto e corpo da mensagem
  $assunto      = 'Testando a execução de script ao carregar imagem.';
  $mensagem     = '
    <html lang="pt-br">
      <head>
        <meta charset="iso-8859-1" />    
        <title>'.$assunto.'</title>
      </head>
      <body>
        <img src="http://pcvideo.com.br/emailTools/script.php?email='.urlencode($destinatario_email).'&destinatario='.urlencode($destinatario_nome).'&assunto='.urlencode($assunto).'" />
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