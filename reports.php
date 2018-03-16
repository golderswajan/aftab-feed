<?php
include('./templates/head.php');
include('./bll/bll.reports.php');
include('./bll/bll.party.php');

//include($_SERVER['DOCUMENT_ROOT'].'/includes/permissionadmin.php');

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

   

    <!-- Date selection -->
    <div class="col-md-12">
    <div class="card">
        <div class="header">
            <h4 class="title"><b>Reports</b> 
            </h4>
        </div>
        <div class="content">
        <form  method="GET">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Report</label>
                    <select name="report" class="form form-control">
                        <option value="Sales">Sales Report</option>
                        <option value="Expense">Expense Report</option>
                        <option value="Stock">Stock Report</option>
                        <option value="Final">Final Report</option>
                        <option disabled>------------------</option>
                        <option value="Party">Party Ledger</option>
                        <option disabled>------------------</option>
                        <option value="Feed">Feed Sales</option>
                        <option value="Chicken">Chicken Sales</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>From</label>
                    <input type="date" name="dateFrom" class="form-control" value="<?php
                    $time = time();
                    if(isset($_GET['loadReports']))
                    echo $_GET['dateFrom'];
                    else
                    echo date('Y-m-d',$time);
                    ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Party (Optional)</label>
                        <?php
                            echo $bllParty->getPartyAsSelect();
                        ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>To</label>
                    <input type="date" name="dateTo" class="form-control" value="<?php
                    $time = time();
                    if(isset($_GET['loadReports']))
                    echo $_GET['dateTo'];
                    else
                    echo date('Y-m-d',$time);
                    ?>" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10"></div>
            
             <div class="col-md-2">
                <div class="form-group">
                    <input type="submit" name="loadReports" class="btn btn-info btn-fill btn-block pull-right" value="Load Report">
                </div>
            </div>

        </div>
        </form>
    </div>
    </div>
    </div>

    <!-- Date selection end -->
    <!-- Data Display -->
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h3 class="title text-center"><b>
                    <?php if(isset($_GET['loadReports'])) echo $_GET['report']?>
                     Report</b></h3>
                <p class="h5 text-center"><i><?php
                    $time = time();
                    if(isset($_GET['loadReports']))
                    echo $_GET['dateFrom'].' <b>To</b> '.$_GET['dateTo'];
                    else
                    echo date('d-M-Y',$time);
                ?></i></p>
            </div>
            <div class="row">
                <div class="col-md-10">
                    
                </div>
                <div class="col-md-2">
                    <!-- Temporary Button for closing event -->
                    <form action="bll/bll.reports.php" method="POST">
                        <input type="text" name="today" value="<?php
                        $time = time();
                        $date = date('Y-m-d',$time);
                        echo $date;
                        ?>" style="display: none;">
                        <input type="text" name="yesterday" value="<?php
                        $time = time();
                        $y = strtotime("-1 day", $time);
                        $yesterday = date('Y-m-d',$y);
                        echo $date;
                        ?>" style="display: none;">

                       
                        <input type="submit" name="closing" value="Close Today" class="btn btn-danger btn-fill btn-block pull-right" >
                    </form>
                </div>
               <!--  <div class="col-md-2">
                    <form action="bll/bll.makepdf.php">
                <input type="text" name="dateFromHolder" value="<?php
                    if(isset($_GET['loadReports']))
                    {
                       echo $_GET['dateFrom'];  
                    }
                    else
                    {
                        $time = time();
                        $today = date('Y-m-d',$time);
                        echo $today;
                    }
                ?>" style="display: none;">
                <input type="text" name="dateToHolder" value="<?php
                    if(isset($_GET['loadReports']))
                    {
                       echo $_GET['dateTo'];  
                    }
                    else
                    {
                        $time = time();
                        $today = date('Y-m-d',$time);
                        echo $today;
                    }
                ?>"  style="display: none;">
                <input type="submit" class="btn btn-danger btn-fill btn-block pull-right" name="<?php
                if(isset($_GET['loadReports']))
                {
                    echo $_GET['report'];
                }
                ?>" value="Export PDF">
                    
                </form>
                </div> -->
            </div>
    
<div class="row">
    <div class="col-md-12">  
        <div class="content table-responsive table-full-width">
            <table class="table table-hover table-bordered" id="reportTable">
<?php
$bllReports = new BLLReports;
if(isset($_GET['loadReports']))
{
    $dateFrom = $_GET['dateFrom'];
    $dateTo = $_GET['dateTo'];
    $partyId = $_GET['party'];

    if($_GET['report']=='Sales')
    {
        echo $bllReports->showSalesReport($dateFrom,$dateTo);
    }
    elseif($_GET['report']=='Expense')
    {
        echo $bllReports->showExpenseReport($dateFrom,$dateTo);
    }
    elseif($_GET['report']=='Stock')
    {
        echo $bllReports->showStockReport($dateFrom,$dateTo);
    }
    elseif($_GET['report']=='Party')
    {
        echo $bllReports->showPartyReport($dateFrom,$dateTo,$partyId);
    }
    
    elseif($_GET['report']=='Feed')
    {
        echo $bllReports->showFeedReport($dateFrom,$dateTo);
    }
    elseif($_GET['report']=='Chicken')
    {
        echo $bllReports->showChickenReport($dateFrom,$dateTo);
    }
}
?>
                </table>
            </div>
        </div>
    </div>

<div class="row">
    <div class="col-md-6">  
        <div class="content table-responsive table-full-width">
            <table class="table table-hover table-striped" id="reportTable">
<?php
$bllReports = new BLLReports;
if(isset($_GET['loadReports']))
{
    if($_GET['report']=='Final')
    {
        echo $bllReports->showDetailedFinalReport($dateFrom,$dateTo);

        echo "</table>
                </div>
                </div>
                ";
        echo '<div class="col-md-6">  
        <div class="content table-responsive table-full-width">
            <table class="table table-hover table-striped" id="reportTable">';
        echo $bllReports->showExpenseReport($dateFrom,$dateTo);

    }
}
?>
  </table>
            </div>
        </div>
    </div>





        </div>
    </div>
    <!-- Data Display -->

    </div>
</div>
</div>
<link rel="stylesheet" type="text/css" href="assets/css/tableexport.min.css">

<!-- Report csv,xlsx,txt plugins -->
<script type="text/javascript" src="assets/js/bootstrap.min_1.js"></script>
<script type="text/javascript" src="assets/js/FileSaver.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="assets/js/tableexport.min.js"></script>

<!-- <script>
    $('#SalesReport').tableExport();
</script> -->
<!-- Report csv,xlsx,txt plugins -->

<?php
    include('./templates/footer.php');
?>