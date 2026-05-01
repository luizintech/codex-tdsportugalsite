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
            <br>

            @include('Posts/filters')  

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