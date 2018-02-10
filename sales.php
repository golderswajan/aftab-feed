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
            if(partyId!=0)$('#customerName').prop('disabled',true);
            else $('#customerName').prop('disabled',false);
        })
        window.setTimeout(function(){
            $('#msgDiv').hide();

        }, 2000);
    });

    function createSubCategoryField(){
        var categoryId = $('#category').val();
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
    }

    function checkToAdd(cb,cbId){
        if(cb.checked){
            saleArray.push(cbId);
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

    function getRowHtml(index,primaryId,name,price,quantity=1) {
        var rowHtml = "<div class=\"row\" id=\"div"+index+"\">\n"+
            "               <div class=\"col-md-1 col-lg-1 col-sm-1\"><h5>"+index+".</h5><input id='parentRowNo"+index+"' name='parentRowNo"+index+"' value='"+primaryId+"' hidden></div>\n"+
            "               <div class=\"col-md-4 col-lg-4 col-sm-4\"><h5>"+name+"</h5><input id='name"+index+"'  value='"+name+"' hidden></div>\n"+
            "               <div class=\"col-md-3 col-lg-3 col-sm-3\"><h5>"+price+"</h5><input id='price"+index+"' name='price"+index+"' value='"+price+"' hidden></div>\n"+
            "               <div class=\"col-md-2 col-lg-2 col-sm-2\"><input id='amount"+index+"' name='amount"+index+"' type=\"number\" class=\"form-control\" value='"+quantity+"' min=\"1\" oninput='measureCost("+index+")'></div>\n" +
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
            "<div class=\"col-md-4 col-lg-4 col-sm-4\"><h4>Products</h4></div>\n"+
            "<div class=\"col-md-3 col-lg-3 col-sm-3\"><h4>Price</h4></div>\n"+
            "<div class=\"col-md-2 col-lg-2 col-sm-2\"><h4>Unit</h4></div>\n"+
            "<div class=\"col-md-1 col-lg-1 col-sm-1\"><h4>Cost</h4></div>\n"+
            "<div class=\"col-md-1 col-lg-1 col-sm-1\"></div>\n"+
            "</div>\n"+
            "<hr>";
        return html;
    }

    function getTotalCostHtml(){
//        commision row
        var html = "<div id='totalCostDiv'>\n" +
            "<div class=\"row\" id='comissionDiv'>\n"+
            "<div class=\"col-md-8 \"></div>\n"+
            "<div class=\"col-md-2 \"><h4>Comission : </h4></div>\n" +
            "<div class=\"col-md-2 \"><input id='comission' name='comission' value='0' type='number' min='0' class='form-control' oninput='calculateTotalCost()'  ondblclick=\"$('#calculator').show()\" required></div>\n" +
            "</div>";
//        total cost row
        html    +=  "<div class=\"row\" >\n"+
            "<div class=\"col-md-8 \"></div>\n"+
            "<div class=\"col-md-2 \"><h4>Total Cost : </h4></div>\n" +
            "<div class=\"col-md-2 \"><h4 id=\"totalCost\">800 tk </h4></div>\n" +
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
        var comission = "";
        for(var i=1;i<counter;i++){
            price = $('#price'+i).val();
            amount = $('#amount'+i).val();
            cost += price*amount;

        }
        comission = $('#comission');
        cost -= comission.val()*1;
        $('#totalCost').html(cost+" tk");
    }

    function hideParty(){
        var nameInput = $('#customerName').val().trim();
        if(nameInput.length==0)$('#partyDDL').prop('disabled',false);
        else $('#partyDDL').prop('disabled',true);
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
                    <h4><b>Cash Memo</b></h4>
                </div>
                <div class="content cash-memo" id="cashMemoDiv">
                    <div class="row">
                        <div class="col-md-1 col-lg-1 col-sm-1"><h4>SL.</h4></div>
                        <div class="col-md-4 col-lg-4 col-sm-4"><h4>Products</h4></div>
                        <div class="col-md-3 col-lg-3 col-sm-3"><h4>Price</h4></div>
                        <div class="col-md-2 col-lg-2 col-sm-2"><h4>Unit</h4></div>
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
    <FORM NAME="Calc" id="calculator" style="display: none;z-index: 1;position: fixed;bottom: 10px;right: 50px;">
        <TABLE BORDER=4>
            <TR>
                <TD>
                    <INPUT TYPE="text"   NAME="Input" Size="20"  readonly>
                    <br>
                </TD>
            </TR>
            <TR>
                <TD>
                    <INPUT TYPE="button" NAME="ac"   VALUE="AC" OnClick="Calc.Input.value = ''">
                    <INPUT TYPE="button" NAME="clear"   VALUE="c" OnCLick="Calc.Input.value = Calc.Input.value.slice(0,-1)">
                    <INPUT TYPE="button" NAME="close" VALUE="close" OnClick="$('#calculator').hide();Calc.Input.value=''">
                    <INPUT TYPE="button" NAME="save"  VALUE="save" OnClick="$('#comission').val(Calc.Input.value);Calc.Input.value='';$('#calculator').hide();calculateTotalCost()">
                    <br>
                    <INPUT TYPE="button" NAME="one"   VALUE="  1  " OnClick="Calc.Input.value += '1'">
                    <INPUT TYPE="button" NAME="two"   VALUE="  2  " OnCLick="Calc.Input.value += '2'">
                    <INPUT TYPE="button" NAME="three" VALUE="  3  " OnClick="Calc.Input.value += '3'">
                    <INPUT TYPE="button" NAME="plus"  VALUE="  +  " OnClick="Calc.Input.value += ' + '">
                    <br>
                    <INPUT TYPE="button" NAME="four"  VALUE="  4  " OnClick="Calc.Input.value += '4'">
                    <INPUT TYPE="button" NAME="five"  VALUE="  5  " OnCLick="Calc.Input.value += '5'">
                    <INPUT TYPE="button" NAME="six"   VALUE="  6  " OnClick="Calc.Input.value += '6'">
                    <INPUT TYPE="button" NAME="minus" VALUE="  --  " OnClick="Calc.Input.value += ' - '">
                    <br>
                    <INPUT TYPE="button" NAME="seven" VALUE="  7  " OnClick="Calc.Input.value += '7'">
                    <INPUT TYPE="button" NAME="eight" VALUE="  8  " OnCLick="Calc.Input.value += '8'">
                    <INPUT TYPE="button" NAME="nine"  VALUE="  9  " OnClick="Calc.Input.value += '9'">
                    <INPUT TYPE="button" NAME="times" VALUE="  x  " OnClick="Calc.Input.value += ' * '">
                    <br>
                    <INPUT TYPE="button" NAME="point" VALUE="  .   " OnClick="Calc.Input.value += '.'">
                    <INPUT TYPE="button" NAME="zero"  VALUE="  0  " OnClick="Calc.Input.value += '0'">
                    <INPUT TYPE="button" NAME="DoIt"  VALUE="  =  " OnClick="Calc.Input.value = eval(Calc.Input.value)">
                    <INPUT TYPE="button" NAME="div"   VALUE="   /  " OnClick="Calc.Input.value += ' / '">
                    <br>
                </TD>
            </TR>
        </TABLE>
    </FORM>
</div>

<?php
include_once './templates/footer-customized.php';
?>
