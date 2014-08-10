@extends('layout.main')

@section('title')
  Search
@stop

@section('body')
  <div class="container">

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
                $url = str_replace('api.discogs.com/image/R-150','s.pixogs.com/image/R-150',$result['thumb']);
                $artist = $result['artists'][0]['name'];
                $title = $result['title'];
              ?>

              <tr>
                <td>
                  @if(@getimagesize($url))
                    <img src="{{ $url }}" alt="cover" class="artwork"/>
                  @else
                    <img src="{{ VINYL_PH_PATH }}" alt="cover" class="artwork"/>
                  @endif
                </td>
                <td>{{ $artist }}</td>
                <td>{{ $title }}</td>
                <td>
                  <a href="{{ URL::route('get-create-vinyl-search') }}?id={{ $result['id'] }}&type={{ $result['type'] }}"><button class="btn btn-sm btn-success">Add</button></a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div><!-- end of .row -->
  </div>
@stop

