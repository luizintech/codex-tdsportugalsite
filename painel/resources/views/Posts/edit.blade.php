@extends('layouts.master')

@section('content')
    
<div class="page-header">
    <h3 class="page-title"> Editar post - <?= $viewModel->objectReturn->title; ?> </h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('')}}/">Dashboard</a></li>
        <li class="breadcrumb-item" href="{{url('../')}}/Posts" aria-current="page">Posts</li>
        <li class="breadcrumb-item active" aria-current="page">Editar post</li>
      </ol>
    </nav>
</div>

  <div class="row">
    <div class="col-md-12 col-xs-12">
      <form action="{{url('Posts/edit')}}/{{$viewModel->objectReturn->id}}" name="frm" 
          method="post" enctype="multipart/form-data" class="form form-login">
          {{csrf_field()}}
          <input type="hidden" name="txtId" value="{{$viewModel->objectReturn->id}}" required />

          <button type="submit" class="btn btn-primary text-uppercase mb-3">
              Gravar
          </button>
          <a href="{{url('Posts')}}" class="btn btn-secondary btn-secondary-back">Voltar</a>
          <br>
          @if($errors->any())
              <div class="mensagem-de-erro-area alert alert-danger">
                  {!! implode('', $errors->all('<div>:message</div>')) !!}
              </div>
          @endif

          @include("Posts/divided-edit-layout")
      </form>
    </div>
  </div>

@endsection

@section('styles')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.tiny.cloud/1/kfnmoaldqf9jc4d4dpg2wmzv2rz2hkcz0uz07bxg115st19i/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            placeholder: "(ESCOLHA)",
            allowClear: true
        });

        tinymce.init({
          selector: '#postContent',
          plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
          toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        });
    });

    $(document).on('click', '.choose-media', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        $('#cover_media_id').val(id);
        $('#cover_media_name').val(name);
        $('#mediaPickerModal').modal('hide');
    });

    $('#media-search').on('keyup', function() {
        const term = $(this).val().toLowerCase();
        $('#media-picker-table tbody tr').each(function(){
            const txt = $(this).text().toLowerCase();
            $(this).toggle(txt.indexOf(term) > -1);
        });
    });

  </script>
@endsection