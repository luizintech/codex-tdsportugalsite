<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$baseUrl = $protocol . "://" . $_SERVER['HTTP_HOST'];

$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

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
        LIMIT 3";
$result = $conn->query($sql);
?>

<div class="main-banner header-text">
    <div class="container-fluid">
        <div class="owl-banner owl-carousel">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($post = $result->fetch_assoc()): ?>
                    <?php
                    $imageUrl = !empty($post['media_path']) && !empty($post['media_filename'])
                        ? $baseUrl . '/painel/' . trim($post['media_path'], '/')
                        : $baseUrl . '/assets/images/banner-item-01.jpg';
                    ?>
                    <div class="item">
                        <img src="<?= htmlspecialchars($imageUrl); ?>" alt="<?= htmlspecialchars($post['title']); ?>">
                        <div class="item-content">
                            <div class="main-content">
                                <?php if (!empty($post['category_title'])): ?>
                                    <div class="meta-category">
                                        <span><?= htmlspecialchars($post['category_title']); ?></span>
                                    </div>
                                <?php endif; ?>
                                <a href="<?= $baseUrl . '/' . htmlspecialchars($post['slug']); ?>">
                                    <h4><?= htmlspecialchars($post['title']); ?></h4>
                                </a>
                                <ul class="post-info">
                                    <li><a href="#"><?= htmlspecialchars($post['author']); ?></a></li>
                                    <li><a href="#"><?= date("F d, Y", strtotime($post['publish_date'])); ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $conn->close(); ?>
