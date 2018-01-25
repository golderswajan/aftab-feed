<?php
// Head and body starting
include_once('bll/bll.expenses.php');
include_once('dal/dal.expensecategory.php');
include_once('dal/dal.user.php');

include_once './templates/topper-customized.php';
?>
<script>
    $(document).ready(function($){
        loadExpenseTable();

        window.setTimeout(function(){
            $('#msgDiv').hide();

        }, 2000);

        function loadExpenseTable(){
            var dateFrom = $('#dateFrom').val();
            var dateTo = $('#dateTo').val();
            var category = $('#expenseCategory').val();
            if(category!=0) category = " and expensecategory.id='"+category+"'";
            else category = '';
            var query = "select expense.id,expense.details,expensecategory.name,expense.date,expense.netAmount from expense,expensecategory where expense.expenseCategoryId=expensecategory.id && expense.date between '"+dateFrom+"' and '"+dateTo+"'"+category+" order by expense.id desc";
            $('#expenseTable').editableGrid({
                primaryTable: "expense",
                selectQuery: query,
                columns:[
                    'Details',
                    'Category',
                    'Date',
                    'Cost'
                ],
                format:{
                    date: {
                        type:'date'
                    },
                    netAmount:{
                        type: 'number'
                    },
                    name:{
                        type: 'ddl',
                        selectQuery:'select * from expensecategory'
                    }
                },
                editMethods:{
                    name:"UPDATE `expense` SET `expenseCategoryId` = '*' WHERE `expense`.`id` = '*'"
                },
//                editAble:{
//                    details:false,
//                }
            });
        }
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

<!--        expense entry-->
        <div class="col-md-12">
            <div class="card" >
                <div class="header">
                    <h4 class="title"><b>Add New Expense</b></h4>
                </div>
                <div class="content">
                    <form action="bll/bll.expenses.php" method="POST">
                         <div class="row">
                        <!-- Hold -->
                            <input type="text" name="id" value="<?php
                                    if(isset($_GET['edit']))
                                       echo $GLOBALS['id'];
                                    ?>" style="display: none">

                        <!-- Hold end -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="categoryId" class="form-control" required>

                                <?php
                                $dalExpenseCategory = new DALExpenseCategory;
                                    $result =  $dalExpenseCategory->getCategory();
                                    $option = "";

                                    while ($res = mysqli_fetch_assoc($result))
                                    {
                                        if(isset($_GET['edit']) && $GLOBALS['categoryId'] == $res['id'])
                                        {
                                        $option .= '<option value='.$res['id'].' selected>';

                                        }
                                        else
                                        {
                                        $option .= '<option value='.$res['id'].'>';

                                        }
                                        $option .= $res['name'];
                                        $option .= '</option>';
                                    }
                                    echo $option;
                                ?>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Details</label>
                                    <input type="text" name="details" class="form-control" placeholder="Details" value="<?php
                                    if(isset($_GET['edit']))
                                       echo $GLOBALS['details'];
                                    ?>">
                                </div>
                            </div>

                         </div>
                        <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Amount (Tk.)</label>
                                <input type="text" name="netAmount" class="form-control" placeholder="Amount in Taka" required value="<?php
                                if(isset($_GET['edit']))
                                   echo $GLOBALS['netAmount'];
                                ?>">
                            </div>
                        </div>

                      <!-- Control user -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" name="dateOfSale" class="form-control" value="<?php
                                if(isset($_GET['edit']))
                                {
                                    echo $GLOBALS['date'];
                                }
                                else
                                {
                                    $time = time();
                                    echo date('Y-m-d',$time);
                                }

                                ?>" required>
                            </div>
                        </div>
                    </div>
    <!-- Control user end-->

                        <input type="submit" class="btn btn-info btn-fill pull-right" name="insert_expense"; value="Save">
                        <div class="clearfix"></div>
                </form>
				</div>
			</div>
    </div>
<!--        expense entry ends-->

        <!-- Date selection -->
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title"><b>Expenses</b>
                    </h4>
                </div>
                <div class="content">
                    <form  method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>From</label>
                                    <input type="date" id="dateFrom" name="dateFrom" class="form-control" value="<?php
                                    if(isset($_GET['loadExpense'])){
                                        echo $_GET['dateFrom'];
                                    }else{
                                        $time = time();
                                        echo date('Y-m-d',$time);
                                    }
                                    ?>" required>
                                </div>
                            </div>
                             <div class="col-md-4">
                                <div class="form-group">
                                    <label>To</label>
                                    <input type="date" id="dateTo" name="dateTo" class="form-control" value="<?php

                                    if(isset($_GET['loadExpense'])){
                                        echo $_GET['dateTo'];
                                    }else{
                                        $time = time();
                                        echo date('Y-m-d',$time);
                                    }

                                    ?>" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Category</label>
                                    <?php
                                    $value=0;
                                    if(isset($_GET['loadExpense'])) $value=$_GET['expenseCategory'];
                                    echo $bllExpense->getExpenseCategoryAsOptions($value);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <input type="submit" id="loadExpense"  name="loadExpense" class="btn btn-info btn-fill pull-right" value="Load Expenses">
                                </div>
                             </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
<!--        date selection ends-->

        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title"><b>Details</b></h4>
                </div>
                <div class="content">
                    <div class="content table-responsive table-full-width">
                        <table id="expenseTable" class="table table-hover table-striped">
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <?php
        $bllExpense = new BLLExpense;
        if(isset($_GET['loadExpense']))
        {
            $dateFrom = $_GET['dateFrom'];
            $dateTo = $_GET['dateTo'];
            $category = $_GET['expenseCategory'];
            echo $bllExpense->getTotalExpense($dateFrom,$dateTo,$category);
        }
        else
        {
            $time = time();
            $today = date('Y-m-d',$time);
            echo $bllExpense->getTotalExpense($today,$today,0);
        }
        ?>

    </div>


<?php
    include('./templates/footer-customized.php');
?>