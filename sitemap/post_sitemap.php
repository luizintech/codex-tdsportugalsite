<?php
    require '../layout/config.php';

    header("Content-Type: application/xml; charset=utf-8");

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $baseUrl = $protocol . "://" . $_SERVER['HTTP_HOST'];

    $conn = new mysqli($host, $user, $password, $dbname);
    $conn->set_charset("utf8");
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    $sql = "SELECT link, published_at FROM posts_highlights ORDER BY published_at DESC";
    $result = $conn->query($sql);

    echo "<?xml version='1.0' encoding='UTF-8'?>";
    echo "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";
    echo "<url><loc>{$baseUrl}</loc><changefreq>daily</changefreq><priority>1.0</priority></url>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $postUrl = $baseUrl . "/" . htmlspecialchars($row['link']);
            $lastMod = date('Y-m-d', strtotime($row['published_at']));
            echo "<url>";
            echo "<loc>{$postUrl}</loc>";
            echo "<lastmod>{$lastMod}</lastmod>";
            echo "</url>";
        }
    }
    
    echo "</urlset>";

    $conn->close();
?>
