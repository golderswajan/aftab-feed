<?php
include($_SERVER['DOCUMENT_ROOT'].'/dal/dal.stock.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');

$id = "";
$categoryId = "";
$subCategoryId = "";
$pcs = "";
$unitPrice = "";
$date = "";
$bllStock = new BLLStock;
class BLLStock
{
	
	
	function __construct()
	{
		$utility = new Utility;
		$dalStock = new DALStock;
		if(isset($_POST['insert_stock']))
		{
			$subCategoryId = $utility->secureInput($_POST['subCategoryId']);
			$pcs = $utility->secureInput($_POST['pcs']);
			$date = $utility->secureInput($_POST['dateOfSale']);

			$unitPrice = $utility->getBuyPrice($subCategoryId);
			$netAmount = $unitPrice*$pcs;

			//echo $subCategoryId.$pcs.$unitPrice;

			$result = $dalStock->insertStock($subCategoryId,$pcs,$unitPrice,$netAmount,$date);
			if($result)
			{
				$_SESSION['message'] = "Stock added Successfully!";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't inset stock !";
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}

		}
		if(isset($_POST['update_stock']))
		{

			$id = $utility->secureInput($_POST['id']);
			$subCategoryId = $utility->secureInput($_POST['subCategoryId']);
			$pcs = $utility->secureInput($_POST['pcs']);
			$date = $utility->secureInput($_POST['dateOfSale']);
			
			$unitPrice = $utility->getBuyPrice($subCategoryId);
			$netAmount = $unitPrice*$pcs;
			
			$result = $dalStock->updateStock($id,$subCategoryId,$pcs,$unitPrice,$netAmount,$date);

			if($result)
			{
				$_SESSION['message'] = "Stock updated Successfully!";
				header('Location:../stock.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update Stock!";
				header('Location:../stock.php');
				exit();
			}

		}

		if(isset($_GET['delete']))
		{
			$id = $utility->secureInput($_GET['delete']);
		
			$result = $dalStock->deleteStock($id);
			if($result)
			{
				$_SESSION['message'] = "Stock deleted Successfully!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}
			else
			{
				$_SESSION['message'] = "Can't delete Stock!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}

		}
		if(isset($_GET['edit']))
		{
			$id = $utility->secureInput($_GET['edit']);
		
			$this->getStockById($id);
		}
	}
	public function showStock($dateFrom,$dateTo)
	{
		$totalStock = 0;
		$data = "";
		$dalProductCategory = new DALProductCategory;
		$resultExpSubCat = $dalProductCategory->getSubCategory();
		while ($resInvSubCat = mysqli_fetch_assoc($resultExpSubCat))
		{
			// Data display 
			$data.='<div class="col-md-12">';
            $data.='<div class="card">';
			// Title of the menu table
			$data.='<div class="header">';
            $data.='<h4 class="title">'.$resInvSubCat['subCategoryName'].'</h4>';
            $data.='</div>';

			// Table for each stock category
			$data.='<div class="table-responsive table-bordered">';
            $data.='<table class="table" id="'.$resInvSubCat['subCategoryName'].'"">';
            
            // For each category find stock

            $dalStock  = new DALStock;
            $resultStock = $dalStock->getStockBySubCategoryId($resInvSubCat['id'],$dateFrom,$dateTo);

            $SL = 1;
            $totalPV = 0;
            $data.= '<thead><th>SL</th><th>Amount(pcs/kg)</th><th>Unit Price</th><th>Product Value</th><th>Edit</th><th>Delete</th></thead>';
            $data.= '<tbody>';
            while ($resInv = mysqli_fetch_assoc($resultStock))
            {
            	$data .= '<tr>';
            	$data .= '<td>'.$SL++.'</td>';
            	$data .= '<td>'.$resInv['pcs'].'</td>';
            	$data .= '<td>'.$resInv['unitPrice'].'</td>';
            	$data .= '<td>'.$resInv['netAmount'].'</td>';

            	$data .='<td><a href="stock.php?edit='.$resInv['id'].'">Edit</a></td>';
				$data .='<td><a href="stock.php?delete='.$resInv['id'].'">Delete</a></td>';
            	$data .= '</tr>';

            	$totalPV += $resInv['netAmount'];
            }
            $data.= '</tbody>';

            $data.= '<tfoot>';
            $data.= '<tr>';
            $data.= '<td>Total = </td><td></td><td></td><td></td><td>'.$totalPV.'</td><td></td><td></td>';
            $data.= '<tr>';
            $data.= '</tfoot>';


            // table for each stock category end
            $data.='</table>';
            $data.='</div>';

            // Data display End
            $data.='</div>';
            $data.='</div>';

            $totalStock += $totalPV;

		}

		// grand total calculation
		$data.='<div class="col-md-12">';
        $data.='<div class="card">';
		$data.='<div class="alert alert-info">';
        $data.='<span class="h3">Total Stock : '.floor($totalStock).' BDT</span>';
        $data.='</div>';
        $data.='</div>';
        $data.='</div>';
        

		return $data;


	}
	public function getStockById($id)
	{
		$dalStock = new DALStock;
		$result = $dalStock->getStockById($id);
		
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['id'] =$res['id'];
			$GLOBALS['categoryId'] =$res['categoryId'];
			$GLOBALS['subCategoryId'] =$res['subCategoryId'];
			$GLOBALS['pcs'] =$res['pcs'];
			$GLOBALS['unitPrice'] =$res['unitPrice'];
			$GLOBALS['date'] =$res['date'];
		}
	}

}
?>