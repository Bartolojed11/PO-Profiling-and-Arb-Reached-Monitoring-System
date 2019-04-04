<?php
    require "../pages/controller/connection.php";
    require "../pages/controller/user_functions.php";
    
    $flag = 0;
    $username = isset($_POST['username']) ? cleandata($_POST['username']) : '';
    $password = isset($_POST['password']) ? cleandata($_POST['password']) : '';
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $flag = logIn($username,$password,$conn);
        echo $flag;
    }
?>