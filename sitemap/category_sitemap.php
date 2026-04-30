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

    $sql = "SELECT slug, created_at FROM categories ORDER BY created_at DESC;";
    $result = $conn->query($sql);

    echo "<?xml version='1.0' encoding='UTF-8'?>";
    echo "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $postUrl = $baseUrl . "/" . $category_base . "/" . htmlspecialchars($row['slug']);
            $lastMod = date('Y-m-d', strtotime($row['created_at']));
            echo "<url>";
            echo "<loc>{$postUrl}</loc>";
            echo "<lastmod>{$lastMod}</lastmod>";
            echo "</url>";
        }
    }
    
    echo "</urlset>";

    $conn->close();
?>
