<?php
  $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
  $baseUrl = $protocol."://".$_SERVER['HTTP_HOST'];

  $conn = new mysqli($host, $user, $password, $dbname);
  $conn->set_charset("utf8");
  if ($conn->connect_error) {
      die("Falha na conexão: " . $conn->connect_error);
  }

    $sql = "SELECT * FROM posts_highlights ORDER BY published_at DESC LIMIT 3";
    $result = $conn->query($sql);
?>
<div class="sidebar">
    <div class="row">

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="col-lg-12">
                <div class="sidebar-item recent-posts">
                    <div class="sidebar-heading">
                        <h2>Últimos artigos</h2>
                    </div>
                    <div class="content">
                        <ul>
                            <?php while ($post = $result->fetch_assoc()): ?>
                                <li><a href="<?= $baseUrl . "/" . htmlspecialchars($post['link']); ?>">
                                    <h5><?= $post['title']; ?></h5>
                                    <span><?= $post['published_at']; ?></span>
                                </a></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
<?php
    $sql = "SELECT * FROM categories ORDER BY name";
    $resultCategories = $conn->query($sql);
?>
    <?php if ($resultCategories && $resultCategories->num_rows > 0): ?>
        <div class="col-lg-12">
            <div class="sidebar-item categories">
            <div class="sidebar-heading">
                <h2>Categorias</h2>
            </div>
            <div class="content">
                <ul>
                    <?php while ($category = $resultCategories->fetch_assoc()): ?>
                        <li><a href="<?= $baseUrl . "/" . $category_base . "/" . htmlspecialchars($category['slug']); ?>"><?= $category['name']; ?></a></li>
                    <?php endwhile; ?>
                </ul>
            </div>
            </div>
        </div>
    <?php endif; ?>

<?php
    $sql = "SELECT * FROM labels ORDER BY name";
    $resultLabels = $conn->query($sql);
?>
    <?php if ($resultLabels && $resultLabels->num_rows > 0): ?>
        <div class="col-lg-12">
            <div class="sidebar-item tags">
            <div class="sidebar-heading">
                <h2>Tópicos</h2>
            </div>
            <div class="content">
                <ul>
                    <?php while ($label = $resultLabels->fetch_assoc()): ?>
                        <li><a href="<?= $baseUrl . "/" . $label_base . "/" . htmlspecialchars($label['slug']); ?>"><?= $label['name']; ?></a></li>
                    <?php endwhile; ?>
                </ul>
            </div>
            </div>
        </div>
    <?php endif; ?>
    
    </div>
</div>