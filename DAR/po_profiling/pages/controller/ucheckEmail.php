<?php
	session_start();
	require 'connectdb.php';
	
	if (isset( $_POST['email'] ) && !empty($_POST['email'])) {
		
		$email = $_POST['email'];
		$user_id = $_SESSION['id'];
		$sql = $conn->prepare("SELECT email FROM users where id = ?");
		$sql->bind_param('s',$user_id);
		$sql->execute();
		$sql->bind_result($remail);
		$sql->store_result();
		if ($sql->num_rows() > 0) {
			while($sql->fetch()){
				if($email == $remail){
					echo 'true';
				} else {
					$sql1 = $conn->prepare("SELECT email FROM users where email = ?");
					$sql1->bind_param('s',$email);
					$sql1->execute();
					$sql1->bind_result($email1);
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