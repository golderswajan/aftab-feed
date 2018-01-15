<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');
include_once ($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');

class DALExpense
{
	
	function __construct()
	{

	}
	public function getExpenseCategory(){
        $utility = new Utility;
	    $query = "SELECT * FROM `expensecategory`";
	    return $utility->db_select($query);
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

	public function getTotalExpense($dateFrom,$dateTo,$category){
        if($category!=0) $category = " and expense.expenseCategoryId='".category."'";
        else $category = '';
        $utility = new Utility;
	    $query = "select sum(expense.netAmount) as cost from expense where expense.date between '".$dateFrom."' and '".$dateTo."'".$category;
        $result = $utility->db_select($query);
        return $result[0]['cost'];

    }

}
?>