@extends('layouts.default')
@section('title','重置密码')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">重置密码</div>
        <div class="panel-body">
          @if (session('status'))
          <div class="alert alert-success">
            {{ session('status') }}
          </div>
          @endif
          <form method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}

            <div class="form-group">
              <label class="col-md-4 control-label">邮箱地址：</label>
              <div class="col-md-6">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
              </div>
            </div>
            @if ($errors->has('email'))
            <div class="form-group has-error">
              <span class="form-text">
                <strong>{{ $errors->first('email') }}</strong>
              </span>
            </div>
            @endif
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  重置
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
