<?php
session_start();

if(isset($_POST["updateId"])) {

	include_once("../database/connect.php");
	
		try {
			
		$link = new mysqli($host, $user, $password, $database);

			if($link -> connect_errno !=0){
			
			throw new Exception($link -> error);
				
			}
			
			else{
				
				$id=$_POST["updateId"];
				$value =  $link -> real_escape_string($_POST["value"]);
				$table = $link -> real_escape_string($_POST["table"]);
				
				
				$query = "UPDATE $table SET payment = '".$value."' WHERE id='".$id."'";
				
				//echo $query;
				
				$result = $link -> query($query);
			
				if(!$result) throw new Exception($link -> error);
				
				include_once("../tools/functions.php");
				
				$sum = getSum("payment", $table, $_SESSION["id"]);
				
				echo $sum;
				//else echo "succes";
				
			}
				
		}
		
		catch(Exception $e) {
		
		echo "Maintenance in progress. Please try again later.";
		
	}
			
		unset($_POST["updateId"]);
		$link -> close();
			
}

else header("Location: ../content/main.php");
			
			
			
?>