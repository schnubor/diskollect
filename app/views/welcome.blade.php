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
              <h1><a href="{{ URL::route('get-user', Auth::user()->id ) }}">{{ Auth::user()->username }}</a></h1>
              <h2>You got <a href="{{ URL::route('get-collection', Auth::user()->id ) }}"><strong>{{ Auth::user()->vinyls->count() }} Vinyls</strong></a> worth <a href="{{ URL::route('get-user', Auth::user()->id ) }}"><strong>{{ number_format(round(Auth::user()->vinyls->sum('price'), 2),2) }} {{ Auth::user()->currency }}</strong></a></h2>
          </div>
        @else
          <div class="welcome-message">
            <h1>Diskollect</h1>
            <h2>Tracking <strong>{{ $vinyls }}</strong> vinyls of <strong>{{ $users }}</strong> collectors.</h2>
          </div>
        @endif
      </div>
    </div>

    <div class="welcome-actions">
      <div class="container">
        @if(Auth::check())
          <div class="col-md-2 col-md-offset-3">
            <a class="btn btn-lg btn-primary btn-block" role="button" href="{{ URL::route('get-search') }}"><i class="fa fa-fw fa-plus-circle"></i> Add Vinyl</a>
          </div>
          <div class="col-md-2">
            <a class="btn btn-lg btn-primary btn-block" role="button" href="{{ URL::route('get-collection', Auth::user()->id ) }}"><i class="fa fa-fw fa-database"></i> Collection</a>
          </div>
          <div class="col-md-2">
            <a class="btn btn-lg btn-primary btn-block" role="button" href="{{ URL::route('get-user', Auth::user()->id) }}"><i class="fa fa-fw fa-bar-chart-o"></i> Statistics</a>
          </div>
        @else
          <div class="col-md-3 col-md-offset-3">
            <a class="btn btn-primary btn-lg btn-block" role="button" href="{{ URL::route('get-signin') }}"><i class="fa fa-fw fa-sign-in"></i>Login</a>
          </div>
          <div class="col-md-3">
            <a class="btn btn-info btn-lg btn-block" role="button" href="{{ URL::route('get-user-create') }}"><i class="fa fa-fw fa-edit"></i>Register</a>
          </div>
        @endif
      </div>
    </div>

    <div class="welcome-content">
      <div class="container">
        @if(Auth::check())
          @if(Auth::user()->vinyls->count())
            <h2>Why not listen to...</h2>
            <?php
              $randomVinyl = Auth::user()->vinyls()->orderBy(DB::raw('RAND()'))->first();
            ?>
            <div class="col-md-4 col-md-offset-4">
              <a href="{{ URL::route('get-vinyl', $randomVinyl->id) }}"><img src="{{ $randomVinyl->artwork }}" class="img-thumbnail" alt="{{ $randomVinyl->artist.' - '.$randomVinyl->title }}" width="100%"></a>
              <p class="vinyl-info">
                <strong>{{ $randomVinyl->artist }}</strong><br>
                <span>{{ $randomVinyl->title }}</span>
              </p>
            </div>
          @endif
        @else

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
