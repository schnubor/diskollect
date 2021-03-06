<table class="footable table table-hover">
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
        $genres = explode(';',$vinyl->genre);
      ?>
      <tr>
        <td><a href="{{ URL::route('get-vinyl', $vinyl->id) }}"><img src="{{ $vinyl->artwork }}" alt="cover" class="artwork"/></a></td>
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
