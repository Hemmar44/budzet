<?php
session_start();

//checking if ajax with text data was send
if(isset($_POST["text"])) {

	//including connection data
	include_once("connect.php");
	
		try {
			
		$link = new mysqli($host, $user, $password, $database);

			if($link -> connect_errno !=0){
			
			throw new Exception($link -> error);
				
			}
	
			
			$i = 0;
			// chekin if size of $_post text is > 0
			while($i<sizeof($_POST["text"])){
				
				$_POST['text'][$i] = $link -> real_escape_string($_POST['text'][$i]); //securing first column data
				$_POST['values'][$i] = $link -> real_escape_string($_POST['values'][$i]); //securing second column data
				
				//creating query to insert data to to income table
				$query = "INSERT INTO income values (NULL, '".$_SESSION['id']."','".$_POST['text'][$i]."','".$_POST['values'][$i]."')";
				
				//inserting data to income table 
				$result = $link -> query($query);
				
				if(!$result) throw new Exception($link -> error);
				
				//incrementing $i
				$i++;
				
				}
			
			//echo "</table>";
			include_once("functions.php");
			
			$id=$_SESSION["id"];
			echo $table = receivingIncome($id);//my function to receive the table with income
			
				}
			
		
				catch(Exception $e) {
		
				echo "Maintenance in progress. Please try again later.";
		
			}
		
		//unseting variable and closing connection
		unset($_POST["text"]);
		$link -> close();
		
		
}

else {
	header("Location: main.php");
}
	


?>