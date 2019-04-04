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
<html>
    <head>
        <?php include 'inc/css_and_meta.php';?>
        <title>PPS | Po Profile</title>
        <style>
            /* .content-wrapper {
                background-color:white;
            } */
            .text-lg {
                font-size:22px;
                color:#00a65a;
                text-shadow:1px 0px green;
            }
            .text-md {
                font-size:18px;
                color:#00a65a;
                text-shadow:1px 0px green;
                font-weight:bold;
            }
            .user-panel {
                background-image:url('../public/img/dar-bg.png');
                height:100px;
            }
            .user-panel {
                background-image:url('../logo/dar-bg.png');
                height:100px;
            }
            .padd-left {
                margin-left:22%;
                margin-right:22%;
            }
            .profile-user-img {
                padding:0px;
                border:2.5px solid white;
            }
            .box {
                border:none;
            }
        </style>
    </head>
    <body class="skin-green fixed sidebar-mini sidebar-mini-expand-feature hold-transition">
        <!-- Site wrapper -->
        <div class="wrapper">
            <?php
            $page = 'view';
            include 'inc/header.php';
            include 'inc/sidebar.php';
            $sql = $conn->prepare('SELECT distinct(users.id) , users.firstname , users.lastname , users.middlename , users.email , users.phoneno, users.profile_pic,
            users.username , prov.province , city.city , brgy.brgy , pos.description
            FROM users inner join province as prov on users.pid = prov.id
            inner join city as city on city.id = users.cid
            inner join barangay as brgy on brgy.id = users.bid
            inner join user_position as pos on pos.id = users.user_position_id 
            where users.id = ?');
            $sql->bind_param('i',$_SESSION['user_id']);
            $sql->execute();
            $sql->bind_result($user_id, $firstname, $lastname, $middlename, $email, $phone, $profile_pic,
                             $username, $province, $city, $brgy, $position);
            $sql->store_result();
            $sql->fetch();
        ?>
        <div class="content-wrapper">
            <section class="content">
                    <div class="row">
                    <div class="col-lg-11" style="margin-right:4%;margin-left:4%;">
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body" style="min-height:650px;">
                        <div class="col-lg-12" style="background-color:#00a65a;height:220px;"><br><br><br><br><br><br>
                            <img class="profile-user-img img-responsive" style="width:180px;height:180px;"
                            src="<?php echo $profile_pic; ?>" alt="User profile picture">
                                <center><strong class="text-center text-lg" style="margin-top:2%;">
                                    <?php echo ucwords($firstname) . ' ' . ucwords($lastname) . ' ' .ucwords($middlename); ?>
                                </strong></center>
                        </div>
                        <div class="col-lg-12">
                        <br><br><br><br><br><br><br>
                            <div class="padd-left">
                                <div class="row">
                                <div class="col-md-12">
                                    <p class="text-md"><span class="fa fa-user"></span> &nbsp;<?php echo ucwords($username); ?></p>
                                    <p class="text-md"><span class="fa fa-home"></span>
                                        <?php echo ucwords($brgy) . ', ' . ucwords($city) . ', ' .ucwords($province); ?>
                                    </p>
                                    <p class="text-md"><span class="fa fa-user"></span> &nbsp;<?php echo ucwords($position); ?></p>
                                    <p class="text-md"><span class="fa  fa-envelope-square"></span> &nbsp;<?php echo $email; ?></p>
                                    <p class="text-md"><span class="fa fa-phone-square"></span> &nbsp;<?php echo $phone; ?></p>
                                    
                                    
                                </div>
                                </div> 
                            </div>
                        </div>
                            </div>
                            </div>
                            
                        </div>
                    </div>
            </section>
        </div>

        </div>
    <?php include 'inc/scripts.php';?>
    <script src="../js/po_profile_form.js"></script>
    </body>
    </html>
    <?php } else {
    header('Location:../index.php');
}?>