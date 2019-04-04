<?php
    $conn = new mysqli("localhost","root","root","dar_db");
    if(!$conn){
        die("Connecting to database had failed!");
    }
?>