@extends('layout.main')

@section('title')
  Search
@stop

@section('body')

  <?php
    $service = new \Discogs\Service();
  ?>

  <div class="page-header">
    <h1>Search Vinyl</h1>
  </div>

  <div class="row">
    <div class="col-md-3">
      <div class="well">
        <div class="form-wrapper">
          {{ Form::open(array('url' => 'search')) }}
            <div class="form-group">
              {{ Form::label('artist', 'Artist') }}
              {{ Form::text('artist', $artist, array('class' => 'form-control')); }}

              @if($errors->has('artist'))
                <div class="alert alert-danger">
                  {{ $errors->first('artist') }}
                </div>
              @endif
            </div>
            <div class="form-group">
              {{ Form::label('title', 'Title') }}
              {{ Form::text('title', $title, array('class' => 'form-control')); }}

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

    <!-- Search Results -->
    <div class="col-md-9">
      <table class="footable table table-hover">
        <thead>
          <tr>
            <th>Artwork</th>
            <th>Artist</th>
            <th>Title</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($results as $result)
            <?php 
              $url = str_replace('api.discogs.com/image/R-90','s.pixogs.com/image/R-150',$result->getThumb());

              $title = $result->getTitle();
              list($artist, $vinylTitle) = explode(' - ', $title);
            ?>

            <tr>
              <td><img src="{{ $url }}" alt="cover" class="artwork"/></td>
              <td>{{ $artist }}</td>
              <td>{{ $vinylTitle }}</td>
              <td>
                <a href="{{ URL::route('get-create-vinyl') }}?id={{ $result->getId() }}&type={{ $result->getType() }}"><button class="btn btn-sm btn-success">Add</button></a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div><!-- end of .row -->

@stop

