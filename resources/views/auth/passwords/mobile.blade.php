@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">重置密码</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.mobile') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right">手机号</label>

                            <div class="col-md-6">
                                <input id="mobile" type="text" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ old('mobile') }}" required>

                                @if ($errors->has('mobile'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="verify_code" class="col-md-4 col-form-label text-md-right">验证码</label>

                            <div class="col-md-6">
                                <input id="verify_code" type="text" class="form-control{{ $errors->has('verify_code') ? ' is-invalid' : '' }}" name="verify_code" required>

                                @if ($errors->has('verify_code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('verify_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input id="sendSms" type="button" value="发送验证码">
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    下一步
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/sms.js') }}"></script>
<script>
$('#sendSms').sms({
    //laravel csrf token
    token       : "{{csrf_token()}}",
    //请求间隔时间
    interval    : 60,
    //请求参数
    requestData : {
        //手机号
        mobile : function () {
            return $('#mobile').val();
        },
    }
});
</script>
@endsection
