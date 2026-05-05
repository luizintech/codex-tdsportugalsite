<div class="col-md-12 form-group">
    <label class="control-label">Key:</label>
    <input type="text" name="key" class="form-control" required maxlength="35" readonly
        value="<?= isset($viewModel->objectReturn) ? $viewModel->objectReturn->key : ''; ?>" />
</div>

<div class="col-md-12 form-group">
    <label class="control-label">Valor:</label>
    <textarea name="value" class="form-control" rows="5"><?= isset($viewModel->objectReturn) ? $viewModel->objectReturn->value : ''; ?></textarea>
</div>
