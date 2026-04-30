<?php
$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("Falha na conex達o: " . $conn->connect_error);
}

$sql = "SELECT * FROM posts_highlights WHERE banner = 1 ORDER BY published_at DESC LIMIT 3;";
$result = $conn->query($sql);
?>

<div class="main-banner header-text">
    <div class="container-fluid">
        <div class="owl-banner owl-carousel">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($post = $result->fetch_assoc()): ?>
                    <div class="item">
                        <img src="<?php echo $post['image_url']; ?>" alt="">
                        <div class="item-content">
                            <div class="main-content">
                                <div class="meta-category">
                                    <span><?php echo $post['category_name']; ?></span>
                                </div>
                                <a href="<?php echo $post['link']; ?>">
                                    <h4><?php echo $post['title']; ?></h4>
                                </a>
                                <ul class="post-info">
                                    <li><a href="#"><?php echo $post['author']; ?></a></li>
                                    <li><a href="#"><?php echo date("F d, Y", strtotime($post['published_at'])); ?></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; 
            $conn->close();?>
        </div>
    </div>
</div>
