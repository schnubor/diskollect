@extends('layout.main')

@section('title')
  Registration
@stop

@section('body')
  <div class="row">
    <div class="col-lg-offset-3 col-md-6 well">
      <legend>Registration</legend>
      <div class="form-wrapper">
        {{ Form::open(array('route' => 'post-user-create', 'class' => 'form-horizontal')) }}
          <div class="form-group">
            {{ Form::label('username', 'User name', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-8">
              {{ Form::text('username', Input::old('username'), array('class' => 'form-control', 'placeholder' => 'Enter your user name')); }}
            </div>

            @if($errors->has('username'))
              <div class="alert alert-danger">
                {{ $errors->first('username') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('email', 'Email address', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-8">
              {{ Form::email('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'example@mail.com')); }}
            </div>

            @if($errors->has('email'))
              <div class="alert alert-danger">
                {{ $errors->first('email') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('currency', 'Currency', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-8">
              {{ Form::select('currency', array('EUR' => '&euro; - Euro', 'USD' => '&#36; - United States Dollar', 'GBP' => '&pound; - Great Britain Pound'), 'EUR', array('class' => 'form-control')) }}
            </div>

            @if($errors->has('description'))
              <div class="alert alert-danger">
                {{ $errors->first('description') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('password', 'Password', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-8">
              {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Choose a password')); }}
            </div>

            @if($errors->has('password'))
              <div class="alert alert-danger">
                {{ $errors->first('password') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('password_again', 'Confirm password', array('class' => 'col-sm-4 control-label')) }}
            <div class="col-sm-8">
              {{ Form::password('password_again', array('class' => 'form-control', 'placeholder' => 'Enter password again')); }}
            </div>

            @if($errors->has('password_again'))
              <div class="alert alert-danger">
                {{ $errors->first('password_again') }}
              </div>
            @endif
          </div>

          {{ Form::submit('Sign up', array('class' => 'btn btn-primary pull-right')) }}
        {{ Form::close() }}
      </div>
    </div>
  </div>
@stop

