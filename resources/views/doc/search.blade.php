@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (empty($docs))
                    未查询到相关文档
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">文档名</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($docs as $doc)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{ $doc->title }}</td>
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
