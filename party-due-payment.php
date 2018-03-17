<?php
/**
 * Created by PhpStorm.
 * User: Swajan
 * Date: 3/17/2018
 * Time: 2:18 PM
 */
require_once './includes/database.php';
include_once './templates/topper-customized.php';

$customerId = isset($_GET['customerId'])?$_GET['customerId']:$_POST['customerId'];


$query = " select customer.id,customer.name,partyhalkhata.amount,partyhalkhata.date,partyhalkhata.details from partyhalkhata,customer where partyhalkhata.id in (select max(partyhalkhata.id) from partyhalkhata where partyhalkhata.customerId='$customerId') && partyhalkhata.customerId=customer.id";
$data = db_select($query)[0];
?>

<div class="row">
    <form action="party-due-payment.php" method="post">
    <!-- Dproduct selection starts -->
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title"><b>Party Due Payment History</b>
                    </h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-lg-3">
                            <div class="form-group">
                                <label>Party Name</label>
                                <input class="form-control"  value="<?= $data['name'] ?>" readonly>
                                <input  name="customerId" value="<?= $data['id'] ?>" hidden>
                            </div>
                        </div>
                        <div class="col-md-3 col-md-offset-1 col-sm-3 col-sm-offset-1 col-lg-3 col-lg-offset-1" >
                            <div class="form-group">
                                <label>From</label>
                                <?php
                                $time = time();
                                $date = date('Y-m-d',$time);
                                $newDate = strtotime("+1 day", strtotime($data['date']));
                                $newDate =  date('Y-m-d',$newDate);
                                ?>
                                <input class="form-control" type="date" id="dateFrom" name="dateFrom" value="<?php echo isset($_POST['search'])?$_POST['dateFrom']:$newDate ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-md-offset-1  col-sm-3 col-sm-offset-1 col-lg-3 col-lg-offset-1" >
                            <div class="form-group">
                                <label>To</label>
                                <input class="form-control" type="date" id="dateTo" name="dateTo" value="<?php echo isset($_POST['search'])?$_POST['dateTo']:$date ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6  col-sm-7  col-lg-7 ">
                            <div class="form-group" style="margin-top: 26px">
                                <label>After closing Halkhata  ( <?=$data['details']?> ) <?=$data['date']?> remaining due : <?=$data['amount']?> Tk</label>
                            </div>
                        </div>

                        <div class="col-md-3 col-md-offset-1 col-sm-3 col-sm-offset-1 col-lg-3 col-lg-offset-1">
                            <div class="form-group" style="margin-top: 26px">
                                <input type="submit" class="form-control btn btn-primary" name="search" value="Search">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <form>


        <div class="row" id="partyDuePaymentDiv" >
            <?php
            if(isset($_POST['search'])){
                $dateTo = $_POST['dateTo'];
                $dateFrom = $_POST['dateFrom'];
            }else{
                $date = date('Y-m-d',time());
                $dateTo = $date;
                $dateFrom = $date;
            }
            echo db_get_party_product_bought_payment($dateFrom,$dateTo,$customerId,$data['amount']);

            ?>


        </div>
</div>

<?php
include_once './templates/footer-customized.php';
?>
