<div class="col-md-4">
  <div class="well well-sm">
    <div class="media">
      <a class="thumbnail pull-left" href="{{ URL::to('vinyls') }}/{{ $vinyl->id }}" style="margin-bottom: 0;">
        <img class="media-object" src="{{ $vinyl->artwork }}" style="width: 150px; height: 150px;">
      </a>
      <div class="media-body">
        <h5 class="media-heading">{{ $vinyl->artist }} - {{ $vinyl->title }}</h5>
        <p>
          <span class="label label-info">{{ $vinyl->releasedate }}</span> 
          <span class="label label-primary">{{ $vinyl->genre }}</span>
          <span class="label label-warning">{{ $vinyl->label }}</span>
          <span class="label label-success">{{ $vinyl->country }}</span>
          <span class="label label-default">{{ $vinyl->type }}</span>
          <span class="label label-default">{{ $vinyl->count }}x {{ $vinyl->size }}inch</span>
        </p>
        </p>
      </div>
    </div>
  </div>
</div>