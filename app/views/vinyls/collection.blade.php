@extends('layout.main')

@section('title')
  Collection
@stop

@section('body')
  <div class="container user-collection">
    <div class="collection-header">
      <div class="user-portrait">
      <a href="{{ URL::route('get-user', $user->id) }}">
        @if($user->image)
          <img src="{{ $user->image }}" alt="{{ $user->username }}">
        @else
          <img src="{{ USER_PH_PATH }}" alt="{{ $user->username }}">
        @endif
      </a>
      </div>
      @if(Auth::check())
        @if($user->id == Auth::user()->id)
          <h1>Your Collection</h1>
        @else
          <h1>{{ $user->username }}s Collection</h1>
        @endif
      @else
        <h1>{{ $user->username }}´s Collection</h1>
      @endif
      <small>{{ $user->vinyls->count() }} Vinyls</small>
    </div>

    <div class="collection-controls row">
      {{ Form::open(array('route' => array('get-collection', $user->id), 'method' => 'get', 'class' => 'form-inline')) }}
      <div class="col-md-6">
        {{ Form::text('filter', Input::old('filter'), array('class' => 'form-control')) }}
        {{ Form::submit('Filter', array('class' => 'btn btn-default')) }}
      </div>
      {{ Form::close() }}
      <div class="col-md-6">
        <div class="btn-group pull-right">
        @if($grid == 'grid')
          <a href="{{ URL::route('get-collection', array($user->id, 'grid')) }}" class="btn btn-default active"><i class="fa fa-fw fa-th"></i></a>
          <a href="{{ URL::route('get-collection', array($user->id, 'table')) }}" class="btn btn-default"><i class="fa fa-fw fa-align-justify"></i></a>
        @else
          <a href="{{ URL::route('get-collection', array($user->id, 'grid')) }}" class="btn btn-default"><i class="fa fa-fw fa-th"></i></a>
          <a href="{{ URL::route('get-collection', array($user->id, 'table')) }}" class="btn btn-default active"><i class="fa fa-fw fa-align-justify"></i></a>
        @endif
        </div>
      </div>
    </div>

    @if($user->vinyls->count() != 0)
      <div class="row vinyl-list">
      @if($grid == 'grid')
        @foreach($vinyls as $vinyl)
          <div class="col-sm-3 vinyl">
            <div class="vinyl-cover">
              <div class="content">
                <div class="overlay">
                  <a href="{{ URL::route('get-vinyl', $vinyl->id) }}">
                    <div class="view-vinyl">
                    </div>
                  </a>
                  @if(Auth::check())
                    @if(Auth::user()->id == $user->id)
                      <a href="{{ URL::route('get-edit-vinyl', $vinyl->id) }}" class="btn btn-default edit-vinyl"><i class="fa fa-pencil"></i></a>
                      {{ Form::open(array('route' => array('delete-vinyl', $vinyl->id))) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::button('<i class="fa fa-trash-o"></i>', array('class' => 'btn btn-default delete-vinyl', 'type' => 'submit')) }}
                      {{ Form::close() }}
                    @endif
                  @endif
                </div>
                
                <a href="{{ URL::route('get-vinyl', $vinyl->id) }}">
                @if(@getimagesize($vinyl->artwork))
                  <img src="{{ $vinyl->artwork }}" alt="{{ $vinyl->artist.' - '.$vinyl->title }}">
                @else
                  <img src="{{ VINYL_PH_PATH }}" alt="{{ $vinyl->artist.' - '.$vinyl->title }}">
                @endif
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
      @else <!-- Table layout -->
        <div class="container">
        <table class="table footable">
          <thead>
            <tr>
              <th data-hide="phone">Artwork</th>
              <th data-toggle="true">Artist</th>
              <th>Title</th>
              <th data-hide="phone,tablet">Label</th>
              <!--<th>Genre</th>-->
              <th data-hide="phone,tablet">Price</th>
              @if(Auth::check())
                @if(Auth::user()->id == $user->id)
                  <th style="text-align: right;">Actions</th>
                @endif
              @endif
            </tr>
          </thead>
          <tbody>
            @foreach($vinyls as $vinyl)
              <?php
                $labels = explode(';',$vinyl->label);
              ?>
              <tr>
                <td><a href="{{ URL::route('get-vinyl', $vinyl->id) }}">
                  @if(@getimagesize($vinyl->artwork))
                    <img src="{{ $vinyl->artwork }}" alt="cover" class="artwork"/>
                  @else
                    <img src="{{ VINYL_PH_PATH }}" alt="cover" class="artwork"/>
                  @endif
                </a></td>
                <td><a href="{{ URL::route('get-vinyl', $vinyl->id) }}">{{ $vinyl->artist }}</a></td>
                <td><a href="{{ URL::route('get-vinyl', $vinyl->id) }}">{{ $vinyl->title }}</a></td>
                <td>
                  <a href="{{ URL::route('get-vinyl', $vinyl->id) }}">
                    @foreach($labels as $label)
                      <span class="label-primary label">{{ $label }}</span>
                    @endforeach
                  </a>
                </td>
                <td><a href="{{ URL::route('get-vinyl', $vinyl->id) }}">{{ round($vinyl->price,2) }} {{ $user->currency }}</a></td>
                @if(Auth::check())
                  @if(Auth::user()->id == $user->id)
                    <td>
                      {{ Form::open(array('route' => array('delete-vinyl', $vinyl->id), 'class' => 'pull-right')) }}
                        {{ Form::hidden('_method', 'DELETE') }}
                        {{ Form::button('<i class="fa fa-trash-o fa-fw"></i>', array('class' => 'btn btn-sm btn-default', 'style' => 'margin-left: 10px', 'type' => 'submit')) }}
                      {{ Form::close() }}

                      <a href="{{ URL::route('get-edit-vinyl', $vinyl->id) }}" style="display: inline-block; float: right;"><button class="btn btn-sm btn-default pull-right"><i class="fa fa-pencil fa-fw"></i></button></a>
                    </td>
                  @endif
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>
        </div>
      @endif
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

@if($grid == 'table')
  @section('scripts')
    <script type="text/javascript">
      $(function () {
        $('.footable').footable();
      });
    </script>
  @stop
@endif

