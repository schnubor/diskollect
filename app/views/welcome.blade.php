@extends('layout.main')

@section('title')
  Diskollect
@stop

@section('body')
  <div class="container">
    <div class="jumbotron">
      <h1>Hello there!</h1>
      <p>This is a simple introduction to diskollect.com. Please feel free to go ahead an register an account to add some vinyls.</p>
      <p><a class="btn btn-primary btn-lg" role="button" href="{{ URL::to('user/create') }}">Register</a></p>
    </div>
  </div>
@stop