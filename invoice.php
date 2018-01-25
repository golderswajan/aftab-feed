<?php
require('includes/fpdf/fpdf.php');
require('includes/connect.php');

/**
* 
*/
class MakePDF
{
	public $companyName="Aftab Feed Products";
	public $companyAddress1="Moylapota";
	public $companyAddress2="Khulna-9208, Bangladesh";
	public $companyPhone="+12345678";
	public $companyFax="Fax +12345678";

	
	function __construct($customerID,$customerName,$customerAddress,$customerPhone,$products)
	{
		//create pdf object
		$pdf = new FPDF('P','mm','A4');
		//add new page
		$pdf->AddPage();

		//set font to arial, bold, 14pt
		$pdf->SetFont('Arial','B',14);

		$this->header($pdf,$customerID);

		$this->billing($pdf,$customerName,$customerAddress,$customerPhone);

		### Invoice Content ===================================
		$pdf->SetFont('Arial','B',12);

		$pdf->Cell(130 ,5,'Description',1,0);
		$pdf->Cell(25 ,5,'Pcs.',1,0);
		$pdf->Cell(34 ,5,'Amount',1,1);//end of line

		$pdf->SetFont('Arial','',12);

		//Numbers are right-aligned so we give 'R' after new line parameter
		$total=0;
		while ($res = mysqli_fetch_assoc($products))
		{
			$pdf->Cell(130 ,5,$res['name'],1,0);
			$pdf->Cell(25 ,5,$res['pcs'],1,0);
			$pdf->Cell(34 ,5,$res['netAmount'],1,1,'R');//end of line

			$total += $res['netAmount'];
		}

		$discount=0;
		$taxRate = 0.15;
		$subTotal = ($total-$discount);
		$subTotal += $subTotal*$taxRate;
		//summary
		$pdf->Cell(130 ,5,'',0,0);
		$pdf->Cell(25 ,5,'Total',0,0);
		$pdf->Cell(4 ,5,'$',1,0);
		$pdf->Cell(30 ,5,$total,1,1,'R');//end of line

		$pdf->Cell(130 ,5,'',0,0);
		$pdf->Cell(25 ,5,'Discount',0,0);
		$pdf->Cell(4 ,5,'$',1,0);
		$pdf->Cell(30 ,5,$discount,1,1,'R');//end of line

		$pdf->Cell(130 ,5,'',0,0);
		$pdf->Cell(25 ,5,'Tax Rate',0,0);
		$pdf->Cell(4 ,5,'$',1,0);
		$pdf->Cell(30 ,5,'15%',1,1,'R');//end of line

		$pdf->Cell(130 ,5,'',0,0);
		$pdf->Cell(25 ,5,'Sub Total',0,0);
		$pdf->Cell(4 ,5,'$',1,0);
		$pdf->Cell(30 ,5,$subTotal,1,1,'R');//end of line

		### Invoice Content end===============================

		//output the result
		$pdf->Output();
	}
	private function header($pdf,$customerID)
	{
				### Header Section====================================
		$pdf->Cell(130 ,5,$this->companyName,0,0);
		$pdf->Cell(59 ,5,'INVOICE',0,1);//end of line

		//set font to arial, regular, 12pt
		$pdf->SetFont('Arial','',12);

		$pdf->Cell(130 ,5,$this->companyAddress1,0,0);
		$pdf->Cell(59 ,5,'',0,1);//end of line

		$pdf->Cell(130 ,5,$this->companyAddress2,0,0);
		$pdf->Cell(25 ,5,'Date',0,0);
		$date = date('Y-M-d');
		$pdf->Cell(34 ,5,$date,0,1);//end of line

		$pdf->Cell(130 ,5,'Phone '.$this->companyPhone,0,0);
		$pdf->Cell(25 ,5,'Invoice #',0,0);
		$pdf->Cell(34 ,5,'1234567',0,1);//end of line

		$pdf->Cell(130 ,5,'Fax '.$this->companyFax,0,0);
		$pdf->Cell(25 ,5,'Customer ID',0,0);
		$pdf->Cell(34 ,5,$customerID,0,1);//end of line

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


	 $customerID="12345678";
	 $customerName="Md. Shahidul Islam";
	 $customerAddress="Khluna University,Khulna-9208";
	 $customerPhone="01521207008";
global $con;
$sql = "SELECT stock.*, subcategory.name FROM stock,subcategory WHERE subcategory.id = stock.subCategoryId GROUP BY subcategory.name";
$products = mysqli_query($con,$sql);
//var_dump($products);
$MakePDF= new MakePDF($customerID,$customerName,$customerAddress,$customerPhone,$products);
?>