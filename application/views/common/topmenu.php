<!-- Beginning of header -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
          <div class="container-fluid">

            <a class="brand" href=""><?php echo  HTML::image("img/custom/icon.png"); ?> AXON-Desk</a>
            <div class="nav-collapse">
              <ul class="nav pull-right">
                <li class="dropdown ">
                    <a class="dropdown-toggle user" data-toggle="dropdown" href="#">
                      Logged in as<span class='username'> <?php echo Auth::user()->user_name; ?> </span>
                    <b class="caret"></b>
                    </a>
                 
                  <ul class="dropdown-menu">
                   <li> <a href="profile_view"> <i class="icon-wrench"></i> Profile & Settings</a> </li>
                   <li class="divider"></li>
                   <li> <a href="logout"> <i class="icon-off"></i> Sign out</a> </li>
                   <!-- <li> <a href="#"> <i class="icon-off"></i> Settings</a> </li> -->
                  </ul>
                </li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
      </div>
    </div>
    <!-- <div class='divider'></div> -->
    <!-- Beginning of header -->