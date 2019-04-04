<?php
include 'connectdb.php';
include 'user_functions.php';
$ssid = isset($_POST['session']) ? $_POST['session'] : '';
$username = isset($_POST['username']) ? cleandata($_POST['username']) : '';
if(!empty($ssid) && !empty($username) && isset($_POST['logout'])) {
    if(logOut($username, $ssid, $conn)) {
        header('location:../../index.php');
    } else {
        header('location:../index.php');
    }
} else {
    header('location:../index.php');
}