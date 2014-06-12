<nav class="navbar navbar-default" role="navigation" style="margin-top: 20px;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ URL::to('/') }}" style="font-weight: bold;">Diskollect</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="{{ URL::to('users') }}"><i class="fa fa-users fa-fw"></i> Members</a></li>
        @if(Auth::check())
          <li><a href="{{ URL::to('users') }}/{{ Auth::user()->id }}/collection"><i class="fa fa-database fa-fw"></i> Collection</a></li>
          <li><a href="{{ URL::to('search') }}"><i class="fa fa-search fa-fw"></i> Search Vinyl</a></li>
        @endif
      </ul>
      <ul class="nav navbar-nav navbar-right">

        @if(Auth::check())
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->username }}<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="{{ URL::to('users') }}/{{ Auth::user()->id }}"><i class="fa fa-user fa-fw"></i> Your Profile</a></li>
              <li><a href="{{ URL::to('users/edit') }}"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
              <li><a href="{{ URL::to('users/change-password') }}"><i class="fa fa-lock fa-fw"></i> Change password</a></li>
              <li class="divider"></li>
              <li><a href="{{ URL::to('users/signout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
            </ul>
          </li>
          
        @else
          <li><a href="{{ URL::to('users/signin') }}"><i class="fa fa-sign-in"></i> Login</a></li>
          <li><a href="{{ URL::to('users/create') }}"><i class="fa fa-edit"></i> Register</a></li>
        @endif
        
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>