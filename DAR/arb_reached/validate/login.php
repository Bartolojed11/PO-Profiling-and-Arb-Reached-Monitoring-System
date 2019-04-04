<?php
    require "../pages/controller/connectdb.php";
    require "../pages/controller/user_functions.php";

    $username = isset($_POST['username']) ? cleandata($_POST['username']) : '';
    $password = isset($_POST['password']) ? cleandata($_POST['password']) : '';
    $flag = 0;
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $flag = logIn($username,$password,$conn);
        echo $flag;
    }
?>