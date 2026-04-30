<div class="col-md-12 form-group">
    <label class="control-label">Título:</label>
    <input type="text" name="title" class="form-control" required maxlength="80"
        value="<?= isset($viewModel->objectReturn) ? $viewModel->objectReturn->title : ''; ?>" />
</div>

<div class="col-md-12 form-group">
    <label class="control-label">Conteúdo:</label>
    <textarea name="content" class="form-control" required rows="8"><?= isset($viewModel->objectReturn) ? $viewModel->objectReturn->content : ''; ?></textarea>
</div>

<div class="col-md-12 form-group">
    <label class="control-label">Autor:</label>
    <input type="text" name="author" class="form-control" required maxlength="50"
        value="<?= isset($viewModel->objectReturn) ? $viewModel->objectReturn->author : ''; ?>" />
</div>

<div class="col-md-12 form-group">
    <label class="control-label">Slug:</label>
    <input type="text" name="slug" class="form-control" required maxlength="250"
        value="<?= isset($viewModel->objectReturn) ? $viewModel->objectReturn->slug : ''; ?>" />
</div>
