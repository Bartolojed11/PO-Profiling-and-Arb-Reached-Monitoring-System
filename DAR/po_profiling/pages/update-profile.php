<?php
session_start();
require 'controller/connection.php';
require 'controller/user_functions.php';
$_COOKIE['username'] = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
$_COOKIE['ssid'] = isset($_COOKIE['ssid']) ? $_COOKIE['ssid'] : '';
    if(authUser($_COOKIE['username'],$_COOKIE['ssid'], $conn)) {
        $user = $_COOKIE['username'] ;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <?php include 'inc/css_and_meta.php';?>
        <title>PPS | Add User</title>
        <style>
            .user-panel {
                background-image:url('../logo/dar-bg.png');
                height:100px;
            }
        </style>
    </head>
    <body class="skin-green fixed sidebar-mini sidebar-mini-expand-feature hold-transition">
        <!-- Site wrapper -->
        <div class="wrapper">
            <?php
                $page = 'up-user';

                include 'inc/header.php';
                include 'inc/sidebar.php';
                $id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
                $sql = 'SELECT userr.*, pos.description , city.city, brgy.brgy
                FROM USERS as userr
                inner join user_position as pos on userr.user_position_id = pos.id
                inner join city as city on city.id = userr.cid
                inner join barangay as brgy on brgy.id = userr.bid
                where userr.id = ?';
                $sql = $conn->prepare($sql);
                $sql->bind_param('i',$id);
                $sql->execute();
                $sql->bind_result($id,$username,$password,$user_pos_id,$role_id,$user_stat_id, $profile_pic, $fname,
                    $lname, $mname, $email, $phone, $pid, $cid,$bid,$date_created,$date_up, $pos_desc, $city, $brgy);
                $sql->store_result();
                $sql->num_rows();
                $sql->fetch();
            ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content">

                    <div class="box box-success">
                        <div class="box-header with-border text-center">
                            <h4><b>UPDATE PROFILE </b></h4>
                        </div>
                        <div class="box-body">

                            <form method="post" role="form" id="register-user" enctype="multipart/form-data" action="controller/updateprofile.php" autocomplete="false">

                                <div class="form-body" style="padding-left:4%;padding-right:4%;">

                                    <!-- json response will be here -->
                                    <div id="errorDiv"></div>
                                    <!-- json response will be here -->

                                    <br>
                                    <label><h3>Personal Information</h3></label>
                                    <!-- end user -->
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-md-6 col-sm-6" style="height:70px;">
                                            <label for="last_name">Last Name</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                                <input type="hidden" value="<?php echo $id ; ?>" name="user_id">
                                                <input type="text"  value="<?php echo $lname ; ?>" class="form-control" id="last_name" name="last_name" >
                                            </div>
                                            <small class="help-block" id="error"></small>
                                        </div>

                                        <div class="form-group col-lg-4 col-sm-6" style="height:70px;">
                                            <label for="first_name">First Name</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                                <input type="text" value="<?php echo $fname ; ?>" class="form-control" id="first_name" name="first_name" >
                                            </div>
                                            <small class="help-block" id="error"></small>
                                        </div>

                                        <div class="form-group col-lg-4 col-sm-6" style="height:70px;">
                                            <label for="middle_name">Middle Name</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                                <input type="text" value="<?php echo $mname ; ?>"  class="form-control" id="middle_name" name="middle_name" >
                                            </div>
                                            <small class="help-block" id="error"></small>
                                        </div>
                                        <!-- end user -->
                                        <!--  -->
                                        <div class="form-group col-md-4 col-sm-6" style="height:70px;">
                                            <label for="email">Email</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
                                                <input name="email" id="email" value="<?php echo $email ; ?>" type="text" class="form-control">
                                            </div> 
                                            <small class="help-block" id="error"></small>
                                        </div>

                                        <div class="form-group col-md-4 col-sm-6" style="height:70px;">
                                            <label for="phone">Phone #</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></div>
                                                <input name="phone" value="<?php echo $phone ; ?>" id="phone" type="text" class="form-control">
                                            </div> 
                                            <small class="help-block" id="error"></small>
                                        </div>

                                        <div class="col-lg-12">
                                            <div></div>
                                        </div>

                                        <div class="form-group col-md-4 col-sm-6" style="height:70px;">
                                            <label for="profile_picture">Profile Picture</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></div>
                                                <input name="profile_picture" id="profile_picture" type="file" value="<?php echo $profile_pic ; ?>" class="form-control" >
                                            </div>
                                            <small class="help-block" id="error"></small>
                                        </div>


                                        <div class="form-group col-lg-4 col-sm-6" style="height:70px;">
                                            <label for="username">Username</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                                <input type="text"  value="<?php echo $username ; ?>" class="form-control" id="username" name="username" >
                                            </div>
                                            <small class="help-block" id="error"></small>
                                        </div>

                                        <div class="col-lg-12">
                                            <div></div>
                                        </div>

                                        <div class="form-group col-lg-4 col-sm-6" style="height:70px;">
                                            <label for="password">Current Password</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                                <input type="password"  class="form-control" id="curr_password" name="curr_password" >
                                            </div>
                                            <small class="help-block" id="error"></small>
                                        </div>


                                        <div class="form-group col-lg-4 col-sm-6" style="height:70px;">
                                            <label for="password">New Password</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                                <input type="password"  class="form-control" id="npassword" name="npassword" >
                                            </div>
                                            <small class="help-block" id="error"></small>
                                        </div>
                                        <div class="form-group col-lg-4 col-sm-6" style="height:70px;">
                                            <label for="cpassword">Confirm Password</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                                <input type="password"  class="form-control" id="cpassword" name="cpassword" >
                                            </div>
                                            <small class="help-block" id="error"></small>
                                        </div>

                                        <div class="form-group col-lg-4 col-sm-6" style="height:70px;">
                                            <label for="position">Position</label>
                                            <div class="input-group" style="width:100%;">
                                                <select class="form-control" id="position" name="position">
                                                <?php
                                                    echo "<option value='$user_pos_id'>$pos_desc</option>";
                                                    if($_SESSION['role'] == 'PARPO I' || $_SESSION['role'] == 'PARPO II') {
                                                        $sql = 'SELECT distinct(id), description FROM user_position WHERE id not in (1,4,5,?)';
                                                    } else {
                                                        $sql = 'SELECT distinct(id), description FROM user_position WHERE id not in (1,2,3,4,5,?)';
                                                    }
                                                    $sql = $conn->prepare($sql);
                                                    $sql->bind_param('i',$user_pos_id);
                                                    $sql->execute();
                                                    $sql->bind_result($pos_id,$position);
                                                    $sql->store_result();
                                                    if($sql->num_rows() > 0) {
                                                        while($sql->fetch()) {
                                                            echo "<option value='$pos_id'>$position</option>";
                                                        }
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <label><h3>Address</h3></label>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-sm-6" style="height:70px;">
                                            <label for="city">Municipality</label>
                                            <select class="form-control" id="city" name="city">
                                                <?php
                                                echo "<option value='$cid'>$city</option>";
                                                $sql = 'SELECT id,city FROM city where id != ?';
                                                $sql = $conn->prepare($sql);
                                                $sql->bind_param('i', $cid);
                                                $sql->execute();
                                                $sql->bind_result($id,$city);

                                                $sql->store_result();
                                                    if($sql->num_rows() > 0) {
                                                        while($sql->fetch()) {
                                                            echo "<option value='$id'>$city</option>";
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4 col-sm-6" style="height:70px;">
                                            <label for="arb_lname">Barangay</label>
                                            <input type="hidden" name="upd_bid" id="upd_bid" value="<?php echo $bid ; ?>">
                                            <select class="form-control" id="brgy" name="brgy" style="width:100%;">
                                                <?php echo "<option value='$bid'>$brgy</option>"?>
                                            </select>
                                        </div>

                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-5"></div>
                                            <div class="col-md-2">
                                                <div class="form-footer">
                                                    <button type="submit" class="btn btn-success" id="update" name="update">
                                                        <span class="glyphicon glyphicon-log-in"></span>&nbsp&nbsp Update
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        </div><br><br><br><br>
                    </div>
                </section>
            </div>
        </div>

        <?php include 'inc/scripts.php' ; ?>
        <script src="../js/update-user.js"></script>
        <script>
            show_barangay();
            function show_barangay() {
                let city = $('#city').val();
                let upd_bid = $('#upd_bid').val();
                $.post('controller/disp_brgy.php' , {
                    cid : city,
                    upd_bid :upd_bid
                }, function(data,status) {
                    $('#brgy').append(data);
                });
            }
        </script>
    </body>
</html>
<?php } else {
    header('Location:../index.php');
}?>