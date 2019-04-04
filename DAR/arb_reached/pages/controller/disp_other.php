<?php
	require_once 'connectdb.php';

	$oid = $_REQUEST['oid'];

	$sql = $conn->prepare('SELECT other,o_id from tbl_other_addr where o_id=?');
	$sql->bind_param('i',$oid);
	$sql->execute();
	$sql->bind_result($other,$o_id);
	$sql->store_result();
    $sql->num_rows();
    $sql->fetch();

    if($oid > 0){
        echo $other;
    } else {
        echo '';
    }
	$conn->close();
?>