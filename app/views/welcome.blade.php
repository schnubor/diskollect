@extends('layout.main')

@section('title')
  Diskollect
@stop

@section('body')
  <div class="jumbotron">
    
    @if(Auth::check())
      <h1>Hello, {{ Auth::user()->username }}!</h1>
      <p>Good to see you again :)</p>
      <p>
        <a class="btn btn-primary btn-lg" role="button" href="{{ URL::to('users') }}/{{ Auth::user()->id }}/collection">Your Collection</a>
        <a class="btn btn-success btn-lg" role="button" href="{{ URL::to('users') }}/{{ Auth::user()->id }}">Your Profile</a>
      </p>
    @else
      <h1>Hello there!</h1>
      <p>This is a simple introduction to diskollect.com. Please feel free to go ahead an register an account to add some vinyls.</p>
      <p>
        <a class="btn btn-primary btn-lg" role="button" href="{{ URL::to('users/signin') }}">Login</a>
        <a class="btn btn-default btn-lg" role="button" href="{{ URL::to('users/create') }}">Register</a>
      </p>
    @endif
  </div>
@stop