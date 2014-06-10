@extends('layout.main')

@section('title')
  Collection
@stop

@section('body')
  <div class="page-header">
    @if($user->id == Auth::user()->id)
      <h1>Your Collection</h1>
    @else
      <h1>{{ $user->name }}´s Collection</h1>
    @endif
  </div>

  @foreach($vinyls as $vinyl)
    <p>
      {{ $vinyl->title }}
    </p>
  @endforeach

@stop

