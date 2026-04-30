<?php
    header("Content-Type: application/xml; charset=utf-8");

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $baseUrl = $protocol . "://" . $_SERVER['HTTP_HOST'];

    $posts = [
        ["link" => "/quem-somos", "published_at" => "2025-03-01"],
        ["link" => "/contato", "published_at" => "2025-03-01"]
    ];

    echo "<?xml version='1.0' encoding='UTF-8'?>";
    echo "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>";
    echo "<url><loc>{$baseUrl}</loc><changefreq>daily</changefreq></url>";

    foreach ($posts as $post) {
        $postUrl = $baseUrl . htmlspecialchars($post['link']);
        $lastMod = date('Y-m-d', strtotime($post['published_at']));
        echo "<url>";
        echo "<loc>{$postUrl}</loc>";
        echo "<lastmod>{$lastMod}</lastmod>";
        echo "</url>";
    }

    echo "</urlset>";
?>
