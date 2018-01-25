<?php
require('includes/fpdf/fpdf.php');
require('includes/connect.php');
require('dal/dal.reports.php');

/**
* 
*/
class ExpensePDF
{
	public $companyName="Aftab Feed Products";
	public $companyAddress1="Moylapota";
	public $companyAddress2="Khulna-9208, Bangladesh";
	public $companyPhone="+12345678";
	public $companyFax=" +12345678";

	
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

		$pdf->SetFont('Arial','',12);

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
		$pdf->Cell(125 ,5,'',0,0);
		$pdf->Cell(25 ,5,'Total',0,0);
		$pdf->Cell(34 ,5,$total,1,1,'R');//end of line

	

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

if(isset($_GET['expensePDF']))
{
	$dateFrom = $_GET['dateFromHolder'];
	$dateTo = $_GET['dateToHolder'];
	$ExpensePDF= new ExpensePDF($dateFrom,$dateTo);
}
?>