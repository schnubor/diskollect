@extends('layout.main')

@section('title')
  {{ $user->username }}
@stop

@section('body')

  <div class="row profile">
		<div class="col-md-3"><!--left col-->

      <ul class="list-group">
        <li class="list-group-item text-muted">
          @if($user->image)
            <img src="{{ $user->image }}" alt="{{ $user->username }}" class="img-responsive profile-pic">
          @else
            <img src="/assets/PH_user_large.png" alt="{{ $user->username }}" class="img-responsive profile-pic">
          @endif
          @if(Auth::check() && Auth::user()->id == $user->id)
            <a href="{{ URL::to('users/edit') }}" class="btn btn-default btn-sm edit-button" role="button"><i class="fa fa-gear fa-fw"></i> Edit Profile</a>
          @endif
        </li>
        <li class="list-group-item text-left"><strong>{{ $user->username }}</strong></li>
        @if($user->name)
        <li class="list-group-item text-left">{{ $user->name }}</li>
        @endif
        @if($user->location)
        <li class="list-group-item text-left">{{ $user->location }}</li>
        @endif
      </ul>

      <a href="{{ URL::route('get-collection', $user->id) }}" class="btn btn-lg btn-primary" style="width: 100%; margin-bottom: 20px;"><i class="fa fa-fw fa-database"></i> View Collection</a>

      @if($user->website)
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Website <i class="fa fa-link fa-1x"></i></h3>
          </div>
          <div class="panel-body"><a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a></div>
        </div>
      @endif

      @if($user->description)
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Description</h3>
        </div>
        <div class="panel-body">{{ $user->description }}</div>
      </div>
      @endif
    </div>

    <div class="col-md-9">

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
      </div><!-- end of progress -->
      
      <div class="panel panel-success">
        <div class="panel-heading">
          <h3 class="panel-title">Collection Value</h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-md-4 text-center">
              <p class="h3" style="margin-top: 10px;"><small class="h3">SUM</small> {{ round($vinyls->sum('price'), 2).' '.$user->currency }}</p>
            </div>
            <div class="col-md-4 text-center">
              <p class="h3" style="margin-top: 10px;"><small class="h3">AVG</small> {{ round($vinyls->avg('price'), 2).' '.$user->currency }}</p>
            </div>
            <div class="col-md-4 text-center">
              <p class="h3" style="margin-top: 10px;"><small class="h3">MAX</small> {{ round($vinyls->max('price'), 2).' '.$user->currency }}</p>
            </div>
          </div>
        </div>
      </div>
      

    </div>

  </div>

@stop
