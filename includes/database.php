<?php
/**
 * Created by PhpStorm.
 * User: swaja
 * Date: 12/24/2017
 * Time: 10:15 AM
 */

function db_connect(){
    $serverName = "localhost";
    $userName = "aftab";
    $pass = "aftab";
    $dbName = "aftab";

    $con = new mysqli($serverName,$userName,$pass,$dbName);

    if(!$con->connect_error){
        return $con;
    }else {
        die("Error in connection : ".$con->connect_error);
    }
}

function db_select($query){
    $con = db_connect();
    $rows = $con->query($query);
    $data = [];
    if($rows==null){
        echo "database query failed";
    }else {
        $rows = $rows->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row){
            array_push($data,$row);
        }
    }
    $con->close();
    return $data;
}

function db_update($query){
    $con = db_connect();
    $con->query($query);
    $con->close();
}

function db_delete($query){
    db_update($query);
}

function db_insert($query){
    db_update($query);
    if (!isset($_SESSION))
    {
        session_start();
    }
    $_SESSION['message'] = "Added Successfully!";
}

// sales pages function
function db_insert_get_customer($name){
    $query = "INSERT INTO `customer` (`id`, `name`, `address`) VALUES (NULL, '".$name."', NULL);";
    db_insert($query);
    $query = "select max(id) as id from customer where name='".$name."'";
    $id = db_select($query);
    return $id[0]['id'];

}

function db_insert_get_saleId($comission=0,$customerId,$categoryId,$memoNo){
    $time = time();
    $date = date('Y-m-d',$time);
    $query = "INSERT INTO `sale` (`id`, `comission`, `date`, `customerId`, `categoryId`, `memoNo`) VALUES (NULL, '".$comission."', '".$date."', '".$customerId."', ".$categoryId.", '".$memoNo."')";
    db_insert($query);
    $query = "select max(id) as id from sale where customerId='".$customerId."'";
    $id = db_select($query);

    if(strcmp($categoryId,"NULL")){
        $query = "select name from category where id ='".$categoryId."'";
        $category = db_select($query)[0]['name'];
        $query = "update memono set ".$category." = ".$category."+1";
    }
    else $query = "update memono set Customer = Customer+1";
    db_update($query);
    return $id[0]['id'];
}

function db_insert_get_returnsId($comission=0,$partyId){
    $time = time();
    $date = date('Y-m-d',$time);
    $query = "INSERT INTO `returns` (`id`, `comission`, `date`, `partyId`) VALUES (NULL, '".$comission."', '".$date."', '".$partyId."')";
    db_insert($query);
    $query = "select max(id) as id from returns where partyId='".$partyId."'";
    $id = db_select($query);
    return $id[0]['id'];
}

function getMemoNo($categoryId){
    $memoNameNo = array();
    $query = "select name from category where id = '".$categoryId."'";
    $data = db_select($query)[0]['name'];
    array_push($memoNameNo,$data);
    $query = "select ".$data." from memono";
    $data = db_select($query)[0][$data];
    array_push($memoNameNo,$data);
    return $memoNameNo;
}
