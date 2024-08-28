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
	<h3>Create a new system</h3>

<?php 
  
   echo"<form name=myform action=systemAdd.php method=get>";
     echo"<TABLE BORDER=0>";
            
        echo "<TR>";
          	echo "<td>Name:</td><td><input type=text maxlength=16 name=systemname value=''/> </TD> ";
        echo"</TR>";


        echo "<TR>";
	     	echo"<td><input type=submit name=pressed value=\"Submit\" /></td>";
        echo"</TR>";
     
    
     echo"</TABLE>";  
   echo"</form>";

?>
		
</div>
</div>
</div>

<?php include dirname(__FILE__) . '/include/footer.php';?>

</div>
</body>
</html>
