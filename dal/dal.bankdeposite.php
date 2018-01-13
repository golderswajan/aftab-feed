<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');


class DALBankDeposite
{
	
	function __construct()
	{

	}
	public function getBankDeposite($dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `bankdeposite` WHERE bankdeposite.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function insertBankDeposite($tokenNo,$bankName,$netAmount,$date)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `bankdeposite`(`id`, `tokenNo`, `bankName`, `netAmount`, `date`) VALUES ('','$tokenNo','$bankName',$netAmount,'$date')";
		$result = $utility->dbQuery($sql);
		//echo $sql;
		return $result;

	}
	public function updateBankDeposite($id,$tokenNo,$bankName,$netAmount,$date)
	{
		$utility = new Utility;
		$sql = "UPDATE `bankdeposite` SET `tokenNo`='$tokenNo',`bankName`='$bankName',`netAmount`=$netAmount,`date`='$date' WHERE id = $id";
		$result = $utility->dbQuery($sql);
		return $result;

	}

	public function deleteBankDeposite($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `bankdeposite` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getBankDepositeById($id)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `bankdeposite` WHERE bankdeposite.id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
}
?>