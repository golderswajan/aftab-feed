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
    $paymentMemoNo = $_POST['partyMemo'];

    $time = time();
    $date = date('Y-m-d',$time);

    //payment insert
    $query = "INSERT INTO `payment` (`id`, `details`, `amount`, `date`, `customerId`, `saleId`, `partyPaymentMemoNo`) VALUES (NULL, '".$details."', '$payment', '".$date."', '".$partyId."', NULL, '".$paymentMemoNo."');";
    db_insert($query);

//    payment memo update
    $query = "update memono set memono.partyPayment = memono.partyPayment + 1";
    db_update($query);

//    decreasing party payment due
    $query = "update partyduepayment set partyduepayment.amount = partyduepayment.amount - '$payment' where partyduepayment.customerId='$partyId'";
    db_update($query);

    $address = "Location: payment.php";
    header($address);

}else if(isset($_POST['customerPayment'])){
    $time = time();
    $date = date('Y-m-d',$time);
    $memo = $_POST['memoNo'];
    $category = $_POST['category'];
    $amount = $_POST['amountCustomer'];
    $dueAmount = $_POST['dueAmount'];

    $query = "insert into payment (id,details,amount,date,customerId,saleId,partyPaymentMemoNo) VALUES (NULL,NULL,'".$amount."','".$date."',NULL,(select sale.id from sale where sale.categoryId='".$category."' && sale.memoNo='".$memo."' ),NULL)";
    db_insert($query);

//    decreasing due
    if($dueAmount<$amount) $amount=$dueAmount;
    $query = "update customerduepayment,sale set customerduepayment.amount = customerduepayment.amount-'".$amount."' where sale.id=customerduepayment.saleId && sale.categoryId='".$category."' && sale.memoNo='".$memo."'";
    db_update($query);
    $address = "Location: payment.php";
    header($address);

}