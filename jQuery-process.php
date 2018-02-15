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
$customerMemo=isset($_POST['customerMemo'])?$_POST['customerMemo']:null;




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
}else if($customerMemo!=null || !empty($customerMemo)){
    $query = "select Customer from memono";
    $data = db_select($query)[0]['Customer'];
    echo json_encode($data);
}