@extends('layout.main')

@section('title')
  {{ $user->username }}
@stop

@section('body')
<div class="container profile">

  <header>
    <div class="profile-image">
      @if($user->image)
        <img src="{{ $user->image }}" alt="{{ $user->username }}" class="img-responsive profile-pic">
      @else
        <img src="/assets/PH_user_large.png" alt="{{ $user->username }}" class="img-responsive profile-pic">
      @endif
    </div>

    <div class="profile-info">
      <div class="username">
        <h1>{{ $user->username }}</h1>
      </div>
      <div class="additional-info">
        @if($user->name)
          <span>{{ $user->name }}</span>
        @endif
        @if($user->location)
          <span>, {{ $user->location }}</span>
        @endif
        @if($user->website)
          <span>, <a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a></span>
        @endif
      </div>
      @if($user->description)
        <div class="user-description">
          <em>{{ $user->description }}</em>
        </div>
      @endif
    </div>
    
    <div class="actions">
      @if(Auth::check() && Auth::user()->id == $user->id)
        <a href="{{ URL::to('users/edit') }}" class="btn btn-default btn-lg edit-button" role="button"><i class="fa fa-gear fa-fw"></i> Edit Profile</a>
      @endif
      <a href="{{ URL::route('get-collection', $user->id) }}" class="btn btn-lg btn-primary" ><i class="fa fa-fw fa-database"></i> View Collection</a>
    </div>

  </header>

  <div class="row">
    <div class="col-md-6">
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

    <div class="col-md-6">
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
</div>
@stop
