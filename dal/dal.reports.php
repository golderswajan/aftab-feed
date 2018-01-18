<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');


class DALReports
{
	
	function __construct()
	{

	}
// Sub category id
	public function getSubCategories()
	{
		$utility = new Utility;
		$sql = "SELECT * FROM subcategory";
		$result = $utility->dbQuery($sql);
		return $result;
	}
// Sales report
	public function getSalesReport($dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT category.name as categoryName, SUM(sale.netAmount) as total FROM sale,subcategory,category WHERE sale.subCategoryId = subcategory.id && subcategory.categoryId = category.id && sale.date BETWEEN '$dateFrom' AND '$dateTo' GROUP BY categoryName";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getSalesReportBySubCategoryName($subCategoryName,$date)
	{
		$utility = new Utility;
		$sql = "SELECT SUM(sale.pcs) as pcs, SUM(sale.netAmount) as netAmount FROM sale,subcategory WHERE sale.subCategoryId = subcategory.id && subcategory.name =  '$subCategoryName' && sale.date ='$date'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getOnHandBySubCategoryName($subCategoryName,$date)
	{
		$utility = new Utility;
		$sql = "SELECT SUM(creditsale.pcs) as pcs, SUM(creditsale.netAmount) as netAmount FROM creditsale,subcategory WHERE creditsale.subCategoryId = subcategory.id && subcategory.name =  '$subCategoryName' && creditsale.date ='$date'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
// Expense report
	public function getExpenseReport($dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT expensecategory.name as categoryName, SUM(expense.netAmount) as total FROM expense,expensecategory WHERE expensecategory.id = expense.expenseCategoryId && expense.date BETWEEN '$dateFrom' AND '$dateTo' GROUP BY categoryName";
		$result = $utility->dbQuery($sql);
		return $result;
	}

// Closing goods of yesterday 
// Closings are calcualted by corn job.
	public function getOpeningStock($subCatName,$yesterday)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `closinginventory`,`subcategory` WHERE closinginventory.subCategoryId = subcategory.id && subcategory.name = '$subCatName' && closinginventory.date = '$yesterday'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getTodayStock($subCatName,$today)
	{
		$utility = new Utility;
		$sql = "SELECT stock.* FROM `stock`,`subcategory` WHERE stock.subCategoryId = subcategory.id && subcategory.name = '$subCatName' && stock.date = '$today'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

// Return goods
	public function getReturnsReportBySubCategoryName($subCategoryName,$date)
	{
		$utility = new Utility;
		$sql = "SELECT SUM(returns.pcs) as pcs, SUM(returns.netAmount) as netAmount FROM returns,subcategory WHERE returns.subCategoryId = subcategory.id && subcategory.name =  '$subCategoryName' && returns.date ='$date'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
/// Opening vault
	public function getOpeningVault($yesterday)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM closingvault WHERE closingvault.date = '$yesterday'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

#%%%%%%%%%%%%%%%%%%%%%%%%%%%S%%%
# Corn Job: Closing Stock
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function cornClosingStock($subCategoryId,$explanation,$pcs,$unitPrice,$netAmount,$date)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `closinginventory`(`id`, `subCategoryId`, `explanation`, `pcs`, `unitPrice`, `netAmount`, `date`) VALUES ('',$subCategoryId,'$explanation',$pcs,$unitPrice,$netAmount,$date)";
		$result = $utility->dbQuery($sql);
		return $result;
	}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%S%%%
# Final Stock Report
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getTotalOpeningStock($yesterday)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM closinginventory WHERE closinginventory.date = '$yesterday'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getTotalArrivedStock($today)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM stock WHERE stock.date = '$today'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getTotalSales($today)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM sale WHERE sale.date = '$today'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	/// only creditsale returns
	public function getTotalReturns($today)
	{
		$utility = new Utility;
		$sql = "SELECT returns.* FROM returns WHERE  returns.subCategoryId = 2 && returns.date = '$today'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getTotalIncentives($today)
	{
		// 2.75% is for POS value
		$utility = new Utility;
		$sql = "SELECT * FROM incentive WHERE incentive.date = '$today'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getTotalCost($today)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM expense WHERE expense.date = '$today'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getBankDeposite($today)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `bankdeposite` WHERE bankdeposite.date = '$today'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getStatus($date)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `flag` WHERE flag.date = '$date'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
}
?>