<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$baseUrl = $protocol."://".$_SERVER['HTTP_HOST']
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9558098409050173"
     crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">

    <title><?= $globalTitle; ?> | Tudo Sobre Portugal</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= $baseUrl; ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="<?= $baseUrl; ?>/assets/css/fontawesome.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>/assets/css/templatemo-stand-blog.css">
    <link rel="stylesheet" href="<?= $baseUrl; ?>/assets/css/owl.css">
  </head>