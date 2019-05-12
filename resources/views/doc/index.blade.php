@extends('layouts.app')
@section('title', '搜索')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if (empty($docs))
                    未查询到相关文档
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">作者</th>
                            <th scope="col">文档名</th>
                            <th scope="col">更新时间</th>
                            <th scope="col">阅读量</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($docs as $doc)
                                <tr>
                                    <td>{{ $doc->user->nickname }}</td>
                                    <td><a href="{{ route('doc.detail', ['doc' => $doc->id]) }}">{{ $doc->title }}</a></td>
                                    <td>{{ $doc->publish_at->format('Y-m-d') }}</td>
                                    <td>{{ $doc->view_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $docs->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
