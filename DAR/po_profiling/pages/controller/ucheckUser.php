<?php
session_start();
require 'connectdb.php';

if (isset( $_POST['username'] ) && !empty($_POST['username'])) {
	
	$username = $_POST['username'];
	$user_id = $_SESSION['id'];
	$sql = $conn->prepare("SELECT username FROM users where id=?");
	$sql->bind_param('s',$user_id);
	$sql->execute();
	$sql->bind_result($uname);
	$sql->store_result();
	if ($sql->num_rows() > 0) {
		while($sql->fetch()){
			if($uname == $username){
				echo 'true';
			} else {
				$sql1 = $conn->prepare("SELECT username FROM users where username=?");
				$sql1->bind_param('s',$username);
				$sql1->execute();
				$sql1->bind_result($uname1);
				$sql1->store_result();
				if($sql1->num_rows() > 0){
					echo 'false';
				} else {
					echo 'true';
				}

			}
		}
	}
}
?>