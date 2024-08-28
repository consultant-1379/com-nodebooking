<html>
<head>
<title>Manage Users</title>

	<script>
	function successFunction(response){
		alert(response);
		self.location="index.php";
	}
	function backFunction(response){
		alert(response);
		self.location="addUser.php";
	}
	
	</script>

</head>
<body>


<?php
include dirname(__FILE__) . '/include/db.php'; 
$db = DB::getInstance();


//get the booking parameter from URL

@$username=$_GET['username']; 
if(FALSE==isset($username)){
	$username=""; 
}
@$signum=$_GET['signum']; 
if(FALSE==isset($signum)){
	$signum=""; 
}
@$team=$_GET['team']; 
if(FALSE==isset($team)){
	$team=""; 
}

@$email_addr=$_GET['email_addr']; 
if(FALSE==isset($email_addr)){
	$email_addr=""; 
}


try {
	if(!filter_var($email_addr, FILTER_VALIDATE_EMAIL)) {
		$response = "E-mail is not valid!";
		echo "<script type=\"text/javascript\">";
		echo "    backFunction('$response')();";
		echo "</script>";
		echo "</body>";
		echo "</html>";
		return;	  
  	}

	$db->sql('select id from user where signum = ?');
	$db->bind(1,$signum);
	$user = $db->singlerow();
	if ($user['id'] != "") {		
		$response = "User ".$signum." already exist!";
		echo "<script type=\"text/javascript\">";
		echo "    backFunction('$response')();";
		echo "</script>";
		echo "</body>";
		echo "</html>";
		return;
	}
	
	//update user table to add the user
	$db->sql('insert into user (name,team,signum,email) values (?,?,?,?)');
	$db->bind(1,$username);
	$db->bind(2,$team);
	$db->bind(3,$signum);
	$db->bind(4,$email_addr);
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

$response = "User ".$signum." successfully added";

echo "<script type=\"text/javascript\">";
echo "    successFunction('$response')();";
echo "</script>";

?>
</body>
</html>
