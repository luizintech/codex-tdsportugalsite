<table class="table table-striped">
    <thead>
    <tr>
        <th>Capa</th>
        <th>Título</th>
        <th>Autor</th>
        <th>Slug</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($viewModel->objectReturn as $Post)
        <tr>
            <td>
                <a href="{{url('uploads/medias')}}/{{ $Post->coverMedia?->filename }}" target="_blank">
                    <img src="{{url('uploads/medias')}}/{{ $Post->coverMedia?->filename }}"
                        alt="{{$Post->coverMedia?->filename ?? '-'}}" />
                </a>
            </td>
            <td>{{$Post->title}}</td>
            <td>{{$Post->author}}</td>
            <td>{{$Post->slug}}</td>
            <td>
                <a href="{{url('')}}/Posts/edit/{{$Post->id}}" class="badge badge-success p-2">Editar</a>
            </td>
            <td>
                <form method="POST" action="{{url('')}}/Posts/delete/{{$Post->id}}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="badge badge-danger p-2 delete-user">Remover</button>
                </form>
            </td>
            <td>
                <a href="{{url('')}}/PostComments/{{$Post->id}}" class="badge badge-primary p-2">Comentários</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
