<html>
<head>
<title>System</title>

	<script>
	function successFunction(response){
		alert(response);
		self.location="index.php";
	}	
	</script>

</head>
<body>


<?php
include dirname(__FILE__) . '/include/db.php'; 
$db = DB::getInstance();

//get the parameter from URL

@$systemname=$_GET['systemname']; 
if(FALSE==isset($systemname)){
	$systemname=""; 
}

$response = "System Add Results:\n";
$response = $response . "System:\t" . $systemname . "\n";

try {
	$db->sql("insert into system (alias,end_date) values (?,date('now','-1 day'))");
	$db->bind(1,$systemname);
	$db->execute();
		
} catch(PDOException $e) {
	if(stripos($e->getMessage(), 'DATABASE IS LOCKED') !== false) {
        	// This should be specific to SQLite, sleep for 0.25 seconds
            	// and try again.  We do have to commit the open transaction first though
            	usleep(250000);
        } else {		
		$response = "Database failed";
		echo "<script type=\"text/javascript\">";
		echo "    successFunction('$response')();";
		echo "</script>";
		echo "</body>";
		echo "</html>";		
		return;
        }
}

$response = "System ".$systemname." successfully added";

echo "<script type=\"text/javascript\">";
echo "    successFunction('$response')();";
echo "</script>";

?>

</body>
</html>
