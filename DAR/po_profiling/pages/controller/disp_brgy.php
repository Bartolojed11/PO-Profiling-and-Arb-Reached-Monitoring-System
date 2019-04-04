<?php
	require 'connection.php'; 
	$cid = $_POST['cid'];
	$update_bid = isset($_POST['upd_bid']) ? $_POST['upd_bid'] : 0 ;
	if($update_bid == 0) {
		$sql = $conn->prepare('SELECT id,brgy from barangay where cid = ?');
		$sql->bind_param('i',$cid);
	} else {
		$sql = $conn->prepare('SELECT id, brgy from barangay where cid=? and id != ?');
		$sql->bind_param('ii',$cid, $update_bid);
	}
	
	$sql->execute();
	$sql->bind_result($id,$brgy);
	$sql->store_result();
	if($sql->num_rows()) {
		while($sql->fetch()) {
			echo "<option value='$id'>$brgy</option>";
		}
	}

?>