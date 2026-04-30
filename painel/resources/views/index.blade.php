@extends('layouts.master')

@section('content')
    
  <div class="row quick-action-toolbar">
    <div class="col-md-12 grid-margin">
      <div class="card">
        <div class="card-header d-block d-md-flex">
          <h5 class="mb-0">Ações rápidas</h5>
          <p class="ms-auto mb-0">Que tal começar a criar um conteúdo para seus potenciais clientes?<i class="icon-bulb"></i></p>
        </div>
        <div class="d-md-flex row m-0 quick-action-btns" role="group" aria-label="Quick action buttons">
          <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
            <a href="{{url('')}}/painel/users" class="btn px-0"> <i class="icon-user me-2"></i> Gerencias usuários</a>
          </div>
          <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
            <a href="{{url('')}}/painel/Posts/create" class="btn px-0"><i class="icon-docs me-2"></i> Criar um artigo</a>
          </div>
          <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
            <a href="{{url('')}}/painel/Pages/create" class="btn px-0"><i class="icon-folder me-2"></i> Criar uma página</a>
          </div>
          <div class="col-sm-6 col-md-3 p-3 text-center btn-wrapper">
            <a href="{{url('')}}/painel/Categories/create" class="btn px-0"><i class="icon-book-open me-2"></i>Criar uma categoria</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="d-sm-flex align-items-baseline report-summary-header">
                <h5 class="font-weight-semibold">Sumário</h5> <span class="ms-auto">Atualizar</span> <button class="btn btn-icons border-0 p-2"><i class="icon-refresh"></i></button>
              </div>
            </div>
          </div>
          <div class="row report-inner-cards-wrapper">

            <div class=" col-md-6 col-xl report-inner-card">
              <div class="inner-card-text">
                <span class="report-title">ARTIGO(S)</span>
                <h4>{{$viewModel->totalPosts}}</h4>
                <span class="report-count">&nbsp;</span>
              </div>
              <div class="inner-card-icon bg-success">
                <i class="icon-rocket"></i>
              </div>
            </div>

            <div class="col-md-6 col-xl report-inner-card">
              <div class="inner-card-text">
                <span class="report-title">PÁGINAS(S)</span>
                <h4>{{$viewModel->totalPages}}</h4>
                <span class="report-count">&nbsp;</span>
              </div>
              <div class="inner-card-icon bg-danger">
                <i class="icon-briefcase"></i>
              </div>
            </div>

            <div class="col-md-6 col-xl report-inner-card">
              <div class="inner-card-text">
                <span class="report-title">TÓPICO(S)</span>
                <h4>{{$viewModel->totalLabels}}</h4>
                <span class="report-count">&nbsp;</span>
              </div>
              <div class="inner-card-icon bg-warning">
                <i class="icon-globe-alt"></i>
              </div>
            </div>

            <div class="col-md-6 col-xl report-inner-card">
              <div class="inner-card-text">
                <span class="report-title">CATEGORIA(S)</span>
                <h4>{{$viewModel->totalCategories}}</h4>
                <span class="report-count">&nbsp;</span>
              </div>
              <div class="inner-card-icon bg-primary">
                <i class="icon-diamond"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  

@endsection
