@extends('layout.main')

@section('title')
  {{ $vinyl->artist }} - {{ $vinyl->title }}
@stop

@section('body')
  <div class="page-header">
      <h1>{{ $vinyl->artist }} - {{ $vinyl->title }}</h1>
  </div>

  <div class="row">
      <div class="col-md-4">
        <div class="well well-sm">
          <div class="media">
            <a class="thumbnail pull-left" href="#" style="margin-bottom: 0;">
              <img class="media-object" src="{{ $vinyl->artwork }}" style="width: 150px; height: 150px;">
            </a>
            <div class="media-body">
              <h5 class="media-heading">{{ $vinyl->artist }} - {{ $vinyl->title }}</h5>
              <p>
                <span class="label label-info">{{ $vinyl->releasedate }}</span> <span class="label label-primary">{{ $vinyl->genre }}</span> <span class="label label-success">{{ $vinyl->label }}</span> <span class="label label-default">{{ $vinyl->count }}x {{ $vinyl->size }}inch</span></p>
              </p>
            </div>
          </div>
        </div>
      </div>
  </div>

  <a class="btn btn-default btn-md" role="button" href="{{ URL::to('users') }}/{{ Auth::user()->id }}/collection"><i class="fa fa-angle-double-left"></i> Back to collection</a>

@stop

