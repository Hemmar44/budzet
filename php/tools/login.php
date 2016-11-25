<?php

session_start(); 

if(array_key_exists("login",$_POST) and array_key_exists("pass",$_POST) and ($_POST["login"]!='') and ($_POST["pass"]!='')) {
	
	include_once("../database/connect.php");
	
		//exceptions
	mysqli_report(MYSQLI_REPORT_STRICT);
	
	//$link = new mysqli($host, $user, $password, $database);
	
	try {
		$link = new mysqli($host, $user, $password, $database);

		if($link -> connect_errno !=0){
			
			throw new Exception($link -> error);
		}
		
		else {
			
			$login =htmlentities($_POST["login"],ENT_QUOTES, "UTF-8");
			
			$login = $link -> real_escape_string($_POST["login"]);
			$pass = $link -> real_escape_string($_POST["pass"]);
			
			
			$result = $link -> query("SELECT * FROM users WHERE nick = '$login' ");
			
			if(!$result) throw new Exception($link ->error);
			
			$row = $result -> num_rows;
			
			if($row>0) {
				
				$data = $result -> fetch_assoc();
				$db_pass = $data["password"];
				$id = $data["id"];
			
				if(password_verify($pass, $db_pass)) {
					
					header("Location: ../content/main.php");
					
					$_SESSION["login"] = $login;
					$_SESSION["id"] = $id;
					
					$link -> close();
					exit();
					
				}
				
				else {
					
					//echo "wrong password";
					
					$_SESSION["log_error"] = "<p> Nieprawidłowe hasło, spróbuj ponownie.</p>";
					
					header("Location: verify.php");
					
				}
			}
			
			else {
				
				$_SESSION["log_error"] = "<p> Użytkownik nie istnieje, musisz się najpierw zarejestrować.</p>";
				
				header("Location: verify.php");
			
			}
			
		}
		$link -> close();
	}
	
	catch(Exception $e) {
		
		echo "Maintenance in progress. Please try again later.";
		
	}

	
	}

else {
	
	$_SESSION["log_error"] = "<p>Wpisz Nick i hasło, żeby się zalogować</p>";
	header("Location: verify.php");
	
	}










?>