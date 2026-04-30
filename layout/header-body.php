<?php
  $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
  $baseUrl = $protocol . "://".$_SERVER['HTTP_HOST'];
  $conn = new mysqli($host, $user, $password, $dbname);
  $conn->set_charset("utf8");
  if ($conn->connect_error) {
      die("Falha na conexão: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM categories";
  $result = $conn->query($sql);
?>
<body>
<!-- ***** Preloader Start ***** -->
<div id="preloader">
    <div class="jumper">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>  
<!-- ***** Preloader End ***** -->

<!-- Header -->
<header class="">
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="/">
         <img src="https://tudosobreportugal.com.br/content/images/tudo-sobre-portugal-logo-240x54-1.jpg" alt="Tudo sobre Portugal">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/">Home
              <span class="sr-only">(current)</span>
            </a>
          </li> 

          <?php if ($result && $result->num_rows > 0): ?>
              <?php while ($category = $result->fetch_assoc()): ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?= $baseUrl; ?>/<?= $category_base; ?>/<?= $category['slug']; ?>"><?= $category['name']; ?></a>
                </li>
              <?php endwhile; ?>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>