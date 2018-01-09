<?php
	require_once('./includes/utility.php');
	/**
	* 
	*/
	class DALDemo extends Utility
	{
		
		function __construct()
		{
			
		}
		public function getUsers()
		{
			$sql = "SELECT * FROM user";
			$result = $this->dbQuery($sql);
			return $result;
		}
		public function getAllUsers()
        {
            $sql = "SELECT * FROM user";
            $result = $this->dbQuery($sql);
            return $result;
        }
    }
?>