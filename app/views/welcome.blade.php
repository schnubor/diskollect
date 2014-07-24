@extends('layout.main')

@section('title')
  Home
@stop

@section('body')
  <div class="main-header">
    <div class="container">
      <div class="message">
        <img class="logo" src="/assets/logo.png" alt="Logo">
        @if(Auth::check())
          <h1>Welcome to Diskollect</h1>
          <p>Good to see you again :)</p>
          <p>
            <a class="btn btn-primary btn-lg" role="button" href="{{ URL::route('get-collection', Auth::user()->id ) }}">Your Collection</a>
            <a class="btn btn-success btn-lg" role="button" href="{{ URL::route('get-user', Auth::user()->id) }}">Your Profile</a>
          </p>
        @else
          <h2>Start sharing your vinyl collection now.</h2>
          <div class="row buttons">
            <div class="col-md-2 col-md-offset-5">
            <a class="btn btn-primary btn-lg full-width" role="button" href="{{ URL::route('get-user-create') }}"><i class="fa fa-fw fa-edit"></i>Register</a><br><br>
            <a class="btn btn-default btn-sm" role="button" href="{{ URL::route('get-signin') }}"><i class="fa fa-fw fa-sign-in"></i>Login</a>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
@stop
