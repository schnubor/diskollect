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
                <h3 class="panel-title">Favourites</h3>
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
                <h3 class="panel-title">Collection Value</h3>
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
                  Most valuable vinyl
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
  $vinylGenres = [];
  foreach($user->vinyls as $vinyl){
    $genres = explode(';',$vinyl->genre);
    foreach($genres as $genre){
      array_push($vinylGenres, $genre);
    }
  }
  $genres = array_count_values($vinylGenres);
?>

@section('scripts')
  <script>
    <?php
      class Color {
        public $color;
        public $highlight;
      }

      $color1 = new Color();
      $color1->color = "#F7464A";
      $color1->highlight = "#FF5A5E";

      $color2 = new Color();
      $color2->color = "#1E7FFF";
      $color2->highlight = "#1EC0FF";

      $color3 = new Color();
      $color3->color = "#FDB45C";
      $color3->highlight = "#FFC870";

      $color4 = new Color();
      $color4->color = "#949FB1";
      $color4->highlight = "#A8B3C5";

      $color5 = new Color();
      $color5->color = "#4D5360";
      $color5->highlight = "#616774";

      $color6 = new Color();
      $color6->color = "#D304FF";
      $color6->highlight = "#D360FF";

      $color7 = new Color();
      $color7->color = "#46BFBD";
      $color7->highlight = "#5AD3D1";

      $color8 = new Color();
      $color8->color = "#2DB51F";
      $color8->highlight = "#58F348";

      $colors = array($color1, $color2, $color3, $color4, $color5, $color6, $color7, $color8);

      $index = 0;
    ?>

    var data = [
      @foreach($genres as $key => $value)
        {
          value: {{ $value }},
          color: "{{ $colors[$index]->color }}",
          highlight: "{{ $colors[$index]->highlight }}",
          label: "{{ $key }}"
        },
        <?php 
          if($index < 7){
            $index++;
          }
          else{
            $index = 0;
          } 
        ?>
      @endforeach
    ];
    var options = {
      responsive: 'true'
    }
    var ctx = document.getElementById("genreChart").getContext("2d");
    var genreChart = new Chart(ctx).PolarArea(data, options);
  </script>
@stop

