<!DOCTYPE html>
<html>
<head>


</head>
<body>

<script>

	function validateForm() 
	{
		var x = document.forms["frmLogCall"]["callerName"].value;
		var y = document.forms["frmLogCall"]["contactNo"].value;
		var z = document.forms["frmLogCall"]["location"].value;
		var w = document.forms["frmLogCall"]["incidentDesc"].value;
 
	if (x == "") 
		{
			alert("Name must be filled out"); 
			return  false;
		}
	else if(!isNaN(x))
		{
			alert("Name in Alphabet only.");
			return  false;  
		}
	  

	else if (y == "") 
		{
			alert("Contact Number must be filled out"); 
			return  false;
		}
	else if(isNaN(y))
		{
			alert("Contact Number MUST be filled with Number only.");  
			return  false;
		}  
  
	else if (z == "") 
		{
			alert("Please fill in the Location"); 
			return  false;
		}
  
	else if (w == "") 
		{
			alert("Please fill in the Description"); 
			return  false;
		}  
  
	else 
		{
			return true;
		}
			
 
	}
//	   if(validateForm() === true) {
//	   function gotopage(){
//	   window.open("dispatch.php", "_self");}

</script>
<?php include ('navigation.php'); ?>

<?php
$con = mysql_connect("localhost","seemon","91054133");
if(!$con)
    {
    die('Cannot connect to database :'.mysql_error());
    }

mysql_select_db("14_simon_pessdb",$con);

$result = mysql_query("SELECT * FROM incidenttype");

$incidenttype;

while($row = mysql_fetch_array($result))
{
//incidenttypeId,incidenttypeDesc


$incidenttype[$row['incidentTypeId']] = $row['incidentTypeDesc'];

}

mysql_close($con);

// simon
?>

<div class="form-container">
<fieldset>
    <legend>Log Call:</legend>
	<form name="frmLogCall" method="POST" action="dispatch.php" onsubmit="return validateForm()">
<table>
	<div class ="center">
	<tr>
		<p><td>Caller Name:</td>
		<td><input type="text" name="callerName"</td></p>
	</tr>

	<tr>
		<p><td>Contact Number:</td>
		<td><input type="text" name="contactNo"</td></p>
	</tr>

	<tr>
		<td><p>Location:</td>
		<td><input type="text" name="location"</p></td>
	</tr>
	<tr>
			<td class="td_label">Incident Type:</td>
			<td class = "td_Date">
			<p>
			<select name="incidenttype" id="incidenttype">
		<?php foreach($incidenttype as $key => $value){?>
			<option value-"<?php echo $key ?>"><?php echo $value ?></option>
		<?php } ?>
			</select>
			</p>
			</td>
			</tr>

	<tr>
	<td>Description</td>
	<td><textarea name="incidentDesc" rows="5" cols="30"></textarea></td>
	</tr>

	<tr>

	<td><input type="reset" name="reset" value="Reset" style="margin-top:25px;"></td>
	<td><input type="submit" value="Process Call" name="processCall" style="margin-top:25px;"></td>

	</tr>


</table>
</form>
</div>
</fieldset>
</div>
</body>
</html>