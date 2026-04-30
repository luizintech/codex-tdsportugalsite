<?php
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $baseUrl = $protocol . "://" . $_SERVER['HTTP_HOST'];

    $config         = parse_ini_file($baseUrl.'/config.ini', true);

    $host           = $config['database']['host'];
    $dbname         = $config['database']['name'];
    $user           = $config['database']['user'];
    $password       = $config['database']['pass'];
   
    $category_base  = $config['site']['base_categories'];
    $label_base     = $config['site']['base_labels'];
    
?>
