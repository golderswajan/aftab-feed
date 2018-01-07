<?php
	require_once('db.php');

	// $db = new DBUtil;
	// $host = $db->getDBHost();
	// $user = $db->getDBUserName();
	// $password = $db->getDBPassword();
	// $db = $db->getDBName();
	$host = "localhost";
	$user = "aftab";
	$password = "aftab";
	$db = "aftab";

	$con = mysqli_connect($host,$user,$password,$db) or die ("Couldn't connnect");
	// if($con)
	// {
	// 	echo "Connected!";
	// }
?>
