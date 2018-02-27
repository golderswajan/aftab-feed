<?php
/**
 * Created by PhpStorm.
 * User: Swajan
 * Date: 2/5/2018
 * Time: 8:41 AM
 */

require_once './includes/database.php';

if(isset($_POST['confirmReturn'])){
    $row = $_POST['rowNumber'];
    $totalCost = $_POST['totalCostField'];
    $categoryId = $_POST['category'];
    $memoNo = $_POST['memo'];


    $returnsId = db_insert_get_returnsId($totalCost,$categoryId,$memoNo);

    $query = "INSERT INTO `returnsproducts` (`id`, `pcs`, `unitPrice`, `returnsId`, `subCategoryId`) VALUES";
    for($i=1;$i<$row;$i++){
        $subCategoryId =$_POST['parentRowNo'.$i];
        $price = $_POST['price'.$i];
        $unit = $_POST['amount'.$i];

        $query .= " (NULL, '".$unit."', '".$price."', '".$returnsId."', '".$subCategoryId."')";
        if($i!=$row-1) $query.=",";
    }
    db_insert($query);
    $address = "Location: returns.php";
    header($address);

}