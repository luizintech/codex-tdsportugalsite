<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$baseUrl = $protocol."://".$_SERVER['HTTP_HOST'];

$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$posts_por_pagina = 8;
$pagina_atual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset = ($pagina_atual - 1) * $posts_por_pagina;

$sql = "SELECT p.id, p.title, p.author, p.slug, p.publish_date,
               m.path AS media_path, m.filename AS media_filename,
               c.slug AS category_slug, c.title AS category_title
        FROM posts p
        INNER JOIN post_categories pc ON pc.post_id = p.id
        INNER JOIN categories c ON c.id = pc.category_id
        LEFT JOIN medias m ON m.id = p.cover_media_id
        WHERE p.is_published = 1 AND c.slug = '".$slug."'
        ORDER BY p.publish_date DESC
        LIMIT $offset, $posts_por_pagina";
$result = $conn->query($sql);

$sql_total = "SELECT COUNT(p.id) AS total
              FROM posts p
              INNER JOIN post_categories pc ON pc.post_id = p.id
              INNER JOIN categories c ON c.id = pc.category_id
              WHERE p.is_published = 1 AND c.slug = '".$slug."'";
$total_result = $conn->query($sql_total);
$total_posts = $total_result ? (int)$total_result->fetch_assoc()['total'] : 0;
$total_paginas = (int)ceil($total_posts / $posts_por_pagina);
?>
<div class="all-blog-posts">
    <div class="row">
        <?php if ($result): while ($postCategory = $result->fetch_assoc()): ?>
            <?php $imageUrl = !empty($postCategory['media_path']) && !empty($postCategory['media_filename'])
                ? $baseUrl . '/' . trim($postCategory['media_path'], '/') . '/' . rawurlencode($postCategory['media_filename'])
                : $baseUrl . '/assets/images/blog-post-01.jpg'; ?>
            <div class="col-lg-12">
                <div class="blog-post">
                    <div class="blog-thumb">
                        <img src="<?= htmlspecialchars($imageUrl); ?>" alt="<?= htmlspecialchars($postCategory['title']); ?>">
                    </div>
                    <div class="down-content">
                        <a href="<?= $baseUrl . '/' . $category_base . '/' . htmlspecialchars($postCategory['category_slug']); ?>"><span><?= htmlspecialchars($postCategory['category_title']); ?></span></a>
                        <a href="<?= $baseUrl . '/' . htmlspecialchars($postCategory['slug']); ?>">
                            <h4><?= htmlspecialchars($postCategory['title']); ?></h4>
                        </a>
                        <ul class="post-info">
                            <li><a href="#"> <?= htmlspecialchars($postCategory['author']); ?> </a></li>
                            <li><a href="#"> <?= date("F d, Y", strtotime($postCategory['publish_date'])); ?> </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endwhile; endif; ?>

        <div class="col-lg-12">
            <div class="main-button">
                <?php if ($pagina_atual > 1): ?>
                    <a href="<?= $baseUrl . '/' . $category_base . '/' . urlencode($slug); ?>?pagina=<?= $pagina_atual - 1; ?>">Anterior</a>
                <?php endif; ?>
                <?php if ($pagina_atual < $total_paginas): ?>
                    <a href="<?= $baseUrl . '/' . $category_base . '/' . urlencode($slug); ?>?pagina=<?= $pagina_atual + 1; ?>">Próximo</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $conn->close(); ?>
