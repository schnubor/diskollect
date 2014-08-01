@extends('layout.main')

@section('title')
  Welcome
@stop

@section('body')
  <div id="welcome">
    <div class="welcome-header">
      <div class="container">
        
        @if(Auth::check())
          <div class="user-message">
            <div class="user">
              <div class="profile-image" style="background-image: url('{{ Auth::user()->image }}'); background-size: cover;"></div>
              <h2 class="welcome-user-msg">Welcome back <strong>{{ Auth::user()->username }}</strong></h2>
            </div>
            <div class="welcome-buttons">
              <a class="btn btn-lg btn-primary" role="button" href="{{ URL::route('get-search') }}"><i class="fa fa-fw fa-plus-circle"></i> Add new Vinyl</a>
            </div>
          </div>
        @else
          <div class="welcome-message">
            <h1>DISKOLLECT</h1>
            <h2>Vinyl Collection Management Done Right.</h2>
          </div>
        @endif
      </div>
    </div>

    <div class="welcome-actions">
      <div class="container">
        @if(Auth::check())
          <div class="container welcome-content">
            <a class="btn btn-primary" role="button" href="{{ URL::route('get-collection', Auth::user()->id ) }}"><i class="fa fa-fw fa-database"></i> Collection</a>
            <a class="btn btn-primary" role="button" href="{{ URL::route('get-user', Auth::user()->id) }}"><i class="fa fa-fw fa-user"></i> Profile</a>
          </div>
        @else
            <a class="btn btn-primary btn-lg" role="button" href="{{ URL::route('get-signin') }}"><i class="fa fa-fw fa-sign-in"></i>Login</a>
            <a class="btn btn-default btn-lg" role="button" href="{{ URL::route('get-user-create') }}"><i class="fa fa-fw fa-edit"></i>Register</a>
        @endif
      </div>
    </div>
  </div>
@stop
