<?php

require_once('./bll/bll.productcategory.php');
include_once './templates/topper-customized.php';
?>

<script>
    $(document).ready(function($){
        $('#categoryTable').editableGrid({
            primaryTable: "category",
            identity: "categoryTable"
        });
        $('#subCategoryTable').editableGrid({
            primaryTable: "subCategory",
            identity: "subCategoryTable",
            selectQuery: "select subcategory.id,subcategory.name,category.name as parent from subcategory,category where subcategory.categoryId=category.id",
            editMethods : {
                parent : "UPDATE `subcategory` SET `categoryId` = '*' WHERE `subcategory`.`id` = '*'",
            },
            format : {
                parent : {
                    type : "ddl",
                    selectQuery : "select * from category"
                }
            }

        });

        window.setTimeout(function(){
            $('#msgDiv').hide();

        }, 2000);
    });
</script>
<!--Page contend starts here .. seperated in each file -->

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

                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title"><b>Category</b></h4>
            
                            </div>
                            <div class="content">
                                <form action="bll/bll.productcategory.php" method="POST">
                                    <div class="row">
                                       
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Category Name</label>
                                                <input type="text" name="categoryName" class="form-control" placeholder="Category Name" required >
                                            </div>
                                        </div>

                                    </div>
                                    <input type="submit" class="btn btn-info btn-fill pull-right" name="insert_category" value="Save">
                                    <div class="clearfix"></div>
                                </form>

                                 <!-- Data display -->
                            <br>
                            <div class="content table-responsive table-full-width">
                                <table id="categoryTable" class="table table-hover table-striped">

                                </table>
                            </div>
                            <!-- Data display end -->

                            </div>
                        </div>
                    </div>
                    <!-- Column end -->
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title"><b>Sub Category</b></h4>
            
                            </div>
                            <div class="content">
                                <form action="bll/bll.productcategory.php" method="POST">
                                    <div class="row">
                                    <input type="text" name="id" value="<?php
                                    if(isset($_GET['editSub']))
                                       echo $_GET['editSub'];
                                    ?>" style="display: none">
                                       
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>SubCategory Name</label>
                                                <input type="text" name="subCategoryName" class="form-control" placeholder="Sub Category Name" required value="<?php
                                                if(isset($_GET['editSub']))
                                                   echo $GLOBALS['name'];
                                                ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <label>Category Name</label>
                                            <?php
                                            echo $bllProductCategory->getCategoryAsOptions();
                                            ?>
                                            </div>
                                        </div>

                                    </div>
                                    <input type="submit" class="btn btn-info btn-fill pull-right" name="insert_sub_category" value="Save">
                                    <div class="clearfix"></div>
                                </form>

                                 <!-- Data display -->
                            <br>
                                <div class="content table-responsive table-full-width">
                                    <table id="subCategoryTable" class="table table-hover table-striped">
                                    </table>
                                </div>
                            <!-- Data display end -->

                            </div>
                        </div>
                    </div>
                    <!-- Column end -->

                </div>



 <?php
    include_once './templates/footer-customized.php';
?>