<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/booking.css" />       
</head>

<?php include dirname(__FILE__) . '/include/header.php';?>

<?php 
include dirname(__FILE__) . '/include/db.php'; 
$db = DB::getInstance();
?>
<body>
<div id="content-container">
<div id="content-container2">
<div id="content-container3">
<div id="content">
	<h3>Add User</h3>

<?php 
  
   echo"<form name=myform action=userAdd.php method=get>";
     echo"<TABLE BORDER=0>";
     
        echo "<TR>";
          	echo "<td>Username:</td><td><input type=text maxlength=50 name=username  value=''/></td>";
        echo"</TR>";

        echo "<TR>";
          	echo "<td>Signum:</td><td><input type=text maxlength=30 name=signum  value=''/></td>";
        echo"</TR>";
       
        echo "<TR>";
          	echo "<td>E-mail:</td><td><input type=text maxlength=60 name=email_addr value=''/> </TD> ";
        echo"</TR>";

        echo "<TR>";
          	echo "<td>Team:</td><td><input type=text maxlength=30 name=team value=''/> </TD> ";
        echo"</TR>";
     
        echo "<TR>";
    
        echo"</TABLE>";  
     	echo"<input type=submit name=pressed value=\"Add user\" />";
	echo"</form>";

?>
		
</div>
</div>
</div>

<?php include dirname(__FILE__) . '/include/footer.php';?>

</div>
</body>
</html>
