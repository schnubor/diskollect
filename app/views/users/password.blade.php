@extends('layout.main')

@section('title')
  Change Password
@stop

@section('body')
  {{ Form::open(array('url' => 'users/change-password')) }}

    <div class="form-group">
      {{ Form::label('old_password', 'Old password') }}
      {{ Form::password('old_password', array('class' => 'form-control', 'placeholder' => 'Enter your old password')); }}

      @if($errors->has('old_password'))
        <div class="alert alert-danger">
          {{ $errors->first('old_password') }}
        </div>
      @endif
    </div>

    <div class="form-group">
      {{ Form::label('password', 'New password') }}
      {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Enter your new password')); }}

      @if($errors->has('password'))
        <div class="alert alert-danger">
          {{ $errors->first('password') }}
        </div>
      @endif
    </div>

    <div class="form-group">
      {{ Form::label('password_again', 'Confirm new password') }}
      {{ Form::password('password_again', array('class' => 'form-control', 'placeholder' => 'Enter your new password again')); }}

      @if($errors->has('password_again'))
        <div class="alert alert-danger">
          {{ $errors->first('password_again') }}
        </div>
      @endif
    </div>

    {{ Form::submit('Change password', array('class' => 'btn btn-primary')) }}

  {{ Form::close() }}
@stop