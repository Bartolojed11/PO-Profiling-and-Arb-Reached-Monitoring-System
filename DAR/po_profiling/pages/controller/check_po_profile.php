<?php
    require 'connection.php';
    $arbo_id = isset($_POST['prof_id']) ? $_POST['prof_id'] : 0;
    $arbo = isset($_POST['part1_arbo_name']) ? $_POST['part1_arbo_name'] : '';
    if($arbo_id > 0) {
        $sql = 'SELECT count(name) from arbo_profile where name = ? and id != ?';
        $sql = $conn->prepare($sql);
        $sql->bind_param('si',$arbo, $arbo_id);
    } else {
        $sql = 'SELECT count(name) from arbo_profile where name = ?';
        $sql = $conn->prepare($sql);
        $sql->bind_param('s',$arbo);
    }
    $sql->execute();
    $sql->bind_result($arbo_count);
    $sql->store_result();
    $sql->num_rows();
    $sql->fetch();
    if($arbo_count > 0) {
        echo '<p id="org_exist" style="color:red"><b>Organization already Existed!!</b></p>';
    } else {
        echo 0;
    }
?>