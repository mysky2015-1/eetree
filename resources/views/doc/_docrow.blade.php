<li>{{ $node['data']['text'] }}</li>
@if (!empty($node['children']))
    <li>
        <ul>
            @foreach($node['children'] as $row)
                @include('doc/_docrow', ['node' => $row])
            @endforeach
        </ul>
    </li>
@endif
