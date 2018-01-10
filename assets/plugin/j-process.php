<?php
/**
 * Created by PhpStorm.
 * User: swajan
 * Date: 12/27/2017
 * Time: 2:11 PM
 */
require_once 'database.php';

$generalSelect=isset($_POST['generalSelect'])?$_POST['generalSelect']:null;
$generalUpdate=isset($_POST['generalUpdate'])?$_POST['generalUpdate']:null;
$generalDelete=isset($_POST['generalDelete'])?$_POST['generalDelete']:null;


if($generalUpdate!=null || !empty($generalUpdate)){
    db_update($generalUpdate);
}else if($generalDelete!=null || !empty($generalDelete)){
    db_delete($generalDelete);
} else if($generalSelect!=null || !empty($generalSelect)){
    $data = db_select($generalSelect);
    echo json_encode($data);
}

