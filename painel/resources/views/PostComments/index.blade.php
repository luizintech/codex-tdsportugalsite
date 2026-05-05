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

  <div class="modal fade" id="replyCommentModal" tabindex="-1" role="dialog" aria-labelledby="replyCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form method="POST" id="replyCommentForm">
          {{ csrf_field() }}
          <div class="modal-header">
            <h5 class="modal-title" id="replyCommentModalLabel">Responder comentário</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="reply_text">Resposta</label>
              <textarea class="form-control" id="reply_text" name="reply_text" rows="4" maxlength="4000" required></textarea>
            </div>
            <small class="text-muted">A resposta será gravada com name <b>admin</b> e email <b>admin@admin</b>.</small>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Salvar resposta</button>
          </div>
        </form>
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

    $('.reply-comment-btn').click(function(){
      const commentId = $(this).data('comment-id');
      const postId = $(this).data('post-id');
      const action = "{{url('')}}/PostComments/reply-comment/" + commentId + "/fromPost/" + postId;
      $('#replyCommentForm').attr('action', action);
      $('#reply_text').val('');
    });

  </script>

@endsection
