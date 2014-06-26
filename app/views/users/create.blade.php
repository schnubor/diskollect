@extends('layout.main')

@section('title')
  Registration
@stop

@section('body')
  <div class="row">
    <div class="col-lg-offset-4 col-md-4 well">
      <legend>Registration</legend>
      <div class="form-wrapper">
        {{ Form::open(array('route' => 'post-user-create')) }}
          <div class="form-group">
            {{ Form::label('username', 'User name') }}
            {{ Form::text('username', Input::old('username'), array('class' => 'form-control', 'placeholder' => 'Enter your user name')); }}

            @if($errors->has('username'))
              <div class="alert alert-danger">
                {{ $errors->first('username') }}
              </div>
            @endif
          </div>
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
            {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Choose a password')); }}

            @if($errors->has('password'))
              <div class="alert alert-danger">
                {{ $errors->first('password') }}
              </div>
            @endif
          </div>
          <div class="form-group">
            {{ Form::label('password_again', 'Confirm password') }}
            {{ Form::password('password_again', array('class' => 'form-control', 'placeholder' => 'Enter password again')); }}

            @if($errors->has('password_again'))
              <div class="alert alert-danger">
                {{ $errors->first('password_again') }}
              </div>
            @endif
          </div>

          {{ Form::submit('Sign up', array('class' => 'btn btn-primary')) }}
        {{ Form::close() }}
      </div>
    </div>
  </div>
@stop

