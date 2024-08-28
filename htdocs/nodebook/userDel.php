<?php
include dirname(__FILE__) . '/include/db.php'; 
$db = DB::getInstance();

//get the delete parameter from URL
$userid = $_POST["userid"];

try {
	//delete user table 
	$db->sql("delete from user where id = ?");
	$db->bind(1,$userid);
	$db->execute();

} catch(PDOException $e) {
	echo "Database failed!";
	return;
}

echo "User is successfully deleted!";
return;
?>
