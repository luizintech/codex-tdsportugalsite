@extends('layouts.master')

@section('content')
    
<div class="page-header">
    <h3 class="page-title"> Posts </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('')}}/">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Posts</li>
      </ol>
    </nav>
</div>

  <div class="row">
    
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">

            <div class="row">
                <div class="col-12">
                    <a href="{{url('')}}/Posts/create" class="badge badge-primary p-2">
                        Novo
                    </a>
                </div>
            </div>


            <form method="GET" action="{{url('')}}/Posts" class="mb-3">
              <div class="row">
                <div class="col-md-4 mb-2">
                  <input type="text" name="title" value="{{ $viewModel->filters['title'] ?? '' }}" class="form-control" placeholder="Filtrar por título" />
                </div>
                <div class="col-md-3 mb-2">
                  <select name="category_id" class="form-control">
                    <option value="">Todas as categorias</option>
                    @foreach(($viewModel->categories ?? []) as $category)
                      <option value="{{ $category->id }}" {{ (string)($viewModel->filters['category_id'] ?? '') === (string)$category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-3 mb-2">
                  <select name="label_id" class="form-control">
                    <option value="">Todas as labels</option>
                    @foreach(($viewModel->labels ?? []) as $label)
                      <option value="{{ $label->id }}" {{ (string)($viewModel->filters['label_id'] ?? '') === (string)$label->id ? 'selected' : '' }}>{{ $label->name }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-2 mb-2">
                  <button type="submit" class="btn btn-primary btn-block">Filtrar</button>
                </div>
              </div>
            </form>

            @if (empty($viewModel->objectReturn) || count($viewModel->objectReturn) === 0)
              @include('shared/empty-table')  
            @else 
              @include('Posts/list-table')
            @endif

          </div>
        </div>
      </div>
    </div>
    
  </div>

  @include('shared/pagination')

@endsection

@section('scripts')

  <script type="text/javascript">

    $('.delete-user').click(function(e){
        e.preventDefault() 
        if (confirm('Tem certeza que deseja remover?')) {
            $(e.target).closest('form').submit()
        }
    });

  </script>

@endsection