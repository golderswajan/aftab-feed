<?php
include('./templates/head.php');
// Head and body starting
include_once('bll/bll.returns.php');
include_once('dal/dal.productcategory.php');
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
            <h4 class="title"><b>Product Return</b></h4>
        </div>
        <div class="content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Party</label>
                            <select class="form-control" name="customerId" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Customer</label>
                            <input type="text" class="form form-control" name="customerId">
                        </div>
                    </div>
                </div>
            
                 <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">

                            <label>Category</label>
                            <form method="GET" name="cat">
                            <select name="productCategory" class="form-control" onchange="this.form.submit()" required>
                            <option>Select a category</option>

                            <?php
                            $dalProductCategory = new DALProductCategory;
                                $result =  $dalProductCategory->getCategory();
                                $option = "";

                                while ($res = mysqli_fetch_assoc($result))
                                {
                                    if(isset($_GET['productCategory']) && $_GET['productCategory']==$res['id'])
                                    {
                                        $option .= '<option value='.$res['id'].' selected>';
                                    }
                                    elseif (isset($_GET['edit']) && $GLOBALS['categoryId']==$res['id']) {
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
                            <!-- Hold -->
                            <input type="text" name="SE" value="<?php
                            if(isset($_GET['SE']))
                                echo $_GET['SE'];

                            ?>" style="display: none;">
                            <!-- Hold data end  -->
                        </form>

                        </div>
                    </div>
                    <form action="bll/bll.returns.php" method="POST">

                <!-- Hold -->
                    <input type="text" name="SE" value="<?php
                    if(isset($_GET['SE']))
                        echo $_GET['SE'];
                     elseif(isset($_GET['edit']))
                        echo $GLOBALS['customerId'];
                    ?>" style="display: none;">
                <!-- Hold end -->
                    <div class="col-md-6">
                        <input type="text" name="returnsId" value="<?php
                            if(isset($_GET['edit']))
                               echo $GLOBALS['returnsId'];
                            ?>" style="display: none;">
                <div class="form-group">
                    <label>Sub Category</label>
                    <select class="form-control" name="subCategoryId" required>

                    <?php
                    $dalProductCategory = new DALProductCategory;
                    if (isset($_GET['productCategory']) || isset($_GET['edit']))
                    {
                         $result = "";
                        if(isset($_GET['edit']))
                        {
                            $result =  $dalProductCategory->getSubCategoryByCategoryId($GLOBALS['categoryId']);
                        }
                        else
                        {
                            $result =  $dalProductCategory->getSubCategoryByCategoryId($_GET['productCategory']);
                        }
                       
                        $option = "";

                        while ($res = mysqli_fetch_assoc($result))
                        {
                            if(isset($_GET['edit']) && $GLOBALS['subCategoryId']==$res['id'])
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
                    }
                    ?>
                    </select>
                </div>
            </div>
                </div>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pcs.</label>
                            <input type="text" name="pcs" class="form-control" placeholder="Pcs. of Product" required value="<?php
                            if(isset($_GET['edit']))
                               echo $GLOBALS['pcs'];
                            ?>">
                        </div>
                    </div>
                </div>

                <input type="submit" class="btn btn-info btn-fill pull-right" name="<?php
                if(isset($_GET['edit']))
                   echo "update_returns";
                else 
                    echo "insert_returns";
                ?>" value="<?php
                if(isset($_GET['edit']))
                   echo "Update";
                else
                    echo "Save";
                ?>">
                <div class="clearfix"></div>
            </form>

        </div>
        
    </div>
</div>

<!-- Date selection -->
<div class="col-md-12">
<div class="card">
    <div class="header">
        <h4 class="title"><b>Returned Products</b> 
        </h4>
    </div>
    <div class="content">
    <form  method="GET">
<!-- Hold -->
    <input type="text" name="SE" value="<?php
    if(isset($_GET['SE']))
        echo $_GET['SE'];
     elseif(isset($_GET['edit']))
        echo $GLOBALS['customerId'];
    ?>" style="display: none;">
<!-- Hold end -->
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
                <input type="submit" name="dateRange" class="btn btn-info btn-fill pull-right" value="Load Returned Products">
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
$bllReturns = new BLLReturns;
if(isset($_GET['dateRange']))
{
    $dateFrom = $_GET['dateFrom'];
    $dateTo = $_GET['dateTo'];
    echo $bllReturns->showReturns($dateFrom,$dateTo);
}

else
{
    $time = time();
    $today = date('Y-m-d',$time);
    echo $bllReturns->showReturns($today,$today);
}
?>

<!-- Data Display End -->

</div>
</div>
</div>
<?php
    include('./templates/footer.php');
?>