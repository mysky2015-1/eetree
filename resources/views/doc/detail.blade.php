@extends('layouts.app')
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
            <div class="my-3 p-3 bg-white rounded box-shadow">
                <h6 class="border-bottom border-gray pb-2 mb-0">我要评论</h6>
                <!-- 未登录 -->
                <div class="media  pt-3">
                    <a href="#" class="btn btn-lg btn-outline-primary inner-center">登录后方可提问哦~</a>
                </div>
                <div class="media text-muted pt-3">
                    <!-- 已登录 -->
                    <form class="needs-validation btn-block" novalidate="">
                        <textarea name="comment" id="comment" cols="30" rows="3" placeholder="请在此发表评论~"></textarea>
                        <div class="invalid-feedback">
                            填写有误
                        </div>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-block" type="submit">提交</button>   
                    </form>
                </div>
            </div>
            <div class="my-3 p-3 bg-white rounded box-shadow comments-list">
                <h6 class="border-bottom border-gray pb-2 mb-0">评论列表</h6>
                <div class="media text-muted pt-3">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <strong class="d-block text-gray-dark">用户名</strong>
                        家开发商的，很快就恢复会受到，好看粉红色的护发素
                        <span class="float-right">发布时间：2019-5-14 15：00</span>
                    </p>
                </div>
                <div class="media text-muted pt-3">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <strong class="d-block text-gray-dark">用户名</strong>
                        家开发商的，很快就恢复会受到，好看粉红色的护发素
                    </p>
                </div>
                <div class="media text-muted pt-3">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                        <strong class="d-block text-gray-dark">用户名</strong>
                        家开发商的，很快就恢复会受到，好看粉红色的护发素
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
