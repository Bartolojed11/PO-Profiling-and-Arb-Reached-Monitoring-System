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
    <style>
        #custom-filter select {
                border:0px;
                border-bottom:1px solid gray;
                outline:none;
                padding-top:5px;
                padding-bottom:2.9px;
            }
            #custom-filter input[type="number"] {
                border:0px;
                border-bottom:1px solid gray;
                outline:none;
            }
            #highlow_filter {
                border:0px;
                border-bottom:1px solid white;
                outline:none;
                padding-top:5px;
                padding-bottom:2.9px;
                background-color:rgba(0,0,0,.0);
                color:white;
            }
            #highlow_filter option {
                color:black;
            }
            table a {
                color:black;
            }
            table a:hover{
                color:green;
            }
            #top_list tr td{
                border-bottom:1px solid lightgray;
            }
            .table-bordered {
                border-color:1px solid lightgray;
            }
            .box {
                border:0px;
            }
            .user-panel {
                background-image:url('../public/img/dar-bg.png');
                height:100px;
            }
    </style>
    <?php include 'inc/cssLinks.php'; ?>
    <link href="../public/img/logo.png" rel="icon" type="image">
    <title>ARB REACHED</title>
</head>
<body class="skin-green fixed sidebar-mini sidebar-mini-expand-feature hold-transition">
        <!-- Site wrapper -->
        <div class="wrapper">
        <?php
            $page = 'sys-users';
            $get_city = isset($_GET['city']) ? $_GET['city'] : '' ;
            include 'inc/navbar.php';
            include 'inc/sidebar.php';
        ?>


<div class="content-wrapper" style="min-height: 916px;">
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="box"> <br>
                    <div class="box-body" style="min-height:600px;">
                            <div class="btn-group" id="user_category" style="padding-left:5%;padding-right:5%;">
                                <button type="button" onclick="showUserReq()" id="conf_user_cat" class="btn btn-success">Confirm Users</button>
                                <button type="button" onclick="showInactUser()" class="btn btn-success">Inactive</button>
                                <button type="button" onclick="showActUser()" class="btn btn-success">Active</button>
                            </div>
                            <div class="form-body" style="padding-left:5%;padding-right:5%;" id="cud"><br>
                            <h3>Confirm new users</h3>
                                <table id="conf_userstbl" class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>USERNAME</th>
                                            <th>FULLNAME</th>
                                            <th>EMAIL</th>
                                            <th>PHONENO.</th>
                                            <th>POSITION</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="conf_users">
                                    
                                    </tbody>
                                </table> 
                                </div>


                                <div class="form-body" style="padding-left:5%;padding-right:5%;" id="aud"><br>
                                <h3>Active Users</h3>
                                <table id="active_userstbl" class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:150px">USERNAME</th>
                                            <th style="width:120px">FULLNAME</th>
                                            <th style="width:120px">EMAIL</th>
                                            <th style="width:120px">POSITION</th>
                                            <th style="width:100px"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="active_users">
                                    
                                    </tbody>
                                </table> 
                                </div>

                                <div class="form-body" style="padding-left:5%;padding-right:5%;" id="iud"><br>
                                <h3>Inactive Users</h3>
                                <table id="inactive_userstbl" class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:150px">USERNAME</th>
                                            <th style="width:120px">FULLNAME</th>
                                            <th style="width:120px">EMAIL</th>
                                            <th style="width:120px">POSITION</th>
                                            <th style="width:100px"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="inactive_users">

                                    </tbody>
                                </table> 
                                </div>

                                <div id="user_modal">
                                </div>
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
    </section>
    </div>
</div>
    <?php
        include 'inc/footer.php';
        include 'inc/js.php' ;
    ?>
    <script>
        display_users();
        display_actveusrs();
        display_inactveusrs();

        $('#aud,#iud').hide();
        function showUserReq() {
            $(this).toggleClass('active');
            $('#cud, #user_category').show();
            $('#aud,#iud').hide();
        }
        function showInactUser() {
            $(this).toggleClass('active');
            $('#iud, #user_category').show();
            $('#cud,#aud').hide();
        }
        function showActUser() {
            $(this).toggleClass('active');
            $('#aud, #user_category').show();
            $('#cud,#iud').hide();
        }
        

        function confirmUser(uid) {
            $.post('admin_/confirm_user.php', {
                id:uid
            }, function(data,status) {
                display_users();
                display_inactveusrs();
                display_actveusrs();
            });
        }

        function deactivate(uid) {
            $.post('admin_/deactivate_user.php', {
                id:uid
            }, function(data,status) {
                display_users();
                display_inactveusrs();
                display_actveusrs();
            });
        }

        function update_user(uid) {
            $.post('admin_/update_user_modal.php', {
                id:uid
            }, function(data,status) {
                $('#user_modal').replaceWith(data);
                $('#user').modal('show');
                
            });
        }

        // setInterval(() => {
        //     display_users();
        //     display_inactveusrs();
        //     display_actveusrs();
        // }, 3000);

        function display_users() {
            $('#conf_users').load('admin_/display_users_request.php');
        }
        function display_inactveusrs() {
            $('#inactive_users').load('admin_/display_inactive_users.php');
        }
        function display_actveusrs() {
            $('#active_users').load('admin_/display_active_users.php');
        }
    </script>
</body>
</html>
<?php } else {
    header('Location:../index.php');    
}?>