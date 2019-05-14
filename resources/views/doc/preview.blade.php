@extends('layouts.nonav')
@section('title', $doc->title)
@section('description', $doc->title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card detail-card">
                <h3 class="detail-title">{{$doc->title}}</h3>
                <ul>
                    @include('doc._docrow', ['node' => $doc->content['root'], 'depth' => 1])
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
