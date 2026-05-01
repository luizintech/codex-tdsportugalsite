<?php
    require 'layout/config.php';
    
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $baseUrl = $protocol."://".$_SERVER['HTTP_HOST'];

    $slug = '';
    if (!isset($_GET['slug']))
    { 
        die();
    }
    $slug = $_GET['slug'];

    $conn = new mysqli($host, $user, $password, $dbname);
    $conn->set_charset("utf8");
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }
    
    $sql = "SELECT * FROM categories WHERE slug = '".$slug."';";
    $resultCategory = $conn->query($sql);

    $categoryName = '';
    $categoryDescription = '';
    $categorySlug = '';
    
    if ($resultCategory && $resultCategory->num_rows > 0)
    {
        while ($category = $resultCategory->fetch_assoc())
        {
            $categoryName =  $category['title'];
            $categoryDescription =  $category['short_description'];
            $categorySlug =  $category['slug'];
        }
    }
    else
    {
        header("Location: ".$baseUrl."/404-nao-encontrado");
        die();
    }

    $globalTitle = $categoryName." | Tudo Sobre Portugal";
    require_once "layout/header.php";
    require_once "layout/header-body.php";
?>

<div class="heading-page header-text">
    <section class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-content">
                        <h4><?= $categoryName; ?></h4>
                        <p>
                            <?= $categoryDescription; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<section class="blog-posts">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <?php require_once "layout/categories-posts.php"; ?>
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