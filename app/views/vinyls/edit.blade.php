@extends('layout.main')

@section('title')
  Edit Vinyl
@stop

@section('body')
  <div class="container create-vinyl">
    <div class="row">
      {{ Form::model($vinyl, array('route' => array('update-vinyl', $vinyl->id), 'method' => 'PUT', 'files' => true)) }}
      <!-- Artwork and Videos -->
      <div class="col-md-4">
        <div class="well">
          <legend>Artwork and Videos</legend>
          <div class="thumbnail">
            @if(@getimagesize($vinyl->artwork))
              <img src="{{ $vinyl->artwork }}" id="vinyl-artwork" alt="{{ $vinyl->artist }} - {{ $vinyl->title }}">
            @else
              <img src="{{ VINYL_PH_PATH }}" id="vinyl-artwork" alt="placeholder">
              <?php $vinyl->artwork = VINYL_PH_PATH; ?>
            @endif
          </div>
          <div class="form-group">
            {{ Form::label('artwork', 'Paste Artwork URL') }}
            {{ Form::text('artwork', $vinyl->artwork, array('class' => 'form-control', 'id' => 'vinyl-artwork-url', 'placeholder' => 'Paste Artwork URL')) }}
          </div>
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
                {{ Form::text('year', $vinyl->releasedate, array('class' => 'form-control', 'placeholder' => 'Enter release year')); }}

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
                {{ Form::label('weight', 'Estimated weight') }}
                {{ Form::text('weight', $vinyl->weight, array('class' => 'form-control', 'placeholder' => 'Enter estimated weight')); }}

                @if($errors->has('weight'))
                  <div class="alert alert-danger">
                    {{ $errors->first('weight') }}
                  </div>
                @endif
              </div>

              <div class="form-group">
                {{ Form::label('catno', 'Catalog number') }}
                {{ Form::text('catno', $vinyl->catno, array('class' => 'form-control', 'placeholder' => 'Enter catalog number')); }}

                @if($errors->has('catno'))
                  <div class="alert alert-danger">
                    {{ $errors->first('catno') }}
                  </div>
                @endif
              </div>

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
            {{ Form::label('price', 'Price in '.Auth::user()->currency) }} <span style="color: red;">*</span>
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
            {{ Form::label('releasetype', 'Release type') }}
            {{ Form::select('releasetype', array('EP' => 'EP', 'LP' => 'LP', 'RE' => 'RE', 'Single' => 'Single'), $vinyl->releasetype, array('class' => 'form-control')); }}

            @if($errors->has('releasetype'))
              <div class="alert alert-danger">
                {{ $errors->first('releasetype') }}
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

      <div class="col-md-12">
        <!-- Tracklist -->
        <div class="well">
          <legend>Tracklist</legend>
          <table class="table table-hover js-track-table">
            <thead>
              <th width="80px">Pos.</th>
              <th>Title</th>
              <th width="100px">Duration</th>
            </thead>
            <tbody>
              @foreach($tracks as $index=>$track)
                <tr>
                  {{ Form::hidden('track_'.$index.'_id', $track->id) }}
                  <td>{{ Form::text('track_'.$index.'_pos', $track->number, array('class' => 'form-control' )); }}</td>
                  <td>{{ Form::text('track_'.$index.'_title', $track->title, array('class' => 'form-control' )); }}</td>
                  <td>{{ Form::text('track_'.$index.'_duration', $track->duration, array('class' => 'form-control' )); }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div class="btn btn-info btn-md add-track"><i class="fa fa-fw fa-plus"></i> Add track</div>
        </div>
        {{ Form::hidden('tracklist_length', $tracks->count(), array('class' => 'tracklist_length')) }}
        {{ Form::hidden('tracklist_length_new', 0, array('class' => 'tracklist_length_new')) }}
      </div>
    </div>

    <hr>
    {{ Form::submit('Edit Vinyl', array('class' => 'btn btn-primary btn-lg pull-right')) }}
    {{ Form::close() }}
  </div>
@stop

@section('scripts')
  <script>
    var count = $('.tracklist_length').val();
    var new_tracks = 0;
    $('.add-track').click(function(){
      $('.js-track-table tbody').append('<tr><td><input class="form-control" name="track_'+count+'_pos" type="text" value="A1"></td><td><input class="form-control" name="track_'+count+'_title" type="text" value="Example title"></td><td><input class="form-control" name="track_'+count+'_duration" type="text" value="1:23"></td></tr>');
      count++;
      new_tracks++;
      $('.tracklist_length_new').val(new_tracks);
    });
  </script>
@stop

