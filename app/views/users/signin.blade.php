@extends('layout.main')

@section('title')
  Sign in
@stop

@section('body')
<div class="container">
  <div class="row">
    <div class="col-md-offset-4 col-md-4 well">
      <legend>Please Sign In</legend>
      @if(Session::has('login-alert'))
        <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {{ Session::get('login-alert') }}
        </div>
      @endif
      {{ Form::open(array('route' => 'post-signin')) }}

        <div class="form-group">
          {{ Form::label('user-email', 'Username or Email') }}
          {{ Form::text('user-email', Input::old('user-email'), array('class' => 'form-control')); }}

          @if($errors->has('email'))
            <div class="alert alert-danger">
              {{ $errors->first('email') }}
            </div>
          @endif
        </div>
        <div class="form-group">
          {{ Form::label('password', 'Password') }}
          {{ Form::password('password', array('class' => 'form-control')); }}
          <small class="pull-right"><a href="{{ URL::route('get-forgot-password') }}">Forgot Password?</a></small><br>

          @if($errors->has('password'))
            <div class="alert alert-danger">
              {{ $errors->first('password') }}
            </div>
          @endif
        </div>

        <div class="checkbox">
          {{ Form::checkbox('remember', 'value', null, array('id' => 'remember')); }}
          {{ Form::label('remember', 'Remember me') }}
        </div>

        {{ Form::submit('Sign in', array('class' => 'btn btn-primary')) }}

      {{ Form::close() }}
    </div>
  </div>
</div>
@stop
