<?php
    require 'connection.php';

    $sql_fcity = 'SELECT city from city order by city asc limit 1';
    $run_sql_sql_fcity = $conn->prepare($sql_fcity);
    $run_sql_sql_fcity->bind_param('s', $city);
    $run_sql_sql_fcity->execute();
    $run_sql_sql_fcity->bind_result($fcity);
    $run_sql_sql_fcity->store_result();
    $run_sql_sql_fcity->fetch();

    $city = !empty($_POST['city']) ? $_POST['city'] : $fcity;
    $sql_city = 'SELECT id from city where city = ?';
    $run_sql_sql_city = $conn->prepare($sql_city);
    $run_sql_sql_city->bind_param('s', $city);
    $run_sql_sql_city->execute();
    $run_sql_sql_city->bind_result($cid);
    $run_sql_sql_city->store_result();
    $run_sql_sql_city->fetch();

    $sql = 'SELECT brgy from barangay where cid = ? order by brgy asc';
    $run_sql = $conn->prepare($sql);
    $run_sql->bind_param('i' , $cid);
    $run_sql->execute();
    $run_sql->bind_result($brgy);
    $run_sql->store_result();
    if($run_sql->num_rows() > 0) {
        while($run_sql->fetch()) {
            echo '<option value="'.$brgy.'">'.$brgy.'</option>';
        }
    }