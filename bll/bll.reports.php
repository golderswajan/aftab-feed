<?php
include($_SERVER['DOCUMENT_ROOT'].'/dal/dal.reports.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');

$bllReports = new BLLReports;
class BLLReports
{
    
    
    function __construct()
    {
        $utility = new Utility;
        $dalReports = new DALReports;
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
                        <th>Tk</th>
                        </thead>
                    <tbody>';

        while ($resSalesReport = mysqli_fetch_assoc($resultSalesReport))
        {
        $data .= '<tr>';

            $data .= '<td>'.$SL++.'</td>';
            $data .= '<td>'.$resSalesReport['categoryName'].'</td>';
            $data .= '<td>'.floor($resSalesReport['total']).'</td>';
        $data .= '</tr>';
        $totalSales += intval($resSalesReport['total']);


        }
        $data .= '<tr><td></td><td>Total = </td><td>';
        $data .= $totalSales;
        $data .= '</td></tr></tbody>';

        return $data;
    }

    public function showExpenseReport($dateFrom,$dateTo)
    {
        $dalReports  = new DALReports;
        $resultSalesReport = $dalReports->getExpenseReport($dateFrom,$dateTo);
        $totalSales = 0;
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
        $totalSales += intval($resSalesReport['total']);


        }
        $data .= '<tr><td></td><td>Total = </td><td>';
        $data .= $totalSales;
        $data .= '</td></tr></tbody>';

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
                        <th>SE OnHand</th>
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
               $totalStockValueToday += $resStockToday['netAmount'];
            }
            if($totalStockToday == NULL)
            {
                $totalStockToday = 0;
                $totalStockValueToday = 0;
            }

            // OnHand goods
            $resultOnHand = $dalReports->getOnHandBySubCategoryName($subCatName,$today);
            // variables
            $totalOnHand = 0;
            $totalOnHandValue = 0;
            while ($resOnHand = mysqli_fetch_assoc($resultOnHand))
            {
               $totalOnHand = $resOnHand['pcs'];
               $totalOnHandValue = $resOnHand['netAmount'];
            }
            if($totalOnHand == NULL)
            {
                $totalOnHand = 0;
                $totalOnHandValue = 0;
            }

             // Sales goods
            $resultSales = $dalReports->getSalesReportBySubCategoryName($subCatName,$today);
            // variables
            $totalSales = 0;
            $totalSalesValue = 0;
            while ($resSales = mysqli_fetch_assoc($resultSales))
            {
               $totalSales = $resSales['pcs'];
               $totalSalesValue = $resSales['netAmount'];
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
               $totalReturnsValue = $resReturns['netAmount'];
            }
            if($totalReturns == NULL)
            {
                $totalReturns = 0;
                $totalReturnsValue = 0;
            }

            // Normalize
            // $precision = 2;
            // $totalStockValueOpening = number_format($totalStockValueOpening,$precision);

            // $totalStockValueToday = number_format($totalStockValueToday,$precision);
            
            // $totalSalesValue = number_format($totalSalesValue,$precision);
            
            // $totalReturnsValue = number_format($totalReturnsValue,$precision);

            // Dispaly data
            $data .= '<tr>';
            $data .= '<td>'.$SL++.'</td>';
            $data .= '<td>'.$subCatName.'</td>';
            $data .= '<td>'.$totalStockOpening.'('.$totalStockValueOpening.')</td>';
            $data .= '<td>'.$totalStockToday.'('.$totalStockValueToday.')</td>';
            // Closing calculation
            $closingPcs = $totalStockOpening+$totalStockToday+$totalReturns-$totalOnHand;

            // Jhamela
            $utility = new Utility;
            $unitPrice = $utility->getSalePrice($subCatId);
            $closingValue = $closingPcs*$unitPrice;

            $data .= '<td>'.$totalOnHand.'('.$totalOnHandValue.')</td>';
            $data .= '<td>'.$totalSales.'('.$totalSalesValue.')</td>';
            $data .= '<td>'.$totalReturns.'('.$totalReturnsValue.')</td>';
            $data .= '<td>'.$closingPcs.'</td>';
            if($subCatName=="Flexi Load")
            {
                $data .= '<td>'.$closingValue.'<td class="alert-danger">'.($closingPcs-($closingPcs-($closingPcs*2.75/100))).'('.($closingValue-($closingValue-$closingValue*(2.75/100))).')</td></td>';
            }
            else
            {
                $data .= '<td>'.$closingValue.'</td>';
            }
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

    public function showFinalReport($today,$yesterday)
    {
        $dalReports  = new DALReports;
        $data = "";
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
         $valueReturns= 0;
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
            $valueIncentives -= $valueIncentives*(2.75/100);
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

        // Total Value
        // Close Vault
        // -----------------
        // Total
        $total = $totalValue+$closeVault;


        // Display section

        // Opening product
        $data.='<tr>';
        $data.='<td>';
        $data.='Opening product:';
        $data.='</td>';
        $data.='<td>';
        $data.=$valueOpening;
        $data.='</td>';
        $data.='</tr>';


        // Incentives

        $data.='<tr>';
        $data.='<td>';
        $data.='Incentive Value:';
        $data.='</td>';
        $data.='<td>';
        $data.=$valueIncentives;
        $data.='</td>';
        $data.='</tr>';

        // PO
        $data.='<tr>';
        $data.='<td>';
        $data.='PO In:';
        $data.='</td>';
        $data.='<td>';
        $data.=$valueArrived;
        $data.='</td>';
        $data.='</tr>';

        // Commission

        $data.='<tr>';
        $data.='<td>';
        $data.='Commission:';
        $data.='</td>';
        $data.='<td>';
        $data.=$valueCommission;
        $data.='</td>';
        $data.='</tr>';

        // Return product

        $data.='<tr>';
        $data.='<td>';
        $data.='MFS Return:';
        $data.='</td>';
        $data.='<td>';
        $data.=$valueReturns;
        $data.='</td>';
        $data.='</tr>';

        // Closing product

        $data.='<tr>';
        $data.='<td>';
        $data.='Total Value:';
        $data.='</td>';
        $data.='<td>';
        $data.=$totalValue;
        $data.='</td>';
        $data.='</tr>';

        $data.="<tr><td colspan='2'><hr></td></tr>";


        

        // Opening Vault
        $data.='<tr>';
        $data.='<td>';
        $data.='Opening Vault:';
        $data.='</td>';
        $data.='<td>';
        $data.=$openingVault;
        $data.='</td>';
        $data.='</tr>';

        // Total Sales
        $data.='<tr>';
        $data.='<td>';
        $data.='Total Sales:';
        $data.='</td>';
        $data.='<td>';
        $data.=$valueSales;
        $data.='</td>';
        $data.='</tr>';


        // Total Sale Value 

        $data.='<tr>';
        $data.='<td>';
        $data.='Total Sale Value :';
        $data.='</td>';
        $data.='<td>';
        $data.=$totalSaleValue;
        $data.='</td>';
        $data.='</tr>';

        $data.="<tr><td colspan='2'><hr></td></tr>";

        // Bank Deposite
        $data.='<tr>';
        $data.='<td>';
        $data.='Bank Deposite:';
        $data.='</td>';
        $data.='<td>';
        $data.=$valueBank;
        $data.='</td>';
        $data.='</tr>';

        // MFS Return
        $data.='<tr>';
        $data.='<td>';
        $data.='MFS Return:';
        $data.='</td>';
        $data.='<td>';
        $data.=$valueReturns;
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

        //Close Vault

        $data.='<tr>';
        $data.='<td>';
        $data.='Close Vault:';
        $data.='</td>';
        $data.='<td>';
        $data.=$closeVault;
        $data.='</td>';
        $data.='</tr>';
        
        $data.="<tr><td colspan='2'><hr></td></tr>";

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

}
?>