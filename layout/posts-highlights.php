<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$baseUrl = $protocol."://".$_SERVER['HTTP_HOST'];

$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$posts_por_pagina = 10;
$pagina_atual = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$offset = ($pagina_atual - 1) * $posts_por_pagina;

$sql = "SELECT p.id, p.title, p.author, p.slug, p.publish_date,
               m.path AS media_path, m.filename AS media_filename,
               c.slug AS category_slug, c.title AS category_title
        FROM posts p
        LEFT JOIN medias m ON m.id = p.cover_media_id
        LEFT JOIN post_categories pc ON pc.post_id = p.id
        LEFT JOIN categories c ON c.id = pc.category_id
        WHERE p.is_published = 1
        GROUP BY p.id
        ORDER BY p.publish_date DESC
        LIMIT $offset, $posts_por_pagina";
$result = $conn->query($sql);

$sql_total = "SELECT COUNT(id) AS total FROM posts WHERE is_published = 1";
$total_result = $conn->query($sql_total);
$total_posts = $total_result ? (int)$total_result->fetch_assoc()['total'] : 0;
$total_paginas = (int)ceil($total_posts / $posts_por_pagina);
?>

<div class="all-blog-posts">
    <div class="row">
        <?php if ($result): while ($post = $result->fetch_assoc()): ?>
            <?php $imageUrl = !empty($post['media_path'])
                ? $baseUrl . '/painel/' . trim($post['media_path'], '/')
                : $baseUrl . '/assets/images/blog-post-01.jpg'; ?>
            <div class="col-lg-12">
                <div class="blog-post">
                    <div class="blog-thumb">
                        <img src="<?= htmlspecialchars($imageUrl); ?>" alt="<?= htmlspecialchars($post['title']); ?>">
                    </div>
                    <div class="down-content">
                        <?php if (!empty($post['category_slug']) && !empty($post['category_title'])): ?>
                            <a href="<?= $baseUrl . '/' . $category_base . '/' . htmlspecialchars($post['category_slug']); ?>"><span><?= htmlspecialchars($post['category_title']); ?></span></a>
                        <?php endif; ?>
                        <a href="<?= $baseUrl . '/' . htmlspecialchars($post['slug']); ?>">
                            <h4><?= htmlspecialchars($post['title']); ?></h4>
                        </a>
                        <ul class="post-info">
                            <li><a href="#"> <?= htmlspecialchars($post['author']); ?> </a></li>
                            <li><a href="#"> <?= date("F d, Y", strtotime($post['publish_date'])); ?> </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endwhile; endif; ?>

        <div class="col-lg-12">
            <div class="main-button">
                <?php if ($pagina_atual > 1): ?>
                    <a href="<?= $baseUrl; ?>/?pagina=<?= $pagina_atual - 1; ?>">Anterior</a>
                <?php endif; ?>
                <?php if ($pagina_atual < $total_paginas): ?>
                    <a href="<?= $baseUrl; ?>/?pagina=<?= $pagina_atual + 1; ?>">Próximo</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $conn->close(); ?>
