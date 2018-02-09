<?php
include($_SERVER['DOCUMENT_ROOT'].'/dal/dal.reports.php');
include($_SERVER['DOCUMENT_ROOT'].'/dal/dal.productcategory.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');
require($_SERVER['DOCUMENT_ROOT'].'/includes/fpdf/fpdf.php');

if(isset($_GET['Sales']))
{
	$dateFrom = $_GET['dateFromHolder'];
	$dateTo = $_GET['dateToHolder'];
	$SalesPDF= new SalesPDF($dateFrom,$dateTo);
}
elseif(isset($_GET['Expense']))
{
	$dateFrom = $_GET['dateFromHolder'];
	$dateTo = $_GET['dateToHolder'];
	$ExpensePDF= new ExpensePDF($dateFrom,$dateTo);
}
elseif(isset($_GET['Stock']))
{
	$dateFrom = $_GET['dateFromHolder'];
	$dateTo = $_GET['dateToHolder'];
	$StockPDF= new StockPDF($dateFrom,$dateTo);
}
elseif(isset($_GET['Feed']))
{
	$dateFrom = $_GET['dateFromHolder'];
	$dateTo = $_GET['dateToHolder'];
	$FeedPDF= new FeedPDF($dateFrom,$dateTo);
}
elseif(isset($_GET['Chicken']))
{
	$dateFrom = $_GET['dateFromHolder'];
	$dateTo = $_GET['dateToHolder'];
	$ChickenPDF= new ChickenPDF($dateFrom,$dateTo);
}
class Company
{
	public $companyName="Aftab Feed Products";
	public $companyAddress1="Moylapota";
	public $companyAddress2="Khulna-9208, Bangladesh";
	public $companyPhone="+12345678";
	public $companyFax=" +12345678";
	function __construct()
	{
	}
}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
## Sales Report 
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
class SalesPDF extends Company
{
	
	function __construct($dateFrom,$dateTo)
	{
		//create pdf object
		$pdf = new FPDF('P','mm','A4');
		//add new page
		$pdf->AddPage();

		//set font to arial, bold, 14pt
		$pdf->SetFont('Arial','B',14);

		$this->header($pdf,$dateFrom,$dateTo);

		//$this->billing($pdf,$customerName,$customerAddress,$customerPhone);

		### Invoice Content ===================================
		$pdf->SetFont('Arial','B',12);

		$pdf->Cell(20 ,5,'SL.',1,0);
		$pdf->Cell(130 ,5,'Description',1,0);
		$pdf->Cell(34 ,5,'Amount (Tk.)',1,1);//end of line

		$pdf->SetFont('Courier','',12);

		//Numbers are right-aligned so we give 'R' after new line parameter
		
		$dalReports  = new DALReports;
        $resultSalesReport = $dalReports->getSalesReport($dateFrom,$dateTo);
		$subTotal=0;
		$sl=1;
		while ($res = mysqli_fetch_assoc($resultSalesReport))
		{
			$total = $res['pcs']*$res['unitPrice'];
			$pdf->Cell(20 ,5,$sl++,1,0);
			$pdf->Cell(130 ,5,$res['subCategoryName'],1,0);
			$pdf->Cell(34 ,5,$total,1,1,'R');//end of line

			$subTotal += $total;
		}

		//summary
		$pdf->SetFont('Helvetica','B',12);

		$pdf->Cell(125 ,5,'',0,0);
		$pdf->Cell(25 ,5,'Total = ',0,0);
		$pdf->Cell(34 ,5,$subTotal." Tk.",1,1,'R');//end of line

	

		### Invoice Content end===============================

		//output the result
		$pdf->Output();
	}
	private function header($pdf,$dateFrom,$dateTo)
	{
				### Header Section====================================
		$pdf->Cell(130 ,5,$this->companyName,0,0);
		$pdf->Cell(50 ,5,'Sales Report',0,1);//end of line

		//set font to arial, regular, 12pt
		$pdf->SetFont('Arial','',12);

		$pdf->Cell(130 ,5,$this->companyAddress1,0,0);
		$pdf->Cell(50 ,5,'',0,1);//end of line

		$pdf->Cell(130 ,5,$this->companyAddress2,0,0);
		$pdf->Cell(25 ,5,'Date',0,0);
		$pdf->Cell(34 ,5,$dateFrom.' To ',0,1);//end of line

		$pdf->Cell(130 ,5,'Phone '.$this->companyPhone,0,0);
		$pdf->Cell(25 ,5,'',0,0);
		$pdf->Cell(34 ,5,$dateTo,0,1);//end of line
		

		$pdf->Cell(130 ,5,'Fax '.$this->companyFax,0,0);
		$pdf->Cell(25 ,5,'Report No.',0,0);
		$pdf->Cell(34 ,5,'1234567',0,1);//end of line

		//make a dummy empty cell as a vertical spacer
		$pdf->Cell(189 ,10,'',0,1);//end of line
		### Header Section End================================
	}
	private function billing($pdf,$customerName,$customerAddress,$customerPhone)
	{
		### Billing address===================================
		$pdf->Cell(100 ,5,'Bill to,',0,1);//end of line

		//add dummy cell at beginning of each line for indentation
		$pdf->Cell(10 ,5,'',0,0);
		$pdf->Cell(90 ,5,$customerName,0,1);

		$pdf->Cell(10 ,5,'',0,0);
		$pdf->Cell(90 ,5,$customerAddress,0,1);

		// $pdf->Cell(10 ,5,'',0,0);
		// $pdf->Cell(90 ,5,'Khulna-9208',0,1);

		$pdf->Cell(10 ,5,'',0,0);
		$pdf->Cell(90 ,5,$customerPhone,0,1);

		//make a dummy empty cell as a vertical spacer
		$pdf->Cell(189 ,10,'',0,1);//end of line

		### Billing address end================================
	}
}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
## Expense Report 
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
class ExpensePDF extends Company
{
	
	function __construct($dateFrom,$dateTo)
	{
		//create pdf object
		$pdf = new FPDF('P','mm','A4');
		//add new page
		$pdf->AddPage();

		//set font to arial, bold, 14pt
		$pdf->SetFont('Arial','B',14);

		$this->header($pdf,$dateFrom,$dateTo);

		//$this->billing($pdf,$customerName,$customerAddress,$customerPhone);

		### Invoice Content ===================================
		$pdf->SetFont('Arial','B',12);

		$pdf->Cell(20 ,5,'SL.',1,0);
		$pdf->Cell(130 ,5,'Description',1,0);
		$pdf->Cell(34 ,5,'Amount (Tk.)',1,1);//end of line

		$pdf->SetFont('Courier','',12);

		//Numbers are right-aligned so we give 'R' after new line parameter
		
		$dalReports  = new DALReports;
        $resultSalesReport = $dalReports->getExpenseReport($dateFrom,$dateTo);
		$total=0;
		$sl=1;
		while ($res = mysqli_fetch_assoc($resultSalesReport))
		{
			$pdf->Cell(20 ,5,$sl++,1,0);
			$pdf->Cell(130 ,5,$res['categoryName'],1,0);
			$pdf->Cell(34 ,5,$res['total'],1,1,'R');//end of line

			$total += $res['total'];
		}

		//summary
		$pdf->SetFont('Helvetica','B',12);

		$pdf->Cell(125 ,5,'',0,0);
		$pdf->Cell(25 ,5,'Total = ',0,0);
		$pdf->Cell(34 ,5,$total." Tk.",1,1,'R');//end of line

	

		### Invoice Content end===============================

		//output the result
		$pdf->Output();
	}
	private function header($pdf,$dateFrom,$dateTo)
	{
				### Header Section====================================
		$pdf->Cell(130 ,5,$this->companyName,0,0);
		$pdf->Cell(50 ,5,'Expense Report',0,1);//end of line

		//set font to arial, regular, 12pt
		$pdf->SetFont('Arial','',12);

		$pdf->Cell(130 ,5,$this->companyAddress1,0,0);
		$pdf->Cell(50 ,5,'',0,1);//end of line

		$pdf->Cell(130 ,5,$this->companyAddress2,0,0);
		$pdf->Cell(25 ,5,'Date',0,0);
		$pdf->Cell(34 ,5,$dateFrom.' To ',0,1);//end of line

		$pdf->Cell(130 ,5,'Phone '.$this->companyPhone,0,0);
		$pdf->Cell(25 ,5,'',0,0);
		$pdf->Cell(34 ,5,$dateTo,0,1);//end of line
		

		$pdf->Cell(130 ,5,'Fax '.$this->companyFax,0,0);
		$pdf->Cell(25 ,5,'Report No.',0,0);
		$pdf->Cell(34 ,5,'1234567',0,1);//end of line

		//make a dummy empty cell as a vertical spacer
		$pdf->Cell(189 ,10,'',0,1);//end of line
		### Header Section End================================
	}
	private function billing($pdf,$customerName,$customerAddress,$customerPhone)
	{
		### Billing address===================================
		$pdf->Cell(100 ,5,'Bill to,',0,1);//end of line

		//add dummy cell at beginning of each line for indentation
		$pdf->Cell(10 ,5,'',0,0);
		$pdf->Cell(90 ,5,$customerName,0,1);

		$pdf->Cell(10 ,5,'',0,0);
		$pdf->Cell(90 ,5,$customerAddress,0,1);

		// $pdf->Cell(10 ,5,'',0,0);
		// $pdf->Cell(90 ,5,'Khulna-9208',0,1);

		$pdf->Cell(10 ,5,'',0,0);
		$pdf->Cell(90 ,5,$customerPhone,0,1);

		//make a dummy empty cell as a vertical spacer
		$pdf->Cell(189 ,10,'',0,1);//end of line

		### Billing address end================================
	}
}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
## Stock Report 
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

class StockPDF extends Company
{
	function __construct($dateFrom,$dateTo)
	{
		//create pdf object
		$pdf = new FPDF('P','mm','A4');
		//add new page
		$pdf->AddPage();

		//set font to arial, bold, 14pt
		$pdf->SetFont('Arial','B',14);

		$this->header($pdf,$dateFrom,$dateTo);

		//$this->billing($pdf,$customerName,$customerAddress,$customerPhone);

		### Invoice Content ===================================
		$pdf->SetFont('Arial','B',12);

		$pdf->Cell(20 ,5,'SL.',1,0);
		$pdf->Cell(130 ,5,'Description',1,0);
		$pdf->Cell(34 ,5,'Amount (Tk.)',1,1);//end of line

		$pdf->SetFont('Courier','',12);

		//Numbers are right-aligned so we give 'R' after new line parameter
		
		$dalReports  = new DALReports;
        $resultSalesReport = $dalReports->getStockReport($dateFrom,$dateTo);
		$total=0;
		$sl=1;
		while ($res = mysqli_fetch_assoc($resultSalesReport))
		{
			$pdf->Cell(20 ,5,$sl++,1,0);
			$pdf->Cell(130 ,5,$res['subCategoryName'],1,0);
			$netAmount = $res['pcs']*$res['unitPrice'];
			$pdf->Cell(34 ,5,$netAmount,1,1,'R');//end of line

			$total += $netAmount;
		}

		//summary
		$pdf->SetFont('Helvetica','B',12);

		$pdf->Cell(125 ,5,'',0,0);
		$pdf->Cell(25 ,5,'Total = ',0,0);
		$pdf->Cell(34 ,5,$total." Tk.",1,1,'R');//end of line

	

		### Invoice Content end===============================

		//output the result
		$pdf->Output();
	}
	private function header($pdf,$dateFrom,$dateTo)
	{
				### Header Section====================================
		$pdf->Cell(130 ,5,$this->companyName,0,0);
		$pdf->Cell(50 ,5,'Stock Report',0,1);//end of line

		//set font to arial, regular, 12pt
		$pdf->SetFont('Arial','',12);

		$pdf->Cell(130 ,5,$this->companyAddress1,0,0);
		$pdf->Cell(50 ,5,'',0,1);//end of line

		$pdf->Cell(130 ,5,$this->companyAddress2,0,0);
		$pdf->Cell(25 ,5,'Date',0,0);
		$pdf->Cell(34 ,5,$dateFrom.' To ',0,1);//end of line

		$pdf->Cell(130 ,5,'Phone '.$this->companyPhone,0,0);
		$pdf->Cell(25 ,5,'',0,0);
		$pdf->Cell(34 ,5,$dateTo,0,1);//end of line
		

		$pdf->Cell(130 ,5,'Fax '.$this->companyFax,0,0);
		$pdf->Cell(25 ,5,'Report No.',0,0);
		$pdf->Cell(34 ,5,'1234567',0,1);//end of line

		//make a dummy empty cell as a vertical spacer
		$pdf->Cell(189 ,10,'',0,1);//end of line
		### Header Section End================================
	}
	private function billing($pdf,$customerName,$customerAddress,$customerPhone)
	{
		### Billing address===================================
		$pdf->Cell(100 ,5,'Bill to,',0,1);//end of line

		//add dummy cell at beginning of each line for indentation
		$pdf->Cell(10 ,5,'',0,0);
		$pdf->Cell(90 ,5,$customerName,0,1);

		$pdf->Cell(10 ,5,'',0,0);
		$pdf->Cell(90 ,5,$customerAddress,0,1);

		// $pdf->Cell(10 ,5,'',0,0);
		// $pdf->Cell(90 ,5,'Khulna-9208',0,1);

		$pdf->Cell(10 ,5,'',0,0);
		$pdf->Cell(90 ,5,$customerPhone,0,1);

		//make a dummy empty cell as a vertical spacer
		$pdf->Cell(189 ,10,'',0,1);//end of line

		### Billing address end================================
	}
}

#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
## Chicken Report 
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
class ChickenPDF extends Company
{
	
	function __construct($dateFrom,$dateTo)
	{
		//create pdf object
		$pdf = new FPDF('P','mm','A3');
		//add new page
		$pdf->AddPage();

		//set font to arial, bold, 14pt
		$pdf->SetFont('Arial','B',14);

		$this->header($pdf,$dateFrom,$dateTo);

		### Content Header ===================================
		$pdf->SetFont('Arial','B',12);

		$dalProductCategory = new DALProductCategory;
        $resultSubCategoryName = $dalProductCategory->getChickenSubCategory();
		
		$pdf->Cell(15 ,5,'SL.',1,0);
		$pdf->Cell(30 ,5,'Customer',1,0);

        while ($res = mysqli_fetch_assoc($resultSubCategoryName))
        {
			$pdf->Cell(25 ,5,$res['subCategoryName'],1,0);
		}
		$pdf->Cell(30 ,5,'Total',1,0);
		$pdf->Cell(30 ,5,'Commission',1,0);
		$pdf->Cell(30 ,5,'Net Total',1,1); /// eol

		$pdf->SetFont('Courier','',12);

		### Content Header end===============================
		### Content body ===================================
		$pdf->SetFont('Arial','B',12);

		$SL=1;

		$dalReports  = new DALReports;
        $resultParty = $dalReports->getParty();
        while ($resParty = mysqli_fetch_assoc($resultParty))
        {
            $partyId = $resParty['id'];
            $totalChicken = 0;
            
            $pdf->Cell(15 ,5,$SL++,1,0);
            $pdf->Cell(30 ,5,$resParty['name'],1,0);

            // Again categorywise all the party sale retrive
            $resultSubCategoryName = $dalProductCategory->getChickenSubCategory();
            while ($resSubCatName = mysqli_fetch_assoc($resultSubCategoryName))
            {
                $keyName = $resSubCatName['subCategoryName'];

                $resultChickenReport = $dalReports->getChickenReport($partyId,$keyName,$dateFrom,$dateTo);

                
                while ($resChickenReport = mysqli_fetch_assoc($resultChickenReport))
                {
                    $total = $resChickenReport['pcs']*$resChickenReport['unitPrice'];
           			$pdf->Cell(25 ,5,$resChickenReport['pcs'],1,0);
                    $totalChicken += intval($total);
                }
            }
            /// Commission calculation
            $resultCom = $dalReports->getChickenCommission($partyId,$dateFrom,$dateTo);
            $totalCommission = 0;
            while ($resCom = mysqli_fetch_assoc($resultCom))
            {
                $totalCommission += $resCom['comission'];
            }

           	$pdf->Cell(30 ,5,$totalChicken,1,0);
           	$pdf->Cell(30 ,5,$totalCommission,1,0);
           	$pdf->Cell(30 ,5,($totalChicken-$totalCommission),1,1);
        }

		### Content body end===============================

		//output the result
		$pdf->Output();
	}
	private function header($pdf,$dateFrom,$dateTo)
	{
				### Header Section====================================
		$pdf->Cell(130 ,5,$this->companyName,0,0);
		$pdf->Cell(50 ,5,'Chicken Report',0,1);//end of line

		//set font to arial, regular, 12pt
		$pdf->SetFont('Arial','',12);

		$pdf->Cell(130 ,5,$this->companyAddress1,0,0);
		$pdf->Cell(50 ,5,'',0,1);//end of line

		$pdf->Cell(130 ,5,$this->companyAddress2,0,0);
		$pdf->Cell(25 ,5,'Date',0,0);
		$pdf->Cell(34 ,5,$dateFrom.' To ',0,1);//end of line

		$pdf->Cell(130 ,5,'Phone '.$this->companyPhone,0,0);
		$pdf->Cell(25 ,5,'',0,0);
		$pdf->Cell(34 ,5,$dateTo,0,1);//end of line
		

		$pdf->Cell(130 ,5,'Fax '.$this->companyFax,0,0);
		$pdf->Cell(25 ,5,'Report No.',0,0);
		$pdf->Cell(34 ,5,'1234567',0,1);//end of line

		//make a dummy empty cell as a vertical spacer
		$pdf->Cell(189 ,10,'',0,1);//end of line
		### Header Section End================================
	}

}

?>