@extends('layout.main')

@section('title')
  New Vinyl
@stop

@section('body')
  <div class="container create-vinyl">
    <?php
      if($search){
        $type = $vinyl['type'];
        $artist = $vinyl['artists'][0]['name'];
        $title = $vinyl['title'];
        $artwork = str_replace('api.discogs.com/image/R-','s.pixogs.com/image/R-',$vinyl['images'][0]['uri']);
        if($vinyl['videos'][0]['uri']){
          $video = $vinyl['videos'][0]['uri'];
          $videoId = substr($video, -11);
        }
        else{
          $video = null;
        }
        $label = $vinyl['labels'][0]['name'];
        $catno = $vinyl['labels'][0]['catno'];
        $genres = implode(';', $vinyl['genres']);
        $year = $vinyl['released_formatted'];
        $country = $vinyl['country'];
        $count = $vinyl['formats'][0]['qty'];
        $tracklistItems = $vinyl['tracklist'];
        $tmp_tracklist = [];
        foreach ($tracklistItems as $item) {
          array_push($tmp_tracklist, $item['position'] . ' ' . $item['title'] . ' ' . $item['duration']);
        }
        $tracklist = implode(';', $tmp_tracklist);
        $weight = $vinyl['estimated_weight'];
      }
      else{
        $type = 'release';
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
        $weight = null;
        $catno = null;
      }
    ?>

    <div class="row">
      {{ Form::open(array('route' => 'post-create-vinyl')) }}
      <!-- Artwork and Videos -->
      <div class="col-md-4">
        <div class="well">
          <legend>Artwork and Videos</legend>
          <div class="thumbnail">
            @if(@getimagesize($artwork))
              <img src="{{ $artwork }}" id="vinyl-artwork" alt="{{ $artist }} - {{ $title }}">
            @else
              <img src="{{ VINYL_PH_PATH }}" id="vinyl-artwork" alt="placeholder">
              <?php $artwork = VINYL_PH_PATH; ?>
            @endif
          </div>
          <div class="form-group">
            {{ Form::label('artwork', 'Paste Artwork URL') }}
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
            <legend>General Data</legend>

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
                {{ Form::label('weight', 'Estimated Weight') }}
                {{ Form::text('weight', $weight, array('class' => 'form-control', 'placeholder' => 'Enter estimated weight')); }}

                @if($errors->has('weight'))
                  <div class="alert alert-danger">
                    {{ $errors->first('weight') }}
                  </div>
                @endif
              </div>

              <div class="form-group">
                {{ Form::label('catno', 'Catalog Number') }}
                {{ Form::text('catno', $catno, array('class' => 'form-control', 'placeholder' => 'Enter catalog number')); }}

                @if($errors->has('catno'))
                  <div class="alert alert-danger">
                    {{ $errors->first('catno') }}
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
          <legend>Release Data</legend>

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
            {{ Form::label('releasetype', 'Release type') }}
            {{ Form::select('releasetype', array('EP' => 'EP', 'LP' => 'LP', 'RE' => 'RE', 'Single' => 'Single'), 'EP', array('class' => 'form-control')); }}

            @if($errors->has('notes'))
              <div class="alert alert-danger">
                {{ $errors->first('notes') }}
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
    {{ Form::submit('Add Vinyl', array('class' => 'btn btn-primary btn-lg pull-right')) }}
    {{ Form::close() }}
  </div>
@stop

