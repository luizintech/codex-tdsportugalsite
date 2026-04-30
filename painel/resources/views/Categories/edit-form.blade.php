<div class="col-md-12 form-group">
    <label class="control-label">Titulo:</label>
    <input type="text" name="title" class="form-control" required maxlength="60"
        value="<?= isset($viewModel->objectReturn) ? $viewModel->objectReturn->title : ''; ?>" />
</div>

<div class="col-md-12 form-group">
    <label class="control-label">Pequena descrição:</label>
    <textarea name="short_description" class="form-control" maxlength="1500" rows="5"><?= isset($viewModel->objectReturn) ? $viewModel->objectReturn->short_description : ''; ?></textarea>
</div>

<div class="col-md-12 form-group">
    <label class="control-label">Slug:</label>
    <input type="text" name="slug" class="form-control" required maxlength="250"
        value="<?= isset($viewModel->objectReturn) ? $viewModel->objectReturn->slug : ''; ?>" />
</div>