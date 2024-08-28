<?php
include dirname(__FILE__) . '/include/db.php'; 
$db = DB::getInstance();

//get the delete parameter from URL
$sysid = $_POST["sysid"];

$response = "Delete System Results:\n";

try {
	//delete system table 
	$db->sql("delete from system where id = ?");
	$db->bind(1,$sysid);
	$db->execute();

} catch(PDOException $e) {
	$response = $response . "Database failed!";
	echo $response;
	return;
}

$response = $response . "System is successfully deleted!";
echo $response;
return;

?>
