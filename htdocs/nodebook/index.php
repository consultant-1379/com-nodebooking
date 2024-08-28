<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/booking.css" />    
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript" src="js/jquery-1.4.1.js"></script>
    <script type="text/javascript" src="js/booking.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {
		handlePopupEvent();
	});	
    </script>                     
</head>

<?php 
  include dirname(__FILE__) . '/include/header.php';
  include dirname(__FILE__) . '/include/db.php'; 
  $db = DB::getInstance();
  
  function days_table($db, $end_date){
	
	echo "<TABLE BORDER=0 cellspacing=0>";     
        	echo "<TR>";
			$seconds = 0;
			$color="#FF4500";  // Max
	
			if ($end_date != ""){		
      				$db->sql("select strftime('%s',?) - strftime('%s',date('now')) as seconds");						 
				$db->bind(1,$end_date);
 				$res = $db->singlerow();

				if( $res['seconds'] >= 0 ){
				  $seconds = $res['seconds'];
				  $seconds = 3600+$seconds;  // To add one extra day
				}					
			}
				
			$days = $seconds/86400;   // 24h=86400sec		
			$days=ceil($days);				
		
			if($days>100){
				$day_percent=100;
			}
			else if($days==0 && $seconds>0){
				$day_percent=1;
				$days=1;
			}		
			else{
				$day_percent=$days;
			}
		
			if($day_percent>70){
				$color="#FF4500";  // Max		
			}
			else if($day_percent>5){
				$color="#FFA500";  // Mid-hi
			}		
			else if($day_percent>0 ){
				$color="#ADFF2F";  // Mid-low		
			}
			else{
				$color="#008000";  // Free
				$day_percent=100;		
			}
							
			echo "<div class='meter-wrap'>";
	        	echo "<div class='meter-value' style='background-color: ".$color."; width: ".$day_percent."%;'>";
			echo "<div class='meter-text'>";
	        
			if($days>0){
				echo $days." days";
			}
			else{
			   	echo "Free";
			}			    
		
			echo "</div>";
			echo "</div>";
			echo "</div>";

	        echo"</TR>";
	echo"</TABLE>";
  }
?>


<body>
<div id="content-container">
<div id="content-container2">
<div id="content-container3">
<div id="content">

<table class="tablesorter" id="systemtable">
<?php

	echo "<tr>";
        	echo "<th>System</th>";
		echo "<th>Hosts</th>";
            	echo "<th>User</th>";
	    	echo "<th>Team</th>";
		echo "<th>Availability</th>";
		echo "<th>Manage</th>";
	echo "</tr>";
		
	$db->sql('select id, systemname, hardware, userid, gwpc, comments, alias, end_date from system order by id');	
	$systems = $db->resultset();
	
	foreach ($systems as $system) {

		$sysid = $system['id'];
		$userid = $system['userid'];
		
		// Find hosts related to this system
		$db->sql('select address from ip where systemid = ?');
		$db->bind(1,$sysid);
		$ips=$db->resultset();
		$isFirst=true;
		
		echo '<tr>';
			echo '<td>' . $system['alias'] . '</td>';
			
			
			echo '<td>';
			// Print all ips
			foreach ($ips as $ip) {
				if(!$isFirst){
					echo '<br>';
				}
				echo $ip['address'];
				$isFirst=false;
			}									
			echo '</td>';
					
			if ($userid != "") {
				$db->sql('select * from user where id = ?');
				$db->bind(1,$userid);
				$user = $db->singlerow();
				echo '<td>' . $user['name'] . '</td>';
				echo '<td>' . $user['team'] . '</td>';
			} else {
				echo '<td>' . '</td>';
				echo '<td>' . '</td>';
			}	
		
			echo"<td>";					
				days_table($db,$system['end_date']);		
			echo"</td>"; 
		
			echo '<td class="mainpagelink" id="width150px">';
				echo '<a href="javascript:void(0)" id="book" onclick="onBookClickedEvent(' . $sysid . ', \'' . $system['alias'] . ' \')">Book</a> - ';
				echo '<a href="javascript:void(0)" id="unbook" onclick="onUnbookClickedEvent(' . $sysid . ')">Unbook</a><br/>';
				echo '<span class="systemdetailslink"><a href="systemdetails.php?sysid=' . $sysid . '&sysname=' . $system['alias'] . '">System Details</a> - ';
				echo '<a href="history.php?sysid=' . $sysid . '&sysname=' . $system['alias'] . '">Log</a></span>';
			echo '</td>';
		echo'</tr>';	
	}
?>

</table>

<?php include dirname(__FILE__) . '/include/popup.php'; ?>
		
</div>
</div>
</div>

<?php include dirname(__FILE__) . '/include/footer.php';?>

</div>
</body>
</html>
