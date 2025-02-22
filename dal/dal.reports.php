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
		$sql = "SELECT subcategory.name as subCategoryName, customer.name as customerName, customer.address as customerAddress, sale.comission as comission, soldproducts.pcs, soldproducts.unitPrice FROM subcategory, soldproducts, sale, customer WHERE customer.id = sale.customerId && sale.id = soldproducts.saleId && soldproducts.subCategoryId = subcategory.id && sale.date BETWEEN  '$dateFrom' AND '$dateTo' GROUP BY subCategoryName";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getSalesReportBySubCategoryName($subCategoryName,$date)
	{
		$utility = new Utility;
		$sql = "SELECT SUM(soldproducts.pcs) as pcs, SUM(soldproducts.unitPrice) as unitPrice FROM soldproducts,sale,subcategory WHERE sale.id = soldproducts.saleId && soldproducts.subCategoryId = subcategory.id && subcategory.name =  '$subCategoryName' && sale.date ='$date'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getSalesReportBySubCategoryId($subCatId,$saleId)
	{
		$utility = new Utility;
		$sql = "SELECT SUM(soldproducts.pcs) as pcs, SUM(soldproducts.unitPrice) as unitPrice FROM soldproducts WHERE soldproducts.subCategoryId =  '$subCatId' && soldproducts.saleId ='$saleId'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getSalesByCategoryName($dateFrom,$dateTo,$categoryName)
	{
		$utility = new Utility;
		$sql = "SELECT  SUM(soldproducts.pcs * soldproducts.unitPrice) as total,sale.memoNo,category.name as categoryName FROM soldproducts,sale,category WHERE soldproducts.saleId = sale.id && sale.categoryId = category.id && category.name = '$categoryName' && sale.date BETWEEN '$dateFrom' AND '$dateTo' GROUP BY memoNo ";
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
		$sql = "SELECT * FROM `closingstock`,`subcategory` WHERE closingstock.subCategoryId = subcategory.id && subcategory.name = '$subCatName' && closingstock.date = '$yesterday'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getStockReport($dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT subcategory.name as subCategoryName, SUM(stock.pcs) as pcs, SUM(stock.unitPrice) as unitPrice FROM stock,subcategory WHERE stock.subCategoryId = subcategory.id && stock.date BETWEEN '$dateFrom' AND '$dateTo' GROUP BY subCategoryName";
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
		$sql = "SELECT SUM(returnsproducts.pcs) as pcs, SUM(returnsproducts.unitPrice) as unitPrice FROM returnsproducts,returns,subcategory WHERE returns.id = returnsproducts.returnsId && returnsproducts.subCategoryId = subcategory.id && subcategory.name =  '$subCategoryName' && returns.date ='$date'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
/// Opening vault
	public function getOpeningVault($yesterday)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM vault WHERE vault.date = '$yesterday'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

#%%%%%%%%%%%%%%%%%%%%%%%%%%%S%%%
# Final Stock Report
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getTotalOpeningStock($yesterday)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM closingstock WHERE closingstock.date = '$yesterday'";
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
	/// only creditsale returns
	public function getTotalReturns($today)
	{
		$utility = new Utility;
		$sql = "SELECT returns.* FROM returns WHERE  returns.subCategoryId = 2 && returns.date = '$today'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getTotalSales($dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT soldproducts.* FROM soldproducts,sale WHERE soldproducts.saleId = sale.id && sale.date  BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}


	public function getTotalCost($dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM expense WHERE expense.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getBankDeposite($dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT * FROM `bankdeposite` WHERE bankdeposite.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%S%%%
# Feed Report
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getFeedReport($partyId,$keyName,$dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT soldproducts.*,sale.comission FROM soldproducts,sale,party,subcategory WHERE soldproducts.saleId = sale.id && sale.customerId= party.customerId && party.id =$partyId && soldproducts.subCategoryId = subcategory.id &&  subcategory.name = '$keyName' && sale.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getFeedSales($dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT sale.*, due.amount, customer.id as customerId, customer.name,customer.address FROM sale,due,customer,category WHERE sale.categoryId = category.id && category.name = 'Feed' && sale.customerId = customer.id && sale.id = due.saleId && sale.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getFeedCommission($partyId,$dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT DISTINCT(sale.id), sale.comission FROM sale,party,soldproducts,subcategory,category WHERE category.name='Feed' && category.id = subcategory.categoryId && subcategory.id = soldproducts.subCategoryId && soldproducts.saleId = sale.id && sale.customerId = party.customerId && party.id = $partyId && sale.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

#%%%%%%%%%%%%%%%%%%%%%%%%%%%S%%%
# Chicken Report
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getChickenReport($customerId,$keyName,$dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT SUM(soldproducts.pcs) as pcs,soldproducts.*,sale.comission FROM soldproducts,sale,subcategory WHERE soldproducts.saleId = sale.id && sale.customerId =$customerId && soldproducts.subCategoryId = subcategory.id &&  subcategory.name = '$keyName' && sale.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getChickenSales($dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT sale.*, due.amount, customer.id as customerId, customer.name,customer.address FROM sale,due,customer,category WHERE sale.categoryId = category.id && category.name = 'Chicken' && sale.customerId = customer.id && sale.id = due.saleId && sale.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getChickenCommission($customerId,$dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT DISTINCT(sale.id), sale.comission FROM sale,soldproducts,subcategory,category WHERE category.name='Chicken' && category.id = subcategory.categoryId && subcategory.id = soldproducts.subCategoryId && soldproducts.saleId = sale.id && sale.customerId = $customerId && sale.date BETWEEN '$dateFrom' AND '$dateTo'";
		$result = $utility->dbQuery($sql);
		return $result;
	}


	public function getParty()
	{
		$utility = new Utility;
		$sql = "SELECT customer.* FROM `party`,customer WHERE party.customerId = customer.id";
		$result = $utility->dbQuery($sql);
		return $result;
	}

	public function getPartyPayment($dateFrom,$dateTo)
	{
		$utility = new Utility;
		$sql = "SELECT customer.name, payment.amount FROM party,customer,payment WHERE party.customerId = customer.id && customer.id = payment.customerId && payment.date BETWEEN '$dateFrom' AND '$dateTo' GROUP BY customer.name ";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getPaymentByPartyId($partyId,$date)
	{
		$utility = new Utility;
		$sql = "SELECT payment.amount as totalPayment,payment.partyPaymentMemoNo,payment.details FROM party,customer,payment WHERE party.customerId = customer.id && customer.id = payment.customerId && party.id=$partyId && payment.date ='$date'";
		$result = $utility->dbQuery($sql);
		return $result;
	}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%S%%%
# Party Report
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	public function getSales($partyId,$date)
	{
		$utility = new Utility;
		$sql = "SELECT sale.* FROM sale,party WHERE sale.date = '$date' && sale.customerId = party.customerId && party.id = $partyId";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getProductSales($saleId,$subCatId)
	{
		$utility = new Utility;
		$sql = "SELECT soldproducts.* FROM soldproducts WHERE soldproducts.subCategoryId = $subCatId && soldproducts.saleId = $saleId ";
		$result = $utility->dbQuery($sql);
		return $result;
	}

///////////////////////////
// CORN JOB
///////////////////////////
	public function cronClosingVault($cash,$date)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `vault`(`id`, `amount`, `date`) VALUES ('',$cash,'$date')";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function cronClosingStock($pcs,$unitPrice,$date,$subCategoryId)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `closingstock`(`id`, `pcs`, `unitPrice`, `date`, `subCategoryId`) VALUES ('',$pcs,$unitPrice,'$date',$subCategoryId)";
		//echo $sql;
		$result = $utility->dbQuery($sql);
		return $result;
	}
}
?>