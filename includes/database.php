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
    $dbName = "relative";

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