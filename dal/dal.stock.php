<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');
include_once ($_SERVER['DOCUMENT_ROOT'].'/includes/database.php');


class DALStock
{
	
	function __construct()
	{

	}
    public function getSubCategory(){
        $utility = new Utility;
        $query = "select id,name from subcategory";
        return $utility->db_select($query);
    }
	public function insertStock($subCategoryId,$pcs,$unitPrice,$date)
	{
		$utility = new Utility;

		$sql = "INSERT INTO `stock`(`id`, `subCategoryId`, `pcs`, `unitPrice`, `date`) VALUES ('',$subCategoryId,$pcs,$unitPrice,'$date')";
		$result = $utility->dbQuery($sql);
		//echo $sql;
		return $result;

	}
	public function updateStock($id,$subCategoryId,$pcs,$unitPrice,$netAmount,$date)
	{
		$utility = new Utility;
		$sql = "UPDATE `stock` SET `explanation`='$explanation',`pcs`=$pcs,`unitPrice`=$unitPrice,`date`='$date',`subCategoryId`=$subCategoryId, `netAmount` = $netAmount WHERE id = $id";
		$result = $utility->dbQuery($sql);
		//echo $sql;
		return $result;

	}
	public function getStock()
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `stock` WHERE 1 ORDER BY stock.date ASC";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function deleteStock($id)
	{
		$utility = new Utility;
		$sql = "DELETE FROM `stock` WHERE id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getStockById($id)
	{
		$utility = new Utility;
		$sql = "SELECT stock.*,category.id as categoryId FROM `stock`,`subcategory`,`category` WHERE stock.subCategoryId = subcategory.id && subcategory.categoryId = category.id && stock.id=".$id;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getStockBySubCategoryId($subCategoryId,$dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `stock` WHERE stock.subCategoryId = $subCategoryId && stock.date  BETWEEN '".$dateFrom."' AND '".$dateTo."'";
		//echo $sql;
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getProfitSE($subCategoryId)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `profit` WHERE profit.subCategoryId = $subCategoryId";
		$result = $utility->dbQuery($sql);

		$percentage=0;
		while ($res = mysqli_fetch_assoc($result))
		{
			$percentage = $res['seRate'];
		}
		return $percentage ;
	}
	public function getProfitPOS($subCategoryId)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `profit` WHERE profit.subCategoryId = $subCategoryId";
		$result = $utility->dbQuery($sql);

		$percentage=0;
		while ($res = mysqli_fetch_assoc($result))
		{
			$percentage = $res['seRate'];
		}
		return $percentage ;
	}

#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# CORN JOB HERE
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function cornClosingStock($subCategoryId,$pcs,$unitPrice,$netAmount,$date)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `closingstock`(`id`, `subCategoryId`, `pcs`, `unitPrice`, `netAmount`, `date`) VALUES('',$subCategoryId,$pcs,$unitPrice,$netAmount,'$date')";

		$result = $utility->dbQuery($sql);
		return $result;

	}
	public function cornClosingVault($closingVault,$today)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `closingvault`(`id`, `netAmount`, `date`) VALUES('',$closingVault,'$today')";
		$result = $utility->dbQuery($sql);
		return $result;

	}

    public function getTotalStock($dateFrom,$dateTo,$category){
        if($category!=0) $category = " and stock.subCategoryId='".category."'";
        else $category = '';
        $utility = new Utility;
        $query = "select sum(pcs*unitPrice) as amount from stock where date  between '".$dateFrom."' and '".$dateTo."'".$category;
        $result = $utility->db_select($query);
        return $result[0]['amount'];

    }

}
?>