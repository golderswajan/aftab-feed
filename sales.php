<?php
include_once './bll/bll.sales.php';
include_once './templates/topper-customized.php';
?>
<style>

    .checkboxDiv label{
        color: #000;
        margin: 3px 10px 10px 10px;
    }

    .checkboxDiv label [type='checkbox']{
        margin: 7px;
        cursor: pointer;
    }

    .cash-memo>.row h4{
        color:green;
    }
    a{
        cursor: pointer;
    }

    .row{
        padding-bottom: 5px;
    }
    .product-category:hover{
        cursor: pointer;
    }


</style>

<script>

    var counter = 1;
    var saleArray = [];

    $(document).ready(function($){
        $('#category').on('change',function(){
            createSubCategoryField();
        });
        $('#partyDDL').on('change',function(){
            var partyId = $('#partyDDL').val();
            if(partyId!=0){
                $('#customerName').prop('disabled',true);

            }
            else{
                $('#customerName').prop('disabled',false);

            }
        })
        window.setTimeout(function(){
            $('#msgDiv').hide();

        }, 2000);

        $(window).keydown(function (event) {
            if(event.keyCode == 13){
                event.preventDefault();
                return false;
            }

        })
        $('form').submit(function (event) {

            $('#category').prop('disabled',false);

            }
        );

    });

    function createSubCategoryField(){

        var categoryId = $('#category').val();

        if(categoryId!=0){
            //        creating subcategory
            $('.checkboxDiv').html('');
            $.post('jQuery-process.php',{categoryId:categoryId},function (data) {
                data = JSON.parse(data);
                var html='';
                for(var i=0;i<data.length;i++){
                    html += "<label><input id='cb"+data[i].id+"' type='checkbox' onchange='checkToAdd(this,"+data[i].id+")'";
                    if(saleArray.indexOf(parseInt(data[i].id))>-1) html += "checked";
                    html += ">"+data[i].name+"</label>";
                }
                $('.checkboxDiv').html(html);
            });

            //        getting memo no
            $.post('jQuery-process.php',{categoryIdForMemo:categoryId},function (data) {
                data = JSON.parse(data);
                $('#memoText').html(data[0]+" : "+data[1]);
                $('#memoId').val(data[1]);
            });
        }else{
            $('.checkboxDiv').html('');
            $('#memoText').html('');
        }



    }

    function checkToAdd(cb,cbId){
        if(cb.checked){
            saleArray.push(cbId);
            $('#category').prop('disabled',true);
            var cashMemoDiv = $('#cashMemoDiv');
            $.post('jQuery-process.php',{subCategoryId:cbId},function(data){
                data = JSON.parse(data);
                data = data[0];
                var hiddenRow = $('#rowNumber');
                var totalCostDiv = $('#totalCostDiv');
                totalCostDiv.remove();
                hiddenRow.remove();
                cashMemoDiv.append(getRowHtml(counter,cbId,data.name,data.price));
                counter++;
                cashMemoDiv.append(getHiddenRow(counter));
                cashMemoDiv.append(getTotalCostHtml());
                calculateTotalCost();
                if(counter==2)  $('#confirmSale').show();
            });
        }else{
            removeAccordingToRow(cbId);
        }
    }

    function removeRow(divId){

        var cashMemoDiv = $('#cashMemoDiv');
        var div = $('#div'+divId);
        var parentRowNo = $('#parentRowNo'+divId).val();
        var parentCheckBox = $('#cb'+parentRowNo);
        parentCheckBox.prop('checked',false);
        var hiddenRowNumber = $('#rowNumber');
        var totalCostDiv = $('#totalCostDiv');
        if(divId==counter-1){
            hiddenRowNumber.remove();
            totalCostDiv.remove();
            div.remove();
            counter--;

            cashMemoDiv.append(getHiddenRow(counter));
            if(counter!=1)cashMemoDiv.append(getTotalCostHtml());
            calculateTotalCost();
        }else{

            var tempCounter = 1;
            var saleHtml = getHeaderHtml();
            var name = "";
            var price = "";
            var quantity = "";
            var primaryKey = "";
            for(var i=1;i<counter;i++){
                if(divId!=i){
                    name = $('#name'+i).val();
                    price = $('#price'+i).val();
                    quantity = $('#amount'+i).val();
                    primaryKey =  $('#parentRowNo'+i).val();
                    saleHtml += getRowHtml(tempCounter,primaryKey,name,price,quantity);
                    tempCounter++;
                }
            }
            counter = tempCounter;
            cashMemoDiv.html(saleHtml);
            cashMemoDiv.append(getHiddenRow(counter));
            cashMemoDiv.append(getTotalCostHtml());
            calculateTotalCost();
        }
        saleArray.splice(saleArray.indexOf(parseInt(parentRowNo)),1);
        if(counter==1)  $('#confirmSale').hide();
        if(saleArray.length==0) $('#category').prop('disabled',false);

    }

    function removeAccordingToRow(cbId){
        var parentDivId = "";
        for(var i=1;i<counter;i++){
            parentDivId = $('#parentRowNo'+i).val();
            if(parentDivId==cbId){
                removeRow(i);
                break;
            }
        }
    }

    function getRowHtml(index,primaryId,name,price,quantity=1,individualComission=1) {
        var rowHtml = "<div class=\"row\" id=\"div"+index+"\">\n"+
            "               <div class=\"col-md-1 col-lg-1 col-sm-1\"><h5>"+index+".</h5><input id='parentRowNo"+index+"' name='parentRowNo"+index+"' value='"+primaryId+"' hidden></div>\n"+
            "               <div class=\"col-md-3 col-lg-3 col-sm-3\"><h5>"+name+"</h5><input id='name"+index+"'  value='"+name+"' hidden></div>\n"+
            "               <div class=\"col-md-2 col-lg-2 col-sm-2\"><h5>"+price+"</h5><input id='price"+index+"' name='price"+index+"' value='"+price+"' hidden></div>\n"+
            "               <div class=\"col-md-2 col-lg-2 col-sm-2\"><input id='amount"+index+"' name='amount"+index+"' type=\"number\" class=\"form-control\" value='"+quantity+"' min=\"1\" oninput='measureCost("+index+")'></div>\n" +
            "               <div class=\"col-md-2 col-lg-2 col-sm-2\"><input id='individualComission"+index+"' name='individualComission"+index+"' type=\"number\" class=\"form-control\" value='"+individualComission+"' min=\"0\" oninput='calculateTotalCost()'></div>\n" +
            "               <div class=\"col-md-1 col-lg-1 col-sm-1\"><h5 id='cost"+index+"'>"+price*quantity+"tk</h5></div>\n" +
            "               <div class=\"col-md-1 col-lg-1 col-sm-1\"><a onclick=\"removeRow("+index+")\"><span class=\"glyphicon glyphicon-remove\"></span></a></div>\n"+
            "          </div>";
        return rowHtml;
    }

    function getHiddenRow(index){
        return "<input id='rowNumber' name='rowNumber' value='"+index+"' hidden>";
    }

    function getHeaderHtml(){
        var html="<div class=\"row\">\n"+
            "<div class=\"col-md-1 col-lg-1 col-sm-1\"><h4>SL.</h4></div>\n"+
            "<div class=\"col-md-3 col-lg-3 col-sm-3\"><h4>Products</h4></div>\n"+
            "<div class=\"col-md-2 col-lg-2 col-sm-2\"><h4>Price</h4></div>\n"+
            "<div class=\"col-md-2 col-lg-2 col-sm-2\"><h4>Unit</h4></div>\n"+
            "<div class=\"col-md-2 col-lg-2 col-sm-2\"><h4>Comission</h4></div>\n"+
            "<div class=\"col-md-1 col-lg-1 col-sm-1\"><h4>Cost</h4></div>\n"+
            "<div class=\"col-md-1 col-lg-1 col-sm-1\"></div>\n"+
            "</div>\n"+
            "<hr>";
        return html;
    }

    function getTotalCostHtml(){

//        total cost row
        var html = "<div id='totalCostDiv'>\n" +
            "<div class=\"row\">\n"+
            "<div class=\"col-md-8 \"></div>\n"+
            "<div class=\"col-md-2 \"><h4>Total Cost : </h4></div>\n" +
            "<div class=\"col-md-2 \"><h4 id=\"totalCost\">800 tk </h4><input name='totalCostField' id='totalCostField' value='' hidden></div>\n" +
            "</div>";
//        commision row
         html += "<div class=\"row\">\n"+
             "<div class=\"col-md-2 \"><h4>Payment : </h4></div>\n"+
             "<div class=\"col-md-2 \"><input type='number' min='0' class='form-control' name='payment' id='payment' oninput='measurePaymentDue()' required></div>\n"+
            "<div class=\"col-md-4 \"></div>\n"+
            "<div class=\"col-md-2 \"><h4 ondblclick='calculateTotalCost()'>Comission : </h4></div>\n" +
            "<div class=\"col-md-2 \"><input id='comission' name='comission' value='0' type='number' min='0' class='form-control' oninput='calculateNetCost()'  required></div>\n" +
            "</div>";

//        net cost row
        html    +=  "<div class=\"row\" >\n"+
            "<div class=\"col-md-2 \"><h4>Due : </h4></div>\n"+
            "<div class=\"col-md-2 \"><input type='number' min='0' class='form-control' name='due' id='due' readonly></div>\n"+
            "<div class=\"col-md-4 \"></div>\n"+
            "<div class=\"col-md-2 \"><h4>Net Cost : </h4></div>\n" +
            "<div class=\"col-md-2 \"><h4 id=\"netCost\">800 tk </h4><input name='netCostField' id='netCostField' value='' hidden></div>\n" +
            "</div>" +
            "</div>";
        return html;
    }

    function measureCost(index){
        var price = $('#price'+index).val();
        var amount = $('#amount'+index).val();
        $('#cost'+index).html(price*amount+"tk");
        calculateTotalCost();
    }

    function calculateTotalCost(){
        var cost = 0;
        var amount = "";
        var price = "";
        var comission = 0;
        var individualComission = '';
        for(var i=1;i<counter;i++){
            price = $('#price'+i).val();
            amount = $('#amount'+i).val();
            individualComission = $('#individualComission'+i).val();
            cost += price*amount;
            comission +=amount*individualComission;
//            console.log(comission);

        }
        $('#totalCost').html(cost+" tk");
        $('#totalCostField').val(cost);
        $('#comission').val(comission);
        cost -= comission;
        $('#netCost').html(cost+" tk");
        $('#netCostField').val(cost);
    }

    function hideParty(){
        var nameInput = $('#customerName').val().trim();
        if(nameInput.length==0){
            $('#partyDDL').prop('disabled',false);
        }
        else {
            $('#partyDDL').prop('disabled',true);

        }
    }

    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode>=48 && charCode<=57)
            return true;
        else if(charCode>=42 && charCode<=47)
            return true;
        else if(charCode==13)
            return true;
        return false;
    }

    function measurePaymentDue() {
        var netCost = $('#netCost').html();
        netCost = parseFloat(netCost.split('tk')[0]);
        var payment = $('#payment').val();
        $('#due').val(netCost-payment);
    }

    function calculateNetCost(){
        var totalCost = $('#totalCost').html();
        totalCost = parseFloat(totalCost.split('tk')[0]);
        var comission = $('#comission').val();
        $('#netCost').html(totalCost-comission);
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
    <form action="sales-refresh.php" method="post">
        <!-- Dproduct selection starts -->
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title"><b>Customer Sale</b>
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
                        <div class="col-md-4 col-md-offset-1 col-sm-4 col-sm-offset-1 col-lg-4 col-lg-offset-1" id="customerDiv">
                            <div class="form-group">
                                <label>Customer</label>
                                <input class="form-control" id="customerName" name="customerName" oninput="hideParty()" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-lg-4">
                            <div class="form-group">
                                <label>Category</label>
                                <?php
                                echo $bllSales->getProductCategoryAsOptions();
                                ?>
                            </div>
                        </div>
                        <div class="col-md-7 col-md-offset-1 col-lg-7 col-lg-offset-1 col-sm-7 col-sm-offset-1">
                            <div class="form-group">
                                <label style="margin-left: 10px">Products</label>
                                <div class="checkboxDiv">
                                    <!--                                <label><input type="checkbox">option 1</label>-->
                                    <!--                                <label><input type="checkbox">option 1</label>-->
                                    <!--                                <label><input type="checkbox">option is very large what are you thinking</label>-->
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--    product selection ends-->

        <!--    cash memo parts start-->
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4><b>Cash Memo   </b>   <span style="margin-left: 30px" id="memoText"></span><input id="memoId" name="memoId" value="" hidden></h4>
                </div>
                <div class="content cash-memo" id="cashMemoDiv">
                    <div class="row">
                        <div class="col-md-1 col-lg-1 col-sm-1"><h4>SL.</h4></div>
                        <div class="col-md-3 col-lg-3 col-sm-3"><h4>Products</h4></div>
                        <div class="col-md-2 col-lg-2 col-sm-2"><h4>Price</h4></div>
                        <div class="col-md-2 col-lg-2 col-sm-2"><h4>Unit</h4></div>
                        <div class="col-md-2 col-lg-2 col-sm-2"><h4>Comission</h4></div>
                        <div class="col-md-1 col-lg-1 col-sm-1"><h4>Cost</h4></div>
                        <div class="col-md-1 col-lg-1 col-sm-1"></div>
                    </div>
                    <hr>
                    <!--                <div class="row" id="div1">-->
                    <!--                    <div class="col-md-1 col-lg-1 col-sm-1">1.</div>-->
                    <!--                    <div class="col-md-4 col-lg-4 col-sm-4">Chicken 2 days</div>-->
                    <!--                    <div class="col-md-3 col-lg-3 col-sm-3">20</div>-->
                    <!--                    <div class="col-md-2 col-lg-2 col-sm-2"><input type="number" class="form-control" value="1" min="1"></div>-->
                    <!--                    <div class="col-md-1 col-lg-1 col-sm-1">100</div>-->
                    <!--                    <div class="col-md-1 col-lg-1 col-sm-1"><a onclick="removeRow(1)"><span class="glyphicon glyphicon-remove"></span></a></div>-->
                    <!--                </div>-->
                    <!--                <div class="row" id="div2">-->
                    <!--                    <div class="col-md-1 col-lg-1 col-sm-1">2.</div>-->
                    <!--                    <div class="col-md-4 col-lg-4 col-sm-4">Chicken 2 days</div>-->
                    <!--                    <div class="col-md-3 col-lg-3 col-sm-3">20</div>-->
                    <!--                    <div class="col-md-2 col-lg-2 col-sm-2"><input type="number" class="form-control" value="1" min="1"></div>-->
                    <!--                    <div class="col-md-1 col-lg-1 col-sm-1">100</div>-->
                    <!--                    <div class="col-md-1 col-lg-1 col-sm-1"><a onclick="removeRow(1)"><span class="glyphicon glyphicon-remove"></span></a></div>-->
                    <!--                </div>-->
                    <!--                <div class="row">-->
                    <!--                    <div class="col-md-8"></div>-->
                    <!--                    <div class="col-md-2"><h4>Total Cost : </h4></div>-->
                    <!--                    <div class="col-md-2"><h4 id="totalCost">800 tk </h4></div>-->
                    <!--                </div>-->
                </div>
            </div>
        </div>
        <input type="submit" id="confirmSale" name="confirmSale" class="btn btn-primary" style="margin-left: 40%;display: none" value="Confirm The Sale" >
    </form>

</div>

<?php
include_once './templates/footer-customized.php';
?>
