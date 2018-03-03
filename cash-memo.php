<?php
/**
 * Created by PhpStorm.
 * User: Swajan
 * Date: 3/2/2018
 * Time: 9:18 AM
 */
include_once './templates/topper-customized.php';
require_once './includes/database.php';
if(isset($_GET['saleId'])){
    $saleId = $_GET['saleId'];
    $query = "select customer.name as customer,sale.memoNo as memo,category.name as category,sale.date,sale.total,sale.comission,sale.net,payment.amount as payment,due.amount as due from customer,sale,category,payment,due where sale.id='".$saleId."' && sale.categoryId=category.id && sale.customerId=customer.id && payment.saleId=sale.id && payment.date=sale.date && due.saleId=sale.id";
    $data = db_select($query);
    $data = $data[0];
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title"><b>Cash Memo  <?= $data['category']." : ".$data['memo']?></b></h4>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-3"><h5>Customer Name : <?= $data['customer']?></h5></div>
                    <div class="col-md-3 col-md-offset-6 col-lg-3 col-lg-offset-6 col-sm-3 col-sm-offset-6"><h5>Date : <?= $data['date']?></h5></div>
                </div>


                    <div class="table-responsive table-full-width" style="padding-top: 10px">
                        <table id="cashMemoTable" class="table table-striped table-hover table-condensed">
                            <?php
                            echo db_getCashMemo($saleId);
                            ?>
                        </table>
                    </div>
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-3">Payment : <?=$data['payment']?></div>
                    <div class="col-md-2 col-md-offset-4 col-lg-2 col-lg-offset-4 col-sm-2 col-sm-offset-4" style="text-align: right"><h6>Total : </h6></div>
                    <div class="col-md-1 col-lg-1 col-sm-1" style="text-align: left"><h6><?=$data['total']?></h6></div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-3">Due : <?=$data['due']?></div>
                    <div class="col-md-2 col-md-offset-4 col-lg-2 col-lg-offset-4 col-sm-2 col-sm-offset-4" style="text-align: right"><h6>Comission : </h6></div>
                    <div class="col-md-1 col-lg-1 col-sm-1" style="text-align: left"><h6><?=$data['comission']?></h6></div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-md-offset-7 col-lg-2 col-lg-offset-7 col-sm-2 col-sm-offset-7" style="text-align: right"><h6>Net : </h6></div>
                    <div class="col-md-1 col-lg-1 col-sm-1" style="text-align: left"><h6><?=$data['net']?></h6></div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
include_once './templates/footer-customized.php';
?>
