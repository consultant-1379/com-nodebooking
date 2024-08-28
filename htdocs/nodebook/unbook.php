<?php
include dirname(__FILE__) . '/include/db.php'; 
$db = DB::getInstance();

//get the unbooking parameter from URL
$sysid = $_POST["sysid"];

$response = "System Unbooking Results:\n";

try {
	//update system table to set the user id
	$db->sql("update system set userid = '', end_date=date('now','-1 day') where id = ?");
	$db->bind(1,$sysid);
	$db->execute();

} catch(PDOException $e) {
	$response = $response . "Database failed, unbooking not successful!";
	echo $response;
	return;
}

$response = $response . "System is successfully unbooked!";
echo $response;
return;

?>
