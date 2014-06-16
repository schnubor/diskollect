@extends('layout.main')

@section('title')
  New Vinyl
@stop

@section('body')
  <?php
    // Discogs
    $service = new \Discogs\Service();

    $data = Input::all();
    $id = $data['id'];
    $type = $data['type'];

    if($type == 'release'){
      $release = $service->getRelease($id);
    }
    else{
      $release = $service->getMaster($id);
    }

    $artist = $release->getArtists()[0]->getName();
    $title = $release->getTitle();
    $labels = $release->getLabels();
    $year = $release->getYear();
    $country = $release->getCountry();

  ?>

  <div class="page-header">
    <h1>Add new vinyl</h1>
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="form-wrapper">
        {{ Form::open(array('url' => 'vinyls/create')) }}
          <div class="form-group">
            {{ Form::label('artist', 'Artist') }}
            {{ Form::text('artist', $artist, array('class' => 'form-control', 'placeholder' => 'Enter artist name' )); }}

            @if($errors->has('artist'))
              <div class="alert alert-danger">
                {{ $errors->first('artist') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('title', 'Title') }}
            {{ Form::text('title', $title, array('class' => 'form-control', 'placeholder' => 'Enter vinyl title')); }}

            @if($errors->has('title'))
              <div class="alert alert-danger">
                {{ $errors->first('title') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('labels', 'Labels') }}
            {{ Form::text('labels', $title, array('class' => 'form-control', 'placeholder' => 'Columbia, Virgin, Universal')); }}

            @if($errors->has('labels'))
              <div class="alert alert-danger">
                {{ $errors->first('labels') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('genres', 'Genres') }}
            {{ Form::text('genres', $title, array('class' => 'form-control', 'placeholder' => 'Columbia, Virgin, Universal')); }}

            @if($errors->has('genres'))
              <div class="alert alert-danger">
                {{ $errors->first('genres') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('year', 'Release year') }}
            {{ Form::text('year', $year, array('class' => 'form-control', 'placeholder' => 'Enter release year')); }}

            @if($errors->has('year'))
              <div class="alert alert-danger">
                {{ $errors->first('year') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('country', 'Country') }}
            {{ Form::text('country', $country, array('class' => 'form-control', 'placeholder' => 'Enter country')); }}

            @if($errors->has('country'))
              <div class="alert alert-danger">
                {{ $errors->first('country') }}
              </div>
            @endif
          </div>
          
          {{ Form::hidden('user_id', Auth::user()->id) }}

      </div>
    </div>
  </div>

  <hr>
  {{ Form::submit('Add Vinyl', array('class' => 'btn btn-primary')) }}
  {{ Form::close() }}
@stop

