@extends('layouts.master')

@section('content')
    
<div class="page-header">
    <h3 class="page-title"> Criar categoria</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('')}}/">Dashboard</a></li>
        <li class="breadcrumb-item" href="{{url('../')}}/Categories" aria-current="page">Categorias</li>
        <li class="breadcrumb-item active" aria-current="page">Criar categoria</li>
      </ol>
    </nav>
</div>

  <div class="row">
    <div class="col-md-12 col-xs-12">
      <form action="{{url('Categories/create')}}" name="frm" 
          method="post" enctype="multipart/form-data" class="form form-login">
          {{csrf_field()}}

          <button type="submit" class="btn btn-primary text-uppercase mb-3">
              Gravar
          </button>
          <a href="{{url('Categories')}}" class="btn btn-secondary btn-secondary-back">Voltar</a>
          <br>
          @if($errors->any())
              <div class="mensagem-de-erro-area alert alert-danger">
                  {!! implode('', $errors->all('<div>:message</div>')) !!}
              </div>
          @endif

          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="row">
                @include("Categories/edit-form")
              </div>
            </div>
          </div>
          
      </form>
    </div>
  </div>

@endsection

@section('styles')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            placeholder: "(ESCOLHA)",
            allowClear: true
        });
    });
  </script>
@endsection