<?php

session_start();

if(isset($_POST["table"])){
	
	include_once("connect.php");

	try {

		$link = new mysqli($host, $user, $password, $database);

			if($link -> connect_errno !=0){
			
			throw new Exception($link -> error);	
			
			}
			
			else {
				
				//echo $_POST['table']." ". $_SESSION['id']." ".$_POST['type']." ".$_POST['values'];
					
				$table = $_POST["table"];
				
				$query = "INSERT INTO $table values (NULL, '".$_SESSION['id']."','".$_POST['type']."','".$_POST['values']."')";
				
				$result = $link -> query($query);		
				
				include_once("functions.php");
				
				//$sendTable = tableDrawerImp($_POST['type'], $_POST['values'], "payments");
				
				$sendTable = oneRow($table);
				
				//$sendTable;

				if(!$result) throw new Exception($link -> error);
				
				$sum = getSum("payment", $table, $_SESSION["id"]);
				
				echo $sendTable."|".$sum;
				//echo($query);
				}
		
		}
	
	catch (Exception $e) {
		
		echo "Maintenance in progress. Please try again later.";
		
			}
			
		unset($_POST["table"]);
		$link -> close();
	
	
	}

else header("Location: main.php");
	

?>