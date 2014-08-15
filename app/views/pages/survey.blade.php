@extends('layout.main')

@section('title')
  Survey
@stop

@section('body')
  <div class="jumbotron" style="margin-top: -20px;">
    <div class="container">
      <h1 style="text-align: center; margin-bottom: 60px;">Choose your language</h1>
      <div class="col-md-3 col-md-offset-3">
        <a href="{{ URL::route('get-survey-de') }}" class="btn btn-block btn-lg btn-info">Deutsch</a>
      </div>
      <div class="col-md-3">
        <a href="{{ URL::route('get-survey-en') }}" class="btn btn-block btn-lg btn-info">English</a>
      </div>
    </div>
  </div>
@stop