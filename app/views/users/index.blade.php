@extends('layout.main')

@section('title')
  All Users
@stop

@section('body')
  <div class="page-header">
    <h1>All users</h1>
  </div>

  <table class="table table-striped table-responsive">
    <thead>
      <tr>
        <th>ID</th>
        <th>User name</th>
        <th>Email</th>
        <th>Collection</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <tr>
        <td>{{ $user->id }}</td>
        <td><a href="{{ URL::to('users') }}/{{ $user->id }}">{{ $user->username }}</a></td>
        <td>{{ $user->email }}</td>
        <td><a href="{{ URL::to('users') }}/{{ $user->id }}/collection">{{ $user->vinyls()->count() }} Vinyls</a></td>
        @if($user->active == 1)
          <td class="success">active</td>
        @else
          <td class="danger">inactive</td>
        @endif
      </tr>
      @endforeach
    </tbody>
  </table>
@stop