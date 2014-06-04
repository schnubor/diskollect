<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  <title>
    @yield('title')
  </title>
</head>
<body>
  <div class="container">

    <!-- Navigation -->
    @include('layout.navigation')

    <!-- All the notifications -->
    @if(Session::has('success-alert'))
      <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('success-alert') }}
      </div>
    @endif

    @if(Session::has('danger-alert'))
      <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('danger-alert') }}
      </div>
    @endif

    <!-- Actual content -->
    @yield('body')
  </div>
</body>
</html>