<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nome</th>
      <th>Mensagem</th>
      <th>Tipo</th>
      <th>Data</th>
    </tr>
  </thead>
  <tbody>@foreach ($viewModel->objectReturn as $Log) <tr>
      <td>{{$Log->id}}</td>
      <td>{{$Log->name}}</td>
      <td>{{$Log->message}}</td>
      <td>
        @switch($Log->type)
            @case(\App\Enums\LogType::Error)
                <span class="badge badge-danger">Error</span>
                @break

            @case(\App\Enums\LogType::Warn)
                <span class="badge badge-warning">Warning</span>
                @break

            @case(\App\Enums\LogType::Info)
                <span class="badge badge-info">Info</span>
                @break

            @case(\App\Enums\LogType::Fatal)
                <span class="badge badge-error">Fatal</span>
                @break

            @default
                <span class="badge badge-secondary">Unknown</span>
        @endswitch
      </td>
      <td>{{$Log->created_at}}</td>
    </tr>@endforeach </tbody>
</table>