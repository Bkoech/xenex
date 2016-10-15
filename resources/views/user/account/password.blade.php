@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="list-grouop">
                    <a href="{{ url('/user/account/setting') }}" class="list-group-item">
                        帳號設定
                    </a>
                    <a href="#}" class="list-group-item active">
                        密碼設定
                    </a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">密碼設定</div>
                    <div class="panel-body">
                        <form action="{{ url('/user/account/password') }}" role="form" method="POST" class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('current_password') ? 'has-error' : '' }}">
                                <label for="current_password" class="col-md-4 control-label">現在密碼</label>

                                <div class="col-md-6">
                                    <input id="current_password" type="password" class="form-control" name="current_password">
                                </div>

                                @if ($errors->has('current_password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">新密碼</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">
                                </div>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                <label for="password_confirmation" class="col-md-4 control-label">確認新密碼</label>

                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                                </div>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-4 col-md-6">
                                    <button class="btn btn-primary">修改密碼</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection