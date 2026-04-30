<?php
    require '../layout/config.php';

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $baseUrl = $protocol."://".$_SERVER['HTTP_HOST'];

    $globalTitle = "Sitemap";

    require_once "../layout/header.php";
    require_once "../layout/header-body.php";
?>

    <div class="heading-page header-text">
      <section class="page-heading">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="text-content">
                <h4><?= $globalTitle; ?></h4>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <section class="blog-posts">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <p>Sitemaps do site:</p>

        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Url</th>
                </tr>
                <tr>
                    <td>
                        Pages
                    </td>
                    <td>
                        <a target="_blank" href="<?=$baseUrl;?>/sitemap/pages_sitemap">pages</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        Posts
                    </td>
                    <td>
                        <a target="_blank" href="<?=$baseUrl;?>/sitemap/posts_sitemap">posts</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        Categorias
                    </td>
                    <td>
                        <a target="_blank" href="<?=$baseUrl;?>/sitemap/categories_sitemap">categories</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        Labels
                    </td>
                    <td>
                        <a target="_blank" href="<?=$baseUrl;?>/sitemap/labels_sitemap">labels</a>
                    </td>
                </tr>
            </thead>
        </table>
        
      </div>

    </div>
  </div>
</section>

<?php 
    require_once "../layout/footer-body.php";
    require_once "../layout/footer.php";
?> 