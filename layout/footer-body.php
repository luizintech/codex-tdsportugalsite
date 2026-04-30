<?php
  $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
  $baseUrl = $protocol."://".$_SERVER['HTTP_HOST'];
?>
<footer>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <ul class="social-icons">
          <li><a href="https://www.facebook.com/tudosobreportugal.com.br"  target="_blank">Facebook</a></li>
          <li><a href="https://www.instagram.com/tudosobreportugal.site/" target="_blank">Instagram</a></li>
          <li><a href="https://www.youtube.com/@tudosobreportugal_site" target="_blank">Youtube</a></li>
          <li><a href="<?= $baseUrl; ?>/quem-somos">Quem Somos</a></li>
          <li><a href="<?= $baseUrl; ?>/contato">Contato</a></li>
        </ul>
      </div>
      <div class="col-lg-12">
        <div class="copyright-text">
          <p>
              Tudo sobre Portugal &copy; 2023 - Todos os direitos reservados. Desenvolvido e criado por <a href="https://reverb.tec.br" target="_blank">Reverb Tech</a>.
        </div>
      </div>
    </div>
  </div>
</footer>