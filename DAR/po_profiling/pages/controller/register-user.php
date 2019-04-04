<?php
require 'connection.php';
session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

if(isset($_POST['register'])) {

    $first_name = isset($_POST['first_name']) ? sanitize($_POST['first_name']) : '';
    $middle_name = isset($_POST['middle_name']) ? sanitize($_POST['middle_name']) : '';
    $last_name = isset($_POST['last_name']) ? sanitize($_POST['last_name']) : '';

    $email = isset($_POST['email']) ? sanitize($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize($_POST['phone']) : '';

    $username = isset($_POST['username']) ? sanitize($_POST['username']) : '';
    $password= isset($_POST['password']) ? sanitize($_POST['password']) : '';
    $position = isset($_POST['position']) ? sanitize($_POST['position']): '';

    $city = isset($_POST['city']) ? sanitize($_POST['city']) : '';
    $brgy = isset($_POST['brgy']) ? sanitize($_POST['brgy']) : '';

    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
    $profile_pic_path = '';

    if(!empty($_FILES['profile_picture'])) {
        $path = "../../../public/profile/";
        $profile_pic_path =  $path . date("Ymdhis").'_'.basename( $_FILES['profile_picture']['name']);
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_pic_path);
        $profile_pic_path = substr($profile_pic_path, 3);
    } else {
        $profile_pic_path = '';
    }

    if($role == 'PARPO I'  || $role == 'PARPO II') {
        $user_stat = 1;
    } else {
        $user_stat = 2;
    }
    $role_id = 2;
    $pid = 1;
    $sql = 'INSERT INTO users (username, password, profile_pic, firstname, lastname,
            middlename, email, phoneno, pid, cid, bid, user_position_id, user_stat_id, role_id)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
    $sql = $conn->prepare($sql);
 
    $sql->bind_param('ssssssssiiiiii', $username, $hashed_pass, $profile_pic_path, $first_name, $last_name,  $middle_name, 
                        $email, $phone, $pid, $city,$brgy ,$position, $user_stat ,$role_id );         
    if($sql->execute()) {
       echo "<script>alert('Registration Complete!');
                window.location.href = '../register-user.php';
            </script>"; 
    } else {
        echo "<script>alert('Registration Failed!');
                window.location.href = '../register-user.php';
            </script>";
    }
}

function sanitize($data) {
    $data = htmlspecialchars($data);
    $data = rtrim($data);
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}