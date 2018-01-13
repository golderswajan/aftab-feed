<?php
// Head and body starting
include('./templates/head.php');
include_once('bll/bll.expenses.php');
include_once('dal/dal.expensecategory.php');
include_once('dal/dal.user.php');


?>
<div class="wrapper">
    <!--Sidebar here-->
<?php
    // Dashboard Sidebar
include('./templates/sidebar.php');

?>
<div class="main-panel">

<?php
            // Top Navbar
include('./templates/navbar.php');
?>
<!--Page contend starts here .. seperated in each file -->

        <div class="content">
            <div class="container-fluid">
                <div class="row">

<?php
if (isset($_SESSION['message']))
    {
        $info= '<div class="alert alert-info">';
        $info.='<span>'.$_SESSION['message'].'</span>';
        $info.='</div>';
        echo $info;
        unset($_SESSION['message']);
    }
?>
    <div class="col-md-12">
            <div class="card">
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

                <div class="row">
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

                <div class="col-md-6">
                    <input type="date" name="dateOfSale" class="form-control" value="<?php
                        $time = time();
                        echo date('Y-m-d',$time);
                    ?>" style="display: none;">
                </div>


</div>
<!-- Control user end-->                

                <input type="submit" class="btn btn-info btn-fill pull-right" name="<?php
                if(isset($_GET['edit']))
                   echo "update_expense";
                else 
                    echo "insert_expense";
                ?>"" value="<?php
                if(isset($_GET['edit']))
                   echo "Update";
                else
                    echo "Save";
                ?>">
                <div class="clearfix"></div>
            </form>
				</div>
			</div>

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
                <input type="date" name="dateFrom" class="form-control" value="<?php
                $time = time();
                if(isset($_GET['edit']))
                    echo $GLOBALS['date'];
                else
                echo date('Y-m-d',$time);
                ?>" required>
            </div>
        </div>
         <div class="col-md-4">
            <div class="form-group">
                <label>To</label>
                <input type="date" name="dateTo" class="form-control" value="<?php
                $time = time();
                if(isset($_GET['edit']))
                    echo $GLOBALS['date'];
                else
                echo date('Y-m-d',$time);
                ?>" required>
            </div>
        </div>
    </div>
    <div class="row">
         <div class="col-md-8">
            <div class="form-group">
                <label>&nbsp;</label>
                <input type="submit" name="dateRange" class="btn btn-info btn-fill pull-right" value="Load Expenses">
            </div>
        </div>

    </div>
    </form>
</div>
</div>
</div>

<!-- Date selection end -->
<!-- Data Display -->

<?php
$bllExpense = new BLLExpense;
if(isset($_GET['dateRange']))
{
    $dateFrom = $_GET['dateFrom'];
    $dateTo = $_GET['dateTo'];
    echo $bllExpense->showExpense($dateFrom,$dateTo);
}
else
{
    $time = time();
    $today = date('Y-m-d',$time);
    echo $bllExpense->showExpense($today,$today);
}
?>

<!-- Data Display End -->

                </div>

            </div>
        </div>


<?php
    include('./templates/footer.php');
?>