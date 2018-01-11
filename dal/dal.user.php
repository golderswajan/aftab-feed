<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');


class DALUser
{
	
	function __construct()
	{

	}
	public function insertUser($name,$phone,$password)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `user`(`id`, `userName`, `phone`, `password`) VALUES ('','$name','$phone','$password')";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getUser()
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `user` WHERE 1 ORDER BY user.id";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getUserById($id)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `user` WHERE user.id=$id";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function UpdateUser($id,$name,$phone)
	{
		$utility = new Utility;
		$sql = "UPDATE `user` SET `userName`='$name',`phone`='$phone' WHERE id=$id";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function deleteUser($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `user` WHERE user.id=$id";
		$result = $utility->dbQuery($sql);
		return $result;
	}
}
?>