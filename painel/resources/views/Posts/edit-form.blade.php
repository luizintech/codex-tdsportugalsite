<div class="col-md-12 form-group">
    <label class="control-label">Título:</label>
    <input type="text" name="title" class="form-control" required maxlength="80"
        value="<?= old('title', isset($viewModel->objectReturn) ? $viewModel->objectReturn->title : ''); ?>" />
</div>

<div class="col-md-12 form-group">
    <label class="control-label">Conteúdo:</label>
    <textarea id="postContent" name="content" class="form-control" rows="8"><?= old('content', isset($viewModel->objectReturn) ? $viewModel->objectReturn->content : ''); ?></textarea>
</div>

<div class="col-md-12 form-group">
    <label class="control-label">Autor:</label>
    <input type="text" name="author" class="form-control" required maxlength="50"
        value="<?= old('author', isset($viewModel->objectReturn) ? $viewModel->objectReturn->author : ''); ?>" />
</div>

<div class="col-md-12 form-group">
    <label class="control-label">Slug:</label>
    <input type="text" name="slug" class="form-control" required maxlength="250"
        value="<?= old('slug', isset($viewModel->objectReturn) ? $viewModel->objectReturn->slug : ''); ?>" />
</div>

<div class="col-md-12 form-group">
    <label class="control-label">Data de Publicação:</label>
    <input type="date" name="publish_date" class="form-control" required
        value="<?= old('publish_date', isset($viewModel->objectReturn) && $viewModel->objectReturn->publish_date ? \Carbon\Carbon::parse($viewModel->objectReturn->publish_date)->format('Y-m-d') : ''); ?>" />
</div>

<div class="col-md-12 form-group">
    <label class="control-label">Publicado:</label>
    <select name="is_published" class="form-control" required>
        <option value="">(ESCOLHA)</option>
        <option value="1" <?= old('is_published', isset($viewModel->objectReturn) ? (int)$viewModel->objectReturn->is_published : null) === 1 ? 'selected' : ''; ?>>Sim</option>
        <option value="0" <?= old('is_published', isset($viewModel->objectReturn) ? (int)$viewModel->objectReturn->is_published : null) === 0 ? 'selected' : ''; ?>>Não</option>
    </select>
</div>
