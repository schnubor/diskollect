@extends('layout.main')

@section('title')
  {{ $vinyl->artist }} - {{ $vinyl->title }}
@stop

@section('body')
  <div class="page-header">
      <h1>{{ $vinyl->artist }} - {{ $vinyl->title }}</h1>
  </div>

  <div class="row">

    <!-- Tracklist -->
    <div class="col-md-4">
      <div class="well well-sm">
        {{ str_replace(';','<br/>',$vinyl->tracklist) }}
      </div>
    </div>

    <!-- Video -->
    <div class="col-md-4">
      <div class="well well-sm">
        <iframe width="100%" height="225" src="//www.youtube.com/embed/{{ substr($vinyl->videos, -11) }}" allowFullscreen frameborder="0"></iframe>
      </div>
    </div>
  </div>

  @if(Auth::check())
    <hr>

    <a class="btn btn-default btn-md" role="button" href="{{ URL::to('users') }}/{{ Auth::user()->id }}/collection"><i class="fa fa-angle-double-left"></i> Back to collection</a>
  @endif

@stop

