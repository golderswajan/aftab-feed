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
    $customer = isset($_POST['customerName'])? $_POST['customerName']:'';
    $party = isset($_POST['partyDDL'])? $_POST['partyDDL']:'';
    $customerId = $party;
    if(!empty($customer)){
        $customerId = db_insert_get_customer($customer);
    }

    $time = time();
    $date = date('Y-m-d',$time);

    $query = "INSERT INTO `sale` (`id`, `pcs`, `unitPrice`, `date`, `customerId`, `subCategoryId`) VALUES";
    for($i=1;$i<$row;$i++){
        $subCategoryId =$_POST['parentRowNo'.$i];
        $price = $_POST['price'.$i];
        $unit = $_POST['amount'.$i];

        $query .= " (NULL, '".$unit."', '".$price."', '".$date."', '".$customerId."', '".$subCategoryId."')";
        if($i!=$row-1) $query.=",";
    }
    db_insert($query);
    $address = "Location: sales.php";
    header($address);

}