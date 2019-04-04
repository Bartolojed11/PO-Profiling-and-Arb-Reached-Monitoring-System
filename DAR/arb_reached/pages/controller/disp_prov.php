<?php

	require 'connectdb.php'; 
	$pid = $_POST['pid'];
	$sql = $conn->prepare('SELECT province from tbl_prov where pid=?');
	$sql->bind_param('i',$pid);
	$sql->execute();
	$sql->bind_result($province);
	$sql->store_result();
	$sql->num_rows();
	$sql->fetch();
	if($pid > 0){
		echo $province;
	} else {
		echo '';
	}

?>