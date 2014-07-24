@extends('layout.main')

@section('title')
  All Users
@stop

@section('body')
<div class="container">
  <div class="page-header">
    <h1>All {{ $users->count() }} users</h1>
  </div>

  <table class="table table-striped table-responsive footable">
    <thead>
      <tr>
        <th>ID</th>
        <th>User name</th>
        <th>Vinyl count</th>
        <th>Member since</th>
        <th>Status</th>
        <th style="text-align: right;">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <tr>
        <td>{{ $user->id }}</td>
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
          <a href="{{ URL::route('get-user', $user->id) }}" class="btn btn-default"><i class="fa fa-fw fa-user"></i> View profile</a>
          <a href="{{ URL::route('get-collection', $user->id) }}" class="btn btn-default"><i class="fa fa-fw fa-database"></i> View collection</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@stop
