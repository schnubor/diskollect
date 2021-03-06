<!doctype html>
<html lang="en">
  @include('layout.head')
<body>
  <!-- Tracking -->
  @include('tracking.google')

  <!-- Navigation -->
  @include('layout.navigation')

  @yield('outer-body')

  <div class="notifications">
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

    @if(Session::has('info-alert'))
      <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('info-alert') }}
      </div>
    @endif
  </div>

  <!-- Actual content -->
  @yield('body')

  @yield('scripts')
</body>
</html>
