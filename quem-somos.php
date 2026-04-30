<?php
    $globalTitle = "Quem somos";
    require 'layout/config.php';
    require_once "layout/header.php";
    require_once "layout/header-body.php";
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
        
        <p>
            Somos o blog Tudo Sobre Portugal, muito mais do que um simples blog, 
            somos uma porta de entrada para o encantador país que é Portugal.
        </p>

        <p>
            Para muitos de nós brasileiros, Portugal é a terra dos nossos ancestrais, um lugar que 
            ressoa em nossas memórias familiares e que tem muito a nos ensinar sobre história, 
            cultura e tradições. 
        </p>
        
        <p>
            Se você ainda não teve a oportunidade de vivenciar pessoalmente tudo o que Portugal tem a oferecer, 
            este blog é um convite para você se aventurar por suas paisagens deslumbrantes, sua culinária deliciosa
            e muito mais que este curiosos país tem a oferecer.
        </p>

        <p>
            Aqui, não nos limitamos a falar apenas sobre turismo. Queremos proporcionar uma imersão 
            completa sobre a vida em Portugal, abordando temas como a vida cotidiana, 
            arte e cultura, história, viagens e muito mais.
        </p>

        <p>
            Cada texto que produzimos é cuidadosamente elaborado para oferecer informações relevantes e inspiradoras, 
            que ajudem a enriquecer sua experiência e conhecimento sobre este país tão especial.
        </p>

      </div>
    </div>
  </div>
</section>

<?php 
    require_once "layout/footer-body.php";
    require_once "layout/footer.php";
?> 