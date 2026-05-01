<form method="GET" action="{{url('')}}/Posts" class="mb-3">
    <div class="row">
    <div class="col-md-4 mb-2">
        <input type="text" name="title" value="{{ $viewModel->filters['title'] ?? '' }}" class="form-control" placeholder="Filtrar por título" />
    </div>
    <div class="col-md-3 mb-2">
        <select name="category_id" class="form-control">
        <option value="">Todas as categorias</option>
        @foreach(($viewModel->categories ?? []) as $category)
            <option value="{{ $category->id }}" {{ (string)($viewModel->filters['category_id'] ?? '') === (string)$category->id ? 'selected' : '' }}>{{ $category->title }}</option>
        @endforeach
        </select>
    </div>
    <div class="col-md-3 mb-2">
        <select name="label_id" class="form-control">
        <option value="">Todas as labels</option>
        @foreach(($viewModel->labels ?? []) as $label)
            <option value="{{ $label->id }}" {{ (string)($viewModel->filters['label_id'] ?? '') === (string)$label->id ? 'selected' : '' }}>{{ $label->title }}</option>
        @endforeach
        </select>
    </div>
    <div class="col-md-2 mb-2">
        <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
        <button type="reset" class="btn btn-secondary btn-block">Limpar</button>
    </div>
    </div>
</form>