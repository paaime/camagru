<?php

trait Database
{

	private function connect()
	{
		$string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
		$con = new PDO($string, DBUSER, DBPASS);
		return $con;
	}

	public function query($query, $data = [])
	{
		try {
			$con = $this->connect();

			$stm = $con->prepare($query);
			$check = $stm->execute($data);

			if ($check) {
				// Check if it's a SELECT query
				if (stripos($query, 'SELECT') === 0) {
					return $stm->fetchAll(PDO::FETCH_OBJ);
				} else {
					return true; // Return true for successful UPDATE or INSERT
				}
			} else {
				return false;
			}
		} catch (Exception $e) {
			return false;
		}
	}

	public function get_row($query, $data = [])
	{

		$con = $this->connect();
		$stm = $con->prepare($query);

		$check = $stm->execute($data);
		if ($check) {
			$result = $stm->fetchAll(PDO::FETCH_OBJ);
			if (is_array($result) && count($result)) {
				return $result[0];
			}
		}

		return false;
	}

}