<?php
    $nome = "";
    $email = "";
    $mensagem = "";

    $naturalAntiSpamNumber = rand(1, 100);
    $antiSpam = base64_encode($naturalAntiSpamNumber);

    $globalTitle = "Contato - Entre em contato conosco!";
    require 'layout/config.php';
    require_once "layout/header.php";
    require_once "layout/header-body.php";
?>

<div class="heading-page header-text">
    <section class="page-heading">
        <div class="container">
            <div class="row">
            <div class="col-lg-12">
                <div class="text-content">
                <h4><?= $globalTitle; ?></h4>
                </div>
            </div>
            </div>
        </div>
    </section>
</div>

<section class="blog-posts">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h2>Entre em Contato</h2>
        <p>Envie sua mensagem e responderemos o mais breve possível.</p>

        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
              $word = trim($_POST["word"]);
              $nome = trim($_POST["nome"]);
              $email = trim($_POST["email"]);
              $mensagem = trim($_POST["mensagem"]);
              $resposta = trim($_POST["antispam"]);

              $antiSpamDecoded = base64_decode($word);

              if ($resposta != $antiSpamDecoded) {
                  echo "<div class='alert alert-danger'>Resposta incorreta para a pergunta anti-spam.</div>";
              } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  echo "<div class='alert alert-danger'>E-mail inválido.</div>";
              } else {
                  $dados = "Nome: $nome\nEmail: $email\nMensagem: $mensagem\n--------------\n";
                  
                  //salva o contato feito em um ficheiro como backup.
                  $fileName = "contatos_" . date("Y-m-d") . ".txt"; 
                  file_put_contents("contacts/".$fileName, $dados, FILE_APPEND);

                  $to = "contato@reverb.tec.br";
                  $subject = "Contato via Site - Tudo Sobre Portugal";
                  $headers = "From: $email\r\nReply-To: $email";
                  mail($to, $subject, $dados, $headers);

                  echo "<div class='alert alert-success'>Mensagem enviada com sucesso!</div>";

                  $nome = "";
                  $email = "";
                  $mensagem = "";
              }
          }
        ?>

        <form method="post" action="contato">
          <input type="hidden" id="word" name="word" value="<?=$antiSpam;?>" />
          <div class="form-group">
            <label>Nome:</label>
            <input type="text" name="nome" class="form-control" required value="<?=$nome;?>" />
          </div>
          <div class="form-group">
            <label>E-mail:</label>
            <input type="email" name="email" class="form-control" required value="<?=$email;?>" />
          </div>
          <div class="form-group">
            <label>Mensagem:</label>
            <textarea name="mensagem" class="form-control" rows="5" required><?=$mensagem;?></textarea>
          </div>
          <div class="form-group">
            <label>Digite o número <?=$naturalAntiSpamNumber;?> abaixo: (anti-spam)</label>
            <input type="text" name="antispam" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
      </div>

    </div>
  </div>
</section>

<?php 
    require_once "layout/footer-body.php";
    require_once "layout/footer.php";
?>
