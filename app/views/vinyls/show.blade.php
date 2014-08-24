@extends('layout.main')

@section('title')
  {{ $vinyl->artist }} - {{ $vinyl->title }}
@stop

@section('body')

  <div class="bg-image" style="background-image: url('{{ $vinyl->artwork }}')"></div>
  <div class="bg-image-overlay"></div>
  <div class="container vinyl-detail">
    <?php
      $labels = explode(';',$vinyl->label);
      $genres = explode(';',$vinyl->genre);
    ?>

    @if(Auth::check())
      <a class="btn btn-default btn-sm" role="button" href="{{ URL::to('users') }}/{{ Auth::user()->id }}/collection" style="position: relative;"><i class="fa fa-angle-double-left"></i> Back to collection</a>
      @if($vinyl->user_id == Auth::user()->id)
        <div class="btn btn-success pull-right disabled">{{ number_format(round($vinyl->price, 2),2) }} EUR</div>
      @endif
    @endif

    <div class="row" style="padding-top: 20px;">
      <div class="col-md-4 col-md-offset-4">
        <div class="row">
          <div class="col-md-10 col-md-offset-1">
            <div class="thumbnail">
              <img src="{{ $vinyl->artwork }}" alt="{{ $vinyl->artist . ' - ' . $vinyl->title }}" class="vinyl-artwork">
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
        <h1 class="vinyl-title">{{ $vinyl->artist }} - {{ $vinyl->title }}</h1>
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
              <dd>{{ $vinyl->created_at }}</dd>
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
            <table class="table table-hoverfootable">
              <thead>
                <th>Pos.</th>
                <th>Title</th>
                <th>Duration</th>
              </thead>
              <tbody>
                @foreach($tracks as $track)
                  <tr>
                    <td>{{ $track->number }}</td>
                    <td>{{ $track->title }}</td>
                    <td>{{ $track->duration }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
    </div>

    <div class="page-header">
      <h2>Samples</h2>
    </div>

    <div class="row">
      <!-- Soundcloud -->
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Soundcloud</h3>
          </div>
          <div class="panel-body">
            <div class="embed-responsive">
              
                <!--<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=$track->uri&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false"></iframe>-->
              
            </div>
          </div>
        </div>
      </div>
      <!-- Youtube -->
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Youtube</h3>
          </div>
          <div class="panel-body">
            <div class="embed-responsive embed-responsive-16by9">
              
                <!--<iframe width="100%" height="315" src="//www.youtube.com/embed/$track['videoId']?list=$track['playlistId']" frameborder="0" allowfullscreen></iframe>-->
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop

