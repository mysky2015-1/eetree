@extends('layouts.app')
@section('title', '搜索')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="content-list-main card">
                @if (empty($docs))
                    <h3 class="text-center">
                        <span class="explore-title">抱歉，未查询到相关文档</span>
                    </h3>
                @else

                    <h3>
                        <span class="explore-title">精选推荐</span>
                    </h3>
                    <div class="main-list-package">
                        @foreach ($docs as $doc)
                            <div class="content-list">
                                <div class="info">
                                <a href="{{ route('doc.detail', ['doc' => $doc->id]) }}">{{ $doc->title }}</a>
                                    <ul>
                                        <li>
                                            <div class="portrait">
                                                <p class="name">用户：{{ $doc->user->nickname }}</p>
                                            </div>
                                        </li>
                                        <li><i class="icon icon-time"></i><span>更新时间：{{ $doc->publish_at->format('Y-m-d') }}</span></li>
                                        <li><i class="icon icon-view"></i><span>阅读量:{{ $doc->view_count }}</span></li>
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                {{ $docs->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
