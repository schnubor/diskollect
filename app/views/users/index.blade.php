@extends('layout.main')

@section('title')
  All Users
@stop

@section('body')
  <div class="container members">
    <div class="page-header">
      <h1>Collectors</h1>
    </div>

    <table class="table table-striped table-responsive footable">
      <thead>
        <tr>
          <th data-hide="phone">ID</th>
          <th data-hide="phone">Pic</th>
          <th data-toggle="true">User name</th>
          <th>Vinyl count</th>
          <th data-hide="phone">Member since</th>
          <th data-hide="phone">Status</th>
          <th data-hide="phone" style="text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td><div class="profile-pic">
          @if($user->image)
            <img src="{{ $user->image }}" alt="{{ $user->username }}">
          @else
            <img src="{{ USER_PH_PATH }}" alt="{{ $user->username }}">
          @endif
          </div></td>
          <td><a href="{{ URL::to('users') }}/{{ $user->id }}">{{ $user->username }}</a></td>
          <td><a href="{{ URL::to('users') }}/{{ $user->id }}/collection">{{ $user->vinyls()->count() }} Vinyls</a></td>
          <td>{{ $user->created_at }}</td>
          <td>
          @if($user->active == 1)
            <span class="label label-success">active</span>
          @else
            <span class="label label-default">inactive</span>
          @endif
          </td>
          <td style="text-align: right;">
            <a href="{{ URL::route('get-user', $user->id) }}" class="btn btn-sm btn-default"><i class="fa fa-fw fa-user"></i> Profile</a>
            <a href="{{ URL::route('get-collection', $user->id) }}" class="btn btn-sm btn-default"><i class="fa fa-fw fa-database"></i> Collection</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    
    <div class="pagination-container">
      {{ $users->links() }}
    </div>

  </div>
@stop

@section('scripts')
  <script type="text/javascript">
    $(function () {
      $('.footable').footable();
    });
  </script>
@stop
