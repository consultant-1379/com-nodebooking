<?php
function date_picker($name, $startyear=NULL, $endyear=NULL){

    if($startyear==NULL) $startyear = date("Y");
    if($endyear==NULL) $endyear=date("Y")+5;     
    $start_month=date("n");
    $start_day=date("j");

    $months=array('','January','February','March','April','May',
    'June','July','August', 'September','October','November','December');

    // Year dropdown
    $html="<select id=end_year name=\"".$name."year\">";

    for($i=$startyear;$i<=$endyear;$i++)
    {      
      $html.="<option value='$i'>$i</option>";
    }
    $html.="</select> ";


    // Month dropdown
    $html.="<select id=end_month name=\"".$name."month\">";

    for($i=1;$i<=12;$i++){              
       if($i==$start_month){
	  $html.="<option value='$i' selected=selected>$months[$i]</option>";
       }
       else{
          $html.="<option value='$i'>$months[$i]</option>";
       }       
    }
    $html.="</select> ";
   
    // Day dropdown
    $html.="<select id=end_day name=\"".$name."day\">";
    for($i=1;$i<=31;$i++)
    {
       if($i==$start_day){
          $html.="<option value='$i' selected=selected>$i</option>";
       }
       else{
          $html.="<option value='$i'>$i</option>";
       }
    }
    $html.="</select> ";

    return $html;
}			

?>


<div id="popupBook">
	<a id="popupBookClose">x</a>
	<h1>To book node <label id="booksysname"></label></h1>
	<p>
		<input type="hidden" id="booksysid" />

		<div>
        		<label>User:</label>
    		</div>
		<div>
			<?php
			$db->sql('select id, name from user order by name collate nocase');
			$bookusers = $db->resultset();
			
			echo '<select id="bookuser">';
			foreach ($bookusers as $bookuser) {
				echo '<option value="' . $bookuser['id'] . '">' . $bookuser['name'] . '</option>';
			}
			echo '</select>';
			?>
    		</div>

		<div>
        		<label>End Date:</label>
    		</div>

		<div>
        		<?php echo date_picker("registration");?>
    		</div>		
		
		<div>
        		<label>Force Booking:</label>
    		</div>
		<div>
        		<select id="force">
            			<option value="false" selected="selected">No</option>
            			<option value="true">Yes</option>
        		</select>
    		</div>
		<div>
        		<label>Comment:</label>
    		</div>
		<div>
			<textarea id="bookcomment" rows="5" cols="40"></textarea>
		</div>
		<div>
        		<input type="button" value="Book" onclick="bookSystem()" /> 

    		</div>		


	</p>
</div>
<div id="backgroundPopup"></div>
