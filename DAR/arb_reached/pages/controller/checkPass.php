<?php
session_start();
require 'connectdb.php';

if (isset( $_POST['curr_password'] ) && !empty($_POST['curr_password'])) {
    $password = $_POST['curr_password'];
    $username = $_SESSION['username'];
    $sql = $conn->prepare('SELECT password FROM users WHERE username = ?');
    $sql->bind_param('s',$username);
    $sql->execute();
    $sql->bind_result($pass);
    $sql->store_result();
    $sql->num_rows();
    $sql->fetch();
    $hashed = password_verify($password,$pass);
    if($hashed){
        echo 'true'; // password is okay
    } else {
        echo 'false'; //incorrect password
    }

}
?>