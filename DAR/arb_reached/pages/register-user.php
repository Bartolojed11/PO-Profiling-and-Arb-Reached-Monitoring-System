<?php
session_start();
require 'controller/connectdb.php';
require 'controller/user_functions.php';
$_COOKIE['username'] = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
$_COOKIE['ssid'] = isset($_COOKIE['ssid']) ? $_COOKIE['ssid'] : '';
    if(authUser($_COOKIE['username'],$_COOKIE['ssid'], $conn)) {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'inc/cssLinks.php'; ?>

        <title>ARB REACHED</title>
        <style>
            .user-panel {
                background-image:url('../public/img/dar-bg.png');
                height:100px;
            }
        </style>
    </head>
    <body class="skin-green fixed sidebar-mini sidebar-mini-expand-feature hold-transition">
        <!-- Site wrapper -->
        <div class="wrapper">
            <?php
            $page = 'register';

            include 'inc/navbar.php';
            include 'inc/sidebar.php';
            ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content">

                    <div class="box box-success">
                        <div class="box-header with-border text-center">
                            <h4><b>Register User</b></h4>
                        </div>
                        <div class="box-body">

                            <form method="post" role="form" id="register-user" enctype="multipart/form-data" action="controller/register-user.php" autocomplete="false">

                                <div class="form-body" style="padding-left:4%;padding-right:4%;">

                                    <!-- json response will be here -->
                                    <div id="errorDiv"></div>
                                    <!-- json response will be here -->

                                    <br>
                                    <label><h3>Personal Information</h3></label>
                                    <!-- end user -->
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="last_name">Last Name</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                                <input type="text"  class="form-control" id="last_name" name="last_name" >
                                            </div>
                                            <span class="help-block" id="error"></span>
                                        </div>

                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="first_name">First Name</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                                <input type="text" class="form-control" id="first_name" name="first_name" >
                                            </div>
                                            <span class="help-block" id="error"></span>
                                        </div>

                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="middle_name">Middle Name</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                                <input type="text"  class="form-control" id="middle_name" name="middle_name" >
                                            </div>
                                            <span class="help-block" id="error"></span>
                                        </div>
                                        <!-- end user -->
                                        <!--  -->
                                        <div class="form-group col-md-4">
                                            <label for="email">Email</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
                                                <input name="email" id="email" type="text" class="form-control">
                                            </div> 
                                            <span class="help-block" id="error"></span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="phone">Phone #</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></div>
                                                <input name="phone" id="phone" type="text" class="form-control">
                                            </div> 
                                            <span class="help-block" id="error"></span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="profile_picture">Profile Picture</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></div>
                                                <input name="profile_picture" id="profile_picture" type="file" class="form-control" >
                                            </div> 
                                            <span class="help-block" id="error"></span>
                                        </div>


                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="username">Username</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                                <input type="text"  class="form-control" id="username" name="username" >
                                            </div>
                                            <span class="help-block" id="error"></span>
                                        </div>

                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="password">Password</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                                <input type="password"  class="form-control" id="password" name="password" >
                                            </div>
                                            <span class="help-block" id="error"></span>
                                        </div>
                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="cpassword">Confirm Password</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                                <input type="password"  class="form-control" id="cpassword" name="cpassword" >
                                            </div>
                                            <span class="help-block" id="error"></span>
                                        </div>

                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="position">Position</label>
                                            <div class="input-group" style="width:100%;">
                                                <select class="form-control" id="position" name="position">
                                                    <option value="1">ARPO I</option>
                                                    <option value="2">PARPO II</option>
                                                    <option value="3">PARPO I</option>
                                                    <option value="4">CARPO</option>
                                                    <option value="5">SARPO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <label><h3>Address</h3></label>
                                    <div class="row">
                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="city">Municipality</label>
                                            <select class="form-control" id="city" name="city">
                                                <?php
                                                $sql = 'SELECT id,city FROM city';
                                                $sql = $conn->prepare($sql);
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
                                        <div class="form-group col-lg-4 col-sm-4">
                                            <label for="arb_lname">Barangay</label>
                                            <select class="form-control" id="brgy" name="brgy" style="width:100%;">

                                            </select>
                                        </div>

                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-5"></div>
                                            <div class="col-md-2">
                                                <div class="form-footer">
                                                    <button type="submit" class="btn btn-success" id="register" name="register">
                                                        <span class="glyphicon glyphicon-log-in"></span>&nbsp&nbsp Register
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

        <?php include 'inc/js.php' ; ?>
        <script src="../public/js/register-user2.js"></script>
        <script>
            show_barangay();
            function show_barangay() {
                let city = $('#city').val();
                $.post('controller/disp_brgy.php' , {
                    cid : city
                }, function(data,status) {
                    $('#brgy').html(data);
                });
            }
        </script>
    </body>
    </html>
<?php } else {
    header('location:../index.php');
}?>


