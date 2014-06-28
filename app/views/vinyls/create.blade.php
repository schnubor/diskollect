@extends('layout.main')

@section('title')
  New Vinyl
@stop

@section('body')
  <?php
    // --- get release from Discogs ----------
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

    // --- get release data ------------------ 

    $artist = $release->getArtists()[0]->getName();
    $title = $release->getTitle();

    $artwork = str_replace('api.discogs.com/image/R-','s.pixogs.com/image/R-',$release->getImages()[0]->getUri());
    $video = $release->getVideos()[0]->getUri();
    $videoId = substr($video, -11);

    // fetch ALL labels

    /*$labelsObj = $release->getLabels();
    $tmp_labels = [];
    foreach ($labelsObj as $label) {
      array_push($tmp_labels, $label->getName());
    }
    $labels = implode(';', $tmp_labels);*/

    $label = $release->getLabels()[0]->getName();
    $genres = implode(';', $release->getGenres());
    $year = $release->getYear();
    $country = $release->getCountry();
    $tracklistItems = $release->getTracklist();
    $tmp_tracklist = [];
    foreach ($tracklistItems as $item) {
      array_push($tmp_tracklist, $item->getPosition() . ' ' . $item->getTitle() . ' ' . $item->getDuration());
    }
    $tracklist = implode(';', $tmp_tracklist);

  ?>

  <div class="row">
    <!-- Artwork and Videos -->
    <div class="col-md-4">
      <div class="well">
        <legend>Artwork and Videos</legend>
        <div class="thumbnail">
          <img src="{{ $artwork }}" alt="Cover">
        </div>
        <div class="thumbnail">
          <iframe width="300" height="169" src="//www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>
    </div>

    <!-- Fetched Data -->
    <div class="col-md-4">
      <div class="well">
        <div class="form-wrapper">
          <legend>Fetched Data</legend>

          {{ Form::open(array('route' => 'post-create-vinyl')) }}
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
              {{ Form::text('labels', $label, array('class' => 'form-control', 'placeholder' => 'Columbia, Virgin, Universal')); }}

              @if($errors->has('labels'))
                <div class="alert alert-danger">
                  {{ $errors->first('labels') }}
                </div>
              @endif
            </div>

            <div class="form-group">
              {{ Form::label('genres', 'Genres') }}
              {{ Form::text('genres', $genres, array('class' => 'form-control', 'placeholder' => 'Columbia, Virgin, Universal')); }}

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

            <div class="form-group">
              {{ Form::label('tracklist', 'Tracklist') }}
              {{ Form::text('tracklist', $tracklist, array('class' => 'form-control', 'placeholder' => 'Enter tracklist')); }}

              @if($errors->has('tracklist'))
                <div class="alert alert-danger">
                  {{ $errors->first('tracklist') }}
                </div>
              @endif
            </div>
            
            {{ Form::hidden('artwork', $artwork) }}
            {{ Form::hidden('videos', $video) }}
            {{ Form::hidden('type', $type) }}
            {{ Form::hidden('user_id', Auth::user()->id) }}

        </div>
      </div>
    </div>

    <!-- User Data -->
    <div class="col-md-4">
      <div class="well">
        <legend>Your Data</legend>

        <div class="form-group">
          {{ Form::label('price', 'Price') }}
          {{ Form::text('price', Input::old('price'), array('class' => 'form-control', 'placeholder' => 'What did you pay?')); }}

          @if($errors->has('price'))
            <div class="alert alert-danger">
              {{ $errors->first('price') }}
            </div>
          @endif
        </div>

        <div class="form-group">
          {{ Form::label('color', 'Color') }}
          {{ Form::color() }}

          @if($errors->has('price'))
            <div class="alert alert-danger">
              {{ $errors->first('price') }}
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <hr>
  {{ Form::submit('Add Vinyl', array('class' => 'btn btn-primary pull-right')) }}
  {{ Form::close() }}
@stop

