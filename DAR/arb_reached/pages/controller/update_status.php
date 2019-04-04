<?php
    require 'connectdb.php';

    $uid = $_POST['uid'];
    $stat_id = $_POST['stat_id'];
    $sql = $conn->prepare('UPDATE tbl_user SET user_stat_id=? where user_id=?');
    $sql->bind_param('ii' , $stat_id , $uid);
    
    if($sql->execute() == true){
        echo '<script>alert(1);</script>';
    }
?>