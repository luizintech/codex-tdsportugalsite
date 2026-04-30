<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>Arquivo</th>
        <th>Caminho</th>
        <th>Slug</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($viewModel->objectReturn as $Media)
        <tr>
            <td class="maxwidth-btns-25px">{{$Media->id}}</td>
            <td class="maxwidth-btns-25px">
                <a href="{{url('')}}/Medias/edit/{{$Media->id}}" class="badge badge-success p-2">Editar</a>
            </td>
            <td class="maxwidth-btns-25px">
                <form method="POST" action="{{url('')}}/Medias/delete/{{$Media->id}}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="badge badge-danger p-2 delete-user">Remover</button>
                </form>
            </td>
            <td>{{$Media->filename}}</td>
            <td>{{$Media->path}}</td>
            <td>{{$Media->slug}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
