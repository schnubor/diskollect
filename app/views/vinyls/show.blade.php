@extends('layout.main')

@section('title')
  {{ $vinyl->artist }} - {{ $vinyl->title }}
@stop

@section('body')

  <?php
    $labels = explode(';',$vinyl->label);
    $genres = explode(';',$vinyl->genre);
  ?>

  @if(Auth::check())
    <a class="btn btn-default btn-sm" role="button" href="{{ URL::to('users') }}/{{ Auth::user()->id }}/collection"><i class="fa fa-angle-double-left"></i> Back to collection</a>

    <hr>
  @endif

  <div class="row">
    <div class="col-md-3">
      <div class="thumbnail">
        <img src="{{ $vinyl->artwork }}" alt="{{ $vinyl->artist . ' - ' . $vinyl->title }}">
      </div>
    </div>

    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">{{ $vinyl->artist }} - {{ $vinyl->title }} <small>released {{ $vinyl->releasedate }}</small></h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-12">
              @foreach($labels as $label)
                <span class="label-primary label">{{ $label }}</span>
              @endforeach
              @foreach($genres as $genre)
                <span class="label-warning label">{{ $genre }}</span>
              @endforeach
              <span class="label-success label">{{ $vinyl->country }}</span>
              <span class="label-default label">{{ $vinyl->count . 'x ' . $vinyl->size . '" ' . $vinyl->type }}</span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <p class="h3">
                {{ round($vinyl->price, 2) }} EUR
              </p>
            </div>
            <div class="col-md-9">
              <p class="h3">
                <small>added</small> {{ $vinyl->created_at }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  
    @if($vinyl->notes)
      <div class="col-md-3">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Notes <small>by {{ User::find($vinyl->user_id)->username }}</small></h3>
          </div>
          <div class="panel-body">
            {{ $vinyl->notes }}
          </div>
        </div>
      </div>
    @endif
  </div>

  <div class="row">

    <!-- User -->
    <div class="col-md-2">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Added by</h3>
        </div>
        
        <img width="100%" src="{{ User::find($vinyl->user_id)->image }}" alt="{{ User::find($vinyl->user_id)->username }}">

        <div class="panel-body">
          <a href="{{ URL::route('get-user', $vinyl->user_id) }}" class="h4">{{ User::find($vinyl->user_id)->username }}</a>
        </div>
      </div>
    </div>

    <!-- Tracklist -->
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Tracklist</h3>
        </div>
        <div class="panel-body">
          {{ str_replace(';','<br/>',$vinyl->tracklist) }}
        </div>
      </div>
    </div>

    <!-- Video -->
    <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Videos</h3>
        </div>
        <div class="panel-body">
          <div class="embed-responsive embed-responsive-16by9">
            <iframe width="100%" height="225" src="//www.youtube.com/embed/{{ substr($vinyl->videos, -11) }}" allowFullscreen frameborder="0"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>

@stop

