@extends('layout.main')

@section('title')
  {{ $user->username }}
@stop

@section('body')
  <div class="page-header">
  <h1>{{ $user->username }} <small>{{ $user->email }}</small></h1>
  </div>
  
@stop