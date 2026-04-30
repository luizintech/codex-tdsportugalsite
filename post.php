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

    $sql = "SELECT * FROM posts_highlights WHERE link = '".$slug."';";
    $resultPost = $conn->query($sql);

    $title = '';
    $cover = '';
    $author = '';
    $date = '';

    if ($resultPost && $resultPost->num_rows > 0)
    {
        while ($post = $resultPost->fetch_assoc())
        {
            $title =  $post['title'];
            $cover =  $post['image_url'];
            $author =  $post['author'];
            $date =  $post['published_at'];
        }
    }

    $globalTitle = $title;

    require_once "layout/header.php";
    require_once "layout/header-body.php";
?>

    <!-- Page Content -->
    <!-- Banner Starts Here -->
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
            <?php
              $filePath = "content/{$slug}.txt";

              if (file_exists($filePath)) {
                  $content = file_get_contents($filePath);
              ?>
              <div class="all-blog-posts">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="blog-post">
                      <div class="blog-thumb">
                        <img src="<?= $cover; ?>" alt="<?= $title; ?>">
                      </div>
                      <div class="down-content">
                        <h1><?= $title; ?></h1>
                        <ul class="post-info">
                          <li><a href="#"><?= $author; ?></a></li>
                          <li><a href="#"><?= date("F d, Y", strtotime($date)); ?></a></li>
                        </ul>
                      </div>
                      <?= "<div class='post-content'>" . $content . "</div>";?>
                    </div>
                  </div>
                </div>
              </div>
              <?php
              } else {
                header("Location: ".$baseUrl."/404-nao-encontrado");
                die();
              }
          ?>
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