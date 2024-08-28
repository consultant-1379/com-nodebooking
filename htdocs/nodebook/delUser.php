<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/booking.css" />
    <script type="text/javascript" src="js/jquery-1.4.1.js"></script>    
    <script>
	function successFunction(response){
		alert(response);
		self.location="index.php";
	}
	function doDeleteUserDetected(userid){
		var x;
		var r=confirm("Are you really sure you want to delete the user?");
		if (r==false)
  		{
	  		return false;
  		}
		
		$(this).html(x);
	
		$.ajaxSetup ({
			cache: false,
			async: false
		});

		$.post("userDel.php", {userid: userid}, function(responseText){  
			alert(responseText);
	            });
		    
		location.reload();	
	}
    </script>
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
	<h3>Delete User</h3>

<?php 

    function list_user_alias($db){   	
	$db->sql('select id,signum from user order by signum collate nocase');	
	$users = $db->resultset();
	
	foreach ($users as $user) {	
		echo("<option value=".$user['id'].">".$user['signum']."</option>");
	}
    }


   echo"<form name=myUserForm action=userDel.php method=get>";
     echo"<TABLE BORDER=0>"; 
     
	echo"<TR>";
          	echo"<TD>User:</TD>";
		
         	echo"<TD>";
			echo"<select name=userid input type=text>";		
				list_user_alias($db);
	  		echo"</select>";
         	echo"</TD>";
       	 echo"</TR>";
            
    echo"</TABLE>";  
    		//echo"<input type=submit name=pressed value=\"Delete\" />";		
		echo "<input type='button' value='Delete' onclick='doDeleteUserDetected( document.myUserForm.userid.value )'>";		
    echo"</form>"
    
?>
		
</div>
</div>
</div>

<?php include dirname(__FILE__) . '/include/footer.php';?>

</div>
</body>
</html>
