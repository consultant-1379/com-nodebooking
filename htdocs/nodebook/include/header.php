<head>
    <script type="text/javascript" src="js/header.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {
		handleHeaderPopupEvent();
	});
    </script> 
    <link rel="stylesheet" type="text/css" href="css/header.css" />
</head>
<div id="head-container">
	<div id="header">
		<h1>COM Node Booking System</h1>
	</div>
</div>
<div id="navigation-container">
	<div id="navigation">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="addUser.php">Add User</a></li>
			<li><a href="delUser.php">Delete User</a></li>
			<li><a href="addSystem.php">Add System</a></li>									
			<li><a href="#" id="about" onclick="onClickedEvent(this.id)">About</a></li>
			<li><a href="#" id="contact" onclick="onClickedEvent(this.id)">Contact us</a></li>
		</ul>
	</div>
</div>
<div id="popupAbout" class="popupHeader">
	<a class="popupClose">x</a>
	<h1>About</h1>
	<p>
		Node booking COM Team Mi5 Style!
	</p>
</div>
<div id="popupContact" class="popupHeader">
	<a class="popupClose">x</a>
	<h1>Contact</h1>
	<p>
		PDLMI5TEAM@ex1.eemea.ericsson.se
	</p>
</div>
<div id="backgroundPopup"></div>
