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

  @if($user->vinyls->count() != 0)

    @include('vinyls.table')

  @else

    @if(Auth::check())
      @if($user->id == Auth::user()->id)
        <p>You don't have any vinyls in your collection yet. Go add some!</p>
        <a href="{{ URL::route('get-search') }}" class="btn btn-large btn-primary">Add a vinyl</a>
      @else
        <p>This user doesn't have any vinyls yet.</p>
      @endif
    @else
      <p>This user doesn't have any vinyls yet.</p>
    @endif
    
  @endif
@stop

@section('scripts')
  <script type="text/javascript">
    $(function () {
      $('.footable').footable();
    });
  </script>
@stop

