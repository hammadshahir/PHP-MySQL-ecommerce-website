<?php
include 'inc/config.php';
$now = gmdate("D, d M Y H:i:s");
header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename=subscriber_list.csv');  
$output = fopen("php://output", "w");  
fputcsv($output, array('SL', 'Subscriber Email'));  
$statement = $pdo->prepare("SELECT * FROM tbl_subscriber WHERE subs_active=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
foreach ($result as $row) {
	fputcsv($output, array($row['subs_id'],$row['subs_email']));
} 
fclose($output);
?>