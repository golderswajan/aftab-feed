<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');


class DALReturns
{
	
	function __construct()
	{

	}
	public function insertReturns($pcs,$unitPrice,$netAmount,$date,$customerId,$subCategoryId)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `returns`(`id`, `pcs`, `unitPrice`, `netAmount`, `date`, `customerId`, `subCategoryId`) VALUES ('',$pcs,'$unitPrice',$pcs,$netAmount,$date,'$customerId','$subCategoryId')";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function updateReturns($id,$pcs,$unitPrice,$netAmount,$date,$customerId,$subCategoryId)
	{
		$utility = new Utility;
		$sql = "UPDATE `returns` SET `pcs`=$pcs,`unitPrice`='$unitPrice',`netAmount`=$netAmount,`date`=$date,`customerId`=$customerId,`subCategoryId`=$subCategoryId WHERE `id`= $id";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function showReturns()
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `returns` WHERE 1";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function deleteReturns($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `returns` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getReturnsById($id)
	{
		$utility = new Utility;
		$sql = "SELECT returns.*,category.id as categoryId,returns.subCategoryId as subCategoryId FROM `returns`,`subcategory`,`category` WHERE returns.subCategoryId = subcategory.id && subcategory.categoryId = category.id && returns.id = ".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}


	public function getReturnsByCategoryId($categoryId,$dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT returns.*, subcategory.name AS subCategory FROM returns,subcategory WHERE $categoryId = subcategory.categoryId && subcategory.id = returns.subCategoryId && returns.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

}
?>