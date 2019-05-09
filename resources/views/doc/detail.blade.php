@extends('layouts.app')
@section('title', $doc->title)
@section('description', $doc->title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <ul>
                    @include('doc/_docrow', ['node' => $doc->content['root'], 'depth' => 1])
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
