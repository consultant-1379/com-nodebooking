<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/systemdetails.css" />
    <script type="text/javascript" src="js/jquery-1.4.1.js"></script>
    <script type="text/javascript" src="js/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="js/systemedit.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {
    		$(".mappingtable tbody td:nth-child(odd)").addClass("odd");
	});
    </script> 
</head>

<?php include dirname(__FILE__) . '/include/header.php';?>

<?php
include dirname(__FILE__) . '/include/db.php';
$db = DB::getInstance();

$sysid = $_GET["sysid"];
$sysname = $_GET["sysname"];

$db->sql('select systemname, alias, hardware, config, comments, cba, userid, activity, ldecmw, comver from system where id = ?');
$db->bind(1,$sysid);
$systemdetail = $db->singlerow();
       
$db->sql('select id, address, protocol, type from ip where systemid = ? ');
$db->bind(1,$sysid);
$ipdetails = $db->resultset();
?>
<body>
<div id="content-container">
<div id="content-container2">
<div id="content-container3">
<div id="content">
<form action="updatesystem.php" method="post">
<div>		
<input type="hidden" name="sysid" value="<?php echo $sysid; ?>"/>
<table id="editnodetable" class="mappingtable">
        <thead>
            	<tr>
			<td colspan="6"><h3>Update System details for Node <?php echo $sysname ?></h3></td>
		</tr>
            	<tr> 
	                <?php
			echo '<td colspan="3"><a href="systemdetails.php?sysid=' . $sysid . '&sysname=' . $sysname . '">Back to system details</a> </td>';
	                echo '<td id="historylink" colspan="3"><a href="history.php?sysid=' . $sysid . '&sysname=' . $sysname . '">Full system logs</a></td>';
			?>
		</tr>
        </thead>
	<tbody>
        <?php
      		echo '<tr><td>System name</td>';
            	echo '<td>  <input type="text" name="systemname" value="'. $systemdetail['alias'] .'"/></td>';
		echo '<td>Hardware Type</td>';
		echo '<td>  <input type="text" name="hardware" value="'. $systemdetail['hardware'] .'"/></td>';
		echo '<tr><td>CBA</td>';
            	if($systemdetail['cba'] == 'true') {
			echo '<td><input type="checkbox" name="cba" value="true" checked="checked"/></td>';
		} else {
			echo '<td><input type="checkbox" name="cba" value="true"/></td>';
		}
		echo '<td>System configuration</td>';
            	echo '<td>  <input type="text" name="config" value="'. $systemdetail['config'] .'"/></td>';
		echo '<tr><td>Activity</td>';
            	echo '<td>  <input type="text" name="activity" value="'. $systemdetail['activity'] .'"/></td>';
		echo '<tr><td>LDEwS/Core MW</td>';
            	echo '<td>  <input type="text" name="ldecmw" value="'. $systemdetail['ldecmw'] .'"/></td>';
		echo '<tr><td>COM version</td>';
            	echo '<td>  <input type="text" name="comver" value="'. $systemdetail['comver'] .'"/></td>';
		echo '<tr><td>Comments</td>';
		echo '<td colspan="3"><textarea id="comments" name="comments" rows="5" cols="85">' . stripslashes($systemdetail['comments']) . '</textarea></td>';
        ?>
		</tr>
	</tbody>
	 
</table>
	<table id="editiptable" class="mappingtable">
		<thead>
            		<tr>
				<td colspan="2"><h3>IP details for Node <i><?php echo $sysname ?></i></h3></td>
				<td><a href="#" onclick="addIpRow()"><img src="image/add.png" /></a></td>
			</tr>
		</thead>
		<tbody>        	
		<?php
        				foreach ($ipdetails as $ipdetail) {
      					echo '<tr><td><input type="hidden" name="ipid[]" value="'. $ipdetail['id'].'"/><input type="text" name="iptype[]" value="'. $ipdetail['type'] .'"/></td>';
      					echo '<td><input type="text" name="ipprotocol[]" value="'. $ipdetail['protocol'] .'"/><input type="text" name="ipaddress[]" value="'. $ipdetail['address'] .'"/></td>';
					echo '<td><a href="#" onclick="onIpDeleteEvent(this)"><img src="image/delete.png" /></a></td></tr>';
					}
        			?>
		</tbody>
        </table>
<table>
	<tr><td> Update by:</td></tr>
	<tr><td>
			<?php
			$db->sql('select id, name from user');
			$bookusers = $db->resultset();
			echo '<select name="userid">';
			foreach ($bookusers as $bookuser) {
				echo '<option value="' . $bookuser['id'] . '">' . $bookuser['name'] . '</option>';
			}
			echo '</select>';
			?>
	</td></tr>
	<br>
	<br>
	<tr><td> What is updated:</td></tr>
	<tr><td><textarea id="bookcomment" name="bookcomment" rows="5" cols="40"></textarea></td></tr>
</table>
<input type="submit" name="updateformsubmit" value="Update System"/>
</div>
</div>
</form>
</div>
</div>
</div>

<?php include dirname(__FILE__) . '/include/footer.php';?>

</div>
</body>
</html>
