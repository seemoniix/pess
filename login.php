<?php
include 'connect_to_database.php'; //connect the connection page
if(empty($_SESSION)) // if the session not yet started 
   session_start();


if(isset($_SESSION['username'])) { // if already login
   header("location: logcall.php"); // send to home page
   exit; 
}
include 'navigation.php';
?>

<html>
<head></head>
<body>
<br/>
<fieldset>
<legend>Login:</legend>
<form action = "login_proccess.php" method = "post">
Username: <input type="text" name="username" /><br />
Password: <input type="password" name="password" /><br />
<input type = "submit" name="submit" value="Log in" />
</form>
</fieldset>
</body>
</html>