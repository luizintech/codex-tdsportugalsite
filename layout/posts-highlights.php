<?php

$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$posts_por_pagina = 10;

$pagina_atual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_atual - 1) * $posts_por_pagina;

$sql = "SELECT * FROM posts_highlights ORDER BY published_at DESC LIMIT $offset, $posts_por_pagina";
$result = $conn->query($sql);

$sql_total = "SELECT COUNT(id) AS total FROM posts_highlights";
$total_result = $conn->query($sql_total);
$total_posts = $total_result->fetch_assoc()['total'];
$total_paginas = ceil($total_posts / $posts_por_pagina);
?>

<div class="all-blog-posts">
    <div class="row">
        <?php while ($post = $result->fetch_assoc()): ?>
            <div class="col-lg-12">
                <div class="blog-post">
                    <div class="blog-thumb">
                        <img src="<?php echo htmlspecialchars($post['image_url']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                    </div>
                    <div class="down-content">
                        <a href="<?= $category_base . "/" . htmlspecialchars($post['category_slug']); ?>"><span><?php echo htmlspecialchars($post['category_name']); ?></span></a>
                        <a href="<?php echo htmlspecialchars($post['link']); ?>">
                            <h4><?php echo htmlspecialchars($post['title']); ?></h4>
                        </a>
                        <ul class="post-info">
                            <li><a href="#"> <?php echo htmlspecialchars($post['author']); ?> </a></li>
                            <li><a href="#"> <?php echo date("F d, Y", strtotime($post['published_at'])); ?> </a></li>
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
