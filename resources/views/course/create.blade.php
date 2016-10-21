@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">新增課程</div>
                    <div class="panel-body">
                        <form action="{{ url('/course/create') }}" class="form-horizontal" method="POST" role="form">
                            {{ csrf_field() }}
                            
                            <div class="form-group {{ $errors->has('serial') ? 'has-error' : '' }}">
                                <label for="serial" class="col-md-4 control-label">課程編號</label>

                                <div class="col-md-6">
                                    <input type="text" name="serial" id="serial" class="form-control" value="{{ old('serial') }}" required>

                                    @if($errors->has('serial'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('serial') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">課程名稱</label>

                                <div class="col-md-6">
                                    <input type="text" name="name" id ="name" class="form-control" value="{{ old('name') }}" required>

                                    @if($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('start_at') ? 'has-error' : '' }}">
                                <label for="start_at" class="col-md-4 control-label">課程開始日期</label>

                                <div class="col-md-6">
                                    <input type="text" name="start_at" id="start_at" class="form-control datepicker" value="{{ old('start_at') }}" required>

                                    @if($errors->has('start_at'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('start_at') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group" {{ $errors->has('end_at') ? 'has-error' : '' }}>
                                <label for="end_at" class="col-md-4 control-label">課程結束日期</label>

                                <div class="col-md-6">
                                    <input type="text" name="end_at" id="end_at" class="form-control datepicker" value="{{ old('end_at') }}">

                                    @if($errors->has('start_at'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('ent_at') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button class="btn btn-primary">新增課程</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
