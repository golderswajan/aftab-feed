<?php
/**
 * Created by PhpStorm.
 * User: Swajan
 * Date: 2/16/2018
 * Time: 7:57 AM
 */
require_once './includes/database.php';

if(isset($_POST['paymentParty'])){
    $partyId = $_POST['partyDDL'];
    $payment = $_POST['amountParty'];
    $details = $_POST['details'];

    $time = time();
    $date = date('Y-m-d',$time);

    $query = "INSERT INTO `partypayment` (`id`, `details`, `amount`, `date`, `customerId`) VALUES (NULL, '".$details."', '".$payment."', '".$date."', '".$partyId."');";

    db_insert($query);
    $address = "Location: payment.php";
    header($address);

}else if(isset($_POST['customerPayment'])){
    $time = time();
    $date = date('Y-m-d',$time);
    $memo = $_POST['memoNo'];
    $category = $_POST['category'];
    $amount = $_POST['amountCustomer'];
    $dueAmount = $_POST['dueAmount'];

    $query = "insert into customerpayment (id,date,amount,saleId) VALUES (NULL,'".$date."','".$amount."',(select sale.id from sale where sale.categoryId='".$category."' && sale.memoNo='".$memo."' ))";
    db_insert($query);

//    decreasing due
    if($dueAmount<$amount) $amount=$dueAmount;
    $query = "update customerdue,sale set customerdue.amount = customerdue.amount-'".$amount."' where sale.id=customerdue.saleId && sale.categoryId='".$category."' && sale.memoNo='".$memo."'";
    db_update($query);
    $address = "Location: payment.php";
    header($address);

}