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

    $sql = "SELECT p.title, p.content, p.author, p.publish_date, p.slug, m.path AS media_path, m.filename AS media_filename
            FROM posts p
            LEFT JOIN medias m ON m.id = p.cover_media_id
            WHERE p.slug = '".$slug."' AND p.is_published = 1
            LIMIT 1";
    $resultPost = $conn->query($sql);

    $title = '';
    $content = '';
    $cover = $baseUrl . '/assets/images/blog-post-01.jpg';
    $author = '';
    $date = '';

    if ($resultPost && $resultPost->num_rows > 0)
    {
        while ($post = $resultPost->fetch_assoc())
        {
            $title =  $post['title'];
            $cover = !empty($post['media_path']) && !empty($post['media_filename'])
                ? $baseUrl . '/' . trim($post['media_path'], '/') . '/' . rawurlencode($post['media_filename'])
                : $cover;
            $content = $post['content'] ?? '';
            $author =  $post['author'];
            $date =  $post['publish_date'];
        }
    }

    $globalTitle = $title;

    require_once "layout/header.php";
    require_once "layout/header-body.php";
?>

    <div class="heading-page header-text">
      <section class="page-heading">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="text-content">
                <h4><?= htmlspecialchars($title); ?></h4>
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
              if (!empty($title) && !empty($content)) {
              ?>
              <div class="all-blog-posts">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="blog-post">
                      <div class="blog-thumb">
                        <img src="<?= htmlspecialchars($cover); ?>" alt="<?= htmlspecialchars($title); ?>">
                      </div>
                      <div class="down-content">
                        <h1><?= htmlspecialchars($title); ?></h1>
                        <ul class="post-info">
                          <li><a href="#"><?= htmlspecialchars($author); ?></a></li>
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
