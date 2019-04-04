<header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>ARB</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>ARB</b>REACHED</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <img src="<?php echo $_SESSION['profile_picture']; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo ucfirst($_SESSION['username']); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo $_SESSION['profile_picture']; ?>" class="img-circle" alt="Image">

                <p>
                  <?php echo '<p>' .ucfirst($_SESSION['username']) . '</p>';
                        echo '<p>' . $_SESSION['role'] . '</p>';
                  ?>

                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">

              <div class="pull-left">
                  <a href="profile.php">
                    <button type="button" class="btn btn-default btn-flat">Profile</button>
                  </a>
              </div>
                <div class="pull-right">
                  <form action="controller/logout.php" method="post">
                    <input type="hidden" name="session" value="<?php echo $_SESSION['ssid']; ?>">
                    <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                    <button type="submit" class="btn btn-default btn-flat" value="1" name="logout">Sign out</button>
                  </form>
                </div>
              </li>
            </ul>
          </li>
            </ul>
        </div>
    </nav>
</header>
