@foreach ($navs as $nav)
    @if (empty($nav['children']))
        <li ><a class="dropdown-item" href="javascript:;">{{ $nav['name']}}</a></li>
    @else
        <li class="dropdown-submenu">
            <a tabindex="-1" class="dropdown-item" href="javascript:;">{{ $nav['name']}}</a>
            <ul class="dropdown-menu">
                @include('layouts/_nav', ['navs' => $nav['children']])
            </ul>
        </li>
    @endif
@endforeach
