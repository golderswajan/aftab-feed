<?php
/**
 * Created by PhpStorm.
 * User: Swajan
 * Date: 2/16/2018
 * Time: 7:57 AM
 */
require_once './includes/database.php';

if(isset($_POST['paymentParty'])){
    $party = $_POST['partyDDL'];
    $amount = $_POST['amountParty'];
    $time = time();
    $date = date('Y-m-d',$time);

    $query = "INSERT INTO `payment` (`id`, `partyId`, `date`, `amount`) VALUES (NULL, '".$party."', '".$date."', '".$amount."');";

    db_insert($query);
    $address = "Location: payment.php";
    header($address);

}else if(isset($_POST['customerPayment'])){
    $memo = $_POST['memoNo'];
    $query = "update customerdue set isPaid='1' where memono='".$memo."'";

    db_update($query);
    $address = "Location: payment.php";
    header($address);

}