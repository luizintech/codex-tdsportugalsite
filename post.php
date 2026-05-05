<?php
    require 'layout/config.php';

    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    $baseUrl = $protocol."://".$_SERVER['HTTP_HOST'];

    $slug = '';
    if (!isset($_GET['slug'])) {
        die();
    }
    $slug = $_GET['slug'];

    $conn = new mysqli($host, $user, $password, $dbname);
    $conn->set_charset("utf8");
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    $stmtPost = $conn->prepare("SELECT p.id, p.title, p.content, p.author, p.publish_date, p.slug, m.path AS media_path, m.filename AS media_filename
            FROM posts p
            LEFT JOIN medias m ON m.id = p.cover_media_id
            WHERE p.slug = ? AND p.is_published = 1
            LIMIT 1");
    $stmtPost->bind_param('s', $slug);
    $stmtPost->execute();
    $resultPost = $stmtPost->get_result();

    $postId = null;
    $title = '';
    $content = '';
    $cover = $baseUrl . '/assets/images/blog-post-01.jpg';
    $author = '';
    $date = '';

    if ($resultPost && $resultPost->num_rows > 0) {
        while ($post = $resultPost->fetch_assoc()) {
            $postId = (int) $post['id'];
            $title = $post['title'];
            $cover = !empty($post['media_path']) && !empty($post['media_filename'])
                ? $baseUrl . '/painel/' . trim($post['media_path'], '/')
                : $cover;
            $content = $post['content'] ?? '';
            $author = $post['author'];
            $date = $post['publish_date'];
        }
    }

    if (empty($title) || empty($content) || empty($postId)) {
        header("Location: " . $baseUrl . "/404-nao-encontrado");
        die();
    }

    $commentError = '';
    $commentSuccess = '';
    $inputName = '';
    $inputEmail = '';
    $inputText = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_form'])) {
        $inputName = trim($_POST['name'] ?? '');
        $inputEmail = trim($_POST['email'] ?? '');
        $inputText = trim($_POST['text'] ?? '');
        $antiSpam = trim($_POST['website'] ?? '');

        if (!empty($antiSpam)) {
            $commentError = 'Não foi possível enviar seu comentário.';
        } elseif (empty($inputName) || empty($inputEmail) || empty($inputText)) {
            $commentError = 'Preencha nome, email e comentário.';
        } elseif (!filter_var($inputEmail, FILTER_VALIDATE_EMAIL)) {
            $commentError = 'Informe um email válido.';
        } else {
            $approved = 0;
            $commentAnswerId = null;
            $stmtInsert = $conn->prepare("INSERT INTO post_comments (post_id, name, email, text, approved, comment_answer_id, created_at, updated_at)
                                         VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
            $stmtInsert->bind_param('isssii', $postId, $inputName, $inputEmail, $inputText, $approved, $commentAnswerId);

            if ($stmtInsert->execute()) {
                $commentSuccess = 'Comentário enviado com sucesso! Ele será exibido após aprovação.';
                $inputName = '';
                $inputEmail = '';
                $inputText = '';
            } else {
                $commentError = 'Erro ao enviar comentário. Tente novamente.';
            }
        }
    }

    $stmtComments = $conn->prepare("SELECT id, name, text, comment_answer_id, created_at
                                    FROM post_comments
                                    WHERE post_id = ? AND approved = 1
                                    ORDER BY created_at DESC, id DESC");
    $stmtComments->bind_param('i', $postId);
    $stmtComments->execute();
    $resultComments = $stmtComments->get_result();

    $rootComments = [];
    $answerComments = [];

    if ($resultComments) {
        while ($comment = $resultComments->fetch_assoc()) {
            $comment['id'] = (int) $comment['id'];
            $comment['comment_answer_id'] = $comment['comment_answer_id'] !== null ? (int) $comment['comment_answer_id'] : null;

            if ($comment['comment_answer_id'] === null) {
                $rootComments[] = $comment;
            } else {
                if (!isset($answerComments[$comment['comment_answer_id']])) {
                    $answerComments[$comment['comment_answer_id']] = [];
                }
                $answerComments[$comment['comment_answer_id']][] = $comment;
            }
        }
    }

    $globalTitle = $title;

    require_once "layout/header.php";
    require_once "layout/header-body.php";
?>

<div class="heading-page header-text">
  <section class="page-heading">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-content">
            <h4><?= htmlspecialchars($title); ?></h4>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<section class="blog-posts grid-system">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="all-blog-posts">
          <div class="row">
            <div class="col-lg-12">
              <div class="blog-post">
                <div class="blog-thumb">
                  <img src="<?= htmlspecialchars($cover); ?>" alt="<?= htmlspecialchars($title); ?>">
                </div>
                <div class="down-content">
                  <h1><?= htmlspecialchars($title); ?></h1>
                  <ul class="post-info">
                    <li><a href="#"><?= htmlspecialchars($author); ?></a></li>
                    <li><a href="#"><?= date("F d, Y", strtotime($date)); ?></a></li>
                  </ul>
                </div>
                <?= "<div class='post-content'>" . $content . "</div>";?>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="sidebar-item comments">
                <div class="sidebar-heading">
                  <h2>Comentários</h2>
                </div>
                <div class="content">
                  <?php if (empty($rootComments)) { ?>
                    <p>Seja o primeiro a comentar.</p>
                  <?php } else { ?>
                    <ul>
                      <?php foreach ($rootComments as $comment) { ?>
                        <li>
                          <div class="author-thumb">
                            <img src="<?= $baseUrl; ?>/assets/images/comment-author-01.jpg" alt="">
                          </div>
                          <div class="right-content">
                            <h4><?= htmlspecialchars($comment['name']); ?><span><?= date("d/m/Y H:i", strtotime($comment['created_at'])); ?></span></h4>
                            <p><?= nl2br(htmlspecialchars($comment['text'])); ?></p>

                            <?php if (!empty($answerComments[$comment['id']])) { ?>
                              <ul style="margin-top: 15px; padding-left: 35px;">
                                <?php foreach ($answerComments[$comment['id']] as $answer) { ?>
                                  <li>
                                    <div class="author-thumb">
                                      <img src="<?= $baseUrl; ?>/assets/images/comment-author-02.jpg" alt="">
                                    </div>
                                    <div class="right-content">
                                      <h4><?= htmlspecialchars($answer['name']); ?><span><?= date("d/m/Y H:i", strtotime($answer['created_at'])); ?></span></h4>
                                      <p><?= nl2br(htmlspecialchars($answer['text'])); ?></p>
                                    </div>
                                  </li>
                                <?php } ?>
                              </ul>
                            <?php } ?>
                          </div>
                        </li>
                      <?php } ?>
                    </ul>
                  <?php } ?>
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="sidebar-item submit-comment">
                <div class="sidebar-heading">
                  <h2>Deixe um comentário</h2>
                </div>
                <div class="content">
                  <?php if (!empty($commentError)) { ?>
                    <p style="color: #c62828;"><?= htmlspecialchars($commentError); ?></p>
                  <?php } ?>
                  <?php if (!empty($commentSuccess)) { ?>
                    <p style="color: #2e7d32;"><?= htmlspecialchars($commentSuccess); ?></p>
                  <?php } ?>

                  <form id="comment" action="" method="POST">
                    <input type="hidden" name="comment_form" value="1">
                    <div class="row">
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <fieldset>
                          <input name="name" type="text" id="name" placeholder="Seu nome" required="" value="<?= htmlspecialchars($inputName); ?>">
                        </fieldset>
                      </div>
                      <div class="col-lg-12 col-md-12 col-sm-12">
                        <fieldset>
                          <input name="email" type="email" id="email" placeholder="Seu email" required="" value="<?= htmlspecialchars($inputEmail); ?>">
                        </fieldset>
                      </div>
                      <div style="display:none;">
                        <input name="website" type="text" tabindex="-1" autocomplete="off">
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          <textarea name="text" rows="6" id="text" 
                            placeholder="Digite seu comentário" required=""><?= htmlspecialchars($inputText); ?></textarea>
                        </fieldset>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          <button type="submit" id="form-submit" class="main-button">Enviar comentário</button>
                        </fieldset>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <?php require_once "layout/post-sidebar.php" ?>
      </div>
    </div>
  </div>
</section>

<?php
    require_once "layout/footer-body.php";
    require_once "layout/footer.php";
?>
