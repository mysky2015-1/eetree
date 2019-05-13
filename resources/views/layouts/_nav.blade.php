@foreach ($navs as $nav)
    @if (!$nav->has('children') || $nav->children->isEmpty())
        <li ><a class="dropdown-item" href="{{ $nav->url }}">{{ $nav->name }}</a></li>
    @else
        <li class="dropdown-submenu">
            <a tabindex="-1" class="dropdown-item" href="{{ $nav->url }}">{{ $nav->name }}</a>
            <ul class="dropdown-menu">
                @include('layouts/_nav', ['navs' => $nav->children])
            </ul>
        </li>
    @endif
@endforeach
