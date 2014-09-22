@extends('layout.main')

@section('title')
  {{ $user->username }}
@stop

@section('body')
<div class="profile">
  <div class="jumbotron header">
    <div class="container">
      <div class="col-md-3" style="text-align: center;">
        <div class="user-image">
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
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">
              <i class="fa fa-fw fa-music"></i> Genres
            </h3>
          </div>
          <div class="panel-body" style="padding: 15px 0;">
            <canvas id="genreChart" width="100%" height="220"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">
                  <i class="fa fa-fw">#</i> Vinyl Count
                </h3>
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
                    <span class="progress-count">{{ $user->vinyls->count() }}/{{ $nextLvlVinyls }} Vinyls</span>
                  </div>
                  <div class="col-xs-4">
                    <strong class="pull-right">Lvl {{ $level+1 }}</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12 favourites">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">
                  <i class="fa fa-fw fa-heart-o"></i> Favourites
                </h3>
              </div>
              <div class="panel-body">
                <p class="h2" style="margin-top: 0;">
                  <small>Artist</small><br>
                  @if(isset($favArtist))
                    {{ $favArtist->artist }}
                  @else
                    Not enough vinyls yet.
                  @endif
                </p>
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
                <h3 class="panel-title">
                  <i class="fa fa-fw fa-money"></i> Collection Value
                </h3>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-4 text-center">
                    <p class="h3" style="margin-top: 10px;"><small>SUM</small><br>{{ $prices['price_sum'].' '.$user->currency }}</p>
                  </div>
                  <div class="col-md-4 text-center">
                    <p class="h3" style="margin-top: 10px;"><small>AVG</small><br>{{ $prices['price_avg'].' '.$user->currency }}</p>
                  </div>
                  <div class="col-md-4 text-center">
                    <p class="h3" style="margin-top: 10px;"><small>MAX</small><br>{{ $prices['price_max'].' '.$user->currency }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="panel panel-warning value-vinyl">
              <div class="panel-heading">
                <h3 class="panel-title">
                  <i class="fa fa-fw fa-star-o"></i> Most valuable vinyl
                </h3>
              </div>
              <div class="panel-body">
                <a href="{{ URL::route('get-vinyl', $valueVinyl->id) }}"><img src="{{ $valueVinyl->artwork }}" alt="{{ $valueVinyl->artist.' - '.$valueVinyl->title }}" width="100%"></a>
                <p>
                  <strong>{{ $valueVinyl->artist }}</strong><br>
                  <span>{{ $valueVinyl->title }}</span>
                </p>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title">
                  <i class="fa fa-fw fa-pie-chart"></i> Sizes
                </h3>
              </div>
              <div class="panel-body" style="padding: 15px 0;">
                <canvas id="sizeChart" width="100%" height="100%"></canvas>
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
  $vinylGenres = [];
  $vinylSizes = [];
  foreach($user->vinyls as $vinyl){
    $genres = explode(';',$vinyl->genre);
    foreach($genres as $genre){
      array_push($vinylGenres, $genre);
    }
    array_push($vinylSizes, $vinyl->size);
  }

  $sizes = array_count_values($vinylSizes);
  $genres = array_count_values($vinylGenres);
?>

@section('scripts')
  <script>
    var sizes = [
      @foreach($sizes as $key => $value)
        {
          value: {{ $value }},
          color: "#202020",
          highlight: "#606060",
          label: "{{ $key }}"
        },
      @endforeach
    ];

    var genres = {
      labels: [
        @foreach($genres as $key => $value)
          "{{ $key }}",
        @endforeach
        ],
      datasets: [
        {
            label: "My First dataset",
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: [
              @foreach($genres as $key => $value)
               {{ $value }},
              @endforeach
            ]
        }
      ]
    }

    var genreOptions = {
      responsive: 'true',
      maintainAspectRatio: false
    }

    var sizeOptions = {
      responsive: 'true',
    }

    var ctx = document.getElementById("genreChart").getContext("2d");
    var dtx = document.getElementById("sizeChart").getContext("2d");
    
    var genreChart = new Chart(ctx).Bar(genres, genreOptions);
    var sizeChart = new Chart(dtx).PolarArea(sizes, sizeOptions);
  </script>
@stop

