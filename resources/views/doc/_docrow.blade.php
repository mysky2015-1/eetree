<li>
    {{ $depth++ }}.
    {{ $node['data']['text'] }}
    @if (!empty($node['data']['image']))
        <img src="{{ $node['data']['image'] }}" width="{{ $node['data']['imageSize']['width'] }}" height="{{ $node['data']['imageSize']['height'] }}"></image>
    @endif
</li>
@if (!empty($node['children']))
    <li>
        <ul>
            @foreach($node['children'] as $row)
                @include('doc/_docrow', ['node' => $row, 'depth' => $depth])
            @endforeach
        </ul>
    </li>
@endif
