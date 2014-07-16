@extends('layout.main')

@section('title')
  Recover Password
@stop

@section('body')
  {{ Form::open(array('route' => 'post-forgot-password')) }}
    <div class="row">
      <div class="col-md-4 col-md-offset-4 well">
        <legend>Recover Password</legend>
        <div class="form-group">
          {{ Form::label('email', 'Enter your Email adress') }}
          {{ Form::email('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Enter your old password')); }}

          @if($errors->has('email'))
            <div class="alert alert-danger">
              {{ $errors->first('email') }}
            </div>
          @endif
        </div>

        {{ Form::submit('Send new password', array('class' => 'btn btn-primary')) }}
      </div>
    </div>

  {{ Form::close() }}
@stop