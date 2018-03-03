
<?php
include_once './templates/topper-customized.php';
?>
<!--    <script type="text/javascript" src="/assets/plugin/jquery-3.2.1.min.js"></script>-->
<!---->
<!--    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />-->
<!--    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>-->

<!--    <link rel="stylesheet" type="text/css" href="./assets/plugin/DataTables/datatables.min.css">-->
<!--    <link rel="stylesheet" type="text/css" href="./assets/plugin/DataTables/buttons.dataTables.min.css">-->
<!---->
<!---->
<!--    <script type="text/javascript" src="./assets/plugin/DataTables/datatables.min.js"></script>-->
<!--    <script type="text/javascript" src="./assets/plugin/DataTables/dataTables.buttons.min.js"></script>-->
<!--    <script type="text/javascript" src="./assets/plugin/DataTables/buttons.flash.min.js"></script>-->
<!--    <script type="text/javascript" src="./assets/plugin/DataTables/jszip.min.js"></script>-->
<!--    <script type="text/javascript" src="./assets/plugin/DataTables/pdfmake.min.js"></script>-->
<!--    <script type="text/javascript" src="./assets/plugin/DataTables/vfs_fonts.js"></script>-->
<!--    <script type="text/javascript" src="./assets/plugin/DataTables/buttons.html5.min.js"></script>-->
<!--    <script type="text/javascript" src="./assets/plugin/DataTables/buttons.print.min.js"></script>-->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Blfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        } );
    </script>

<div class="table-responsive" style="padding: 10px">
    <table id="example" class="table table-hover table-striped" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Name</th>
        <th>Position</th>
        <th>Office</th>
        <th>Age</th>
        <th>Start date</th>
        <th>Salary</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>Name</th>
        <th>Position</th>
        <th>Office</th>
        <th>Age</th>
        <th>Start date</th>
        <th>Salary</th>
    </tr>
    </tfoot>
    <tbody>
    <tr>
        <td>Tiger Nixon</td>
        <td>System Architect</td>
        <td>Edinburgh</td>
        <td>61</td>
        <td>2011/04/25</td>
        <td>$320,800</td>
    </tr>
    <tr>
        <td>Garrett Winters</td>
        <td>Accountant</td>
        <td>Tokyo</td>
        <td>63</td>
        <td>2011/07/25</td>
        <td>$170,750</td>
    </tr>
    <tr>
        <td>Ashton Cox</td>
        <td>Junior Technical Author</td>
        <td>San Francisco</td>
        <td>66</td>
        <td>2009/01/12</td>
        <td>$86,000</td>
    </tr>
    <tr>
        <td>Cedric Kelly</td>
        <td>Senior Javascript Developer</td>
        <td>Edinburgh</td>
        <td>22</td>
        <td>2012/03/29</td>
        <td>$433,060</td>
    </tr>

    </tbody>
</table>
</div>
<?php
include_once './templates/footer-customized.php';
?>