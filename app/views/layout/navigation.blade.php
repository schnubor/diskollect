<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ URL::to('/') }}" style="font-weight: bold;">
        <img src="/assets/logo.png" alt="Logo" class="logo"> Diskollect
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        @if(Auth::check())
          <li><a href="{{ URL::route('get-user', Auth::user()->id) }}"><i class="fa fa-bar-chart-o fa-fw"></i> Your Stats</a></li>
          <li><a href="{{ URL::route('get-collection', Auth::user()->id) }}"><i class="fa fa-database fa-fw"></i> Collection</a></li>
          <li><a href="{{ URL::route('get-search') }}"><i class="fa fa-plus-circle fa-fw"></i> New Vinyl</a></li>
        @else
          <li><a href="{{ URL::route('get-all-users') }}"><i class="fa fa-users fa-fw"></i> Members</a></li>
        @endif
      </ul>
      <ul class="nav navbar-nav navbar-right">

        @if(Auth::check())
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user fa-fw"></i> {{ Auth::user()->username }}<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="{{ URL::route('get-edit-user') }}"><i class="fa fa-pencil fa-fw"></i> Edit Profile</a></li>
              <li><a href="{{ URL::route('get-change-password') }}"><i class="fa fa-lock fa-fw"></i> Change password</a></li>
              <li class="divider"></li>
              <li><a href="{{ URL::route('get-signout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">More<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="{{ URL::route('get-all-users') }}"><i class="fa fa-users fa-fw"></i> Members</a></li>
              <li><a href="#"><i class="fa fa-info fa-fw"></i> Impressum</a></li>
            </ul>
          </li>
        @else
          <li><a href="{{ URL::route('get-signin') }}"><i class="fa fa-sign-in"></i> Login</a></li>
          <li><a href="{{ URL::route('get-user-create') }}"><i class="fa fa-edit"></i> Register</a></li>
        @endif
        
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</div>