@extends('layout.main')

@section('title')
  Welcome
@stop

@section('body')
  <div id="welcome">
    <div class="welcome-header">
      <div class="container">
        
        @if(Auth::check())
          <div class="welcome-message">
              <h1>{{ Auth::user()->username }}</h1>
              <h2>You got <strong>{{ Auth::user()->vinyls->count() }} Vinyls</strong> worth <strong>{{ round(Auth::user()->vinyls->sum('price'), 2) }} {{ Auth::user()->currency }}</strong></h2>
          </div>
        @else
          <div class="welcome-message">
            <h1>Diskollect</h1>
            <h2>Vinyl Collection Management Done Right.</h2>
          </div>
        @endif
      </div>
    </div>

    <div class="welcome-actions">
      <div class="container">
        @if(Auth::check())
            <a class="btn btn-lg btn-primary" role="button" href="{{ URL::route('get-search') }}"><i class="fa fa-fw fa-plus-circle"></i> Add Vinyl</a>
            <a class="btn btn-lg btn-primary" role="button" href="{{ URL::route('get-collection', Auth::user()->id ) }}"><i class="fa fa-fw fa-database"></i> Collection</a>
            <a class="btn btn-lg btn-primary" role="button" href="{{ URL::route('get-user', Auth::user()->id) }}"><i class="fa fa-fw fa-bar-chart-o"></i> Statistics</a>
        @else
            <a class="btn btn-primary btn-lg" role="button" href="{{ URL::route('get-signin') }}"><i class="fa fa-fw fa-sign-in"></i>Login</a>
            <a class="btn btn-default btn-lg" role="button" href="{{ URL::route('get-user-create') }}"><i class="fa fa-fw fa-edit"></i>Register</a>
        @endif
      </div>
    </div>

    <div class="welcome-footer">
      <div class="container">
        <p>
          Diskollect is being made by <a href="http://twitter.com/schnubor" target="_blank">@schnubor</a> using <a href="http://laravel.com" target="_blank">Laravel</a> and the <a href="http://www.discogs.com/developer" target="_blank">Discogs API</a>
        </p>
      </div>
    </div>
  </div>
@stop
