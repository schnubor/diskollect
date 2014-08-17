@extends('layout.main')

@section('title')
  {{ $user->username }}
@stop

@section('body')
<div class="profile">
  <div class="jumbotron header">
    <div class="container">
      <div class="col-md-3" style="text-align: center;">
        <div class="profile-image">
          @if($user->image)
            <img src="{{ $user->image }}" alt="{{ $user->username }}" class="img-responsive profile-pic">
          @else
            <img src="{{ USER_PH_PATH }}" alt="{{ $user->username }}" class="img-responsive profile-pic">
          @endif
        </div>
        @if(Auth::check() && Auth::user()->id == $user->id)
          <a href="{{ URL::to('users/edit') }}" class="btn btn-default btn-sm edit-button" role="button" style="margin-top: 20px;"><i class="fa fa-gear fa-fw"></i> Edit Profile</a>
        @endif
      </div>
      <div class="col-md-9">
        <div class="profile-info">
          <div class="username">
            <h1>{{ $user->username }}</h1>
          </div>
          <p class="additional-info">
            @if($user->name)
              <span>{{ $user->name }},</span>
            @endif
            @if($user->location)
              <span>{{ $user->location }},</span>
            @endif
            @if($user->website)
              <span><a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a></span>
            @endif
          </p>
        </div>

        <div class="actions">
          <a href="{{ URL::route('get-collection', $user->id) }}" class="btn btn-lg btn-primary" ><i class="fa fa-fw fa-database"></i> View Collection</a>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Vinyl Count</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-xs-6 col-xs-offset-3 text-center">
                    <p class="h1">{{ $user->vinyls->count() }} Vinyls<p>
                    <hr>
                    <h3>Level {{ $level }}</h3>
                    <div class="profile-user-rank">{{ $rank }}</div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="progress">
                      <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $progress }}%; min-width: 30px;">
                        {{ $progress }}%
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-4">
                    <strong>Lvl {{ $level }}</strong>
                  </div>
                  <div class="col-xs-4 text-center">
                    <span class="progress-count">{{ $vinyls->count() }}/{{ $nextLvlVinyls }} Vinyls</span>
                  </div>
                  <div class="col-xs-4">
                    <strong class="pull-right">Lvl {{ $level+1 }}</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- end of left area -->

      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-success collection-value">
              <div class="panel-heading">
                <h3 class="panel-title">Collection Value</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-4 text-center">
                    <p class="h3" style="margin-top: 10px;"><small>SUM</small><br>{{ round($vinyls->sum('price'), 2).' '.$user->currency }}</p>
                  </div>
                  <div class="col-md-4 text-center">
                    <p class="h3" style="margin-top: 10px;"><small>AVG</small><br>{{ round($vinyls->avg('price'), 2).' '.$user->currency }}</p>
                  </div>
                  <div class="col-md-4 text-center">
                    <p class="h3" style="margin-top: 10px;"><small>MAX</small><br>{{ round($vinyls->max('price'), 2).' '.$user->currency }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">Genres</h3>
              </div>
              <div class="panel-body" style="padding: 15px 0;">
                <canvas id="genreChart" width="100%" height="100%"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div><!-- end of right area -->

    </div>
  </div>
</div>
@stop

<?php
  $genres = [];
  foreach($user->vinyls as $vinyl){
    $vinylGenre = explode(';',$vinyl->genre);
    array_push($genres, $vinylGenre);
  }
?>

@section('scripts')
  <script>
    var data = [
      {
        value: 300,
        color:"#F7464A",
        highlight: "#FF5A5E",
        label: "Red"
      },
      {
        value: 50,
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "Green"
      },
      {
        value: 100,
        color: "#FDB45C",
        highlight: "#FFC870",
        label: "Yellow"
      },
      {
        value: 40,
        color: "#949FB1",
        highlight: "#A8B3C5",
        label: "Grey"
      },
      {
        value: 120,
        color: "#4D5360",
        highlight: "#616774",
        label: "Dark Grey"
      }
    ];
    var options = {
      responsive: 'true'
    }
    var ctx = document.getElementById("genreChart").getContext("2d");
    var genreChart = new Chart(ctx).PolarArea(data, options);
  </script>
@stop

