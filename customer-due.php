<?php
/**
 * Created by PhpStorm.
 * User: Swajan
 * Date: 2/16/2018
 * Time: 8:09 AM
 */
include_once './templates/topper-customized.php';
?>
<script>

    $(document).ready(function($){
        window.setTimeout(function(){
            $('#msgDiv').hide();

        }, 2000);
    });

    function getCustomer(){
        var customerMemo = $('#memoNo').val();
        if(customerMemo!=''){
            $.post('jQuery-process.php',{customerDueMemo:customerMemo},function (data) {
                data = JSON.parse(data);
                $('#customerName').val(data);
                if(data=="NOT EXISTS") $('#customerName').css('color','red');
                else $('#customerName').css('color','blue');
            })
        }else $('#customerName').val("");

    }
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
    <form action="customer-due-refresh.php" method="post">
        <!-- Dproduct selection starts -->
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title"><b>Customer Due Add</b>
                    </h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-lg-3">
                            <div class="form-group">
                                <label>Customer Memo No</label>
                                <input type="number" min="0" class="form-control" name="memoNo" id="memoNo" oninput="getCustomer()" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-md-offset-1 col-sm-3 col-sm-offset-1 col-lg-3 col-lg-offset-1" >
                            <div class="form-group">
                                <label>Amount(TK)</label>
                                <input class="form-control" type="number" id="dueAmount" name="dueAmount" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-md-offset-1  col-sm-3 col-sm-offset-1 col-lg-3 col-lg-offset-1" >
                            <div class="form-group">
                                <label>Possible Date</label>
                                <input class="form-control" type="date" id="possibleDate" name="possibleDate" required>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-lg-4">
                            <div class="form-group">
                                <label>Customer Name</label>
                                <input class="form-control" name="customerName" id="customerName" readonly>
                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 col-lg-4 col-lg-offset-1" >
                            <div class="form-group">
                                <label>Mobile No</label>
                                <input class="form-control" id="mobileNo" type="number" name="mobileNo" required>
                            </div>
                        </div>
                        <div class="col-md-2  col-sm-2 col-lg-2 " >
                            <div class="form-group" style="margin-top: 26px">
                                <input type="submit" class="form-control btn btn-success" name="customerDue" value="Due Add">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <form>
            <div>

            <?php
 include_once './templates/footer-customized.php';
?>
