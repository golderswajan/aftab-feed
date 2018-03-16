<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/utility.php');


class DALParty
{
	
	function __construct()
	{

	}
	public function insertParty($name,$address,$mobile,$quota)
	{
		$utility = new Utility;
		$sql = "INSERT INTO `customer`(`id`, `name`, `address`, `mobile`) VALUES ('','$name','$address','$mobile')";
		$result = $utility->dbQuery($sql);

		$partyIdSql = "SELECT `id` FROM `customer` WHERE name='$name' && address='$address' && mobile='$mobile'";
		$result = $utility->dbQuery($partyIdSql);
		while ($res = mysqli_fetch_assoc($result))
		{
			$partyId = $res['id'];
//			creating empty field for party due
            $emptyDueSql = "INSERT INTO `partyduepayment` (`id`, `amount`, `customerId`) VALUES (NULL, '0', '$partyId');";
            $utility->dbQuery($emptyDueSql);

			$partySql = "INSERT INTO `party`(`id`, `quota`, `customerId`) VALUES ('',$quota,'$partyId')";
			$result = $utility->dbQuery($partySql);
		}
		return $result;
	}
	public function getParty()
	{
		$utility = new Utility;
		$sql = "SELECT customer.*,party.quota FROM customer,party WHERE customer.id = party.customerId";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function getPartyById($id)
	{
		$utility = new Utility;
		$sql = "SELECT customer.*,party.quota FROM customer,party WHERE customer.id = party.customerId && party.id=$id";
		$result = $utility->dbQuery($sql);
		return $result;
	}
	public function UpdateParty($id,$name,$address,$mobile,$quota)
	{
		$utility = new Utility;
		$sql = "UPDATE `party` SET `quota`='$quota'";
		$sqlCustomer = "UPDATE `customer`,party SET `name`='$name',`address`='$address',`mobile`='$mobile' WHERE customer.id=party.customerId && party.id = $id";
		
		$result = $utility->dbQuery($sql);
		$result = $utility->dbQuery($sqlCustomer);
		return $result;
	}
	public function deleteParty($id)
	{
		$utility = new Utility;

		$sql = "DELETE FROM `party` WHERE party.id=$id";
		$result = $utility->dbQuery($sql);

		return $result;
	}
}
?>