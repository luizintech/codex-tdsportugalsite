@extends('layouts.master')
@section('content')
<div class="page-header"><h3 class="page-title"> Logs </h3><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{url('')}}/">Dashboard</a></li><li class="breadcrumb-item active" aria-current="page">Logs</li></ol></nav></div>
<div class="row"><div class="col-lg-12 grid-margin stretch-card"><div class="card"><div class="card-body"><div class="table-responsive">@if (empty($viewModel->objectReturn) || count($viewModel->objectReturn) === 0) @include('shared/empty-table') @else @include('Logs/list-table') @endif</div></div></div></div></div>
@include('shared/pagination')
@endsection
