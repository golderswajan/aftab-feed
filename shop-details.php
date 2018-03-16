<?php
/**
 * Created by PhpStorm.
 * User: Swajan
 * Date: 2/16/2018
 * Time: 8:09 AM
 */

$category = isset($_POST['search'])?$_POST['detailsCategoryDDL']:1;
$partyId = isset($_POST['partyDDL'])?$_POST['partyDDL']:1;
include_once './bll/bll.sales.php';
include_once './templates/topper-customized.php';
include_once './includes/database.php';

?>
<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
<script>

    $(document).ready(function($){


        window.setTimeout(function(){
            $('#msgDiv').hide();

        }, 2000);

        $(window).keydown(function (event) {
            if(event.keyCode == 13){
                event.preventDefault();
                return false;
            }

        })


        $('#detailsTable').dataTable({
            dom: 'Blfrtip',
            sorting:false,
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ]
        });
        $('#detailsCategoryDDL').on('change',function () {
            var index = $('#detailsCategoryDDL').val();
            if(index==5){
                console.log("HELLO");
                $('#partyDiv').show();
                $('#partyDuePaymentDiv').show();
                $('#detailsDiv').hide();
            }else{

                $('#partyDiv').hide();
                $('#partyDuePaymentDiv').hide();
                $('#detailsDiv').show();



            }
        })
    });


</script>

<div class="row">
    <?php
    if (isset($_SESSION['message']))
    {
        $info= '<div id="msgDiv" class="alert alert-info">';
        $info.='<span>'.$_SESSION['message'].'</span>';
        $info.='</div>';
        echo $info;
        unset($_SESSION['message']);
    }
    ?>
    <form action="shop-details.php" method="post">
        <!-- Dproduct selection starts -->
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title"><b>Details History</b>
                    </h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-lg-3">
                            <div class="form-group">
                                <label>Details Category</label>
                                <select name="detailsCategoryDDL" id="detailsCategoryDDL" class="form-control">
                                    <option value="1" <?=$category==1?'selected':''?>>Product Sales</option>
                                    <option value="2" <?=$category==2?'selected':''?>>Customers Due</option>
                                    <option value="3" <?=$category==3?'selected':''?>>Customer Due Payment</option>
                                    <option value="4" <?=$category==4?'selected':''?>>Product Returns</option>
                                    <option value="5" <?=$category==5?'selected':''?>>Party Due Payment</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-md-offset-1 col-sm-3 col-sm-offset-1 col-lg-3 col-lg-offset-1" >
                            <div class="form-group">
                                <label>From</label>
                                <?php
                                $time = time();
                                $date = date('Y-m-d',$time);
                                ?>
                                <input class="form-control" type="date" id="dateFrom" name="dateFrom" value="<?php echo isset($_POST['search'])?$_POST['dateFrom']:$date ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-md-offset-1  col-sm-3 col-sm-offset-1 col-lg-3 col-lg-offset-1" >
                            <div class="form-group">
                                <label>To</label>
                                <input class="form-control" type="date" id="dateTo" name="dateTo" value="<?php echo isset($_POST['search'])?$_POST['dateTo']:$date ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-lg-3">
                            <div class="form-group" id="partyDiv" style="<?=($category==5)?"display: block":"display: none"?>">
                                <label>Party</label>
                                <?php
                                echo $bllSales->getProductPartiesAsOptions($partyId);
                                ?>
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
        <form>

            <div class="row" id="detailsDiv" style="<?=($category!=5)?"display: block":"display: none"?>">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title"><b>Search Result</b></h4>
                        </div>
                        <div class="content">
                            <div class="table-responsive table-full-width" style="padding: 10px">
                                <table id="detailsTable" class="table table-striped table-bordered table-hover table-condensed">
                                    <?php
                                        if(isset($_POST['search'])){
                                            $dateTo = $_POST['dateTo'];
                                            $dateFrom = $_POST['dateFrom'];

                                            if($category==1){
                                                echo db_get_sales_details($dateFrom,$dateTo);
                                            }else if($category==2){
                                                echo db_get_customer_due_details();
                                            }else if($category==3){
                                                echo db_get_customer_due_payment($dateFrom,$dateTo);
                                            }else if($category==4){
                                                echo db_get_returns($dateFrom,$dateTo);
                                            }

                                        }else{
                                            $dateTo = $date;
                                            $dateFrom = $date;
                                            echo db_get_sales_details($dateFrom,$dateTo);
                                        }

                                    ?>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            

            <div class="row" id="partyDuePaymentDiv" style="<?=($category==5)?"display: block":"display: none"?>">
                <?php
                if(isset($_POST['search'])){
                    $dateTo = $_POST['dateTo'];
                    $dateFrom = $_POST['dateFrom'];
                    if($category==5){
                        echo db_get_party_product_bought_payment($dateFrom,$dateTo,$partyId);
                    }
                }

                ?>


            </div>

        </div>

</div>

<?php
 include_once './templates/footer-customized.php';
?>
