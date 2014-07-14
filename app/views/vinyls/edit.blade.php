@extends('layout.main')

@section('title')
  Edit Vinyl
@stop

@section('body')

  <div class="row">
    {{ Form::model($vinyl, array('route' => array('update-vinyl', $vinyl->id), 'method' => 'PUT', 'files' => true)) }}
    <!-- Artwork and Videos -->
    <div class="col-md-4">
      <div class="well">
        <legend>Artwork and Videos</legend>
        <div class="thumbnail">
          <img src="{{ $vinyl->artwork }}" id="vinyl-artwork">
        </div>
        <div class="form-group">
          {{ Form::label('artwork', 'Artwork URL') }}
          {{ Form::text('artwork', $vinyl->artwork, array('class' => 'form-control', 'id' => 'vinyl-artwork-url', 'placeholder' => 'Paste Artwork URL')) }}
        </div>
        @if($vinyl->videos != null)
          <?php
            $videoId = substr($vinyl->videos, -11);
          ?>
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
              {{ Form::text('artist', $vinyl->artist, array('class' => 'form-control', 'placeholder' => 'Enter artist name' )); }}

              @if($errors->has('artist'))
                <div class="alert alert-danger">
                  {{ $errors->first('artist') }}
                </div>
              @endif
            </div>

            <div class="form-group">
              {{ Form::label('title', 'Title') }} <span style="color: red;">*</span>
              {{ Form::text('title', $vinyl->title, array('class' => 'form-control', 'placeholder' => 'Enter vinyl title')); }}

              @if($errors->has('title'))
                <div class="alert alert-danger">
                  {{ $errors->first('title') }}
                </div>
              @endif
            </div>

            <div class="form-group">
              {{ Form::label('label', 'Labels') }}
              {{ Form::text('label', $vinyl->label, array('class' => 'form-control', 'placeholder' => 'Columbia, Virgin, Universal')); }}

              @if($errors->has('label'))
                <div class="alert alert-danger">
                  {{ $errors->first('label') }}
                </div>
              @endif
            </div>

            <div class="form-group">
              {{ Form::label('genre', 'Genres') }}
              {{ Form::text('genre', $vinyl->genre, array('class' => 'form-control', 'placeholder' => 'Electronic; House')); }}

              @if($errors->has('genre'))
                <div class="alert alert-danger">
                  {{ $errors->first('genre') }}
                </div>
              @endif
            </div>

            <div class="form-group">
              {{ Form::label('year', 'Release year') }}
              {{ Form::text('year', $vinyl->year, array('class' => 'form-control', 'placeholder' => 'Enter release year')); }}

              @if($errors->has('year'))
                <div class="alert alert-danger">
                  {{ $errors->first('year') }}
                </div>
              @endif
            </div>

            <div class="form-group">
              {{ Form::label('country', 'Country') }}
              {{ Form::text('country', $vinyl->country, array('class' => 'form-control', 'placeholder' => 'Enter country')); }}

              @if($errors->has('country'))
                <div class="alert alert-danger">
                  {{ $errors->first('country') }}
                </div>
              @endif
            </div>

            <div class="form-group">
              {{ Form::label('tracklist', 'Tracklist') }}
              {{ Form::text('tracklist', $vinyl->tracklist, array('class' => 'form-control', 'placeholder' => 'Enter tracklist')); }}

              @if($errors->has('tracklist'))
                <div class="alert alert-danger">
                  {{ $errors->first('tracklist') }}
                </div>
              @endif
            </div>
            
            {{ Form::hidden('videos', $vinyl->video) }}
            {{ Form::hidden('type', $vinyl->type) }}
            {{ Form::hidden('user_id', Auth::user()->id) }}

        </div>
      </div>
    </div>

    <!-- User Data -->
    <div class="col-md-4">
      <div class="well">
        <legend>Your Data</legend>

        <div class="form-group">
          {{ Form::label('price', 'Price') }} <span style="color: red;">*</span>
          {{ Form::text('price', round($vinyl->price, 2), array('class' => 'form-control', 'placeholder' => 'What did you pay?')); }}

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
          {{ Form::select('size', array('7' => '7"', '10' => '10"', '12' => '12"'), $vinyl->size, array('class' => 'form-control')); }}

          @if($errors->has('size'))
            <div class="alert alert-danger">
              {{ $errors->first('size') }}
            </div>
          @endif
        </div>

        <div class="form-group">
          {{ Form::label('count', 'Count') }}
          {{ Form::text('count', $vinyl->count, array('class' => 'form-control', 'placeholder' => 'Quantity of vinyls')); }}

          @if($errors->has('count'))
            <div class="alert alert-danger">
              {{ $errors->first('count') }}
            </div>
          @endif
        </div>

        <div class="form-group">
          {{ Form::label('notes', 'Notes') }}
          {{ Form::text('notes', $vinyl->notes, array('class' => 'form-control', 'placeholder' => '140 characters')); }}

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
  {{ Form::submit('Edit Vinyl', array('class' => 'btn btn-primary pull-right')) }}
  {{ Form::close() }}
@stop

