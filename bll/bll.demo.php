<?php

require_once('./dal/dal.demo.php');

class BLLDemo
{
	
	function __construct()
	{
		# code...
	}
	public function getUsers()
	{
		$dalDemo = new DALDemo;
		$result = $dalDemo->getUsers();
		$res=$dalDemo->getRows($result);
		$size = sizeof($res);
		$data = "";
		$sl = 1;
		for ($i=0; $i<$size-1; $i++)
		{ 
			$data.= "<tr>";
			$data.= "<td>";
			$data.= $sl++;
			$data.= "</td>";
			$data.= "<td>";
			$data.= $res[$i]['userName'];
			$data.= "</td>";
			$data.= "<td>";
			$data.= $res[$i]['password'];
			$data.= "</td>";
			$data.= "</tr>";
		}
		return $data;
	}

	public function getAllUsers()
    {
        $dalDemo = new DALDemo;
        $result = $dalDemo->getAllUsers();
        return $result;
    }
}
?>