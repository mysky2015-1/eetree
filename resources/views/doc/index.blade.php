@extends('layouts.app')

@section('content')
<div class="container">
    list
</div>
@endsection

@section('scripts')
<script>

$.post({
    url: '{{ route('userCategory.folder') }}',
    data: {
        id: 0
    },
    success: function(res) {
        if (res.status != 'success') {
            return;
        }
        console.log(res.data)
    },
    error : function (XMLHttpRequest) {
        if (XMLHttpRequest.responseJSON.code == 422) {
            layer.msg(XMLHttpRequest.responseJSON.message);
        }
    },
});
</script>
@endsection
