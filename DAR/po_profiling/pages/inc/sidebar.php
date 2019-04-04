<?php
    $users_sql = 'SELECT COUNT(*) from users where user_stat_id = 2';
    $users_sql = $conn->prepare($users_sql);
    $users_sql->execute();
    $users_sql->bind_result($users_count);
    $users_sql->store_result();
    $users_sql->fetch();
?>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
        <!-- Sidebar user panel -->
        <div class="user-panel" style="padding-top:30px;">
            <div class="pull-left image">
                <img src="<?php echo $_SESSION['profile_picture']; ?>"
                style="height:35px;width:35px;" class="img-circle" alt="profile_pic">
            </div>
            <div class="pull-left info">
                <?php if(isset($_SESSION['username']))  echo '<p>'.$_SESSION['username'] .'</p>';  else  echo '<p>Username</p>';  ?>
                <?php if(isset($_SESSION['role']))  echo ''.$_SESSION['role'] .'';  else  echo 'Role';  ?>
            </div>
        </div>

        

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header">MAIN MENU</li>

            <li class="<?php if($page=='home') { echo 'active' ; } ?>">
                <a href="index.php">
                    <i class="fa fa-home"></i> <span>Home</span>
                </a>
            </li>

            <li class="<?php if($page=='form') { echo 'active' ; } ?>">
                <a href="po_profile_form.php">
                    <i class="fa fa-plus-circle"></i>
                    <span>Add Organization</span>
                    <!-- ARBO Profiling , View ARBO Profiling, ARBO REPORTS-->
                </a>
            </li>

            <li class="<?php if($page=='view' || $page == 'edit') { echo 'active' ; } ?>">
                <a href="po_profile_search.php">
                    <i class="fa fa-search"></i>
                    <span>List of Organizations</span>
                </a>
            </li>

        <?php if($_SESSION['role'] == 'PARPO I' || $_SESSION['role'] == 'PARPO II') { ?>
            <li><a href="../../arb_reached/pages/index.php">
            <i class="fa fa fa-location-arrow"></i> <span>ARB Reached</span></a></li>
            <li class="<?php if($page == 'sys-users') { echo 'active'; } ?>"><a href="confirm-user.php">
            <i class="fa fa fa-user"></i> <span>System Users&nbsp;&nbsp; <span class="badge"><?php echo $users_count ; ?></span></span></a></li>
        <?php } ?>

        <li class="treeview <?php if($page == 'reg-user' || $page == 'up-user') { echo 'active'; } ?>"  >
            <a href="#">
                <i class="fa fa-gear"></i> <span>Settings</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>


            <ul class="treeview-menu"> 
                <li class="<?php if($page == 'reg-user') { echo 'active'; } ?>"><a href="register-user.php"><i class="fa fa-circle-o"></i>Register User</a></li>
                <li class="<?php if($page == 'up-user') { echo 'active'; } ?>"><a href="update-profile.php"><i class="fa fa-circle-o"></i>Update Profile</a></li>
                <li><a href="print_form.php" target="_blank"><i class="fa fa-circle-o"></i>Print Vacant Form</a></li>
                <li><a href="print_mem_form.php" target="_blank"><i class="fa fa-circle-o"></i>Print Member Form</a></li>
            </ul>
        </li>
        </ul></section>
    <!-- /.sidebar -->
</aside>