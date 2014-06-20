@extends('layout.main')

@section('title')
  Authenticate with Discogs
@stop

@section('body')
  <div class="page-header">
    <h1>Authenticate with Discogs</h1>
  </div>

  <p>Diskollect is using the Discogs API for some of it's features. You need to authenticate with Discogs before using those features.</p>

  <a href="/oauth/discogs" class="btn btn-primary">oAuth with Discogs</a>

@stop