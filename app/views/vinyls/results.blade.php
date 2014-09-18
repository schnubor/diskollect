@extends('layout.main')

@section('title')
  Search
@stop

@section('body')
  <div class="jumbotron search-form" style="margin-top: -20px;">
    <div class="container">
      <div class="well col-md-7" style="margin-bottom: 0;">
        <legend>Search on Discogs</legend>
        <div class="form-wrapper">
          {{ Form::open(array('url' => 'search', 'class' => 'form-inline')) }}
            <div class="form-group">
              {{ Form::text('artist', $artist, array('class' => 'form-control', 'placeholder' => 'Artist')); }}

              @if($errors->has('artist'))
                <div class="alert alert-danger">
                  {{ $errors->first('artist') }}
                </div>
              @endif
            </div>
            <div class="form-group">
              {{ Form::text('title', $title, array('class' => 'form-control', 'placeholder' => 'Title')); }}

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

      <div class="col-md-2">
        <div class="or">- OR -</div>
      </div>

      <div class="col-md-3 well">
        <legend>Add manually</legend>
        <a href="{{ URL::route('get-create-vinyl') }}" class="btn btn-md btn-block btn-info"><i class="fa fa-plus fa-fw"></i> Add manually</a>
      </div>
    </div>
  </div>
  <!-- Search Results -->
  <div class="container">
    <table class="footable table table-hover">
      <thead>
        <tr>
          <th data-hide="phone">Artwork</th>
          <th data-toggle="true">Artist</th>
          <th>Title</th>
          <th data-hide="phone">Label</th>
          <th data-hide="tablet,phone">Cat. No.</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $index = 0;
        ?>
        @foreach($results as $result)
          <?php
            if(isset($iTunesData[$index]->results[0]->artworkUrl100)){
              //dd($iTunesData[$index]->results[0]->artworkUrl100);
              $url = $iTunesData[$index]->results[0]->artworkUrl100;
            }
            else{
              $url = VINYL_PH_PATH;
            }
            $index++;

            $artist = $result['artists'][0]['name'];
            $title = $result['title'];
            $label = $result['labels'][0]['name'];
            $catno = $result['labels'][0]['catno'];
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
            <td>{{ $label }}</td>
            <td>{{ $catno }}</td>
            <td>
              <a href="{{ URL::route('get-create-vinyl-search') }}?id={{ $result['id'] }}&type={{ $result['type'] }}&artwork={{ $url }}"><button class="btn btn-sm btn-success btn-block">Add</button></a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@stop

@section('scripts')
  <script type="text/javascript">
    $(function () {
      $('.footable').footable();
    });
  </script>
@stop

