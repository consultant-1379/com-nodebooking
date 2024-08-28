function onBookClickedEvent () {
	var sysid = $("#nodeid").val();
	var sysname = $("#nodename").val();
	$("#booksysname").text(sysname);
	$("#booksysid").val(sysid);
	//centering with css
	centerPopup();
	//load popup
	loadPopup();
}

function onUnbookClickedEvent () {
	var sysid = $("#nodeid").val();

	var x;
	var r=confirm("Are you sure to unbook the system?");
	if (r==false)
  	{
  		return false;
  	}
	$(this).html(x);
	
	$.ajaxSetup ({
		cache: false,
		async: false
	});

	$.post("unbook.php", {sysid: sysid}, function(responseText){  
		alert(responseText);
            });
	location.reload();
}


function onDeleteSystemClickedEvent () {
	var sysid = $("#nodeid").val();

	var x;
	var r=confirm("Are you really sure you want to delete the system?");
	if (r==false)
  	{
  		return false;
  	}
	$(this).html(x);
	
	$.ajaxSetup ({
		cache: false,
		async: false
	});

	$.post("deleteSystem.php", {sysid: sysid}, function(responseText){  
		alert(responseText);
            });
	    
	location="index.php";
//	location.reload();
}
