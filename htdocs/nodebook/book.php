<?php
include dirname(__FILE__) . '/include/db.php'; 
$db = DB::getInstance();

//get the booking parameter from URL
$sysid = $_POST["sysid"];
$userid = $_POST["userid"];
//$team = $_POST["team"];
$force = $_POST["force"];
$comment = $_POST["comment"];
$end_month = $_POST['month'];
$end_month = str_pad($end_month, 2, '0', STR_PAD_LEFT);
$end_day = $_POST['day'];
$end_day = str_pad($end_day, 2, '0', STR_PAD_LEFT);
$end_year = $_POST['year'];

$date = date("Y-m-d");


try {
	
	$db->sql('select userid, end_date from system where id = ?');
	
	$db->bind(1,$sysid);
	$system = $db->singlerow();	
	$end_date=$system['end_date'];
	
	$seconds_left=-1;
	
	if( $end_date != ""){		
		$db->sql("select strftime('%s',?) - strftime('%s',date('now')) as seconds");						 
		$db->bind(1,$end_date);
		$res = $db->singlerow();		
		$seconds_left=$res['seconds'];	
	}
		
#	if ($force == "false" && $system['userid'] != "" ) {

	if ($force == "false" && $seconds_left >= 0 ) {
		$response = "System is already booked";
		echo $response;
		return;
	}
		
	$db->beginTransaction();

	//update system table to set the user id	
	$db->sql("update system set userid = ?, email_sent='false', book_date=date('now') ,end_date=date('$end_year-$end_month-$end_day 23:59:59') where id = ?");
	
	$db->bind(1,$userid);
	$db->bind(2,$sysid);
	$db->execute();

	//insert a log into the log table
	$db->sql('insert into log(id, udate, userid, comments, systemid) values(NULL, ?, ?, ?, ?)');
	$db->bind(1,$date);
	$db->bind(2,$userid);
	$db->bind(3,$comment);
	$db->bind(4,$sysid);
	$db->execute();

	$db->endTransaction();
	

} catch(PDOException $e) {
	if(stripos($e->getMessage(), 'DATABASE IS LOCKED') !== false) {
        	// This should be specific to SQLite, sleep for 0.25 seconds
            	// and try again.  We do have to commit the open transaction first though
            	$db->endTransaction();
            	usleep(250000);
        } else {
            	$db->cancelTransaction();
		$response = "Database failed, booking not successful!";
		echo $response;
		return;
        }
}


$response = "System is successfully booked!\n";
$response = $response."Date: " . $end_year .":" . $end_month .":" . $end_day;
echo $response;
return;
?>
