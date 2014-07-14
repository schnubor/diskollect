@extends('layout.main')

@section('title')
  {{ $user->username }}
@stop

@section('body')

  <div class="row">
		<div class="col-sm-3"><!--left col-->

      <ul class="list-group">
        <li class="list-group-item text-muted">
          @if($user->image)
          <img src="{{ $user->image }}" alt="{{ $user->username }}" class="img-responsive profile-pic">
          @else
          <img src="/assets/PH_user_large.png" alt="{{ $user->username }}" class="img-responsive profile-pic">
          @endif
        </li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Username</strong></span> {{ $user->username }}</li>
        @if($user->name)
        <li class="list-group-item text-right"><span class="pull-left"><strong>Name</strong></span> {{ $user->name }}</li>
        @endif
        <li class="list-group-item text-right"><span class="pull-left"><strong>Email</strong></span> {{ $user->email }}</li>
        @if($user->location)
        <li class="list-group-item text-right"><span class="pull-left"><strong>Location</strong></span> {{ $user->location }}</li>
        @endif
      </ul>

      <a href="{{ URL::route('get-collection', $user->id) }}" class="btn btn-lg btn-primary" style="width: 100%; margin-bottom: 20px;"><i class="fa fa-fw fa-database"></i> View Collection</a>

      @if($user->website)
        <div class="panel panel-default">
          <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
          <div class="panel-body"><a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a></div>
        </div>
      @endif

      @if($user->description)
      <div class="panel panel-default">
        <div class="panel-heading">Description</div>
        <div class="panel-body">{{ $user->description }}</div>
      </div>
      @endif

      @if(Auth::check() && Auth::user()->id == $user->id)
        <a href="{{ URL::to('users/edit') }}" class="btn btn-default btn-sm" role="button" style="margin-right: 10px;"><i class="fa fa-gear fa-fw"></i> Edit Profile</a>
      @endif
    </div>

    <div class="col-sm-9">
      <div class="page-header profile-user-name">
        <h1>{{ $user->vinyls->count() }} vinyls</h1>
      </div>

      <!-- Level progress -->
      <div class="row">
        <div class="col-xs-6 col-xs-offset-3 text-center well">
          <h2>Level {{ $level }}</h2>
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

      <hr>

      @if($vinyls->count() == 0)
        <small>This user doesn't have any vinyls yet.</small>
      @else
        @include('vinyls.table')
      @endif
    </div>

  </div>

@stop
