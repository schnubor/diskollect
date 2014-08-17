@extends('layout.main')

@section('title')
  Authenticate with Discogs
@stop

@section('body')
  <div class="container">
    <div class="page-header">
      <h1>Authenticate with Discogs</h1>
    </div>

    <p>You need to authenticate with Discogs before using this feature.</p>

    <a href="{{ URL::route('get-oAuthDiscogs') }}" class="btn btn-primary">oAuth with Discogs</a>
  </div>
@stop
