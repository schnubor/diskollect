@extends('layout.main')

@section('title')
  Add Vinyl
@stop

<?php
  $user = User::find(Auth::user()->id);
?>

@section('body')
  <div class="jumbotron search-form" style="margin-top: -20px;">
    <div class="container">
      <div class="well col-md-7" style="margin-bottom: 0;">
        <legend>Search on Discogs</legend>
        @if($user->discogs_access_token)
          <div class="form-wrapper">
            {{ Form::open(array('url' => 'search', 'class' => 'form-inline')) }}
              <div class="form-group">
                {{ Form::text('artist', Input::old('artist'), array('class' => 'form-control', 'placeholder' => 'Artist')); }}

                @if($errors->has('artist'))
                  <div class="alert alert-danger">
                    {{ $errors->first('artist') }}
                  </div>
                @endif
              </div>
              <div class="form-group">
                {{ Form::text('title', Input::old('title'), array('class' => 'form-control', 'placeholder' => 'Title')); }}

                @if($errors->has('title'))
                  <div class="alert alert-danger">
                    {{ $errors->first('title') }}
                  </div>
                @endif
              </div>

              {{ Form::submit('Search', array('class' => 'btn btn-primary')) }}
            {{ Form::close() }}
          </div>
        @else
          <p>You need to authenticate with Discogs before using this feature.</p>
          <a href="{{ URL::route('get-oAuthDiscogs') }}" class="btn btn-primary"><i class="fa fa-fw fa-exchange"></i> oAuth with Discogs</a>
        @endif
      </div>

      <div class="col-md-2">
        <div class="or">- OR -</div>
      </div>

      <div class="col-md-3 well">
        <legend>Add manually</legend>
        <a href="{{ URL::route('get-create-vinyl') }}" class="btn btn-md btn-block btn-info"><i class="fa fa-plus fa-fw"></i> Add manually</a>
      </div>
    </div>
  </div>
@stop

