<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>Description</th>
        <th>Slug</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($viewModel->objectReturn as $Label) 
        <tr>
            <td class="maxwidth-btns-25px">{{$Label->id}}</td>
            <td class="maxwidth-btns-25px">
                <a href="{{url('')}}/Labels/edit/{{$Label->id}}"
                    class="badge badge-success p-2">
                    Editar
                </a>
            </td>
            <td class="maxwidth-btns-25px">
                <form method="POST" action="{{url('')}}/Labels/delete/{{$Label->id}}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" 
                    class="badge badge-danger p-2 delete-user">
                    Remover
                    </button>
                </form>
            </td>
            <td>{{$Label->title}}</td>
            <td>{{$Label->slug}}</td>
        </tr>
    @endforeach

    </tbody>
</table>