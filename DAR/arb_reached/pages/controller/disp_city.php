<?php

	require 'connectdb.php'; 
	$cid = $_POST['cid'];
	$sql = $conn->prepare('SELECT city from tbl_city where cid=?');
	$sql->bind_param('i',$cid);
	$sql->execute();
	$sql->bind_result($city);
	$sql->store_result();
	$sql->num_rows();
	$sql->fetch();
	if($cid > 0) {
		echo $city;
	} else {
		echo '';
	}

?>