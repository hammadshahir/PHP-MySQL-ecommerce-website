<?php require_once('header.php'); ?>

<?php
	
	// Delete from tbl_subscriber
	$statement = $pdo->prepare("DELETE FROM tbl_subscriber WHERE subs_active=0");
	$statement->execute();

	header('location: subscriber.php');
?>