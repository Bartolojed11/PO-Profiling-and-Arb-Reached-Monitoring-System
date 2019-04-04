<?php
	require 'connectdb.php'; 
	$cid = $_POST['cid'];
	$update_bid = isset($_POST['upd_bid']) ? $_POST['upd_bid'] : 0 ;
	$arb_reached_flag = isset($_POST['arb_reached_flag']) ? $_POST['arb_reached_flag'] : 0 ;
	if($update_bid == 0) {
		$sql = $conn->prepare('SELECT id,brgy from barangay where cid = ?');
		$sql->bind_param('i',$cid);
	} else {
		$sql = $conn->prepare('SELECT id, brgy from barangay where cid=? and id != ?');
		$sql->bind_param('ii',$cid, $update_bid);

		$sql_ = 'SELECT id, brgy from barangay where cid = ? and id = ?';
		$sql_ = $conn->prepare($sql_);
		$sql_->bind_param('ii',$cid,$update_bid);
		$sql_->execute();
		$sql_->bind_result($id_, $brgy_);
		$sql_->store_result();
		$sql_->num_rows();
		$sql_->fetch();
	}
	
	$sql->execute();
	$sql->bind_result($id,$brgy);
	$sql->store_result();
	if($sql->num_rows()) {
		if($arb_reached_flag != 0) {
			echo "<option value='0'>ALL</option>";
		}
		if($update_bid > 0) {
			echo "<option value='$id_'>$brgy_</option>";
		}
		while($sql->fetch()) {
				echo "<option value='$id'>$brgy</option>";
		}
	}

?>