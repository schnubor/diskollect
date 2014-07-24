@extends('layout.main')

@section('title')
  Search Vinyl
@stop

@section('body')
  <div class="container">
    <div class="page-header">
      <h1>Search Vinyl</h1>
    </div>

    <div class="row">
      <div class="col-md-3">
        <div class="well" style="margin-bottom: 0;">
          <div class="form-wrapper">
            {{ Form::open(array('url' => 'search')) }}
              <div class="form-group">
                {{ Form::label('artist', 'Artist') }}
                {{ Form::text('artist', Input::old('artist'), array('class' => 'form-control')); }}

                @if($errors->has('artist'))
                  <div class="alert alert-danger">
                    {{ $errors->first('artist') }}
                  </div>
                @endif
              </div>
              <div class="form-group">
                {{ Form::label('title', 'Title') }}
                {{ Form::text('title', Input::old('title'), array('class' => 'form-control')); }}

                @if($errors->has('title'))
                  <div class="alert alert-danger">
                    {{ $errors->first('title') }}
                  </div>
                @endif
              </div>

              {{ Form::submit('Search', array('class' => 'btn btn-primary')) }}
            {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-3">
        <hr>
        <a href="{{ URL::route('get-create-vinyl') }}" class="btn btn-lg btn-primary" style="width: 100%"><i class="fa fa-plus fa-fw"></i> Add manually</a>
      </div>
    </div>
  </div>
@stop

