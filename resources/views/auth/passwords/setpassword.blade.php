@extends('la.layouts.auth')

@section('htmlheader_title')
Set New Password
@endsection

@section('content')

<body class="login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{ url('/') }}"><b>{{ LAConfigs::getByKey('sitename_part1') }} </b>{{ LAConfigs::getByKey('sitename_part2') }}</a>
  </div><!-- /.login-logo -->

  @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif

  @if (count($errors) > 0)
    <div class="alert alert-danger">
      <strong>Whoops!</strong> There were some problems with your input.<br><br>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="login-box-body">
    <p class="login-box-msg">Set New Password</p>
    <form action="{{ url(config('laraadmin.adminRoute') . '/setpass') }}" method="post" autocomplete="off">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="form-group has-feedback">
        <input type="password" name="new_password" value="" id="password" class="form-control" placeholder="Password" autocomplete="off" required="required" data-rule-minlength="6" data-msg-minlength="Please enter at least 6 characters.">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback">
        <input type="password" name="password_confirmation" value="" id="password_confirmation" class="form-control" placeholder="Retype password" autocomplete="off" required="required" data-rule-equalto="#password" data-msg-equalto="Please enter the same value again.">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="row">
        <div class="col-xs-2">
        </div><!-- /.col -->
        <div class="col-xs-8">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Set password</button>
        </div><!-- /.col -->
        <div class="col-xs-2">
        </div><!-- /.col -->
      </div>
    </form>

  </div><!-- /.login-box-body -->

</div><!-- /.login-box -->

@include('la.layouts.partials.scripts_auth')

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>

@endsection
