<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');


class DALPrice
{
	
	function __construct()
	{

	}
	public function insertPrice($subCategoryName)
	{
		$utility = new Utility;

		// Default buy and sale value add when new subCategory created 
		$sql = "INSERT INTO `price`(`id`, `buy`, `sale`, `subCategoryId`) VALUES ('',1,1,(SELECT `id` FROM `subcategory` WHERE subcategory.name = '$subCategoryName'))";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function updatePrice($id,$buy,$sale)
	{
		$utility = new Utility;
		$sql = "UPDATE `price` SET `buy`=$buy,`sale`=$sale WHERE id = $id";
		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function getPrice()
	{
		$utility = new Utility;
		$sql = "SELECT price.*,subcategory.name as subCategoryName FROM `price`,`subcategory` WHERE price.subCategoryId = subcategory.id";
		$result = $utility->dbQuery($sql);
		return $result;
	}
}
?>