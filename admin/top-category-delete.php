<?php require_once('header.php'); ?>

<?php
// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_top_category WHERE tcat_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php	
	$statement = $pdo->prepare("SELECT * 
							FROM tbl_top_category t1
							JOIN tbl_mid_category t2
							ON t1.tcat_id = t2.tcat_id
							JOIN tbl_end_category t3
							ON t2.mcat_id = t3.mcat_id
							WHERE t1.tcat_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$ecat_ids[] = $row['ecat_id'];
	}

	if(isset($ecat_ids)) {

		for($i=0;$i<count($ecat_ids);$i++) {
			$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE ecat_id=?");
			$statement->execute(array($ecat_ids[$i]));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$p_ids[] = $row['p_id'];
			}
		}

		for($i=0;$i<count($p_ids);$i++) {

			// Getting photo ID to unlink from folder
			$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$p_featured_photo = $row['p_featured_photo'];
				unlink('../assets/uploads/'.$p_featured_photo);
			}

			// Getting other photo ID to unlink from folder
			$statement = $pdo->prepare("SELECT * FROM tbl_product_photo WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$photo = $row['photo'];
				unlink('../assets/uploads/product_photos/'.$photo);
			}

			// Delete from tbl_photo
			$statement = $pdo->prepare("DELETE FROM tbl_product WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));

			// Delete from tbl_product_photo
			$statement = $pdo->prepare("DELETE FROM tbl_product_photo WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));

			// Delete from tbl_product_size
			$statement = $pdo->prepare("DELETE FROM tbl_product_size WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));

			// Delete from tbl_product_color
			$statement = $pdo->prepare("DELETE FROM tbl_product_color WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));

			// Delete from tbl_rating
			$statement = $pdo->prepare("DELETE FROM tbl_rating WHERE p_id=?");
			$statement->execute(array($p_ids[$i]));

			// Delete from tbl_payment
			$statement = $pdo->prepare("SELECT * FROM tbl_order WHERE product_id=?");
			$statement->execute(array($p_ids[$i]));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
			foreach ($result as $row) {
				$statement1 = $pdo->prepare("DELETE FROM tbl_payment WHERE payment_id=?");
				$statement1->execute(array($row['payment_id']));
			}

			// Delete from tbl_order
			$statement = $pdo->prepare("DELETE FROM tbl_order WHERE product_id=?");
			$statement->execute(array($p_ids[$i]));
		}

		// Delete from tbl_end_category
		for($i=0;$i<count($ecat_ids);$i++) {
			$statement = $pdo->prepare("DELETE FROM tbl_end_category WHERE ecat_id=?");
			$statement->execute(array($ecat_ids[$i]));
		}

	}

	// Delete from tbl_mid_category
	$statement = $pdo->prepare("DELETE FROM tbl_mid_category WHERE tcat_id=?");
	$statement->execute(array($_REQUEST['id']));

	// Delete from tbl_top_category
	$statement = $pdo->prepare("DELETE FROM tbl_top_category WHERE tcat_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: top-category.php');
?>