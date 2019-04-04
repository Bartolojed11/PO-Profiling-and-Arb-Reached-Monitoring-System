<?php

require 'connection.php';

if (isset( $_POST['email'] ) && !empty($_POST['email'])) {
	$email = $_POST['email'];
	$sql = $conn->prepare('SELECT email FROM users where email=?');
	$sql->bind_param('s',$email);
	$sql->execute();
	$sql->bind_result($email);
	$sql->store_result();
			
	if ($sql->num_rows() > 0) {
		echo 'false'; // email already taken
	} else {
		echo 'true'; 
	}
}
?>