@extends('layout.main')

@section('title')
  Sign in
@stop

@section('body')
  <div class="row">
    <div class="col-lg-offset-4 col-md-4 well">
      <legend>Please Sign In</legend>
      @if(Session::has('login-alert'))
        <div class="alert alert-danger alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {{ Session::get('login-alert') }}
        </div>
      @endif
      {{ Form::open(array('route' => 'post-signin')) }}

        <div class="form-group">
          {{ Form::label('email', 'Email address') }}
          {{ Form::email('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'example@mail.com')); }}

          @if($errors->has('email'))
            <div class="alert alert-danger">
              {{ $errors->first('email') }}
            </div>
          @endif
        </div>
        <div class="form-group">
          {{ Form::label('password', 'Password') }}
          {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Enter your password')); }}

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
@stop