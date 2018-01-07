<?php

class DBUtil
{
	
	function __construct()
	{
		$this->readConfig();
	}

	private function readConfig(){

		$this->_ini_array = parse_ini_file("../config/system.ini");

		$this->_host =	$this->_ini_array['db_host'];
		$this->_username = $this->_ini_array['db_username'];
		$this->_password = $this->_ini_array['db_password'];
		$this->_database = $this->_ini_array['db_database'];
	
		$this->_log_enabled=$this->_ini_array['log_enabled'];
		$this->_log_level=$this->_ini_array['log_level'];
		$this->_log_file_path=$this->_ini_array['log_path'];
	

		$this->_lang_default=$this->_ini_array['lang_default'];

	}

	public function getDBHost(){

		return $this->_host;
	}

	public function getDBUserName(){

		return $this->_username;
	}

	public function getDBPassword(){

		return $this->_password;
	}

	public function getDBName(){

		return $this->_database;
	}

	public function isLogEnabled(){

		return $this->_log_enabled;
	}

	public function getLogLevel(){

		return $this->_log_level;
	}

	public function getLogFilePath(){

		return $this->_log_file_path; 
	}
	
	public function getDefaultLanguage(){
		return $this->_lang_default;
	}
}
?>