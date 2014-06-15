@extends('layout.main')

@section('title')
  Search
@stop

@section('body')
  <div class="page-header">
    <h1>Search Vinyl</h1>
  </div>

  <div class="form-wrapper">
    {{ Form::open(array('url' => 'search')) }}
      <div class="form-group">
        {{ Form::label('artist', 'Artist') }}
        {{ Form::text('artist', $artist, array('class' => 'form-control', 'placeholder' => 'Daft Punk')); }}

        @if($errors->has('artist'))
          <div class="alert alert-danger">
            {{ $errors->first('artist') }}
          </div>
        @endif
      </div>
      <div class="form-group">
        {{ Form::label('title', 'Title') }}
        {{ Form::text('title', $title, array('class' => 'form-control', 'placeholder' => 'Random Access Memories')); }}

        @if($errors->has('title'))
          <div class="alert alert-danger">
            {{ $errors->first('title') }}
          </div>
        @endif
      </div>

      {{ Form::submit('Search', array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
  </div>

  <div class="page-header">
    <h2>Found {{ $count }} Vinyls</h2>
  </div>

  <?php
    $service = new \Discogs\Service();
  ?>

  <div class="row">
    
    @foreach($results as $result)
      <?php 
        $url = str_replace('api.discogs.com/image/R-90','s.pixogs.com/image/R-150',$result->getThumb());

        $title = $result->getTitle();
        list($artist, $vinylTitle) = explode(' - ', $title);
      ?>

      <div class="col-md-4">
        <div class="well well-sm">
          <div class="media">
            <a class="thumbnail pull-left" href="{{ URL::to('search/vinyl') }}?id={{ $result->getId() }}&type={{ $result->getType() }}" style="margin-bottom: 0;">
              <img class="media-object" src="{{ $url }}" style="width: 150px; height: 150px;">
            </a>
            <div class="media-body">
              <h5 class="media-heading">{{ $title }}</h5>
              <p>
                <span class="label label-info">{{ $result->getYear() }}</span>
                @foreach($result->getGenre() as $genre)
                  <span class="label label-primary">{{ $genre }}</span>
                @endforeach
                <span class="label label-warning">{{ $result->getLabel()[0] }}</span>
                <span class="label label-success">{{ $result->getCountry() }}</span>
                <span class="label label-default">{{ $result->getType() }}</span>
              </p>

            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <hr>
  


@stop

