@extends('layout.main')

@section('title')
  {{ $user->username }}
@stop

@section('body')
  <div class="page-header">
  	<h1>{{ $user->username }} 
  	@if(Auth::check())
  		<a href="#" class="btn btn-default btn-sm" role="button">Edit Profile</a>
  	@endif
  	</h1>
  </div>

  <div class="row">
		<div class="col-sm-4"><!--left col-->  

      <ul class="list-group">
        <li class="list-group-item text-muted"><img src="{{ $user->image }}" alt="{{ $user->username }}" class="img-responsive"></li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Name</strong></span> {{ $user->name }}</li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Email</strong></span> {{ $user->email }}</li>
        <li class="list-group-item text-right"><span class="pull-left"><strong>Country</strong></span> {{ $user->country }}</li>
      </ul>

      <div class="panel panel-default">
        <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
        <div class="panel-body"><a href="http://{{ $user->website }}" target="_blank">{{ $user->website }}</a></div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">Description</div>
        <div class="panel-body">{{ $user->description }}</div>
      </div>
    </div>

    <div class="col-sm-8">
    	Right side content ...
    </div>

  </div>
  
@stop