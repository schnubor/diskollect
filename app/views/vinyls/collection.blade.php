@extends('layout.main')

@section('title')
  Collection
@stop

@section('body')
  <div class="page-header">
    @if(Auth::check())
      @if($user->id == Auth::user()->id)
        <h1>Your Collection</h1>
      @else
        <h1>{{ $user->name }}´s Collection</h1>
      @endif
    @else
      <h1>{{ $user->name }}´s Collection</h1>
    @endif
  </div>

  <div class="row">
    @foreach($vinyls as $vinyl)
      @include('vinyls.card')
    @endforeach
  </div>

@stop

