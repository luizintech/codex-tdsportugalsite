@php
    use Illuminate\Support\Str;
@endphp

<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>&nbsp;</th>
        <th>Key</th>
        <th>Value</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($viewModel->objectReturn as $config) 
        <tr>
            <td class="maxwidth-btns-25px">{{$config->id}}</td>
            <td class="maxwidth-btns-25px">
                <a href="{{url('')}}/Configurations/edit/{{$config->id}}"
                    class="badge badge-success p-2">
                    Editar
                </a>
            </td>
            <td>{{$config->key}}</td>
            <td>{{ Str::limit($config->value, 50) }}</td>
        </tr>
    @endforeach

    </tbody>
</table>