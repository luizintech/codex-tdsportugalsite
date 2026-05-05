<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>&nbsp;</th>
        <th>Data</th>
        <th>Nome <small>(E-mail)</small></th>
        <th class="comment-text-limit">Comentário</th>
        <th>Aprovado?</th>
        <th>Resposta</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($viewModel->objectReturn as $Comment)
        <tr>
            <td>{{$Comment->id}}</td>
            <td>
                <form method="POST" action="{{url('')}}/PostComments/delete/{{$Comment->id}}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="badge badge-danger p-2 delete-user">Remover</button>
                </form>
            </td>
            <td>{{$Comment->created_at}}</td>
            <td>{{$Comment->name}} - <small>{{$Comment->email}}</small></td>
            <td class="comment-text-limit">{{$Comment->text}}</td>
            <td>
                @if ($Comment->approved)
                    <span class="badge badge-success">SIM</span><br>
                    <form method="POST" action="{{url('')}}/PostComments/reject-comment/{{$Comment->id}}/fromPost/{{$Comment->post_id}}">
                        {{ csrf_field() }}
                        <button type="submit" class="badge badge-warning">Retirar</button>
                    </form>
                @else 
                    <span class="badge badge-danger">NÃO</span><br>
                    <form method="POST" action="{{url('')}}/PostComments/approve-comment/{{$Comment->id}}/fromPost/{{$Comment->post_id}}">
                        {{ csrf_field() }}
                        <button type="submit" class="badge badge-primary">Aprovar</button>
                    </form>
                @endif
            </td> 
            <td>
                @if ($Comment->comment_answer_id != null)
                    <span class="badge badge-info">RESPOSTA</span>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
