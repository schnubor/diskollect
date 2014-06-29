<table class="footable table table-hover">
  <thead>
    <tr>
      <th>Artwork</th>
      <th>Artist</th>
      <th>Title</th>
      <th>Label</th>
      <!--<th>Genre</th>-->
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
        <!--<td>
          @foreach($genres as $genre)
            <span class="label-warning label">{{ $genre }}</span>
          @endforeach
        </td>-->
        <td>{{ round($vinyl->price,2) }}</td>
        <td>
          @if(Auth::check())
            @if(Auth::user()->id == $vinyl->user_id)
              {{ Form::open(array('route' => array('delete-vinyl', $vinyl->id), 'class' => 'pull-right')) }}
                {{ Form::hidden('_method', 'DELETE') }}
                {{ Form::button('<i class="fa fa-trash-o fa-fw"></i>', array('class' => 'btn btn-sm btn-danger', 'style' => 'margin-left: 10px', 'type' => 'submit')) }}
              {{ Form::close() }}
            @endif
          @endif
          <a href="{{ URL::route('get-vinyl', $vinyl->id) }}"><button class="btn btn-sm btn-success pull-right">Show</button></a>
          
        </td>
      </tr>
    @endforeach
  </tbody>
</table>