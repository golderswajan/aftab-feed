<?php
/**
 * Created by PhpStorm.
 * User: DreamLess
 * Date: 10/9/2017
 * Time: 3:45 AM
 */
require_once './includes/database.php';

if(isset($_POST['confirmSale'])){
    $row = $_POST['rowNumber'];
    $comission = $_POST['comission'];
    $customer = isset($_POST['customerName'])? $_POST['customerName']:'';
    $party = isset($_POST['partyDDL'])? $_POST['partyDDL']:'';
    $customerId = $party;
    if(!empty($customer)){
        $customerId = db_insert_get_customer($customer);
    }



    $saleId = db_insert_get_saleId($comission,$customerId);

    $query = "INSERT INTO `soldproducts` (`id`, `pcs`, `unitPrice`, `saleId`, `subCategoryId`) VALUES";
    for($i=1;$i<$row;$i++){
        $subCategoryId =$_POST['parentRowNo'.$i];
        $price = $_POST['price'.$i];
        $unit = $_POST['amount'.$i];

        $query .= " (NULL, '".$unit."', '".$price."', '".$saleId."', '".$subCategoryId."')";
        if($i!=$row-1) $query.=",";
    }
    db_insert($query);
    $address = "Location: sales.php";
    header($address);

}