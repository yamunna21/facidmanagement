<?php

//Appointment.php

class Appointment
{
	public $base_url = 'http://localhost/managementsystem/';
	public $connect;
	public $query;
	public $statement;
	public $now;

	public function __construct()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=facidsystem", "facid", "123");

		date_default_timezone_set('Asia/Kuala_Lumpur');

		session_start();

		$this->now = date("Y-m-d H:i:s",  STRTOTIME(date('h:i:sa')));
	}

	function execute($data = null)
	{
		$this->statement = $this->connect->prepare($this->query);
		if($data)
		{
			$this->statement->execute($data);
		}
		else
		{
			$this->statement->execute();
		}		
	}

	function row_count()
	{
		return $this->statement->rowCount();
	}

	function statement_result()
	{
		return $this->statement->fetchAll();
	}

	function get_result()
	{
		return $this->connect->query($this->query, PDO::FETCH_ASSOC);
	}

	function is_login()
	{
		if(isset($_SESSION['admin_id']))
		{
			return true;
		}
		return false;
	}

	function is_master_user()
	{
		if(isset($_SESSION['user_type']))
		{
			if($_SESSION["user_type"] == 'Master')
			{
				return true;
			}
			return false;
		}
		return false;
	}

	function clean_input($string)
	{
	  	$string = trim($string);
	  	$string = stripslashes($string);
	  	$string = htmlspecialchars($string);
	  	return $string;
	}

	function get_total_today_patient()
	{
		$this->query = "
		SELECT * FROM patients_table
		WHERE admission_date = CURDATE() 
		";
		$this->execute();
		return $this->row_count();
	}

	function get_total_14_patient()
	{
		$this->query = "
		SELECT * FROM patients_table 
		WHERE admission_date < (NOW()) - INTERVAL 7 DAY
		";
		$this->execute();
		return $this->row_count();
	}

	function get_total_21_day_patient()
	{
	    $this->query = "
		SELECT * FROM patients_table
		WHERE admission_date < (NOW()) - INTERVAL 14 DAY
		";
		$this->execute();
		return $this->row_count();
	}

	function get_total_schedule()
	{
		$this->query = "
		SELECT * FROM  doctor_schedule_table 
		WHERE doctor_schedule_date = CURDATE() 
		";
		$this->execute();
		return $this->row_count();
	}

	function get_total_doctor()
	{
		$this->query = "
		SELECT * FROM doctor_table 
		";
		$this->execute();
		return $this->row_count();
	}

	function get_total_patient()
	{
		$this->query = "
		SELECT * FROM patients_table 
		";
		$this->execute();
		return $this->row_count();
	}


}


?>