<?php
include dirname(__FILE__) . '/include/db.php'; 

if ($_POST['updateformsubmit']) 
{
	//echo "submit is called";
	updateSystemDetails();
	
} else {
	//echo "no fucntion called";
}

function updateSystemDetails(){
	//get the parameters from URL
	$sysid = $_POST["sysid"];
	$systemname = $_POST["systemname"];
	$hardware = $_POST["hardware"];
	$cba = $_POST["cba"];
	if($cba != 'true') {
		$cba = 'false';
	}
	$config = $_POST["config"];
	$comments = $_POST["comments"];


	// User details for log entry
	$userid = $_POST["userid"];
	$bookcomment = $_POST["bookcomment"];
	$date = date("Y-m-d");

	//ip details of system.
	$ipids = $_POST["ipid"];
	if($ipids == '') {
		$ipids = array();
	}
	$iptypes = $_POST["iptype"];
	$ipaddresses = $_POST["ipaddress"];
	$ipprotocols = $_POST["ipprotocol"];

	$newipids = $_POST["newipid"];
	$newiptypes = $_POST["newiptype"];
	$newipaddresses = $_POST["newipaddress"];
	$newipprotocols = $_POST["newipprotocol"];

	//$response = "Update ". $systemname . "system :\n";
	try {
		$db = DB::getInstance();
		$db->sql('select id from ip where systemid = ?');
		$db->bind(1,$sysid);
		$curIpIdsInDb = $db->resultset();
		$curIpIds = array();
		foreach($curIpIdsInDb as $result_num => $sub_array)
		{
    			$curIpIds[$result_num] = $sub_array['id'];
		}

		$ipIdsToDelete = array_diff($curIpIds, $ipids);
		//echo $sysid . " " . $systemname . " " . $hardware . " " . $gwpc . " " . $config . " " . $comments;
		//echo $date . " " . $userid . " " . $bookcomment;
		$db->beginTransaction();
		//update system table to set the user id
		$db->sql('update system set alias = ?, hardware = ?, cba = ?, config = ?, comments = ? where id = ?');
		$db->bind(1,$systemname);
		$db->bind(2,$hardware);
		$db->bind(3,$cba);
		$db->bind(4,$config);
		$db->bind(5,$comments);
		$db->bind(6,$sysid);
		$db->execute();

		//insert a log into the log table
		$db->sql('insert into log(id, udate, userid, comments, systemid) values(NULL, ?, ?, ?, ?)');
		$db->bind(1,$date);
		$db->bind(2,$userid);
		$db->bind(3,$bookcomment);
		$db->bind(4,$sysid);
		$db->execute();

		// update in iptables. 
		$db->sql('update ip set address = ?, protocol = ?, type = ? where id = ?');
		for ($i=0; $i < sizeof($ipids); $i++)
		  {
			$db->bind(1,$ipaddresses[$i]);
			$db->bind(2,$ipprotocols[$i]);
			$db->bind(3,$iptypes[$i]);
			$db->bind(4,$ipids[$i]);
			$db->execute();
		  }

		$db->sql('delete from ip where id = ?');
		foreach ($ipIdsToDelete as $ipIdDelete)
		  {
			$db->bind(1,$ipIdDelete);
			$db->execute();
		  }

		$db->sql('insert into ip values (NULL, ?, ?, ?, ?)');
		for ($i=0; $i < sizeof($newipids); $i++)
		  {
			$db->bind(1,$newipaddresses[$i]);
			$db->bind(2,$newipprotocols[$i]);
			$db->bind(3,$newiptypes[$i]);
			$db->bind(4,$sysid);
			$db->execute();
		  }

		$db->endTransaction();
	} catch(PDOException $e) {
		if(stripos($e->getMessage(), 'DATABASE IS LOCKED') !== false) {
        		// This should be specific to SQLite, sleep for 0.25 seconds
	            	// and try again.  We do have to commit the open transaction first though
            		$db->endTransaction();
	            	usleep(250000);
        	} else {
            		$db->cancelTransaction();
			//$response = $response . "Database failed, update not successful!";
			//echo $response;
			//return;
	        }
	}

	//$response = $response . "System is successfully updated!";
	//echo $response;
	header("Location: systemdetails.php?sysid=" . $sysid . "&sysname=" . $systemname);
	return;
}


?>
