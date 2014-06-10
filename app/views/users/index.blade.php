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
        <th>Profile</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->username }}</td>
        <td>{{ $user->email }}</td>
        <td><a href="users/{{ $user->id }}">{{ $user->username }}</a></td>
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