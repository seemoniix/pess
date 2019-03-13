<!DOCTYPE HTML>
<html>
<head>
<title>Dispatch</title>

<?php include 'navigation.php';?>
<style>
	.center
	{
		margin-left:35%;	
	}
</style>

<?php

//echo "You have clicked submit button and following is the values:<br>";
		//echo "caller name:" . $_POST['callerName'] . "<br>";
		//echo "contactNo:" . $_POST['contactNo'] . "<br>";
		//echo "You have selected total " . $total_selected . " cars!";
		//keep checked
		//print_r(explode(',',$patrolcarArray[1]['patrolcarId']));
		//echo "123";

if (!isset($_POST['processCall']) && !isset($_POST['Submit'])){
		header("Location: logcall.php");}
		
	if(isset($_POST['submit']))
	{
			$con = mysql_connect("localhost","seemon","91054133");
	if(!$con)
		{
		die('Cannot connect to database :'.mysql_error());
		}

	mysql_select_db("14_simon_pessdb",$con);

		$sql= "INSERT INTO incident (callName, phoneNumber ,incidentTypeId,incidentLocation, incidentDese ,incidentStatusId) VALUE('".$_POST['callerName']."','".$_POST['contactNo']."','".$_POST['incidenttype']."','".$_POST['location']."','".$_POST['incidentDesc']."','$status')";
		
		
		if(!mysql_query($sql,$con))
		{
				die('Error:' .mysql_error());
		}
		
		mysql_close($con);
	}
	
?>
<div style="margin-left:0%;">
<fieldset>
<legend>Dispatch Patrol car:</legend>
<form name="DispatchForm" method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
<div class ="center">

	<tr>
		<td>
			Caller's Name :
		</td>
		<td>
			<input type="hidden" name="callerName" value='<?php echo $callerName;?>'/>
		</td>
		<td>
			<b><?php echo $_POST['callerName'];?></b>
		</td>
	</tr>
	<br><br>
	<tr>
		<td>
			Contact No :
		</td>

		<td>
			<b><?php echo $_POST['contactNo'];?></b>
		</td>
	</tr>
	<br><br>
	<tr>
		<td>
			Location :
		</td>

		<td>
			<b><?php echo $_POST['location'];?></b>
		</td>
	</tr>
	<br><br>
		<tr>
		<td>
			Incident Type :
		</td>

		<td>
			<b><?php echo $_POST['incidenttype'];?></b>
		</td>
	</tr>
	<br><br>
	<tr>
		<td>
			Incident Description :
		</td>

		<td> 
			<p><?php echo $_POST['incidentDesc'];?></p>
		</td>
	
	</tr>
	</div>
</form>
<br>
</head>
<body>
<?php
/* Search and retrieve similar pending incidents and populate a table */

// connect to a database
$con = mysql_connect("localhost","seemon","91054133");
	if(!$con)
		{
		die('Cannot connect to database :'.mysql_error());
		}

	mysql_select_db("14_simon_pessdb",$con);

$sql = "SELECT patrolcarId, statusDesc FROM patrolcar JOIN patrolcar_status ON patrolcar.patrolcarStatusId = patrolcar_status.statusId WHERE patrolcar.patrolcarStatusId='2' OR patrolcar.patrolcarStatusId='3'";

$result=mysql_query($sql,$con);

$incidentArray;
$count=0;

while($row = mysql_fetch_array($result))
{
		$patrolcarArray[$count]=$row;
		$count++;
}

if(!mysql_query($sql,$con))
{
		die('Error:' . mysql_error());
}

mysql_close($con);

?>

<form name="DispatchForm" method="POST" action=<?php echo htmlentities($_SERVER['PHP_SELF']);?>>
<table width="80%" border="1" align="center" cellpadding="4" cellspacing="8" style="margin-left:100px;">
<tr>
<td width="20%">&nbsp;</td>
<td width="51%">Patrol Car ID</td>
<td width="29%">Status</td>
</tr>

<?php
$i=0;
while($i < $count){
?>
<tr>
<td class="td_label"><input type="checkbox" name="chkPatrolcar[]" value="<?php echo $patrolcarArray[$i]['patrolcarId']?>"></td>
<td><?php echo $patrolcarArray[$i]['patrolcarId']?></td>
<td><?php echo $patrolcarArray[$i]['statusDesc']?></td>
</tr>

<?php $i++;
} ?>

</table>

<table width="35%%" border="0" align="center" cellpadding="4" cellspacing="4">
<td width="46%" class="td_label"> <input type="reset" name="btnCancle" id="btnCancle" value="Reset" style="margin-top:23px; margin-left:70%;"> </td>
<td width="54%" class="td_Data">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btnSubmit" id="btnSubmit" value="Submit" style="margin-left:70%;">
</td>
</table>
	<input type="hidden" name="callerName"  value="<?php echo $_POST['callerName']; ?>">
	<input type="hidden" name="contactNo" value="<?php echo $_POST['contactNo']?>">
	<input type="hidden" name="Location" value="<?php echo $_POST['Location']; ?>">
	<input type="hidden" name="incidentDesc" value="<?php echo $_POST['incidentDesc']; ?>">
	<input type="hidden" name="incidenttype" value="<?php echo $_POST['incidenttype']; ?>">
</form>
</fieldset>
</div>

<?php
if (isset($_POST["btnSubmit"]))
{
	//connect to database
$con = mysql_connect("localhost","seemon","91054133");
	if(!$con)
		{
		die('Cannot connect to database :'.mysql_error());
		}

	mysql_select_db("14_simon_pessdb",$con);

//update patrol car status table and dispatch table 
$patrolcarDispatched = $_POST["chkPatrolcar"];

$c = count($patrolcarDispatched);

//insert new incident
$status;
if($c>0){
	$status='2';
}else{
	$status='1';
}

$sql = "INSERT INTO incident (callName, phoneNumber, incidentTypeid, incidentLocation, incidentDese, incidentStatusid) VALUES('$_POST[callerName]','$_POST[ContactNo]','$_POST[incidenttype]','$_POST[Location]','$_POST[incidentDesc]','$status')";

if(!mysql_query($sql,$con))
{
		die('Error1:'.mysql_error());
}
//retrieve new increment key for incidentId
$incidentId = mysql_insert_id($con);;

for($i=0;$i<$c;$i++)
{
	$sql="UPDATE patrolcar SET patrolcarStatusId='1' WHERE patrolcarId = '$patrolcarDispatched[$i]'";
	
	if(!mysql_query($sql,$con))
	{
	die('Error2:'.mysql_error());
	}
	
	$sql = "INSERT INTO dispatch(incidentId,patrolcarId,timeDispatched) VALUES('$incidentId','$patrolcarDispatched[$i]',NOW())";
	
	if(!mysql_query($sql,$con))
	{
	die('Error3:'.mysql_error());	
	}	
}

mysql_close($con); }

?>


</body>
</html>