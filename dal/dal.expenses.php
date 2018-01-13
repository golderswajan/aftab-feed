<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');


class DALExpense
{
	
	function __construct()
	{

	}
	public function insertExpense($categoryId,$details,$netAmount,$date)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `expense`(`id`, `details`, `netAmount`, `date`, `expenseCategoryId`) VALUES ('','$details',$netAmount,'$date',$categoryId)";
		$result = $utility->dbQuery($sql);
		//echo $sql;
		return $result;

	}
	public function updateExpense($id,$categoryId,$details,$netAmount,$date)
	{
		$utility = new Utility;
		$sql = "UPDATE `expense` SET `details`='$details',`netAmount`=$netAmount,`date`='$date',`expenseCategoryId`=$categoryId WHERE id = $id";
		$result = $utility->dbQuery($sql);
		return $result;

	}

	public function deleteExpense($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `expense` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getExpenseById($id)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `expense` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getExpenseByCategoryId($categoryId,$dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT expense.* FROM expense WHERE  expense.expenseCategoryId = $categoryId && expense.date BETWEEN '".$dateFrom."' AND '".$dateTo."'";
		//echo $sql;
		$result = $utility->dbQuery($sql);
		return $result;
	}

}
?>