<?php

session_start();
//checking if variable exists
if(isset($_POST["text"])) {
     //including connection
	include_once("../database/connect.php");
	
		try {
			//establishing connection
		$link = new mysqli($host, $user, $password, $database);

			if($link -> connect_errno !=0){
			
			throw new Exception($link -> error);
				
			}
			
			else {
				//query to delete from this id
			$query = "DELETE FROM income WHERE userid = '".$_SESSION['id']."'";
			//deleting from data for this id
			$result = $link -> query($query);
			
			
			if(!$result) throw new Exception($link -> error);
			
			$i = 0;
			
			
			while($i<sizeof($_POST["text"])){
				
				$_POST['text'][$i] = $link -> real_escape_string($_POST['text'][$i]); //securing first column data
				$_POST['values'][$i] = $link -> real_escape_string($_POST['values'][$i]); //securing second column data
				
				//query to insert new data to database
				$query = "INSERT INTO income values (NULL, '".$_SESSION['id']."','".$_POST['text'][$i]."','".$_POST['values'][$i]."')";
				
				//inserting new data into data base
				$result = $link -> query($query);
				
				if(!$result) throw new Exception($link -> error);
				
				$i++;
				
				}
			
			
			include_once("../tools/functions.php");
			$id=$_SESSION["id"];
			
			echo $table = receivingIncome($id);//my function to receive the table with income
			
			}
			
		
			}
		
		
		catch(Exception $e) {
		
		echo "Maintenance in progress. Please try again later.";
		
			}
			
		unset($_POST["text"]);
		$link -> close();
	
		
}

else header("Location: ../content/main.php");






?>