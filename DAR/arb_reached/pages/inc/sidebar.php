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
                <img style="height:35px;width:35px;" src="<?php echo $_SESSION['profile_picture']; ?>" class="img-circle img-responsive" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo ucfirst($_SESSION['username']);?></p>
                <?php echo $_SESSION['role'];?>
            </div>
        </div>

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu tree" data-widget="tree">
            <li class="header">MAIN MENU</li>
        <li class="<?php if($page == 'index') { echo 'active'; } ?>"><a href="index.php"><i class="fa fa-book"></i> <span>Home</span></a></li>
        <li class="<?php if($page == 'add_arb') { echo 'active'; } ?>"><a href="add_arb.php"><i class="fa fa-users"></i> <span>Add ARB</span></a></li>
        
        <!-- reached -->
        <li class="<?php if($page == 'arb-reached') { echo 'active'; } ?>"><a href="arb-reached.php"><i class="fa fa-book"></i> <span>Reached ARB(s)</span></a></li>
        
        <?php if($_SESSION['role'] == 'PARPO I' || $_SESSION['role'] == 'PARPO II') { ?>
            <li><a href="../../po_profiling/pages/index.php">
            <i class="fa fa fa-location-arrow"></i> <span>Po Profiling</span></a></li>
            <li class="<?php if($page == 'sys-users') { echo 'active'; } ?>"><a href="confirm-user.php">
            <i class="fa fa fa-user"></i> <span>System Users&nbsp;&nbsp; <span class="badge"><?php echo $users_count ; ?></span></span></a></li>
        <?php } ?>
        
        <!-- Organization -->
            <li class="treeview <?php if($page == 'register' || $page == 'update-profile') { echo 'active'; }?>">
                <a href="#">
                    <i class="fa fa-gear"></i> <span>Settings</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu"> 
                    <li class="<?php if($page == 'register') { echo 'active'; }?>"><a href="register-user.php"><i class="fa fa-circle-o"></i>Register User</a></li>
                    <li class="<?php if($page == 'update-profile') { echo 'active'; }?>"><a href="update-profile.php"><i class="fa fa-circle-o"></i>Update Profile</a></li>
                </ul>
            </li>
    </ul></section>
    <!-- /.sidebar -->
</aside>