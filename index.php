<?php
include('./templates/head.php');


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


    <!-- Data Display -->
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h3 class="title text-center"><b>Aftab Feed Products</b></h3>
                <br>
                <p class="text-center">Moylapota, Khulna.</p>
                <p class="h5 text-center"><i><?php
                    $time = time();
                    if(isset($_GET['dateSelect']))
                    echo $_GET['date'];
                    else
                    echo date('l, F d, Y',$time);
                ?></i></p>
            </div>

            <div class="content table-responsive table-full-width">
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="card">
                <div class="header">
                    <h3 class="title text-center"><b>Aftab Feed Products</b></h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            
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

<?php
    include('./templates/footer.php');
?>