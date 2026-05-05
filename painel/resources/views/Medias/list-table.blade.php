<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>&nbsp;</th>
        <th>Arquivo</th>
        <th>Caminho</th>
        <th>Slug</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($viewModel->objectReturn as $Media)
        <tr>
            <td>{{$Media->id}}</td> 
            <td>
                <form method="POST" action="{{url('')}}/Medias/delete/{{$Media->id}}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="badge badge-danger p-2 delete-user">Remover</button>
                </form>
            </td>
            <td>
                <a href="{{url('uploads/medias')}}/{{$Media->filename}}" target="_blank">
                    <img src="{{url('uploads/medias')}}/{{$Media->filename}}" />
                </a>
            </td>
            <td>{{$Media->path}}</td>
            <td>{{$Media->slug}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
