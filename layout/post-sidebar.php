<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$baseUrl = $protocol."://".$_SERVER['HTTP_HOST'];

$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$sql = "SELECT slug, title, publish_date FROM posts WHERE is_published = 1 ORDER BY publish_date DESC LIMIT 3";
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
                                <li><a href="<?= $baseUrl . '/' . htmlspecialchars($post['slug']); ?>">
                                    <h5><?= htmlspecialchars($post['title']); ?></h5>
                                    <span><?= date("F d, Y", strtotime($post['publish_date'])); ?></span>
                                </a></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>
<?php
$sql = "SELECT slug, title FROM categories ORDER BY title";
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
                        <li><a href="<?= $baseUrl . "/" . $category_base . "/" . htmlspecialchars($category['slug']); ?>"><?= htmlspecialchars($category['title']); ?></a></li>
                    <?php endwhile; ?>
                </ul>
            </div>
            </div>
        </div>
    <?php endif; ?>

<?php
$sql = "SELECT slug, title FROM labels ORDER BY title";
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
                        <li><a href="<?= $baseUrl . "/" . $label_base . "/" . htmlspecialchars($label['slug']); ?>"><?= htmlspecialchars($label['title']); ?></a></li>
                    <?php endwhile; ?>
                </ul>
            </div>
            </div>
        </div>
    <?php endif; ?>

    </div>
</div>
