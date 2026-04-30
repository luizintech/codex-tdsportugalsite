<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>Capa</th>
        <th>Título</th>
        <th>Autor</th>
        <th>Slug</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($viewModel->objectReturn as $Post)
        <tr>
            <td class="maxwidth-btns-25px">{{$Post->id}}</td>
            <td class="maxwidth-btns-25px">
                <a href="{{url('')}}/Posts/edit/{{$Post->id}}" class="badge badge-success p-2">Editar</a>
            </td>
            <td class="maxwidth-btns-25px">
                <form method="POST" action="{{url('')}}/Posts/delete/{{$Post->id}}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="badge badge-danger p-2 delete-user">Remover</button>
                </form>
            </td>
            <td>{{ $Post->coverMedia?->filename ?? '-' }}</td>
            <td>{{$Post->title}}</td>
            <td>{{$Post->author}}</td>
            <td>{{$Post->slug}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
