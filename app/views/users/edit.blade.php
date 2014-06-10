@extends('layout.main')

@section('title')
  Settings
@stop

@section('body')
  <div class="page-header">
    <h1>Edit Profile</h1>
  </div>

  <div class="form-wrapper">
    {{ Form::model($user, array('route' => array('update-user', $user->id), 'method' => 'PUT', 'files' => true)) }}
      <div class="form-group">
        {{ Form::label('profilepic', 'Profile Picture') }}
        {{ Form::file('profilepic', array('class' => 'form-control')); }}

        @if($errors->has('profilepic'))
          <div class="alert alert-danger">
            {{ $errors->first('profilepic') }}
          </div>
        @endif
      </div>
      <div class="form-group">
        {{ Form::label('name', 'Name') }}
        {{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'placeholder' => 'Your real name')); }}

        @if($errors->has('name'))
          <div class="alert alert-danger">
            {{ $errors->first('name') }}
          </div>
        @endif
      </div>
      <div class="form-group">
        {{ Form::label('location', 'Location') }}
        {{ Form::text('location', Input::old('location'), array('class' => 'form-control', 'placeholder' => 'Your current location')); }}

        @if($errors->has('location'))
          <div class="alert alert-danger">
            {{ $errors->first('location') }}
          </div>
        @endif
      </div>
      <div class="form-group">
        {{ Form::label('website', 'Website') }}
        {{ Form::text('website', Input::old('website'), array('class' => 'form-control', 'placeholder' => 'http://www.example.com')); }}

        @if($errors->has('website'))
          <div class="alert alert-danger">
            {{ $errors->first('website') }}
          </div>
        @endif
      </div>
      <div class="form-group">
        {{ Form::label('description', 'Description') }}
        {{ Form::text('description', Input::old('description'), array('class' => 'form-control', 'placeholder' => '140 characters description')); }}

        @if($errors->has('description'))
          <div class="alert alert-danger">
            {{ $errors->first('description') }}
          </div>
        @endif
      </div>

      {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
  </div>
@stop

