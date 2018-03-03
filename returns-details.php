<?php
/**
 * Created by PhpStorm.
 * User: Swajan
 * Date: 3/3/2018
 * Time: 8:41 AM
 */
include_once './templates/topper-customized.php';
require_once './includes/database.php';
if(isset($_GET['returnId'])){
    $returnId = $_GET['returnId'];
    $query = "select customer.name as customer,category.name as category,sale.memoNo as memo,returns.date,returns.total from customer,category,sale,returns where sale.customerId=customer.id && sale.categoryId=category.id && sale.id=returns.saleId && returns.id='$returnId'";
    $data = db_select($query);
    $data = $data[0];
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title"><b>Return Memo  <?= $data['category']." : ".$data['memo']?></b></h4>
            </div>
            <div class="content">
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-3"><h5>Customer Name : <?= $data['customer']?></h5></div>
                    <div class="col-md-3 col-md-offset-6 col-lg-3 col-lg-offset-6 col-sm-3 col-sm-offset-6"><h5>Date : <?= $data['date']?></h5></div>
                </div>


                <div class="table-responsive table-full-width" style="padding: 10px">
                    <table id="cashMemoTable" class="table table-striped table-hover table-condensed">
                        <?php
                        echo db_get_return_details($returnId);
                        ?>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-3">Net Amount : <?=$data['total']?> tk</div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
include_once './templates/footer-customized.php';
?>
