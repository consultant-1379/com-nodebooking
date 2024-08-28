<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>COM Node Booking System - System Details</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/booking.css" />
    <link rel="stylesheet" type="text/css" href="css/systemdetails.css" />
    <script type="text/javascript" src="js/jquery-1.4.1.js"></script>
    <script type="text/javascript" src="js/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="js/booking.js"></script>
    <script type="text/javascript" src="js/systemdetails.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {
		$("#nodehistorytable").tablesorter({widthFixed: true, widgets: ['zebra']});
    		$(".mappingtable tbody td:nth-child(odd)").addClass("odd"); // solve ie problem with nth-child
		handlePopupEvent();
	});
    </script> 
</head>

<?php include dirname(__FILE__) . '/include/header.php';?>

<?php
include dirname(__FILE__) . '/include/db.php';
$db = DB::getInstance();

$sysid = $_GET["sysid"];
$sysname = $_GET["sysname"];

$db->sql('select systemname, alias, hardware, config, comments, cba from system where id = ?');
$db->bind(1,$sysid);
$systemdetails = $db->singlerow();

$db->sql('select u.name, u.team from system s, user u where s.id = ? and s.userid=u.id');
$db->bind(1,$sysid);
$userdetails = $db->singlerow();        

$db->sql('select address, protocol, type from ip where systemid = ?');
$db->bind(1,$sysid);
$ipdetails = $db->resultset();
?>
<body>
<div id="content-container">
<div id="content-container2">
<div id="content-container3">
<div id="content">
<h3>System details for Node <?php echo $sysname ?></h3>
<input type="hidden" id="nodeid" value="<?php echo $sysid?>"/>
<input type="hidden" id="nodename" value="<?php echo $sysname?>"/>
<table id="nodetable" class="mappingtable">
            <thead>
            	<tr>
			<td colspan="4"> Booked by: 
            			<?php 
            			 echo $userdetails['name'] . ' (Team - '.$userdetails['team'].')'; 
            			 ?>
			</td>
			<td colspan="2">
				<?php echo '<a href="systemedit.php?sysid=' . $sysid . '&sysname=' . $sysname . '">Edit</a>'; ?> - 
           			<a href="javascript:void(0)" id="book" onclick="onBookClickedEvent()">Book</a> - 
           			<a href="javascript:void(0)" id="unbook" onclick="onUnbookClickedEvent()">Unbook</a> - 
	                	<?php
	                		echo '<a href="history.php?sysid=' . $sysid . '&sysname=' . $sysname . '">System logs</a> -';
				?>
				<a href="javascript:void(0)" id="delete_system" onclick="onDeleteSystemClickedEvent()">Delete</a>
			</td>
		</tr>
            </thead>
	<tbody>
        <?php
   		echo '<tr><td>System name</td>';
            	echo '<td>' . $systemdetails['alias'] . '</td>';
		echo '<td>Hardware Type</td>';
            	echo '<td>' . $systemdetails['hardware'] . '</td>';
            	echo '<td>System configuration</td>';
            	echo '<td>' . $systemdetails['config'] .'</td></tr>';
		echo '<tr><td>CBA</td>';
            	if($systemdetails['cba'] == 'true') {
			echo '<td><input type="checkbox" name="cba" value="true" checked="checked" disabled/></td>';
		} else {
			echo '<td><input type="checkbox" name="cba" value="true" disabled/></td>';
		}
            	echo '<td>Comments</td>';
            	echo '<td colspan="3">' . stripslashes($systemdetails['comments'])  . '</td>';
            	echo '</tr>';	
        ?>
	</tbody>
</table>

<table id="nodeiptable" class="mappingtable">
			<thead>
				<tr><td colspan="2">IP details for Node <i><?php echo $sysname ?></i></td></tr>
			</thead>
			<tbody>
        			<?php
        				foreach($ipdetails as $ipdetail) {
      						echo '<tr><td>' . $ipdetail['type'] . '</td>';
            					echo '<td>' . $ipdetail['protocol'] .' '. $ipdetail['address'] . '</td></tr>';
					}
        			?>
			</tbody>
</table>

<h4>Latest update history for Node <i><?php echo $sysname ?></i></h4>
<table class="tablesorter" id="nodehistorytable">
	<thead>
		<tr>
            		<th>Date</th>
            		<th>User</th>
            		<th>Comment</th>
		</tr>
        </thead>
	<tbody>
        			 <?php
        			$db->sql('select l.udate, u.name, l.comments from log l, user u where l.systemid = ? and l.userid = u.id order by l.id desc limit 10;');
        			$db->bind(1,$sysid);
        			$logs = $db->resultset();

        foreach ($logs as $log) {
                echo '<tr><td>' . $log['udate'] . '</td>';
                echo '<td>' . $log['name'] . '</td>';
                echo '<td>' . stripslashes($log['comments']) . '</td></tr>';
        }
        ?>
	</tbody>
</table>

<input type="button" value="Back" onclick="history.go(-1);return true;">

<?php include dirname(__FILE__) . '/include/popup.php'; ?>

</div>
</div>
</div>

<?php include dirname(__FILE__) . '/include/footer.php';?>

</div>
</body>
</html>
