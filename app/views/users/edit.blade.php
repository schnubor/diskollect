@extends('layout.main')

@section('title')
  Settings
@stop

@section('body')

  <div class="row">
    <div class="col-md-6 col-md-offset-3 well">
      <legend>Edit Profile</legend>
      <div class="form-wrapper">
        {{ Form::model($user, array('route' => array('update-user', $user->id), 'method' => 'PUT', 'files' => true, 'class' => 'form-horizontal')) }}
          <div class="form-group">
            {{ Form::label('profilepic', 'Profile Picture', array('class' => 'col-sm-3 control-label')) }}
            <div class="col-sm-9">
              {{ Form::file('profilepic', array('class' => 'form-control')); }}
            </div>

            @if($errors->has('profilepic'))
              <div class="alert alert-danger">
                {{ $errors->first('profilepic') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('name', 'Name', array('class' => 'col-sm-3 control-label')) }}
            <div class="col-sm-9">
              {{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'placeholder' => 'Your real name')); }}
            </div>

            @if($errors->has('name'))
              <div class="alert alert-danger">
                {{ $errors->first('name') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('location', 'Location', array('class' => 'col-sm-3 control-label')) }}
            <div class="col-sm-9">
              {{ Form::text('location', Input::old('location'), array('class' => 'form-control', 'placeholder' => 'Your current location')); }}
            </div>

            @if($errors->has('location'))
              <div class="alert alert-danger">
                {{ $errors->first('location') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('website', 'Website', array('class' => 'col-sm-3 control-label')) }}
            <div class="col-sm-9">
              {{ Form::text('website', Input::old('website'), array('class' => 'form-control', 'placeholder' => 'http://www.example.com')); }}
            </div>

            @if($errors->has('website'))
              <div class="alert alert-danger">
                {{ $errors->first('website') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('description', 'Description', array('class' => 'col-sm-3 control-label')) }}
            <div class="col-sm-9">
              {{ Form::text('description', Input::old('description'), array('class' => 'form-control', 'placeholder' => '140 characters description')); }}
            </div>

            @if($errors->has('description'))
              <div class="alert alert-danger">
                {{ $errors->first('description') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('currency', 'Currency', array('class' => 'col-sm-3 control-label')) }}
            <div class="col-sm-9">
              {{ Form::select('currency', array('EUR' => '&euro; - Euro', 'USD' => '&#36; - United States Dollar', 'GBP' => '&pound; - Great Britain Pound'), 'EUR', array('class' => 'form-control')) }}
            </div>

            @if($errors->has('description'))
              <div class="alert alert-danger">
                {{ $errors->first('description') }}
              </div>
            @endif
          </div>

          {{ Form::submit('Update Profile', array('class' => 'btn btn-primary pull-right')) }}
        {{ Form::close() }}
      </div>
    </div>
  </div> 
@stop

