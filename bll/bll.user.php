<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/dal/dal.user.php');

$id="";
$name="";
$phone="";

$bllUser = new BllUser;
class BllUser
{
	
	function __construct()
	{
		$utility = new Utility;
		$dalUser = new DALUser;
		if(isset($_POST['insert_user']))
		{
			$name = $utility->secureInput($_POST['name']);
			$password = $utility->secureInput($_POST['password']);
			$phone = $utility->secureInput($_POST['phone']);
			$hash = hash('sha256','shahid@cseku'.$password);
			
			$result = $dalUser->insertUser($name,$phone,$hash);

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
		if(isset($_POST['update_user']))
		{
			$id = $utility->secureInput($_POST['id']);
			$name = $utility->secureInput($_POST['name']);
			$password = $utility->secureInput($_POST['password']);
			$phone = $utility->secureInput($_POST['phone']);
			
			$result = $dalUser->updateUser($id,$name,$phone);
			if($result)
			{
				$_SESSION['message'] = "User updated Successfully!";
				header('Location:../user.php');
				exit();
			}
			else
			{
				$_SESSION['message'] = "Can't update User!";
				header('Location:../user.php');
				exit();
			}
		}
		if(isset($_GET['edit']))
		{
			$id = $utility->secureInput($_GET['edit']);
			$this->getUserById($id);
		}
		if(isset($_GET['delete']))
		{
			$id = $utility->secureInput($_GET['delete']);
			$result = $dalUser->deleteUser($id);
			if($result)
			{
				$_SESSION['message'] = "User deleted Successfully!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}
			else
			{
				$_SESSION['message'] = "Can't delete User!";
				// header('Location:'.$_SERVER['HTTP_REFERER']);
				// exit();
			}
		}
	}
	public function showUser()
	{
		$dalUser = new DALUser;
		$result = $dalUser->getUser();

		$data = "";
		$SL= 1;
		while ($res=mysqli_fetch_assoc($result))
		{
			$data.='<tr>';
			$data.='<td>'.$SL++.'</td>';
			$data.='<td>'.$res['userName'].'</td>';
			$data.='<td>'.$res['phone'].'</td>';
			$data .='<td><a href="user.php?edit='.$res['id'].'">Edit</a></td>';
				$data .='<td><a href="user.php?delete='.$res['id'].'">Delete</a></td>';
			$data.='</tr>';
		}
		return $data;

	}
	public function getUserById($id)
	{
		$dalUser = new DALUser;
		$result = $dalUser->getUserById($id);
		
		while ($res = mysqli_fetch_assoc($result))
		{
			$GLOBALS['mfsId'] =$res['id'];
			$GLOBALS['name'] =$res['userName'];
			$GLOBALS['phone'] =$res['phone'];
			
		}
	}
}

?>