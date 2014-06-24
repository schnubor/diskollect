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

  <table class="footable table table-hover">
    <thead>
      <tr>
        <th>Artwork</th>
        <th>Artist</th>
        <th>Title</th>
        <th>Label</th>
        <th>Genre</th>
        <th>Price</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($vinyls as $vinyl)
        <?php
          $labels = explode(';',$vinyl->label);
          $genres = explode(';',$vinyl->genre);
        ?>
        <tr>
          <td><img src="{{ $vinyl->artwork }}" alt="cover" class="artwork"/></td>
          <td>{{ $vinyl->artist }}</td>
          <td>{{ $vinyl->title }}</td>
          <td>
            @foreach($labels as $label)
              <span class="label-primary label">{{ $label }}</span>
            @endforeach
          </td>
          <td>
            @foreach($genres as $genre)
              <span class="label-warning label">{{ $genre }}</span>
            @endforeach
          </td>
          <td>{{ round($vinyl->price,2) }}</td>
          <td>actions</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@stop

@section('scripts')
  <script type="text/javascript">
    $(function () {
      $('.footable').footable();
    });
  </script>
@stop

