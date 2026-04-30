@extends('layouts.disconnected')

@section('content')

<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth">
      <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
          
          <form action="#" name="frmLogin" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="auth-form-light text-left p-5">
              
              <form class="pt-3">

                {{-- Mensagens de erro --}}
                @if($errors->any())
                    <div class="form-group">
                        <div class="mensagem-de-erro-area alert alert-danger">
                            {!! implode('', $errors->all('<div>:message</div>')) !!}
                        </div>
                    </div>
                @endif

                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" 
                    name="email" placeholder="E-mail" required />
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" 
                    name="password" placeholder="Senha" required />
                </div>
                <div class="mt-3">
                  <button class="btn d-grid btn-primary btn-lg font-weight-medium auth-form-btn">Entrar</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input"> Mantenha-me conectado </label>
                  </div>
                </div>
              </form>
            </div>
          </form>

        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
  </div>
  <!-- page-body-wrapper ends -->
</div>

@endsection