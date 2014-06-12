@extends('layout.main')

@section('title')
  New vinyl
@stop

@section('body')
  <div class="page-header">
    <h1>Add new vinyl</h1>
  </div>

  <div class="form-wrapper">
    {{ Form::open(array('url' => 'vinyls/create')) }}
      <div class="form-group">
        {{ Form::label('artist', 'Artist') }}
        {{ Form::text('username', Input::old('username'), array('class' => 'form-control', 'placeholder' => 'Enter your user name')); }}

        @if($errors->has('username'))
          <div class="alert alert-danger">
            {{ $errors->first('username') }}
          </div>
        @endif
      </div>
      <div class="form-group">
        {{ Form::label('email', 'Email adress') }}
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

      {{ Form::submit('Add Vinyl', array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
  </div>
@stop

