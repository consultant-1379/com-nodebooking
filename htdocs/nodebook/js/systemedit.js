function onIpDeleteEvent(element) {
	var x;
	var r=confirm("Are you sure to delete the ip address?");
	if (r==true)
  	{
  		$(element).closest("tr").remove();
  	}
	$("#editiptable").html(x);
	var row = $(element).closest("tr");
	var iptype = row.find("td:nth-child(1) input:nth-child(2)").val();
	var ipprot = row.find("td:nth-child(2) input:nth-child(1)").val();
	var ipaddr = row.find("td:nth-child(2) input:nth-child(2)").val();
	var message = "IP address: " + iptype + " " + ipprot + " " + ipaddr + " removed\n";
	$('#bookcomment').val($('#bookcomment').val()+message);
}

function addIpRow() {
	$('#editiptable tr:last').after('<tr><td><label>Host&nbsp;</label><input type="hidden" name="newipid[]"/><input type="text" name="newiptype[]"/></td><td><label>Protocol&nbsp;</label><input type="text" name="newipprotocol[]"/><label>&nbsp;IP&nbsp;</label><input type="text" name="newipaddress[]"/></td><td><a href="#" onclick="onIpDeleteEvent(this)"><img src="image/delete.png" /></a></td></tr>');
}
