@extends('layout.main')

@section('title')
  Collection
@stop

@section('body')
  <div class="container user-collection">
    <div class="collection-header">
      <div class="user-portrait">
        <img src="{{ $user->image }}" alt="{{ $user->username }}">
      </div>
      @if(Auth::check())
        @if($user->id == Auth::user()->id)
          <h1>Your Collection</h1>
        @else
          <h1>{{ $user->username }}´s Collection</h1>
        @endif
      @else
        <h1>{{ $user->username }}´s Collection</h1>
      @endif
      <small>{{ $user->vinyls->count() }} Vinyls</small>
    </div>

    @if($user->vinyls->count() != 0)
      <div class="row vinyl-list">
      @foreach($user->vinyls as $vinyl)
        <div class="col-sm-3 vinyl">
          <div class="vinyl-cover">
          <a href="{{ URL::route('get-vinyl', $vinyl->id) }}"><img src="{{ $vinyl->artwork }}" alt="{{ $vinyl->artist.' - '.$vinyl->title }}"></a>
          </div>
          <div class="vinyl-artist">
            <span>{{ $vinyl->artist }}</span>
          </div>
          <div class="vinyl-title">
            <span>{{ $vinyl->title }}</span>
          </div>
        </div>
      @endforeach
      </div>
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
  </div>
@stop

@section('scripts')
  <script type="text/javascript">
    $(function () {
      $('.footable').footable();
    });
  </script>
@stop

