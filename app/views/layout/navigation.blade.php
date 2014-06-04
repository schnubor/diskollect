<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ URL::to('/') }}">Diskollect</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('users') }}">Collectors</a></li>
        @if(Auth::check())
          <li><a href="{{ URL::to('search') }}">Search Vinyl</a></li>
        @endif
      </ul>
      <ul class="nav navbar-nav navbar-right">

        @if(Auth::check())
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->username }}<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="{{ URL::to('users') }}/{{ Auth::user()->id }}">Your Profile</a></li>
              <li><a href="{{ URL::to('users/change-password') }}">Change password</a></li>
              <li class="divider"></li>
              <li><a href="{{ URL::to('users/signout') }}">Logout</a></li>
            </ul>
          </li>
          
        @else
          <li><a href="{{ URL::to('users/signin') }}">Login</a></li>
          <li><a href="{{ URL::to('users/create') }}">Register</a></li>
        @endif
        
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>