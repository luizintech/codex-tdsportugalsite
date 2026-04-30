<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$baseUrl = $protocol."://".$_SERVER['HTTP_HOST'];

$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$posts_por_pagina = 8;

$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_atual - 1) * $posts_por_pagina;

$sql = "SELECT * FROM posts_highlights WHERE post_tags like '%".$slug."%' ORDER BY published_at DESC LIMIT $offset, $posts_por_pagina";
$resultLabel = $conn->query($sql);

$sql_total = "SELECT COUNT(id) AS total FROM posts_highlights WHERE post_tags like '%".$slug."%'";
$total_result = $conn->query($sql_total);
$total_posts = $total_result->fetch_assoc()['total'];
$total_paginas = ceil($total_posts / $posts_por_pagina);
?>

<div class="all-blog-posts">
    <div class="row">
        <?php while ($label = $resultLabel->fetch_assoc()): ?>
            <div class="col-lg-12">
                <div class="blog-post">
                    <div class="blog-thumb">
                        <img src="<?php echo htmlspecialchars($label['image_url']); ?>" alt="<?php echo htmlspecialchars($label['title']); ?>">
                    </div>
                    <div class="down-content">
                        <a href="<?= $baseUrl . "/" . $category_base . "/" . htmlspecialchars($label['category_slug']); ?>"><span><?php echo htmlspecialchars($label['category_name']); ?></span></a>
                        <a href="<?php echo htmlspecialchars($label['link']); ?>">
                            <h4><?php echo htmlspecialchars($label['title']); ?></h4>
                        </a>
                        <ul class="post-info">
                            <li><a href="#"> <?php echo htmlspecialchars($label['author']); ?> </a></li>
                            <li><a href="#"> <?php echo date("F d, Y", strtotime($label['published_at'])); ?> </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>

        <!-- Paginação -->
        <div class="col-lg-12">
            <div class="main-button">
                <?php if ($pagina_atual > 1): ?>
                    <a href="?pagina=<?php echo $pagina_atual - 1; ?>">Anterior</a>
                <?php endif; ?>
                <?php if ($pagina_atual < $total_paginas): ?>
                    <a href="?pagina=<?php echo $pagina_atual + 1; ?>">Próximo</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $conn->close(); ?>
