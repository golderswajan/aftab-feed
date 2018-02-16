<?php
/**
 * Created by PhpStorm.
 * User: Swajan
 * Date: 2/16/2018
 * Time: 9:17 AM
 */
require_once './includes/database.php';

if(isset($_POST['customerDue'])){
    $memoNo = $_POST['memoNo'];
    $amount = $_POST['dueAmount'];
    $possibleDate = $_POST['possibleDate'];
    $mobile = $_POST['mobileNo'];
    $time = time();
    $date = date('Y-m-d',$time);

    $query = "INSERT INTO `customerdue` (`id`, `dueDate`, `paymentDate`, `amount`, `isPaid`, `memoNo`) VALUES (NULL, '".$date."', '".$possibleDate."', '".$amount."', '0', '".$memoNo."')";
    db_insert($query);

    $query = "update customer set customer.mobile='".$mobile."' where customer.id in (select sale.customerId from sale where sale.categoryId is NULL and sale.memoNo='".$memoNo."' )";
    db_insert($query);
    $address = "Location: customer-due.php";
    header($address);

}