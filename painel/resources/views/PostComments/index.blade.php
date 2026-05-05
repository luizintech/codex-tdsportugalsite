@extends('layouts.master')

@section('content')
    
  <div class="page-header">
      <h3 class="page-title"> Comentarios do artigo </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('')}}/">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Comentários do artigo</li>
        </ol>
      </nav>
  </div>

  <div class="row">
    <div class="col-md-12 col-xs-12">
      <a href="{{url('Posts')}}" class="btn btn-secondary btn-secondary-back">Voltar</a>
    </div>
  </div>
  <br>

  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">

            @if (empty($viewModel->objectReturn) || count($viewModel->objectReturn) === 0)
              @include('shared/empty-table')  
            @else 
              @include('PostComments/list-table')
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
        if (confirm('Tem certeza?')) {
            $(e.target).closest('form').submit()
        }
    });

  </script>

@endsection