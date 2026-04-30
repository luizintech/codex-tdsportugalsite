<?php
    $globalTitle = "Viver, estudar, imigrar e morar em terras lusitanas!";
    require 'layout/config.php';
    require_once "layout/header.php";
    require_once "layout/header-body.php";
    require_once "layout/sliders.php";
?>
<section class="blog-posts">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <?php require_once "layout/posts-highlights.php"; ?>
      </div>
      <div class="col-lg-4">
        <?php require_once "layout/post-sidebar.php"; ?>
      </div>
    </div>
  </div>
</section>

<?php 
    require_once "layout/footer-body.php";
    require_once "layout/footer.php";
?> 