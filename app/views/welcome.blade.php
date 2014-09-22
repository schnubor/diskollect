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
            <div class="welcome-actions">
              <div class="col-md-2 col-md-offset-3">
                <a class="btn btn-lg btn-primary btn-block" role="button" href="{{ URL::route('get-search') }}"><i class="fa fa-fw fa-plus-circle"></i> Add Vinyl</a>
              </div>
              <div class="col-md-2">
                <a class="btn btn-lg btn-primary btn-block" role="button" href="{{ URL::route('get-collection', Auth::user()->id ) }}"><i class="fa fa-fw fa-database"></i> Collection</a>
              </div>
              <div class="col-md-2">
                <a class="btn btn-lg btn-primary btn-block" role="button" href="{{ URL::route('get-user', Auth::user()->id) }}"><i class="fa fa-fw fa-bar-chart-o"></i> Statistics</a>
              </div>
            </div>
          </div>
        @else
          <div class="welcome-message">
            <h1>Diskollect</h1>
            <h2>Tracking <strong>{{ $vinyls }}</strong> vinyls of <strong>{{ $users }}</strong> collectors.</h2>
            <div class="welcome-actions">
              <div class="col-md-2 col-md-offset-4">
                <a class="btn btn-primary btn-lg btn-block" role="button" href="{{ URL::route('get-signin') }}"><i class="fa fa-fw fa-sign-in"></i>Login</a>
              </div>
              <div class="col-md-2">
                <a class="btn btn-default btn-lg btn-block" role="button" href="{{ URL::route('get-user-create') }}"><i class="fa fa-fw fa-edit"></i>Register</a>
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>

    <div class="welcome-content">
      <div class="container">
        @if(Auth::check())
          @if(Auth::user()->vinyls->count())
            <?php
              $randomVinyl = Auth::user()->vinyls()->orderBy(DB::raw('RAND()'))->first();
            ?>
            <div class="col-md-8">
              <p class="h2">Latest vinyls</p>
              <hr>
              <div class="row">
                @foreach($latestVinyls as $vinyl)
                  <div class="col-md-4 latest-vinyl">
                    <a href="{{ URL::route('get-vinyl', $vinyl->id) }}"><img src="{{ $vinyl->artwork }}" alt="{{ $vinyl->artist.' - '.$vinyl->title }}" width="100%" class="img-thumbnail"></a>
                    <p>
                      <strong>{{ $vinyl->artist }}</strong><br>
                      <span>{{ $vinyl->title }}</span>
                    </p>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="col-md-4">
              <p class="h2">Vinyl of the moment</p>
              <hr>
              <a href="{{ URL::route('get-vinyl', $randomVinyl->id) }}"><img src="{{ $randomVinyl->artwork }}" class="img-thumbnail" alt="{{ $randomVinyl->artist.' - '.$randomVinyl->title }}" width="100%"></a>
              <p class="vinyl-info">
                <strong>{{ $randomVinyl->artist }}</strong><br>
                <span>{{ $randomVinyl->title }}</span>
              </p>
            </div>
          @endif
        @else
          <div class="intro">
            <div class="col-md-4">
              <div class="text-center"><i class="fa fa-fw fa-line-chart"></i></div>
              <p>
                Dive into the numbers and keep track. We will create personlized statistics for your collection.
              </p>
            </div>
            <div class="col-md-4">
              <div class="text-center"><i class="fa fa-fw fa-cubes"></i></div>
              <p>
                Diskollect integrates with different APIs like Discogs or iTunes to get all the data you need.
              </p>
            </div>
            <div class="col-md-4">
              <div class="text-center"><i class="fa fa-fw fa-refresh"></i></div>
              <p>
                Easy to use. Build, manage and share your collection at home or on the go.
              </p>
            </div>
          </div>
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
