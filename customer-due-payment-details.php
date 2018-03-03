<?php
/**
 * Created by PhpStorm.
 * User: Swajan
 * Date: 3/2/2018
 * Time: 4:16 PM
 */
include_once './templates/topper-customized.php';
require_once './includes/database.php';
if(isset($_GET['saleId'])){
    $saleId = $_GET['saleId'];
    $query = "select customer.name as customer,category.name as category,sale.memoNo as memo,sale.date ,sale.net,(select sum(payment.amount) from payment where payment.saleId='".$saleId."') as totalPayment,customerduepayment.amount as due from sale,customer,customerduepayment,category where sale.id='".$saleId."' and sale.customerId=customer.id && customerduepayment.saleId=sale.id && sale.categoryId=category.id";
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


                <div class="table-responsive table-full-width" style="padding: 10px">
                    <table id="cashMemoTable" class="table table-striped table-hover table-condensed">
                        <?php
                        echo db_get_customer_due_payment_details($saleId);
                        ?>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-3">Net Amount : <?=$data['net']?> tk</div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-3">Total Payment : <?=$data['totalPayment']?> tk</div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-3">Due : <?=$data['due']?> tk</div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
include_once './templates/footer-customized.php';
?>
