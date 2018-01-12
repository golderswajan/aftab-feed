
<?php
    // Head and body starting
include('./bll/bll.expensecategory.php');
include_once './templates/topper-customized.php';
//include($_SERVER['DOCUMENT_ROOT'].'/includes/permissionadmin.php');

?>
<script>
    $(document).ready(function($){
        $('#expenseCategoryTable').editableGrid({
            primaryTable:"expensecategory"
        });
    });

    window.setTimeout(function(){
        $('#msgDiv').hide();

    }, 2000);
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
                        <div class="card ">
                            <div class="header">
                                <h4 class="title"><b>Expense Category</b></h4>
                                <p class="category"></p>
                            </div>
                            <div class="content">
                                 <form action="bll/bll.expensecategory.php" method="POST">
                                    <div class="row">
                                    <input type="text" name="id" value="<?php
                                    if(isset($_GET['edit']))
                                       echo $_GET['edit'];
                                    ?>" style="display: none">
                                       
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Category Name</label>
                                                <input type="text" name="categoryName" class="form-control" placeholder="Category Name" required value="<?php
                                                if(isset($_GET['edit']))
                                                   echo $GLOBALS['name'];
                                                ?>">
                                            </div>
                                        </div>

                                    </div>
                                    <input type="submit" class="btn btn-info btn-fill pull-right" name="insert_category" value="Save">
                                    <div class="clearfix"></div>
                                </form>

                                   <!-- Data display -->
                            <br>
                            <div class="content table-responsive table-full-width">
                                <table id="expenseCategoryTable" class="table table-hover table-striped">

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