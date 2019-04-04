<?php
require '../controller/connectdb.php';
$id = isset($_POST['id']) ? $_POST['id'] : 0 ;
$new_pass = isset($_POST['new_pass']) ? $_POST['new_pass'] : '' ;
$username = isset($_POST['username']) ? $_POST['username'] :  '';
$role = isset($_POST['role']) ? $_POST['role'] : 0 ;
if($_SERVER['REQUEST_METHOD'] == 'POST' && $id != 0) {
    $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
    if(!empty($new_pass)) {
        $sql = 'UPDATE users set username  = ?, password = ?, user_position_id = ? WHERE id = ?';
        $sql = $conn->prepare($sql);
        $sql->bind_param('ssii',$username, $new_pass, $role, $id);
        if($sql->execute()) {
            header('Location:../confirm-user.php');
        }
    } else {
        $sql = 'UPDATE users set username  = ?, user_position_id = ? WHERE id = ?';
        $sql = $conn->prepare($sql);
        $sql->bind_param('sii',$username, $role, $id);
        if($sql->execute()) {
            header('Location:../confirm-user.php');
        }
    }
}
