@extends('layout.main')

@section('title')
  New Vinyl
@stop

@section('body')
  <div class="container">
    <?php

      if($data = Input::all()){
        // --- get release from Discogs ----------
        $service = new \Discogs\Service();

        $id = $data['id'];
        $type = $data['type'];

        if($type == 'release'){
          $release = $service->getRelease($id);
        }
        else{
          $release = $service->getRelease($service->getMaster($id)->getMainRelease());
        }

        // --- get release data ------------------

        $artist = $release->getArtists()[0]->getName();
        $title = $release->getTitle();

        $artwork = str_replace('api.discogs.com/image/R-','s.pixogs.com/image/R-',$release->getImages()[0]->getUri());
        if($release->getVideos()[0]){
          $video = $release->getVideos()[0]->getUri();
          $videoId = substr($video, -11);
        }
        else{
          $video = null;
        }

        // fetch ALL labels

        /*$labelsObj = $release->getLabels();
        $tmp_labels = [];
        foreach ($labelsObj as $label) {
          array_push($tmp_labels, $label->getName());
        }
        $labels = implode(';', $tmp_labels);*/

        $label = $release->getLabels()[0]->getName();
        $genres = implode(';', $release->getGenres());
        $year = $release->getReleased();
        $country = $release->getCountry();
        $count = $release->getFormats()[0]->qty;
        $tracklistItems = $release->getTracklist();
        $tmp_tracklist = [];
        foreach ($tracklistItems as $item) {
          array_push($tmp_tracklist, $item->getPosition() . ' ' . $item->getTitle() . ' ' . $item->getDuration());
        }
        $tracklist = implode(';', $tmp_tracklist);
      }
      else{
        $id = null;
        $type = null;
        $artist = null;
        $title = null;
        $artwork = null;
        $video = null;
        $videoId = null;
        $label = null;
        $genres = null;
        $year = null;
        $country = null;
        $count = null;
        $tracklist = null;
      }

    ?>

    <div class="row">
      {{ Form::open(array('route' => 'post-create-vinyl')) }}
      <!-- Artwork and Videos -->
      <div class="col-md-4">
        <div class="well">
          <legend>Artwork and Videos</legend>
          <div class="thumbnail">
            <img src="{{ $artwork }}" id="vinyl-artwork">
          </div>
          <div class="form-group">
            {{ Form::label('artwork', 'Artwork URL') }}
            {{ Form::text('artwork', $artwork, array('class' => 'form-control', 'id' => 'vinyl-artwork-url', 'placeholder' => 'Paste Artwork URL')) }}
          </div>
          @if($video != null)
            <div class="thumbnail">
              <iframe width="300" height="169" src="//www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
            </div>
          @endif
        </div>
      </div>

      <!-- Fetched Data -->
      <div class="col-md-4">
        <div class="well">
          <div class="form-wrapper">
            <legend>Fetched Data</legend>


              <div class="form-group">
                {{ Form::label('artist', 'Artist') }} <span style="color: red;">*</span>
                {{ Form::text('artist', $artist, array('class' => 'form-control', 'placeholder' => 'Enter artist name' )); }}

                @if($errors->has('artist'))
                  <div class="alert alert-danger">
                    {{ $errors->first('artist') }}
                  </div>
                @endif
              </div>

              <div class="form-group">
                {{ Form::label('title', 'Title') }} <span style="color: red;">*</span>
                {{ Form::text('title', $title, array('class' => 'form-control', 'placeholder' => 'Enter vinyl title')); }}

                @if($errors->has('title'))
                  <div class="alert alert-danger">
                    {{ $errors->first('title') }}
                  </div>
                @endif
              </div>

              <div class="form-group">
                {{ Form::label('label', 'Labels') }}
                {{ Form::text('label', $label, array('class' => 'form-control', 'placeholder' => 'Columbia, Virgin, Universal')); }}

                @if($errors->has('label'))
                  <div class="alert alert-danger">
                    {{ $errors->first('label') }}
                  </div>
                @endif
              </div>

              <div class="form-group">
                {{ Form::label('genre', 'Genres') }}
                {{ Form::text('genre', $genres, array('class' => 'form-control', 'placeholder' => 'Columbia, Virgin, Universal')); }}

                @if($errors->has('genre'))
                  <div class="alert alert-danger">
                    {{ $errors->first('genre') }}
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
            {{ Form::label('price', 'Price in '.$user->currency) }} <span style="color: red;">*</span>
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

          <div class="form-group">
            {{ Form::label('size', 'Size') }}
            {{ Form::select('size', array('7' => '7"', '10' => '10"', '12' => '12"'), '12', array('class' => 'form-control')); }}

            @if($errors->has('size'))
              <div class="alert alert-danger">
                {{ $errors->first('size') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('count', 'Count') }}
            {{ Form::text('count', $count, array('class' => 'form-control', 'placeholder' => 'Quantity of vinyls')); }}

            @if($errors->has('count'))
              <div class="alert alert-danger">
                {{ $errors->first('count') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            {{ Form::label('notes', 'Notes') }}
            {{ Form::text('notes', Input::old('notes'), array('class' => 'form-control', 'placeholder' => '140 characters')); }}

            @if($errors->has('notes'))
              <div class="alert alert-danger">
                {{ $errors->first('notes') }}
              </div>
            @endif
          </div>

        </div>
      </div>
    </div>

    <hr>
    {{ Form::submit('Add Vinyl', array('class' => 'btn btn-primary pull-right')) }}
    {{ Form::close() }}
  </div>
@stop

