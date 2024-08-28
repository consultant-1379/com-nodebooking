var popupStatus = 0;

function handlePopupEvent () {
	
	//Click the x event!
	$("#popupBookClose").click(
		function(){
			disablePopup();
		}
	);

	//Click out event!
	$("#backgroundPopup").click(
		function(){
			disablePopup();
		}
	);
}

function bookSystem () {
	var sysid = $("#booksysid").val();
	var sysname = $("#booksysname").text();
	var userid = $("#bookuser option:selected").val();
	var username = $("#bookuser option:selected").text();
/*	var team = $("#bookteam").val();*/
	var force = $("#force option:selected").val();
	var comment = $("#bookcomment").val();	
	var end_month = $("#end_month").val();
	var end_year = $("#end_year").val();
	var end_day = $("#end_day").val();	

	$.ajaxSetup ({
		cache: false,
		async: false
	});


	/*var r=confirm("Are sid=" + sysid + " u_id=" + userid );
	if (r==false)
  	{
  		return false;
  	} */  

	$.post("book.php", {sysid: sysid, sysname: sysname, userid: userid, username: username, force: force, comment: comment, month: end_month, day: end_day, year: end_year }, function(responseText){  
		alert(responseText);
        });
	    

	    
	disablePopup();
	location.reload();	
}

function loadPopup () {
	//loads popup only if it is disabled
	if(popupStatus==0) {
		$("#backgroundPopup").css({"opacity": "0.7"});
		$("#backgroundPopup").fadeIn("slow");
		$("#popupBook").fadeIn("slow");
		popupStatus = 1;
	}
}

function disablePopup () {
	//disables popup only if it is enabled
	if(popupStatus==1) {
		$("#backgroundPopup").fadeOut("slow");
		$("#popupBook").fadeOut("slow");
		popupStatus = 0;
	}
}

function centerPopup () {
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $("#popupBook").height();
	var popupWidth = $("#popupBook").width();
	//centering
	$("#popupBook").css({"position": "absolute","top": '20%',"left": '40%'});
	//only need force for IE6

	$("#backgroundPopup").css({"height": windowHeight});
}
