<?php
/**
 * Created by PhpStorm.
 * User: Swajan
 * Date: 1/24/2018
 * Time: 1:14 AM
 */
include_once './includes/database.php';
$categoryId=isset($_POST['categoryId'])?$_POST['categoryId']:null;
$subCategoryId=isset($_POST['subCategoryId'])?$_POST['subCategoryId']:null;
$categoryIdForMemo=isset($_POST['categoryIdForMemo'])?$_POST['categoryIdForMemo']:null;
$customerDueAmountMemo=isset($_POST['customerDueAmountMemo'])?$_POST['customerDueAmountMemo']:null;
$categoryIdForDueMemo=isset($_POST['categoryIdForDueMemo'])?$_POST['categoryIdForDueMemo']:null;
$returnMemo=isset($_POST['returnMemo'])?$_POST['returnMemo']:null;
$categoryIdForReturn=isset($_POST['categoryIdForReturn'])?$_POST['categoryIdForReturn']:null;



//for sale page
if($categoryId!=null || !empty($categoryId)){
    $query = "select * from subcategory where categoryId = '".$categoryId."'";
    $data = db_select($query);
    echo json_encode($data);
}else if($subCategoryId!=null || !empty($subCategoryId)){
    $query = "select subcategory.name,price.sale as price from subcategory,price where subcategory.id=price.subCategoryId && subcategory.id='".$subCategoryId."'";
    $data = db_select($query);
    echo json_encode($data);
}else if($categoryIdForMemo!=null || !empty($categoryIdForMemo)){
    echo json_encode(getMemoNo($categoryIdForMemo));

}
//for payment page
else if($customerDueAmountMemo!=null || !empty($customerDueAmountMemo)){
    $query = "select customer.name,customerduepayment.amount from customer,sale,customerduepayment where sale.categoryId='".$categoryIdForDueMemo."' && sale.memoNo='".$customerDueAmountMemo."' && sale.id=customerduepayment.saleId && sale.customerId=customer.id";
    $data = db_select($query);
    if($data==null || empty($data)){
        $data = "NOT EXISTS";
    }
    echo json_encode($data);
}
//for return page
else if($returnMemo!=null || !empty($returnMemo)){
    $query = "select customer.name from customer,sale where customer.id=sale.customerId && sale.categoryId='".$categoryIdForReturn."' && sale.memoNo='".$returnMemo."'";
    $data = db_select($query);
    if($data==null || empty($data)){
        $data = "NOT EXISTS";
    }
    echo json_encode($data);
}

