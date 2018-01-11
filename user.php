<?php
// Head and body starting
include('./templates/head.php');

include('./bll/bll.user.php');
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
                                <h4 class="title"><b>Add New User</b></h4>
                            </div>
                            <div class="content">
                                <form action="bll/bll.user.php" method="POST">
                                    <div class="row">
                                        <input type="text" name="id" value="<?php
                                                if(isset($_GET['edit']))
                                                   echo $_GET['edit'];
                                                ?>" style="display: none">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" name="name" class="form-control" placeholder="Name" required value="<?php
                                                if(isset($_GET['edit']))
                                                   echo $GLOBALS['name'];
                                                ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Phone No</label>
                                                <input type="text" name="phone" class="form-control" placeholder="Phone No" required value="<?php
                                                if(isset($_GET['edit']))
                                                   echo $GLOBALS['phone'];
                                                ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="text" name="password" class="form-control" placeholder="Password" required value="<?php
                                                if(isset($_GET['edit']))
                                                   echo $GLOBALS['password'];
                                                ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <input type="submit" class="btn btn-info btn-fill pull-right" name="<?php
                                                if(isset($_GET['edit']))
                                                   echo "update_user";
                                                else 
                                                    echo "insert_user";
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
                    </div>
                   <!--  Add new User end-->
                   <!-- Data Display -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title"><b>List of Users</b></h4>
                                <p class="category">Aftab Feed Products</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>SL.</th>
                                        <th>Name</th>
                                        <th>Phone No</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $bllUser = new BLLUser;
                                        echo $bllUser->showUser();
                                    ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <!-- Data Display End -->

                </div>

            </div>
        </div>


<?php
    include('./templates/footer.php');
?>