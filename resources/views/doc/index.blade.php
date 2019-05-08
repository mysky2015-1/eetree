@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">文档名</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

@section('beforeScripts')
<script>
var needVue = true;
</script>
@endsection
@section('scripts')
<script>
axios({
    method: 'post',
    url: '{{ route('userCategory.folder') }}',
    data: {
        id: 0
    },
}).then(function (res) {
    console.log(res.data.data)
});
</script>
@endsection
