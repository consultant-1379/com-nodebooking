<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script type="text/javascript" src="js/jquery-1.4.1.js"></script>
    <script type="text/javascript" src="js/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {
		$("#historytable").tablesorter({widthFixed: true, widgets: ['zebra']}).tablesorterPager({container: $("#pager")});
	});
    </script> 
</head>

<?php include dirname(__FILE__) . '/include/header.php';?>

<?php 
include dirname(__FILE__) . '/include/db.php'; 
$db = DB::getInstance();

$sysid = $_GET["sysid"];
$sysname = $_GET["sysname"];

?>
<body>
<div id="content-container">
<div id="content-container2">
<div id="content-container3">
<div id="content">
<h3>Booking History for Node <?php echo $sysname ?></h3>
<table class="tablesorter" id="historytable">
        <thead>
		<tr>
            		<th>Date</th>
            		<th>User</th>
            		<th>Comment</th>
		</tr>
        </thead>
	<tbody>
	<?php
	$db->sql('select l.id, l.udate, u.name, l.comments from log l, user u where l.systemid = ? and l.userid = u.id order by l.id desc;');
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
<div id="pager" class="tablesorterPager">
	<span>
		<img src="image/first.png" class="first"/>
		<img src="image/prev.png" class="prev"/>
		<input type="text" class="pagedisplay"/>
		<img src="image/next.png" class="next"/>
		<img src="image/last.png" class="last"/>
		<select class="pagesize">
			<option selected="selected"  value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option  value="40">40</option>
		</select>
	</span>
</div>
<div id="backbutton">
<input type="button" value="Back" onclick="history.go(-1);return true;">
</div>

</div>
</div>
</div>

<?php include dirname(__FILE__) . '/include/footer.php';?>

</div>
</body>
</html>
