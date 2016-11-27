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
		else { echo "Baza danych o nazwie budget została skutecznie utworzona";}
	
	}
		
		
	}
	catch(Exception $e) {
		echo "Coś poszło nie tak sprawdź dane i spróbuj ponownie";
	}
	
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