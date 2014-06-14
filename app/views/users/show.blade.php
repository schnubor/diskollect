@extends('layout.main')

@section('title')
  {{ $user->username }}
@stop

@section('body')
  <div class="page-header">
  	<h1>{{ $user->username }} 
  	@if(Auth::check())
  		<a href="{{ URL::to('users/edit')}}" class="btn btn-default btn-sm" role="button">Edit Profile</a>
  	@endif
  	</h1>
  </div>

  <div class="row">
		<div class="col-sm-4"><!--left col-->  

      <ul class="list-group">
        <li class="list-group-item text-muted"><img src="{{ $user->image }}" alt="{{ $user->username }}" class="img-responsive"></li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Name</strong></span> {{ $user->name }}</li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Email</strong></span> {{ $user->email }}</li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Location</strong></span> {{ $user->location }}</li>
      </ul>

      <div class="panel panel-default">
        <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
        <div class="panel-body"><a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a></div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">Description</div>
        <div class="panel-body">{{ $user->description }}</div>
      </div>
    </div>

    <div class="col-sm-8">
      @foreach($vinyls as $vinyl)
      	<div class="col-sm-6">
          <div class="well well-sm">
            <div class="media">
              <a class="thumbnail pull-left" href="{{ URL::to('vinyls') }}/{{ $vinyl->id }}" style="margin-bottom: 0;">
                <img class="media-object" src="{{ $vinyl->artwork }}" style="width: 150px; height: 150px;">
              </a>
              <div class="media-body">
                <h5 class="media-heading">{{ $vinyl->artist }} - {{ $vinyl->title }}</h5>
                <p>
                  <span class="label label-info">{{ $vinyl->releasedate }}</span> 
                  <span class="label label-primary">{{ $vinyl->genre }}</span> 
                  <span class="label label-warning">{{ $vinyl->label }}</span> 
                  <span class="label label-success">{{ $vinyl->country }}</span> 
                  <span class="label label-default">{{ $vinyl->releasetype }}</span> 
                  <span class="label label-default">{{ $vinyl->count }}x {{ $vinyl->size }}inch</span>
                </p>
              </div>
            </div>
          </div>  
        </div>
      @endforeach
    </div>

  </div>
  
@stop