<?php
require 'connectdb.php' ;

$type = $_POST['type'];
$uid = $_POST['uid'];
    if($type == 'deactivate'){
        $update = 0;
        $sql = $conn->prepare('UPDATE d_tbl_user set user_stat_id = ? where user_id=?');
        $sql->bind_param('ii' , $update, $uid);
        if($sql->execute() == true){
            echo 1;
        } else {
            echo 2;
        }
    }
    else if($type == 'activate'){
        $update = 1;
        $sql = $conn->prepare('UPDATE d_tbl_user set user_stat_id = ? where user_id=?');
        $sql->bind_param('ii' , $update, $uid);
        if($sql->execute() == true){
            echo 1;
        } else {
            echo 2;
        }
    }
?>