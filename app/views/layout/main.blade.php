<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
  <?= stylesheet_link_tag() ?>
  <?= javascript_include_tag() ?>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  <title>
    Diskollect | @yield('title')
  </title>
</head>
<body>
  <!-- Navigation -->
  @include('layout.navigation')

  <div class="container">

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

  @yield('scripts')
</body>
</html>