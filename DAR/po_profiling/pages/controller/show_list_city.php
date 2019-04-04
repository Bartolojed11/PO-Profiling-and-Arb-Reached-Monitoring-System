<?php
    require 'connection.php';

    $prov = $_POST['prov'];
    $sql_prov = 'SELECT id from province where province = ?';
    $run_sql_sql_prov = $conn->prepare($sql_prov);
    $run_sql_sql_prov->bind_param('s', $prov);
    $run_sql_sql_prov->execute();
    $run_sql_sql_prov->bind_result($pid);
    $run_sql_sql_prov->store_result();
    $run_sql_sql_prov->fetch();


    $sql_city = 'SELECT city from city where pid = ? order by city asc';
    $run_sql_city = $conn->prepare($sql_city);
    $run_sql_city->bind_param('i', $pid);
    $run_sql_city->execute();
    $run_sql_city->bind_result($city);
    $run_sql_city->store_result();
    if($run_sql_city->num_rows() > 0) {
        while($run_sql_city->fetch()) {
            echo '<option value="'.$city.'">'.$city.'</option>';
        }
    }