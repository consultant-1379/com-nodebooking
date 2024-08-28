var popup = 0;

function handleHeaderPopupEvent () {
	
	//Click the x event!
	$(".popupClose").click(
		function(){
			disableHeaderPopup();
		}
	);

	//Click out event!
	$("#backgroundPopup").click(
		function(){
			disableHeaderPopup();
		}
	);
}

function onClickedEvent(eventType) {
	var target = "";
	if (eventType == "about") {
		target = "#popupAbout";
	} else {
		target = "#popupContact";
	}
	centerHeaderPopup(target);
	//load popup
	loadHeaderPopup(target);
}

function loadHeaderPopup (target) {
	//loads popup only if it is disabled
	if(popup==0) {
		$("#backgroundPopup").css({"opacity": "0.7"});
		$("#backgroundPopup").fadeIn("slow");
		$(target).fadeIn("slow");
		popup = 1;
	}
}

function disableHeaderPopup () {
	//disables popup only if it is enabled
	if(popup==1) {
		$("#backgroundPopup").fadeOut("slow");
		$(".popupHeader").fadeOut("slow");
		popup = 0;
	}
}

function centerHeaderPopup (target) {
	//request data for centering
	var windowWidth = document.documentElement.clientWidth;
	var windowHeight = document.documentElement.clientHeight;
	var popupHeight = $(target).height();
	var popupWidth = $(target).width();
	//centering
	$(target).css({"position": "absolute","top": '20%',"left": '40%'});
	//only need force for IE6

	$("#backgroundPopup").css({"height": windowHeight});
}
