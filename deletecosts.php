<?php

session_start();

if(isset($_POST["deleteId"])) {
	
	include_once("connect.php");
	
		try {
			
		$link = new mysqli($host, $user, $password, $database);

			if($link -> connect_errno !=0){
			
			throw new Exception($link -> error);
				
			}
		
		else {
			
			$table = $_POST["table"];
			$ids = $_POST["deleteId"];
			
			$i=0;
			$deleted = sizeof($ids);
			
			while($i<$deleted){
				
				$query = "DELETE FROM $table WHERE id = '".$ids[$i]."'";
				
				$result = $link -> query($query);
				
				if(!$result) throw new Exception($link -> error);
				
				$i++;
			}
			
			include_once("functions.php");
			
			$sum = getSum("payment", $table, $_SESSION["id"]);
			
			echo $sum;
			
			}
		
		}
		
		catch(Exception $e) {
		
		echo "Maintenance in progress. Please try again later.";
		
			}
			
		unset($_POST["deleteId"]);
		$link -> close();

}

else header("Location: main.php");








?>