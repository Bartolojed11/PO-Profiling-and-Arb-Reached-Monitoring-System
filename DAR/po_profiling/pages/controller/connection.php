<?php

    $host="localhost";
    $username="root";
    $password="root";
    $database="dar_db";

    $conn=new mysqli ($host,$username,$password,$database);
    if ($conn->connect_error)
    {
        die ("failed to connect".$conn->connect_error);
    }
?>