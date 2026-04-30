<div class="col-md-12 form-group">
    <label class="control-label">Upload da imagem:</label>
    <input type="file" name="image_file" class="form-control" accept="image/*" />
    @if(isset($viewModel->objectReturn) && !empty($viewModel->objectReturn->filename))
        <small class="text-muted">Atual: {{$viewModel->objectReturn->filename}}</small>
    @endif
</div>

<div class="col-md-12 form-group">
    <label class="control-label">Nome do arquivo (somente leitura):</label>
    <input type="text" name="filename" class="form-control" maxlength="150" readonly
        value="<?= isset($viewModel->objectReturn) ? $viewModel->objectReturn->filename : ''; ?>" />
    <small class="text-muted">Este campo é preenchido automaticamente com o nome do upload.</small>
</div>

<div class="col-md-12 form-group">
    <label class="control-label">Path / URL (opcional):</label>
    <input type="text" name="path" class="form-control" maxlength="100"
        value="<?= isset($viewModel->objectReturn) ? $viewModel->objectReturn->path : ''; ?>" />
</div>

<div class="col-md-12 form-group">
    <label class="control-label">Slug:</label>
    <input type="text" name="slug" class="form-control" required maxlength="250"
        value="<?= isset($viewModel->objectReturn) ? $viewModel->objectReturn->slug : ''; ?>" />
</div>
