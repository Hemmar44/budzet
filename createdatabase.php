<?php 

if(isset($_POST["database"])){
	
	$server = $_POST["server"];
	$user = $_POST["user"];
	$password = $_POST["pass"];
	$budget = $_POST["database"];
	
	
	$link = new mysqli($server, $user, $password);
	
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	try{
		if($link -> connect_errno != 0) {
			
			throw new Exception($link -> error);
		}
		
	else{
		
	$query = "CREATE DATABASE budget";
	
		$result = $link -> query($query);
		
		if(!$result) {throw new Exception($link -> error);}
		
		else { echo "baza ok <br/>";
		
			$link -> close();
			
			createUserTable();
			createOtherTables("income", "source", "value");
			createOtherTables("life", "credit", "payment");
			createOtherTables("loans", "credit", "payment");
			createOtherTables("mpay", "credit", "payment");

			
		}
		
		
		}
	
	}
	catch(Exception $e) {
		echo "Coś poszło nie tak sprawdź dane i spróbuj ponownie";
	}
		
	//$link -> close();			
	
}
		function createUserTable(){
				$link = new mysqli($_POST["server"], $_POST["user"], $_POST["pass"], "budget");
			
				if($link -> connect_errno != 0) {
			
				throw new Exception($link -> error);
			
				}
				
				else {
				$query = "CREATE TABLE users (
				id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				nick TEXT NOT NULL,
				email TEXT NOT NULL,
				password TEXT NOT NULL		
				)"; 
					
				$result = $link -> query($query);
		
				if(!$result) {throw new Exception($link -> error);}
					
				else echo "Tabela users ok <br/>";
				
				
				}
			$link -> close();
			}
			
			function createOtherTables($name, $textColumn, $valueColumn){
				$link = new mysqli($_POST["server"], $_POST["user"], $_POST["pass"], "budget");
			
				if($link -> connect_errno != 0) {
			
				throw new Exception($link -> error);
			
				}
				
				else {
				$query = "CREATE TABLE $name (
				id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				userid  INT(11) NOT NULL,
				$textColumn TEXT NOT NULL,
				$valueColumn INT(11) NOT NULL		
				)"; 
					
				$result = $link -> query($query);
		
				if(!$result) {throw new Exception($link -> error);}
					
				else echo "Tabela '$name' ok <br/>";
				
				
				}
			$link -> close();
			}
				

?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />

	
	<title>Stwórz tabele</title>
	
</head>
<body>
<div><span>Stwórz bazę danych potzebną do prawidłowego działania aplikacji</span></div>
<form method="post">
	<table>
		<thead>
			<tr>
				<th>Pozycja</th><th>Dane</th>
			</tr>
			<tr>
				<td>Server name</td><td><input type="text" name="server"/></td>
			</tr>
			<tr>
				<td>Username</td><td><input type="text" name="user"/></td>
			</tr>
			<tr>
				<td>Password</td><td><input type="password" name="pass"/></td>
			</tr>
			<tr>
				<td>Database</td><td><input type="text" value="budget" name="database" readonly></td>
			</tr>
		</thead>
	</table>
	<input type="submit" value="Utwórz Bazę"/>
	<?php print_r($_POST) ?>

</form>
</body>
</html>