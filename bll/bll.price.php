<?php
include($_SERVER['DOCUMENT_ROOT'].'/dal/dal.price.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');

$bllPrice = new BLLPrice;
class BLLPrice
{
	
	
	function __construct()
	{
		$utility = new Utility;
		$dalPrice = new DALPrice;
		if(isset($_POST['update_price']))
		{

			$id = $_POST['priceId'];
			$buy = $_POST['buy'];
			$sale = $_POST['sale'];
			
			for($i=1;$i<sizeof($id);$i++)
			{
				//echo $id[$i]."---".$buy[$i]."---".$sale[$i]."<br>";
				$result = $dalPrice->updatePrice($id[$i],$buy[$i],$sale[$i]);
			}

			if($result)
			{
				$_SESSION['message'] = "Price updated Successfully!";
				header('Location:../price.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update Price!";
				header('Location:../price.php');
				exit();
			}

		}
	}
	public function showPrice()
	{
		$totalPrice = 0;
		$data = "";
	
        $dalPrice  = new DALPrice;
        $resultPrice = $dalPrice->getPrice();
        $SL = 1;
        while ($res = mysqli_fetch_assoc($resultPrice))
        {
        	$data .= '<div class="row">';

        $data.=    '<div class="col-md-1">
		            <div class="form-group">
		                <input type="text" name="priceId[]" class="form-control"  value="'.$res["id"].'" style="display:none;">
		            '.$SL++.'.
		            </div>
         		</div>';
        $data.=    '<div class="col-md-3">
		            <div class="form-group">
		              '.$res["subCategoryName"].'
		            </div>
         		</div>';

        $data.=    '<div class="col-md-3">
		            <div class="form-group">
		                <input type="text" name="buy[]" class="form-control"  value="'.$res["buy"].'">
		            </div>
         		</div>';
        $data.=    '<div class="col-md-3">
		            <div class="form-group">
		                <input type="text" name="sale[]" class="form-control"  value="'.$res["sale"].'">
		            </div>
         		</div>';


        	$data .= '</div>';
        }
		return $data;


	}

}
?>