@extends('layout.main')

@section('title')
  Diskollect
@stop

@section('body')
  <div class="jumbotron">
    <h1>Hello there!</h1>
    <p>This is a simple introduction to diskollect.com. Please feel free to go ahead an register an account to add some vinyls.</p>
    
    @if(Auth::check())
      <p>
        Hello, {{ Auth::user()->username }}! Good to see you again :)
      </p>
    @else
      <p>
        <a class="btn btn-primary btn-lg" role="button" href="{{ URL::to('users/signin') }}">Login</a>
        <a class="btn btn-default btn-lg" role="button" href="{{ URL::to('users/create') }}">Register</a>
      </p>
    @endif
  </div>
@stop