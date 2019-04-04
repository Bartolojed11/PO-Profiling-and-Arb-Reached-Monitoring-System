<?php

require_once 'connectdb.php';

if (isset( $_POST['username'] ) && !empty($_POST['username'])) {
	$username = $_POST['username'];
	$sql = $conn->prepare(" SELECT username FROM users where username = ? ");
	$sql->bind_param('s',$username);
	$sql->execute();
	$sql->bind_result($uname);
	$sql->store_result();
	if ($sql->num_rows() > 0) {
		echo 'false'; // username already taken
	} else {
		echo 'true'; 
	}
}
?>