@extends('layout.main')

@section('title')
  Home
@stop

@section('outer-body')
  <div class="main-header">
    <div class="container">
      @if(Auth::check())
        <h1>Hello, {{ Auth::user()->username }}!</h1>
        <p>Good to see you again :)</p>
        <p>
          <a class="btn btn-primary btn-lg" role="button" href="{{ URL::route('get-collection', Auth::user()->id ) }}">Your Collection</a>
          <a class="btn btn-success btn-lg" role="button" href="{{ URL::route('get-user', Auth::user()->id) }}">Your Profile</a>
        </p>
      @else
        <h1>Hello there!</h1>
        <p>This is a simple introduction to diskollect.com. Please feel free to go ahead an register an account to add some vinyls.</p>
        <p>
          <a class="btn btn-primary btn-lg" role="button" href="{{ URL::route('get-signin') }}">Login</a>
          <a class="btn btn-default btn-lg" role="button" href="{{ URL::route('get-user-create') }}">Register</a>
        </p>
      @endif
    </div>
  </div>
@stop