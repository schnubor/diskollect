@extends('layout.main')

@section('title')
  {{ $vinyl->artist }} - {{ $vinyl->title }}
@stop

@section('body')

  <div class="container vinyl-detail" itemscope itemtype="http://schema.org/CreativeWork">
    <?php
      $labels = explode(';',$vinyl->label);
      $genres = explode(';',$vinyl->genre);
    ?>

    @if(Auth::check())
      <a class="btn btn-default btn-sm" role="button" href="{{ URL::to('users') }}/{{ Auth::user()->id }}/collection" style="position: relative;"><i class="fa fa-angle-double-left"></i> Back to collection</a>
      @if($vinyl->user_id == Auth::user()->id)
        <div class="btn btn-success pull-right disabled">{{ number_format(round($vinyl->price, 2),2) }} EUR</div>
      @endif
      <hr>
    @endif

    <div class="row" style="padding-top: 20px;">
      <div class="col-md-6 col-md-offset-3">
        <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <div class="thumbnail">
              <img itemprop="image" src="{{ $vinyl->artwork }}" alt="{{ $vinyl->artist . ' - ' . $vinyl->title }}" class="vinyl-artwork">
            </div>
          </div>
        </div>
      </div>
    </div>

    @if(Auth::check())
      @if($vinyl->user_id == Auth::user()->id)
        <div class="row">
          <div class="col-md-12 text-center">
            <p><a href="{{ URL::route('get-edit-vinyl', $vinyl->id) }}" class="btn btn-md btn-default" style="margin-right: 10px;"><i class="fa fa-fw fa-gear"></i>Edit Vinyl</a></p>
          </div>
        </div>
      @endif
    @endif

    <div class="row">
      <div class="col-md-12 text-center">
      <h1 class="vinyl-title"><span itemprop="MusicGroup">{{ $vinyl->artist }}</span> - {{ $vinyl->title }}</h1>
      </div>
    </div>

    <hr style="position: relative;">
    @if($vinyl->notes)
      <div class="row">
        <div class="col-md-12">
          <p class="notes">"{{ $vinyl->notes }}"</p>
        </div>
      </div>
      <hr style="position: relative;">
    @endif

    <div class="row">
     
      <!-- General -->
      <div class="col-md-3">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">General Infos</h3>
          </div>
          <div class="panel-body">
            <div class="user-image">
              <img width="100%" src="{{ User::find($vinyl->user_id)->image }}" alt="{{ User::find($vinyl->user_id)->username }}">
            </div>
            <dl>
              <dt>Owner</dt>
              <dd><a href="{{ URL::route('get-user', $vinyl->user_id) }}" class="h4">{{ User::find($vinyl->user_id)->username }}</a></dd>
              <dt>Labels</dt>
              <dd>
                @foreach($labels as $label)
                  {{ $label.' ' }}
                @endforeach
              </dd>
              <dt>Genres</dt>
              <dd>
                @foreach($genres as $genre)
                  {{ $genre.' ' }}
                @endforeach
              </dd>
              <dt>Catalog number</dt>
              <dd>{{ $vinyl->catno }}</dd>
              <dt>Format</dt>
              <dd>{{ $vinyl->releasetype }}, {{ $vinyl->count }}x {{ $vinyl->size.'"' }} Vinyl, {{ $vinyl->weight }} grams</dd>
              <dt>Released</dt>
              <dd>{{ $vinyl->releasedate }} in {{ $vinyl->country }}</dd>
              <dt>Date added</dt>
              <dd itemprop="dateCreated">{{ $vinyl->created_at }}</dd>
            </dl>
          </div>
        </div>
      </div>

      <!-- Tracklist -->
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Tracklist</h3>
          </div>
          <div class="panel-body">
            <table class="table table-hoverfootable footable">
              <thead>
                <th>Pos.</th>
                <th>Title</th>
                <th>Duration</th>
                <th data-toggle="true">Listen</th>
                <th data-hide="all">Samples</th>
              </thead>
              <tbody>
                @foreach($tracks as $index=>$track)
                  <tr>
                    <td>{{ $track->number }}</td>
                    <td>{{ $track->title }}</td>
                    <td>{{ $track->duration }}</td>
                    <td></td>
                    <td>
                      @if(isset($youtube[$index][0]->id->videoId))
                        <div class="embed-responsive embed-responsive-16by9">
                          <iframe src="//www.youtube.com/embed/{{ $youtube[$index][0]->id->videoId }}?autohide=0" width="260px" height="35px" frameborder="0" allowfullscreen></iframe>
                        </div>
                      @else
                        Sorry, no samples found.
                      @endif
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
    </div>

  </div>
@stop

@section('scripts')
  <script type="text/javascript">
    $(function () {
      $('.footable').footable();
    });
  </script>
@stop

