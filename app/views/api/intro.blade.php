@extends('layout.main')

@section('title')
  API Introduction
@stop

@section('body')
  <div class="jumbotron">
    <div class="container">
      <h1>API Introduction</h1>
      <p>This is a quick introdution to the RESTful Diskollect API. The basic response format is JSON.<br>
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
    </div>

    <!-- Collection -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Collection</h3>
      </div>
      <div class="panel-body">
        <code>GET api/collection/&lt;user_id&gt;</code>
      </div>
    </div>

    <!-- Vinyl -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Vinyl</h3>
      </div>
      <div class="panel-body">
        <code>GET api/vinyl/&lt;id&gt;</code>
      </div>
    </div>
  </div>
@stop