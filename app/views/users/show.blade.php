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
        @if($user->name)
        <li class="list-group-item text-right"><span class="pull-left"><strong>Name</strong></span> {{ $user->name }}</li>
        @endif
        <li class="list-group-item text-right"><span class="pull-left"><strong>Email</strong></span> {{ $user->email }}</li>
        @if($user->location)
        <li class="list-group-item text-right"><span class="pull-left"><strong>Location</strong></span> {{ $user->location }}</li>
        @endif
      </ul>
      
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
    </div>

    <div class="col-sm-9">
      <div class="page-header profile-user-name">
        <h2>{{ $user->username }} <small>{{ $user->vinyls->count() }} vinyls</small>
        @if(Auth::check() && Auth::user()->id == $user->id)
          <a href="{{ URL::to('users/edit')}}" class="btn btn-default btn-sm pull-right" role="button">Edit Profile</a>
        @endif
        </h2>
      </div>
      @if($vinyls->count() == 0)
        <small>This user doesn't have any vinyls yet.</small>
      @else
        @include('vinyls.table')
      @endif
    </div>

  </div>
  
@stop