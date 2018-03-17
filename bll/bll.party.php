<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/dal/dal.party.php');

$id="";
$name="";
$address="";
$phone="";
$quota="";

$bllParty = new BllParty;
class BllParty
{
	
	function __construct()
	{
		$utility = new Utility;
		$dalParty = new DALParty;
		if(isset($_POST['insert_party']))
		{
			$name = $utility->secureInput($_POST['name']);
			$address = $utility->secureInput($_POST['address']);
			$phone = $utility->secureInput($_POST['phone']);
			$quota = $utility->secureInput($_POST['quota']);
			
			$result = $dalParty->insertParty($name,$address,$phone,$quota);

			if($result)
			{
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();
			}
			else
			{
				header('Location:'.$_SERVER['HTTP_REFERER']);
				exit();

			}
		}
		if(isset($_POST['update_party']))
		{
			$id = $utility->secureInput($_POST['id']);
			$name = $utility->secureInput($_POST['name']);
			$address = $utility->secureInput($_POST['address']);
			$phone = $utility->secureInput($_POST['phone']);
			$quota = $utility->secureInput($_POST['quota']);
			
			$result = $dalParty->updateParty($id,$name,$address,$phone,$quota);
			if($result)
			{
				$_SESSION['message'] = "Party updated Successfully!";
				header('Location:../party.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update Party!";
				header('Location:../party.php');
				exit();
			}
		}
		if(isset($_GET['edit']))
		{
			$id = $utility->secureInput($_GET['edit']);
			$this->getPartyById($id);
		}
		if(isset($_GET['delete']))
		{
			$id = $utility->secureInput($_GET['delete']);
			$result = $dalParty->deleteParty($id);
			if($result)
			{
				$_SESSION['message'] = "Party deleted Successfully!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}
			else
			{
				$_SESSION['message'] = "Can't delete Party!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}
		}
	}
	public function showParty()
	{
		$dalParty = new DALParty;
		$result = $dalParty->getParty();

		$data = "";
		$SL= 1;
		while ($res=mysqli_fetch_assoc($result))
		{
			$data.='<tr>';
			$data.='<td>'.$SL++.'</td>';
			$data.='<td>'.$res['name'].'</td>';
			$data.='<td>'.$res['address'].'</td>';
			$data.='<td>'.$res['mobile'].'</td>';
			$data.='<td>'.$res['quota'].'</td>';
			$data .='<td><a href="party.php?edit='.$res['id'].'">Edit</a></td>';
				$data .='<td><a href="party.php?delete='.$res['id'].'">Delete</a></td>';
			$data.='</tr>';
		}
		return $data;

	}
	public function getPartyAsSelect($partyId=0)
    {
        $dalParty = new DALParty;
		$result = $dalParty->getParty();
        $data ='<select id="party" name="party" class="selectpicker form-control" data-live-search="true">';
        foreach ($result as $res)
        {
            if($res['id']==$partyId) $data .='<option value='.$res['id'].' selected>';
            else $data .='<option value='.$res['id'].'>';
            $data .=$res['name'];
            $data .='</option>';
        }
        $data .='</select>';

        return $data;

    }
	public function getPartyById($id)
	{
		$dalParty = new DALParty;
		$result = $dalParty->getPartyById($id);
		
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['id'] =$res['id'];
			$GLOBALS['name'] =$res['name'];
			$GLOBALS['phone'] =$res['mobile'];
			$GLOBALS['address'] =$res['address'];
			$GLOBALS['quota'] =$res['quota'];
			
		}
	}
}

?>