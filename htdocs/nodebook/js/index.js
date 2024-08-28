function hideTableIdColumn () {
	$('td:nth-child(1),th:nth-child(1)').hide();
}

function onBookClickedEvent (sysid, sysname) {
	$("#booksysname").text(sysname);
	$("#booksysid").val(sysid);
	//centering with css
	centerPopup();
	//load popup
	loadPopup();
}

function onUnbookClickedEvent (sysid) {
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





