@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <ul>
                    @include('_docrow', ['node' => $doc->content['root']])
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
