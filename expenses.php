<?php
/**
 * Created by PhpStorm.
 * User: swajan
 * Date: 1/9/2018
 * Time: 1:23 PM
 */

include_once './templates/topper-customized.php'?>

<style>

</style>


<div class="col-md-12 card" style="padding: 15px ">
    <div class="row">
        <div class="col-md-6">
            <div class="row form-group">
                <div class="col-md-4"><h7>Expense Category : </h7></div>
                <div class="col-md-8">
                    <select class="form-control" required>
                        <option>a</option>
                        <option>b</option>
                        <option>c</option>
                    </select>
                </div>
            </div>
    
            <div class="row form-group">
                <div class="col-md-4"><h7>DETAILS : </h7></div>
                <div class="col-md-8">
                    <textarea rows="3" class="form-control" required></textarea>
                </div>
            </div>
        </div>
    
    
        <div class="col-md-6">
            <div class="row form-group">
                <div class="col-md-4"><h7>DATE : </h7></div>
                <div class="col-md-8">
                   <input type="date" class="form-control" required>
                </div>
            </div>
    
            <div class="row form-group">
                <div class="col-md-4"><h7>AMOUNT (TK) : </h7></div>
                <div class="col-md-8">
                   <input type="number" class="form-control" min="0" required>
                </div>
            </div>
        </div>
    </div>

    <div class="row"><button type="button" style="margin-left:41%" class="btn btn-sm btn-primary btn-fill">Add Cost</button></div>

</div>

<div class="col-md-12 card">
    <div class="content table-responsive table-full-width">
        <table class="table table-hover table-striped">
        </table>
    </div>
</div>

<?php
include_once './templates/footer-customized.php';
?>
