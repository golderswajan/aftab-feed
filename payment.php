<?php
/**
 * Created by PhpStorm.
 * User: Swajan
 * Date: 2/16/2018
 * Time: 7:41 AM
 */
include_once './bll/bll.sales.php';
include_once './includes/database.php';
include_once './templates/topper-customized.php';
?>

<script>

    $(document).ready(function(){
        window.setTimeout(function(){
            $('#msgDiv').hide();

        }, 2000);

        $(window).keydown(function (event) {
            if(event.keyCode == 13){
                event.preventDefault();
                return false;
            }

        })

    });

    function checkExist(){
        console.log("HELLO");
    }

    function hidePartyForm(event){
        $('#partyDDL').prop('disabled',true);
        $('#amountParty').prop('disabled',true);
        $('#details').prop('disabled',true);
        if($('#customerName').val()=="NOT EXISTS"){
            event.preventDefault();
        }

    }
    function hideCustomerForm(){
        $('#memoNo').prop('disabled',true);
        $('#amountCustomer').prop('disabled',true);

    }

    function searchCustomer(){
        var customerMemo = $('#memoNo').val();
        var category = $('#category').val();
        console.log(customerMemo+" "+category+"hello");
        if(customerMemo!='' && category!=0){
            $.post('jQuery-process.php',{customerDueAmountMemo:customerMemo,categoryIdForDueMemo:category},function (data) {
                data = JSON.parse(data);

                if(data=="NOT EXISTS"){
                    $('#customerName').val(data);
                    $('#dueAmount').val(data);
                    $('#customerName').css('color','red');
                    $('#dueAmount').css('color','red');

                }
                else{
                    data = data[0];
                    $('#customerName').val(data['name']);
                    $('#dueAmount').val(data['amount']);
                    $('#customerName').css('color','blue');
                    $('#dueAmount').css('color','blue');
                }
                if(data['amount']==0){
                    $('#amountCustomer').hide();
                    $('#customerPayment').hide();
                    $('#dueAmount').val("Fully Paid");
                    $('#dueAmount').css({'color':'green','font-size':'20px'});
                }else{
                    $('#amountCustomer').show();
                    $('#customerPayment').show();
                }
            })
        }else{
            $('#customerName').val("");
            $('#dueAmount').val("");
        }

    }
</script>

<style>
    input[type=checkbox]:hover{
        cursor: pointer;
    }
</style>

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
    <form action="payment-refresh.php" id="partyForm" method="post">
        <!-- Dproduct selection starts -->
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <?php
                        $query = "select partyPayment from memono";
                        $memo = db_select($query)[0]['partyPayment'];
                    ?>
                    <h4 class="title"><b>Party Payment  Memo:<?= $memo ?><input type="number" name="partyMemo" value="<?= $memo?>" hidden></b>
                    </h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-lg-4" id="partyDiv">
                            <div class="form-group">
                                <label>Party</label>
                                <!--                            <select class="selectpicker form-control" data-live-search="true" id="partyDDL">-->
                                <?php
                                echo $bllSales->getProductPartiesAsOptions();
                                ?>
                                <!--                            </select>-->
                            </div>
                        </div>

                        <div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 col-lg-4 col-lg-offset-1" >
                            <div class="form-group">
                                <label>Details</label>
                                <input class="form-control" id="details" name="details" required>
                            </div>
                        </div>

                        <div class="col-md-2 col-md-offset-1 col-sm-2 col-sm-offset-1 col-lg-2 col-lg-offset-1" >
                            <div class="form-group">
                                <label>Amount(TK)</label>
                                <input class="form-control" id="amountParty" name="amountParty" type="number" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-2  col-sm-2 col-lg-2 " >
                            <div class="form-group" style="margin-top: 26px">
                                <input type="submit" class="form-control btn btn-success" name="paymentParty" onclick="hideCustomerForm()" value="Paid">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
     <form>

         <form action="payment-refresh.php"  method="post">
             <!-- Dproduct selection starts -->
             <div class="col-md-12">
                 <div class="card">
                     <div class="header">
                         <h4 class="title"><b>Customer Due Payment</b>
                         </h4>
                     </div>
                     <div class="content">
                         <div class="row">
                             <div class="col-md-3 col-sm-3 col-lg-3">
                                 <div class="form-group">
                                     <label>Category</label>
                                     <?php
                                     echo $bllSales->getProductCategoryAsOptions();
                                     ?>
                                 </div>
                             </div>
                             <div class="col-md-2 col-sm-2 col-lg-2">
                                 <div class="form-group">
                                     <label>Memo No</label>
                                     <input type="number" min="0" class="form-control" name="memoNo" id="memoNo" required>
                                 </div>
                             </div>
                             <div class="col-md-4 col-md-offset-0 col-sm-4 col-sm-offset-0 col-lg-4 col-lg-offset-0">
                                 <div class="form-group">
                                     <label>Customer Name</label>
                                     <input class="form-control" name="customerName" id="customerName" readonly>
                                 </div>
                             </div>
                             <div class="col-md-2 col-md-offset-0 col-sm-2 col-sm-offset-0 col-lg-2 col-lg-offset-0" >
                                 <div class="form-group">
                                     <label>Due Amount(TK)</label>
                                     <input class="form-control"  id="dueAmount" name="dueAmount" readonly required>
                                 </div>
                             </div>

                         </div>

                         <div class="row">
                             <div class="col-md-3 col-sm-3 col-lg-3" style="margin-top: 25px">
                                 <div class="form-group" >
                                     <input class="form-control btn btn-primary" name="customerSearch" type="button" onclick="searchCustomer()" value="Search">
                                 </div>
                             </div>
                             <div class="col-md-3 col-md-offset-2 col-sm-3 col-sm-offset-2 col-lg-3 col-lg-offset-2">
                                 <div class="form-group" >
                                     <label>Payment Amount(TK)</label>
                                     <input class="form-control"  type="number" name="amountCustomer" id="amountCustomer" required>
                                 </div>
                             </div>
                             <div class="col-md-2 col-md-offset-1 col-sm-2 col-sm-offset-1 col-lg-2 col-lg-offset-1" style="margin-top: 25px">
                                 <div class="form-group">
                                     <input class="form-control btn btn-success" name="customerPayment" id="customerPayment" type="submit" onclick="hidePartyForm(event)" value="Paid">
                                 </div>
                             </div>


                         </div>

                     </div>
                 </div>
             </div>
             <form>
 </div>


<?php
    include_once './templates/footer-customized.php';
?>

