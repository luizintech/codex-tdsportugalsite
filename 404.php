<?php
    require 'layout/config.php';
    $globalTitle = "404- Conteúdo não encontrado.";

    require_once "layout/header.php";
    require_once "layout/header-body.php";
?>

    <div class="heading-page header-text">
      <section class="page-heading">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="text-content">
                <h4><?= $title; ?></h4>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <section class="blog-posts grid-system">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            Conteúdo não encontrado.
          </div>
          <div class="col-lg-4">
            <?php require_once "layout/post-sidebar.php" ?>
          </div>
        </div>
      </div>
    </section>

<?php 
    require_once "layout/footer-body.php";
    require_once "layout/footer.php";
?> 