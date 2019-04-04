<?php
    require '../controller/connection.php';
$id = isset($_POST['id']) ? $_POST['id'] : 0 ;
$sql = 'UPDATE users set user_stat_id = 1 WHERE id = ?';
$sql = $conn->prepare($sql);
$sql->bind_param('i',$id);
$sql->execute();