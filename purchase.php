<?php
include_once('bll/bll.purchase.php');
include_once('dal/dal.productcategory.php');
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
                var category = $('#subCategory').val();
                if(category!=0) category = " and stock.subCategoryId='"+category+"'";
                else category = '';
                var query = "select stock.id,subcategory.name,stock.date,stock.pcs,stock.unitPrice,stock.pcs*stock.unitPrice as netAmount from subcategory,stock where subcategory.id=stock.subCategoryId and stock.date between '"+dateFrom+"' and '"+dateTo+"' "+category+" order by subcategory.name asc";
                $('#stockTable').editableGrid({
                    primaryTable: "stock",
                    selectQuery: query,
                    columns:[
                        'SubCategory',
                        'Date',
                        'Amount(pcs/kg)',
                        'Unit Price',
                        'Product Value'
                    ],
                    format:{
                        date: {
                            type:'date'
                        },
                        pcs:{
                            type: 'number'
                        },
                        name:{
                            type: 'ddl',
                            selectQuery:'select * from subcategory'
                        },

                    },
                    editMethods:{
                        name:"UPDATE `stock` SET `subCategoryId` = '*' WHERE `stock`.`id` = '*'"
                    },
                editAble:{
                    netAmount:false,
                    unitPrice:false
                }
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


    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title"><b>Add New Stock</b></h4>
            </div>
            <div class="content">

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
                                </form>

                            </div>
                        </div>

                        <form action="bll/bll.purchase.php" method="POST">
                            <div class="col-md-6">
                                <input type="text" name="id" value="<?php
                                    if(isset($_GET['edit']))
                                       echo $GLOBALS['id'];
                                    ?>" style="display: none;">
                                <div class="form-group">
                                    <label>Sub Category</label>
                                    <select class="form-control" name="subCategoryId">

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
                                            if(isset($_GET['edit']) && $GLOBALS['subCategoryId'])
                                            {
                                                if($res['id']==$GLOBALS['subCategoryId'])
                                                {
                                                    $option .= '<option value='.$res['id'].' selected>';

                                                }
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
                                <label>Amount(Pcs/kg)</label>
                                <input type="text" name="pcs" class="form-control" placeholder="Pcs. of Product" required value="<?php
                                if(isset($_GET['edit']))
                                   echo $GLOBALS['pcs'];
                                ?>">
                            </div>
                        </div>
                    </div>


                    <input type="submit" class="btn btn-info btn-fill pull-right" name="<?php
                    if(isset($_GET['edit']))
                       echo "update_stock";
                    else
                        echo "insert_stock";
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
                <h4 class="title"><b>Stock</b>
                </h4>
            </div>
            <div class="content">
                <form  method="GET">
                    <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>From</label>
                            <input type="date" id="dateFrom" name="dateFrom" class="form-control" value="<?php
                            if(isset($_GET['loadStock'])){
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

                             if(isset($_GET['loadStock'])){
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
                                if(isset($_GET['loadStock'])) $value=$_GET['subCategory'];
                                echo $bllStock->getSubCategoryAsOptions($value);
                                ?>
                            </div>
                        </div>
                </div>
                    <div class="row">
                         <div class="col-md-12">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <input type="submit" name="loadStock" class="btn btn-info btn-fill pull-right" value="Load Stock">
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
                <h4 class="title"><b>Details</b></h4>
            </div>
            <div class="content">
                <div class="content table-responsive table-full-width">
                    <table id="stockTable" class="table table-hover table-striped">
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- Data Display End -->

    <?php
    $bllStock = new BLLStock;
    if(isset($_GET['loadStock']))
    {
        $dateFrom = $_GET['dateFrom'];
        $dateTo = $_GET['dateTo'];
        $category = $_GET['subCategory'];
        echo $bllStock->getTotalStock($dateFrom,$dateTo,$category);
    }
    else
    {
        $time = time();
        $today = date('Y-m-d',$time);
        echo $bllStock->getTotalStock($today,$today,0);
    }
    ?>


</div>
<?php
    include('./templates/footer-customized.php');
?>