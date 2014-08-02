@extends('layout.main')

@section('title')
  Collection
@stop

@section('body')
  <div class="container user-collection">
    <div class="collection-header">
      <div class="user-portrait">
      <a href="{{ URL::route('get-user', $user->id) }}"><img src="{{ $user->image }}" alt="{{ $user->username }}"></a>
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
      @foreach($vinyls as $vinyl)
        <div class="col-sm-3 vinyl">
          <div class="vinyl-cover">
            <div class="content">
              <div class="overlay">
                <a href="{{ URL::route('get-vinyl', $vinyl->id) }}">
                  <div class="view-vinyl">
                  </div>
                </a>
                <a href="{{ URL::route('get-edit-vinyl', $vinyl->id) }}" class="btn btn-default edit-vinyl"><i class="fa fa-pencil"></i></a>
                {{ Form::open(array('route' => array('delete-vinyl', $vinyl->id))) }}
                  {{ Form::hidden('_method', 'DELETE') }}
                  {{ Form::button('<i class="fa fa-trash-o"></i>', array('class' => 'btn btn-default delete-vinyl', 'type' => 'submit')) }}
                {{ Form::close() }}
              </div>
              
              <a href="{{ URL::route('get-vinyl', $vinyl->id) }}">
                <img src="{{ $vinyl->artwork }}" alt="{{ $vinyl->artist.' - '.$vinyl->title }}">
              </a>
            </div>
          </div>
          <div class="vinyl-info">
            <div class="vinyl-artist">
              <span>{{ $vinyl->artist }}</span>
            </div>
            <div class="vinyl-title">
              <span>{{ $vinyl->title }}</span>
            </div>
          </div>
        </div>
      @endforeach
      </div>

      <div class="pagination-container">
        {{ $vinyls->links() }}
      </div>
    @else
      <!-- Vinyl Count is 0 -->
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

