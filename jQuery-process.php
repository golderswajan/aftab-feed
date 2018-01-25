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


if($categoryId!=null || !empty($categoryId)){
    $query = "select * from subcategory where categoryId = '".$categoryId."'";
    $data = db_select($query);
    echo json_encode($data);
}else if($subCategoryId!=null || !empty($subCategoryId)){
    $query = "select subcategory.name,price.sale as price from subcategory,price where subcategory.id=price.subCategoryId && subcategory.id='".$subCategoryId."'";
    $data = db_select($query);
    echo json_encode($data);
}