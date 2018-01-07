<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');


class DALUser
{
	
	function __construct()
	{

	}

	public function getUser()
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `user` WHERE 1 ORDER BY user.id";
		$result = $utility->dbQuery($sql);
		return $result;
	}
}
?>