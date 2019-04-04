<?php
	require_once 'connectdb.php';
	
	$bid = (isset($_REQUEST['bid'])) ? $_REQUEST['bid'] : '' ;
	$brgy = (isset($_REQUEST['brgy'])) ? $_REQUEST['brgy'].'%' : '' ;
	if($bid > 0){
		$sql = $conn->prepare('SELECT other,o_id from tbl_other_addr where bid=?');
		$sql->bind_param('i',$bid);
	} else {
		$sql1 = $conn->prepare('SELECT bid from tbl_brgy where brgy LIKE ?');
		$sql1->bind_param('s',$brgy);
		$sql1->execute();
		$sql1->bind_result($bid);
		$sql1->store_result();
		$sql1->num_rows();
		$sql1->fetch();

		$sql = $conn->prepare('SELECT other,o_id from tbl_other_addr where bid=?');
		$sql->bind_param('i',$bid);
	}

	$sql->execute();
	$sql->bind_result($other,$o_id);
	$sql->store_result();
	if($sql->num_rows() > 0){
		while($sql->fetch()){
			echo '<li onclick="showotheraddr(this.value)" value='.$o_id.'><a>'.$other.'</a></li>	';
		}
	}
	echo '<li onclick="showotheraddr(this.value)" value="0"><a>(Other)Please Specify</a></li>';
	$conn->close();
?>