<?php
namespace Agpay;

use PDO;
require "./vendor/autoload.php";

class Database {
	private $db_user = "root";
	private $db_host = "localhost";
	private $db_pass = "";
	private $db_name = "agpaytech";
	public $con;

	public function db_connect() {
		$this->con = null;
		try {
			$this->con = new PDO("mysql:host=" .$this->db_host. ";dbname=".$this->db_name, $this->db_user, $this->db_pass);
			$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//	echo "Successful";
		} 
		catch (PDOException $e) {
			echo "Connection Error:" .$e-> getMessage();
		}
		return $this->con;
	}
}
?>