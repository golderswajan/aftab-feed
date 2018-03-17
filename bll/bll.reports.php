<?php
include($_SERVER['DOCUMENT_ROOT'].'/dal/dal.reports.php');
include($_SERVER['DOCUMENT_ROOT'].'/dal/dal.party.php');
include($_SERVER['DOCUMENT_ROOT'].'/dal/dal.productcategory.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');

$bllReports = new BLLReports;
class BLLReports
{
    
    
    function __construct()
    {
        $utility = new Utility;
        $dalReports = new DALReports;

        if (isset($_POST['closing']))
        {
            $today = $_POST['today'];
            $yesterday = $_POST['yesterday'];
            $this->closingVault($today,$yesterday);
            $this->closingStock($today,$yesterday);

            header('Location:'.$_SERVER['HTTP_REFERER']);
            exit();
        }
    }

    public function showSalesReport($dateFrom,$dateTo)
    {
        $dalReports  = new DALReports;
        $resultSalesReport = $dalReports->getSalesReport($dateFrom,$dateTo);
        $totalSales = 0;
        $data = "";
        $SL = 1;

        $data.='<thead>
                        <th>SL.</th>
                        <th>Product</th>
                        <th>Pcs./Kg.</th>
                        <th>Tk</th>
                        </thead>
                    <tbody>';

        while ($resSalesReport = mysqli_fetch_assoc($resultSalesReport))
        {
            $total = $resSalesReport['pcs']*$resSalesReport['unitPrice'];
            $data .= '<tr>';
            $data .= '<td>'.$SL++.'</td>';
            $data .= '<td>'.$resSalesReport['subCategoryName'].'</td>';
            $data .= '<td>'.$resSalesReport['pcs'].'</td>';
            $data .= '<td>'.floor($total).'</td>';
            $data .= '</tr>';
            $totalSales += intval($total);


        }
        $data .= '<tr><td></td><td>Total = </td><td></td><td>';
        $data .= $totalSales;
        $data .= '</td></tr></tbody>';

        return $data;
    }
    public function showFeedReport($dateFrom,$dateTo)
    {
         $data = "";
        $SL = 1;

        $data.='<thead>
            <th>SL.</th>
            <th>Customer</th>
            <th>M.#</th>';

        $dalProductCategory = new DALProductCategory;
        $resultSubCategoryName = $dalProductCategory->getFeedSubCategory();
        while ($resSubCatName = mysqli_fetch_assoc($resultSubCategoryName))
        {
            $data.= '<th>'.$resSubCatName['subCategoryName'].'</th>';
        }
        $data.='<th>Total</th><th>Commission</th><th>Net Total</th><th>Remarks</th>
                </thead>
                <tbody>';

        $dalReports  = new DALReports;
        $resultSales = $dalReports->getFeedSales($dateFrom,$dateTo);

        while ($resSales= mysqli_fetch_assoc($resultSales))
        {
            $saleId = $resSales['id'];
            $customerId = $resSales['customerId'];
            $customerName = $resSales['name'];
            $customerAddress = $resSales['address'];
            $memoNo = $resSales['memoNo'];
            $total = $resSales['total'];
            $net = $resSales['net'];
            $com = $resSales['comission'];
            $due = $resSales['amount'];

            $data.='<tr>';
            $data.='<td>'.$SL++.'</td>';
            $data.='<td>'.$customerName.'('.$customerAddress.')</td>';
            $data.='<td>'.$memoNo.'</td>';

            $dalProductCategory = new DALProductCategory;
            $resultChickenSubCat = $dalProductCategory->getFeedSubCategory();
            while ($resChickenSubCat = mysqli_fetch_assoc($resultChickenSubCat))
            {
                $subCatId = $resChickenSubCat['id'];
                $pcs=0;
                $resultProductSale = $dalReports->getProductSales($saleId,$subCatId);
                while ($resProductSale = mysqli_fetch_assoc($resultProductSale))
                {
                    $pcs += $resProductSale['pcs'];
                }

                $data.='<td>'.$pcs.'</td>';

            }

            $data.='<td>'.$total.'</td>';
            $data.='<td>'.$com.'</td>';
            $data.='<td>'.$net.'</td>';
            $data.='<td>'.$due.'</td>';


            $data.='</tr>';


        }


        return $data;
    }
    public function showChickenReport($dateFrom,$dateTo)
    {
        $data = "";
        $SL = 1;

        $data.='<thead>
            <th>SL.</th>
            <th>Customer</th>
            <th>M.#</th>';

        $dalProductCategory = new DALProductCategory;
        $resultSubCategoryName = $dalProductCategory->getChickenSubCategory();
        while ($resSubCatName = mysqli_fetch_assoc($resultSubCategoryName))
        {
            $data.= '<th>'.$resSubCatName['subCategoryName'].'</th>';
        }
        $data.='<th>Total</th><th>Commission</th><th>Net Total</th><th>Remarks</th>
                </thead>
                <tbody>';

        $dalReports  = new DALReports;
        $resultSales = $dalReports->getChickenSales($dateFrom,$dateTo);

        while ($resSales= mysqli_fetch_assoc($resultSales))
        {
            $saleId = $resSales['id'];
            $customerId = $resSales['customerId'];
            $customerName = $resSales['name'];
            $customerAddress = $resSales['address'];
            $memoNo = $resSales['memoNo'];
            $total = $resSales['total'];
            $net = $resSales['net'];
            $com = $resSales['comission'];
            $due = $resSales['amount'];

            $data.='<tr>';
            $data.='<td>'.$SL++.'</td>';
            $data.='<td>'.$customerName.'('.$customerAddress.')</td>';
            $data.='<td>'.$memoNo.'</td>';

            $dalProductCategory = new DALProductCategory;
            $resultChickenSubCat = $dalProductCategory->getChickenSubCategory();
            while ($resChickenSubCat = mysqli_fetch_assoc($resultChickenSubCat))
            {
                $subCatId = $resChickenSubCat['id'];
                $pcs=0;
                $resultProductSale = $dalReports->getProductSales($saleId,$subCatId);
                while ($resProductSale = mysqli_fetch_assoc($resultProductSale))
                {
                    $pcs += $resProductSale['pcs'];
                }

                $data.='<td>'.$pcs.'</td>';

            }

            $data.='<td>'.$total.'</td>';
            $data.='<td>'.$com.'</td>';
            $data.='<td>'.$net.'</td>';
            $data.='<td>'.$due.'</td>';


            $data.='</tr>';


        }


        return $data;
    }

    public function showChickenReport2($dateFrom,$dateTo)
    {
        $data = "";
        $SL = 1;

        $data.='<thead>
                <th>SL.</th>
                <th>Client</th>';

        $dalProductCategory = new DALProductCategory;
        $resultSubCategoryName = $dalProductCategory->getChickenSubCategory();
        while ($resSubCatName = mysqli_fetch_assoc($resultSubCategoryName))
        {
            $data.= '<th>'.$resSubCatName['subCategoryName'].'</th>';
        }
        $data.='<th>Total</th><th>Commission</th><th>Net Total</th>
                </thead>
                <tbody>';

        $dalReports  = new DALReports;
        $dalParty  = new DALParty;
        // replace after pary crud created
        $resultParty = $dalParty->getCustomer();
        while ($resCustomer = mysqli_fetch_assoc($resultParty))
        {
            $customerId = $resCustomer['id'];
            $totalChicken = 0;
            
            
            $data .= '<tr>';
            $data .= '<td>'.$SL++.'</td>';
            $data .= '<td>'.$resCustomer['name'].'</td>';

            // Again categorywise all the Customer sale retrive
            $resultSubCategoryName = $dalProductCategory->getChickenSubCategory();
            while ($resSubCatName = mysqli_fetch_assoc($resultSubCategoryName))
            {
                $keyName = $resSubCatName['subCategoryName'];
                $resultChickenReport = $dalReports->getChickenReport($customerId,$keyName,$dateFrom,$dateTo);

                $data .= '<td>';
                while ($resChickenReport = mysqli_fetch_assoc($resultChickenReport))
                {
                    $total = $resChickenReport['pcs']*$resChickenReport['unitPrice'];
                    $data .=$resChickenReport['pcs'];
                    $totalChicken += intval($total);
                }
                $data .= '</td>';
            }
            /// Commission calculation
            $resultCom = $dalReports->getChickenCommission($customerId,$dateFrom,$dateTo);
            $totalCommission = 0;
            while ($resCom = mysqli_fetch_assoc($resultCom))
            {
                $totalCommission += $resCom['comission'];
            }

            $data .= '<td>'.$totalChicken.'</td>';
            $data .= '<td>'.$totalCommission.'</td>';
            $data .= '<td>'.($totalChicken-$totalCommission).'</td>';
            $data .= '</tr>';
        }
        $data .= '</tbody>';
        
        return $data;
    }


    public function showExpenseReport($dateFrom,$dateTo)
    {
        $dalReports  = new DALReports;
        $resultSalesReport = $dalReports->getExpenseReport($dateFrom,$dateTo);
        $totalExpense = 0;
        $data = "";
        $SL = 1;

        $data.=' <thead>
                        <th>SL.</th>
                        <th>Product</th>
                        <th>Tk</th>
                        </thead>
                    <tbody>';

        while ($resSalesReport = mysqli_fetch_assoc($resultSalesReport))
        {
            $data .= '<tr>';

            $data .= '<td>'.$SL++.'</td>';
            $data .= '<td>'.$resSalesReport['categoryName'].'</td>';
            $data .= '<td>'.$resSalesReport['total'].'</td>';
            $data .= '</tr>';
            $totalExpense += intval($resSalesReport['total']);
        }

        $resultBank = $dalReports->getBankDeposite($dateFrom,$dateTo);
        while ($resBank = mysqli_fetch_assoc($resultBank))
        {
            $data .= '<tr>';

            $data .= '<td>'.$SL++.'</td>';
            $data .= '<td>'.$resBank['bankName'].'</td>';
            $data .= '<td>'.$resBank['netAmount'].'</td>';
            $data .= '</tr>';
            $totalExpense += intval($resBank['netAmount']);
        }


        $data .= '<tr><td></td><td>Total = </td><td>';
        $data .= $totalExpense;
        $data .= '</td></tr></tbody>';

        return $data;

    }
    public function showPartyReport($dateFrom,$dateTo,$partyId)
    {
        $data = "";

        $dalParty = new DALParty;
        $resultParty = $dalParty->getPartyById($partyId);
        while ($resParty = mysqli_fetch_assoc($resultParty))
        {
            $data.= '<h3 class="text-center">'.$resParty['name'].','.$resParty['address'].'</h3>';
        }

        $data.='<thead>
                <th>SL.</th>
                <th>Date</th>
                <th>Memo</th>
                <th>D.</th>';

        $dalProductCategory = new DALProductCategory;
        $resultSubCategoryName = $dalProductCategory->getSubCategory();
        while ($resSubCatName = mysqli_fetch_assoc($resultSubCategoryName))
        {
            $data.= '<th>'.$resSubCatName['subCategoryName'].'</th>';
        }
        $data.='<th>Total</th><th>Com.</th><th>Net.</th><th>Payment</th><th>Balance</th>
                </thead>
                <tbody>';

        $dalReports  = new DALReports;

        // Party loop
        //$partyId = 2; 

        // Date loop 
        $SL = 1;
        $tempBalance = 10000;// HardCode... will be changed later

        $datediff = strtotime($dateTo) - strtotime($dateFrom);
        $datediff = floor($datediff/(60*60*24));
        for($i = 0; $i < $datediff + 1; $i++)
        {

            $date= date("Y-m-d", strtotime($dateFrom . ' + ' . $i . 'day'));

            /// Sold products list
            $resultSales = $dalReports->getSales($partyId,$date);
            while ($resSales = mysqli_fetch_assoc($resultSales))
            {

                $memoNo = $resSales['memoNo'];
                $saleId = $resSales['id'];
                $com = $resSales['comission'];
                $net = $resSales['net'];
                $total = $resSales['total'];
                $tempBalance += $net;

                // Put Data
                $data.='<tr><td>'.$SL++.'</td>';
                $data.='<td>'.$date.'</td>';
                $data.='<td>'.$memoNo.'</td>';
                $data.='<td> - </td>';

                $resultSubCategory= $dalProductCategory->getSubCategory();
                while ($resSubCat = mysqli_fetch_assoc($resultSubCategory))
                {
                    $subCatId= $resSubCat['id'];

                    $resultProducts = $dalReports->getSalesReportBySubCategoryId($subCatId,$saleId);
                    while ($resProd = mysqli_fetch_assoc($resultProducts))
                    {
                        $pcs = $resProd['pcs'];
                        
                        $data.='<td>'.$pcs.'</td>';
                    }
                }

                // Extra
                $data.='<td>'.$total.'</td>';
                $data.='<td>'.$com.'</td>';
                $data.='<td>'.$net.'</td>';
                $data.='<td> - </td>';
                $data.='<td>'.$tempBalance.'</td>';

                $data.='</tr>'; // End loop
            }
           
            $resultPayments = $dalReports->getPaymentByPartyId($partyId,$date);
            while ($resPayment = mysqli_fetch_assoc($resultPayments))
            {
                $payment = $resPayment['totalPayment'];
                $memoNo = $resPayment['partyPaymentMemoNo'];
                $details = $resPayment['details'];
                $tempBalance -= $payment;


                // Put Data
                $data.='<tr><td>'.$SL++.'</td>';
                $data.='<td>'.$date.'</td>';
                $data.='<td>'.$memoNo.'</td>';
                $data.='<td>'.$details.'</td>';

                $resultSubCategory= $dalProductCategory->getSubCategory();
                while ($resSubCat = mysqli_fetch_assoc($resultSubCategory))
                {

                    $data.='<td>  </td>';
                }

                // Extra
                $data.='<td> - </td>';
                $data.='<td> - </td>';
                $data.='<td> - </td>';
                $data.='<td>'.$payment.'</td>';
                $data.='<td>'.$tempBalance.'</td>';
                

                $data.='</tr>'; // End loop
            }
        }
        

        return $data;
       

    }
// Report Stock 
    public function showStockReport($yesterday,$today)
    {
        $dalReports  = new DALReports;
        $resultSubCat = $dalReports->getSubCategories();
        $totalStock = 0;
        $data = "";
        $SL = 1;

        $data.='<thead>
                        <th>SL.</th>
                        <th>Product</th>
                        <th>Opening Goods</th>
                        <th>Recieved Goods</th>
                        <th>Sales Goods</th>
                        <th>Return Goods</th>
                        <th>Closing Goods</th>
                        <th>Product Value</th>
                        </thead>
                    <tbody>';
        while ($resSubCat = mysqli_fetch_assoc($resultSubCat))
        {
            $subCatId = $resSubCat['id'];
            $subCatName = $resSubCat['name'];

            // Stock Opening
            $resultStockOpening = $dalReports->getOpeningStock($subCatName,$yesterday);
            // variables
            $totalStockOpening = 0;
            $totalStockValueOpening = 0;
            while ($resStockOpening = mysqli_fetch_assoc($resultStockOpening))
            {
                // More than 1 row returns :-) ;-)
               $totalStockOpening += $resStockOpening['pcs'];
               $totalStockValueOpening += $resStockOpening['netAmount'];
            }
            if($totalStockOpening == NULL)
            {
                $totalStockOpening = 0;
                $totalStockValueOpening = 0;
            }

            // Stock Today: Today actually
            $resultStockToday = $dalReports->getTodayStock($subCatName,$today);
            // variables
            $totalStockToday = 0;
            $totalStockValueToday = 0;
            while ($resStockToday = mysqli_fetch_assoc($resultStockToday))
            {
                // More than 1 row returns :-) ;-)
               $totalStockToday += $resStockToday['pcs'];
               $totalStockValueToday += $resStockToday['unitPrice']*$resStockToday['pcs'];
            }
            if($totalStockToday == NULL)
            {
                $totalStockToday = 0;
                $totalStockValueToday = 0;
            }


             // Sales goods
            $resultSales = $dalReports->getSalesReportBySubCategoryName($subCatName,$today);
            // variables
            $totalSales = 0;
            $totalSalesValue = 0;
            while ($resSales = mysqli_fetch_assoc($resultSales))
            {
               $totalSales = $resSales['pcs'];
               $unitPrice = $resSales['unitPrice'];

               $totalSalesValue = $totalSales*$unitPrice;
            }
            if($totalSales == NULL)
            {
                $totalSales = 0;
                $totalSalesValue = 0;
            }

             // Return goods
            $resultReturns = $dalReports->getReturnsReportBySubCategoryName($subCatName,$today);
            // variables
            $totalReturns = 0;
            $totalReturnsValue = 0;
            while ($resReturns = mysqli_fetch_assoc($resultReturns))
            {
               $totalReturns = $resReturns['pcs'];
               $unitPrice = $resSales['unitPrice'];

               $totalReturnsValue = $totalReturns*$unitPrice;
            }
            if($totalReturns == NULL)
            {
                $totalReturns = 0;
                $totalReturnsValue = 0;
            }

            // Dispaly data
            $data .= '<tr>';
            $data .= '<td>'.$SL++.'</td>';
            $data .= '<td>'.$subCatName.'</td>';
            $data .= '<td>'.$totalStockOpening.'('.$totalStockValueOpening.')</td>';
            $data .= '<td>'.$totalStockToday.'('.$totalStockValueToday.')</td>';
            // Closing calculation
            $closingPcs = $totalStockOpening+$totalStockToday+$totalReturns-$totalSales;

            // Jhamela
            $utility = new Utility;
            $unitPrice = $utility->getBuyPrice($subCatId);
            $closingValue = $closingPcs*$unitPrice;

            $data .= '<td>'.$totalSales.'('.$totalSalesValue.')</td>';
            $data .= '<td>'.$totalReturns.'('.$totalReturnsValue.')</td>';
            $data .= '<td>'.$closingPcs.'</td>';

            $data .= '<td>'.$closingValue.'</td>';
            $data .= '</tr>';
            $totalStock += $closingValue;

        }
        $data .= '<tr><td colspan="8">Total = </td><td>';
        $data .= floor($totalStock);
        $data .= '</td></tr>';

        return $data;

    }
#%%%%%%%%%%%%%%%%%%%%%%%%%
# FINAL REPORT 
#%%%%%%%%%%%%%%%%%%%%%%%%%

    public function showFinalReport($dateFrom,$dateTo)
    {
        $dalReports  = new DALReports;
        $data = "";
        
        // Opening vault
        $yesterday = strtotime("-1 day", $dateFrom);
        $resultVault= $dalReports->getOpeningVault($yesterday);
        $valueVault = 0;
        while ($resVault = mysqli_fetch_assoc($resultVault))
        {
           $valueVault += $resVault['amount'];
        }

        // Total Sales
        $resultSales= $dalReports->getTotalSales($dateFrom,$dateTo);
        $valueSales = 0;
        while ($resSales = mysqli_fetch_assoc($resultSales))
        {
           $valueSales += $resSales['pcs']*$resSales['unitPrice'];
        }
        

        // Total Cost
        $resultCost= $dalReports->getTotalCost($dateFrom,$dateTo);
        $valueCost = 0;
        while ($resCost = mysqli_fetch_assoc($resultCost))
        {
           $valueCost += $resCost['netAmount'];
        }

        // Bank Deposite
        $resultBank= $dalReports->getBankDeposite($dateFrom,$dateTo);
        $valueBank = 0;
        while ($resBank = mysqli_fetch_assoc($resultBank))
        {
           $valueBank += $resBank['netAmount'];
        }

        // Display section
        $total = $valueVault+$valueSales-$valueCost-$valueBank;
        
        // Total Sales
        $data.='<tr>';
        $data.='<td>';
        $data.='Total Sales:';
        $data.='</td>';
        $data.='<td>';
        $data.=$valueSales;
        $data.='</td>';
        $data.='</tr>';


        // Bank Deposite
        $data.='<tr>';
        $data.='<td>';
        $data.='Bank Deposite:';
        $data.='</td>';
        $data.='<td>';
        $data.=$valueBank;
        $data.='</td>';
        $data.='</tr>';

        // Total Cost
        $data.='<tr>';
        $data.='<td>';
        $data.='Costs:';
        $data.='</td>';
        $data.='<td>';
        $data.=$valueCost;
        $data.='</td>';
        $data.='</tr>';

       
        //Total

        $data.='<tr>';
        $data.='<td>';
        $data.='Total:';
        $data.='</td>';
        $data.='<td>';
        $data.=$total;
        $data.='</td>';
        $data.='</tr>';
        $data.='</tbody>';


        return $data;
    }
    public function showDetailedFinalReport($dateFrom,$dateTo)
    {
        $dalReports  = new DALReports;
        $data = "";
        
        $dalProductCategory = new DALProductCategory;
        $resultCategoryName = $dalProductCategory->getCategory();

        $data.='<thead>';
        $data.='<th>M.No</th><th>Detatils</th><th>Amount</th>';
        $data.='</thead>';

        // Opening vault
        
        $date=date_create($dateFrom);
        date_sub($date,date_interval_create_from_date_string("1 days"));
        $yesterday= date_format($date,"Y-m-d");

        $resultVault= $dalReports->getOpeningVault($yesterday);
        $valueVault = 0;
        while ($resVault = mysqli_fetch_assoc($resultVault))
        {
           $valueVault += $resVault['amount'];
        }
        if($valueVault==NULL)
        {
            $valueVault = 0;
        }
        $data.='<tr>';
        $data.='<td>';
        $data.='</td>';
        $data.='<td>';
        $data.= 'Previous cash in hand';
        $data.='</td>';
        $data.='<td>';
        $data.=$valueVault;
        $data.='</td>';
        $data.='</tr>';

        // Value Sales

        $totalValueSales = 0;
        while ($resCatName = mysqli_fetch_assoc($resultCategoryName))
        {
            // Total Sales
            $resultSales= $dalReports->getSalesByCategoryName($dateFrom,$dateTo,$resCatName['name']);
            $valueSales=0;
            while ($resSales = mysqli_fetch_assoc($resultSales))
            {
                $valueSales += $resSales['total'];
                // Total Sales
                $data.='<tr>';
                $data.='<td>';
                $data.= $resSales['memoNo'];
                $data.='</td>';
                $data.='<td>';
                $data.= $resSales['categoryName'];
                $data.='</td>';
                $data.='<td>';
                $data.=$resSales['total'];
                $data.='</td>';
                $data.='</tr>';
            }
            if($valueSales>0)
            {
                $data.='<tr>';
                $data.='<td>';
                $data.='</td>';
                $data.='<td class="text-right">';
                $data.= 'Sub Total=';
                $data.='</td>';
                $data.='<td>';
                $data.=$valueSales;
                $data.='</td>';
                $data.='</tr>';
            }

            $totalValueSales+=$valueSales;
        }


        // Pary payments
        $resultParty= $dalReports->getPartyPayment($dateFrom,$dateTo);
        $valueParty = 0;
        while ($resParty = mysqli_fetch_assoc($resultParty))
        {
            // payments
            $valueParty+=$resParty['amount'];
            $data.='<tr>';
            $data.='<td>';
            //$data.= $resSales['memoNo'];
            $data.='</td>';
            $data.='<td>';
            $data.= $resParty['name'];
            $data.='</td>';
            $data.='<td>';
            $data.=$resParty['amount'];
            $data.='</td>';
            $data.='</tr>';
        }
        if($valueParty>0)
        {
            $data.='<tr>';
            $data.='<td>';
            $data.='</td>';
            $data.='<td class="text-right">';
            $data.= 'Sub Total=';
            $data.='</td>';
            $data.='<td>';
            $data.=$valueParty;
            $data.='</td>';
            $data.='</tr>';
        }
        // Grand Total DR.
        $data.='<tr>';
        $data.='<td>';
        $data.='</td>';
        $data.='<td class="text-right">';
        $data.= 'Total Deposite=';
        $data.='</td>';
        $data.='<td>';
        $data.=$valueVault+$valueParty+$totalValueSales;
        $data.='</td>';
        $data.='</tr>';

        // Total Cost
        $resultCost= $dalReports->getTotalCost($dateFrom,$dateTo);
        $valueCost = 0;
        while ($resCost = mysqli_fetch_assoc($resultCost))
        {
           $valueCost += $resCost['netAmount'];
        }

        // Bank Deposite
        $resultBank= $dalReports->getBankDeposite($dateFrom,$dateTo);
        $valueBank = 0;
        while ($resBank = mysqli_fetch_assoc($resultBank))
        {
           $valueBank += $resBank['netAmount'];
        }

        $data.='</tbody>';


        return $data;
    }
    public function getClosingVault($today,$yesterday)
    {
        $dalReports  = new DALReports;

        // Total Opening Stock
        $resultOpening = $dalReports->getTotalOpeningStock($yesterday);
        $valueOpening = 0;
        while ($resOpening = mysqli_fetch_assoc($resultOpening))
        {
           $valueOpening += $resOpening['netAmount'];
        }

        // Total Stock Arrived today
        $resultArrived= $dalReports->getTotalArrivedStock($today);
        $valueArrived = 0;
        while ($resArrived = mysqli_fetch_assoc($resultArrived))
        {
           $valueArrived += $resArrived['netAmount'];
        }
        // Lifting commission

        $valueCommission = $this->getTotalCommission($today,$yesterday);

        // Total Sales
        $resultSales= $dalReports->getTotalSales($today);
        $valueSales = 0;
        while ($resSales = mysqli_fetch_assoc($resultSales))
        {
           $valueSales += $resSales['netAmount'];
        }
        // Return //products mfs
        // No need any more, since double entry system introduced
        // $resultReturns= $dalReports->getTotalReturns($today);
        // $valueReturns= 0;
        // while ($resReturn = mysqli_fetch_assoc($resultReturns))
        // {
        //    $valueReturns += $resReturn['netAmount'];
        // }

        // Total Cost
        $resultCost= $dalReports->getTotalCost($today);
        $valueCost = 0;
        while ($resCost = mysqli_fetch_assoc($resultCost))
        {
           $valueCost += $resCost['netAmount'];
        }

        // Bank Deposite
        $resultBank= $dalReports->getBankDeposite($today);
        $valueBank = 0;
        while ($resBank = mysqli_fetch_assoc($resultBank))
        {
           $valueBank += $resBank['netAmount'];
        }

        // Total Incentives
        $resultIncentives= $dalReports->getTotalIncentives($today);
        $valueIncentives= 0;
        while ($resIncentives = mysqli_fetch_assoc($resultIncentives))
        {
           $valueIncentives += $resIncentives['netAmount'];
        }
        // Left 2.75% incentives for POS value
        if($valueIncentives>0)
        {
            $valueIncentives =$valueIncentives- $valueIncentives*(2.75/100);
        }


        // Flooring
        $valueOpening = floor($valueOpening);
        $valueArrived = floor($valueArrived);
        $valueSales = floor($valueSales);
        $valueReturns = floor($valueReturns);
        $valueCost = floor($valueCost);
        $valueBank = floor($valueBank);
        $valueIncentives= floor($valueIncentives);
        $valueCommission = floor($valueCommission);

        // Calculations 

        // Opening Value
        // Incentive 
        // PO IN
        // Commission
        // MFS Return
        // -----------------
        // Total Value
        
        $totalValue= $valueOpening+$valueArrived+$valueIncentives+$valueReturns+$valueCommission;


        $closingProduct = $totalProduct+$valueReturns-$valueSales;

        // Opening Vault
        // Total Sale
        // -----------------
        // Total Sale Value
        $openingVault = 0;
        $resultVault = $dalReports->getOpeningVault($yesterday);
        while ($res = mysqli_fetch_assoc($resultVault))
        {
            $openingVault+= $res['netAmount'];
        }
        if($openingVault == NULL)
        {
            $openingVault = 0;
        }
        
        $totalSaleValue = $openingVault+$valueSales;
        // Total Sale Value
        //- Bank 
        //- MFS Return
        //-Cost
        
        // --------------------
        // Close Vault
        $closeVault =$totalSaleValue- ($valueBank+$valueReturns+$valueCost);
        return $closeVault;
    }
    public function getTotalCommission($today,$yesterday)
    {
        $dalReports  = new DALReports;
        $resultSubCat = $dalReports->getSubCategories();
        $totalCommission = 0;
    
        while ($resSubCat = mysqli_fetch_assoc($resultSubCat))
        {
            $subCatId = $resSubCat['id'];
            $subCatName = $resSubCat['name'];



            // Stock Today
            $resultStockToday = $dalReports->getTodayStock($subCatName,$today);
            // variables
            $totalStockToday = 0;
            $totalStockValueToday = 0;
            while ($resStockToday = mysqli_fetch_assoc($resultStockToday))
            {
                // More than 1 row returns :-) ;-)
               $totalStockToday += $resStockToday['pcs'];
               $totalStockValueToday += $resStockToday['netAmount'];
            }
            if($totalStockToday == NULL)
            {
                $totalStockToday = 0;
                $totalStockValueToday = 0;
            }

             
        
            $commissionPcs = $totalStockToday;

            // Jhamela
            $utility = new Utility;
            $buyPrice = $utility->getBuyPrice($subCatId);
            $salePrice = $utility->getSalePrice($subCatId);
            $closingProfit = ($commissionPcs*$salePrice)-($commissionPcs*$buyPrice);

            $totalCommission += $closingProfit;

        }

        // Incentive Today
        $resultIncentiveToday = $dalReports->getTotalIncentives($today);
        // variables
        $totalIncentiveToday = 0;
        $totalIncentiveValueToday = 0;
        while ($resIncentiveToday = mysqli_fetch_assoc($resultIncentiveToday))
        {
            // More than 1 row returns :-) ;-)
           $totalIncentiveToday += $resIncentiveToday['pcs'];
           $totalIncentiveValueToday += $resIncentiveToday['netAmount'];
        }
        if($totalIncentiveToday == NULL)
        {
            $totalIncentiveToday = 0;
            $totalIncentiveValueToday = 0;
        }
        $incentiveValue = $incentiveValue-$incentiveValue*(2.75/100);

        return $totalCommission+$incentiveValue;
    }

    public function getStatus($date)
    {
        $dalReports  = new DALReports;
        $result = $dalReports->getStatus($date);
       
        $data = "";
        $status = 0;
        while ($res = mysqli_fetch_assoc($result))
        {
            $status = $res['submit'];
        }

        if($status==1)
        {
            return "Report Submitted!";
        }
        else
        {
            return "Report not submitted yet!";

        }

    }

    public function closingVault($dateTo,$dateFrom)
    {
        $dalReports  = new DALReports;
        
        $dalProductCategory = new DALProductCategory;
        $resultCategoryName = $dalProductCategory->getCategory();

        $totalValueSales = 0;
        while ($resCatName = mysqli_fetch_assoc($resultCategoryName))
        {
            // Total Sales
            $resultSales= $dalReports->getSalesByCategoryName($dateFrom,$dateTo,$resCatName['name']);
            $valueSales=0;
            while ($resSales = mysqli_fetch_assoc($resultSales))
            {
                $valueSales += $resSales['total'];
            }

            $totalValueSales+=$valueSales;
        }


        // Pary payments
        $resultParty= $dalReports->getPartyPayment($dateFrom,$dateTo);
        $valueParty = 0;
        while ($resParty = mysqli_fetch_assoc($resultParty))
        {
            // payments
            $valueParty+=$resParty['amount'];
        }
        // Total Cost
        $resultCost= $dalReports->getTotalCost($dateFrom,$dateTo);
        $valueCost = 0;
        while ($resCost = mysqli_fetch_assoc($resultCost))
        {
           $valueCost += $resCost['netAmount'];
        }

        // Bank Deposite
        $resultBank= $dalReports->getBankDeposite($dateFrom,$dateTo);
        $valueBank = 0;
        while ($resBank = mysqli_fetch_assoc($resultBank))
        {
           $valueBank += $resBank['netAmount'];
        }

        $cashOnHand = $totalValueSales+$valueParty - $valueCost-$valueBank;

        $dalReports->cronClosingVault($cashOnHand,$dateTo);

    }

    public function closingStock($today,$yesterday)
    {
        $dalReports  = new DALReports;
        $resultSubCat = $dalReports->getSubCategories();
        $totalStock = 0;

        while ($resSubCat = mysqli_fetch_assoc($resultSubCat))
        {
            $subCatId = $resSubCat['id'];
            $subCatName = $resSubCat['name'];

            // Stock Opening
            $resultStockOpening = $dalReports->getOpeningStock($subCatName,$yesterday);
            // variables
            $totalStockOpening = 0;
            $totalStockValueOpening = 0;
            while ($resStockOpening = mysqli_fetch_assoc($resultStockOpening))
            {
                // More than 1 row returns :-) ;-)
               $totalStockOpening += $resStockOpening['pcs'];
               $totalStockValueOpening += $resStockOpening['netAmount'];
            }
            if($totalStockOpening == NULL)
            {
                $totalStockOpening = 0;
                $totalStockValueOpening = 0;
            }

            // Stock Today: Today actually
            $resultStockToday = $dalReports->getTodayStock($subCatName,$today);
            // variables
            $totalStockToday = 0;
            $totalStockValueToday = 0;
            while ($resStockToday = mysqli_fetch_assoc($resultStockToday))
            {
                // More than 1 row returns :-) ;-)
               $totalStockToday += $resStockToday['pcs'];
               $totalStockValueToday += $resStockToday['unitPrice']*$resStockToday['pcs'];
            }
            if($totalStockToday == NULL)
            {
                $totalStockToday = 0;
                $totalStockValueToday = 0;
            }

             // Sales goods
            $resultSales = $dalReports->getSalesReportBySubCategoryName($subCatName,$today);
            // variables
            $totalSales = 0;
            $totalSalesValue = 0;
            while ($resSales = mysqli_fetch_assoc($resultSales))
            {
               $totalSales = $resSales['pcs'];
               $unitPrice = $resSales['unitPrice'];

               $totalSalesValue = $totalSales*$unitPrice;
            }
            if($totalSales == NULL)
            {
                $totalSales = 0;
                $totalSalesValue = 0;
            }

             // Return goods
            $resultReturns = $dalReports->getReturnsReportBySubCategoryName($subCatName,$today);
            // variables
            $totalReturns = 0;
            $totalReturnsValue = 0;
            while ($resReturns = mysqli_fetch_assoc($resultReturns))
            {
               $totalReturns = $resReturns['pcs'];
               $unitPrice = $resSales['unitPrice'];

               $totalReturnsValue = $totalReturns*$unitPrice;
            }
            if($totalReturns == NULL)
            {
                $totalReturns = 0;
                $totalReturnsValue = 0;
            }
            // Closing calculation
            $closingPcs = $totalStockOpening+$totalStockToday+$totalReturns-$totalSales;

            // Jhamela
            $utility = new Utility;
            $unitPrice = $utility->getBuyPrice($subCatId);
            // $closingValue = $closingPcs*$unitPrice;
            // $totalStock += $closingValue;
            if($closingPcs>0)
            {
                $dalReports->cronClosingStock($closingPcs,$unitPrice,$today,$subCatId);
            }

        }
    }

}
?>