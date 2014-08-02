@extends('layout.main')

@section('title')
  API Introduction
@stop

@section('body')
  <div class="jumbotron" style="margin-top: -20px;">
    <div class="container">
      <h1>API Introduction</h1>
      <p>This is a quick introduction to the RESTful Diskollect API. The basic response format is JSON.<br>
      Check the examples below for more insights.</p>
    </div>
  </div>
  <div class="container">
    <!-- User -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Users</h3>
      </div>
      <div class="panel-body">
        <code>GET api/user/&lt;username&gt;</code>
      </div>
      <!-- List group -->
      <ul class="list-group">
        <li class="list-group-item"><strong>Example</strong> <br> <kbd>curl -i http://beta.diskollect.com/api/user/schnubor</kbd></li>
        <li class="list-group-item"><strong>Response</strong> <br> <code>JSON</code></li>
      </ul>
    </div>

    <!-- Collection -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Collection</h3>
      </div>
      <div class="panel-body">
        <code>GET api/collection/&lt;user_id&gt;</code>
      </div>
      <!-- List group -->
      <ul class="list-group">
        <li class="list-group-item"><strong>Example</strong> <br> <kbd>curl -i http://beta.diskollect.com/api/collection/1</kbd></li>
        <li class="list-group-item"><strong>Response</strong> <br> <code>JSON</code></li>
      </ul>
    </div>

    <!-- Vinyl -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Vinyl</h3>
      </div>
      <div class="panel-body">
        <code>GET api/vinyl/&lt;id&gt;</code>
      </div>
      <!-- List group -->
      <ul class="list-group">
        <li class="list-group-item"><strong>Example</strong> <br> <kbd>curl -i http://beta.diskollect.com/api/vinyl/1</kbd></li>
        <li class="list-group-item"><strong>Response</strong> <br> <code>JSON</code></li>
      </ul>
    </div>
  </div>
@stop