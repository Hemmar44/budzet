<?php 
session_start();
//$_SESSION["all_errors"]='';
//$_SESSION["ok"] = '';
//$row = 0;

if(array_key_exists("nick",$_POST)){

		$nick = $_POST["nick"];
		$email = $_POST["email"];
		$password = $_POST["password1"];
		$password2 = $_POST["password2"];

		
		//$flag = true;
		//$nick ="ąs";
		//verifying nick, it needs to have more then four and less then 21 characters
		
		if((strlen($nick)<4) or (strlen($nick)>20)) {
			
			//$flag=false;
			$_SESSION["error_nick1"] = "<p>Nick: Musi posiadać minimum sześć i maksymalnie 20 znaków.</p>"; //error message
			$_SESSION["all_errors"] .= $_SESSION["error_nick1"]; //collecting error messages
		}
		
		//only alphanumerick signs in nick
		
		if(!ctype_alnum($nick)) {
			
			//$flag=false;
			$_SESSION["error_nick2"] = "<p>Nick: Tylko cyfry i litery, bez polskich znaków</p>"; //error message
			$_SESSION["all_errors"] .= $_SESSION["error_nick2"];//collecting error messages
		}
		
		//sanitizing email and checking if it's a valid email adress
		
		$sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if((filter_var($sanitized_email, FILTER_VALIDATE_EMAIL)==false) or ($email!=$sanitized_email)){
			
			//$flag=false;
			$_SESSION["error_email"] = "<p>Email: Podaj poprawny adres email</p>"; //error message
			$_SESSION["all_errors"] .= $_SESSION["error_email"]; //collecting error messages
		}
		
		//password needs to be longer theen 5 and less then 21 characters
		
		if((strlen($password)<6) or (strlen($nick)>20)) {
			
			//$flag=false;
			$_SESSION["error_password"] = "<p>Hasło: Miniumum sześć i maksymalnie dwadzieścia znaków</p>"; //error message
			$_SESSION["all_errors"] .= $_SESSION["error_password"]; //collecting error messages
		}
		
		//$password2 = "ąsdf";
		//echo $password ."<br/>";
		//echo $password2 ."<br/>";
		
		//checking if passwords are equal
		
		if(strcmp($password, $password2) !== 0) {
			
			//$flag=false;
			$_SESSION["error_password2"] = "<p>Hasło: Hasła nie są identyczne</p>"; //error message
			$_SESSION["all_errors"] .= $_SESSION["error_password2"]; //collecting error messages
		}
		
		//hashing password 
		$hashedPassword = password_hash($password,PASSWORD_DEFAULT);
		//print_r($_POST);
		
		if(!array_key_exists("terms",$_POST)) {
			
			//$flag=false; 
			$_SESSION["error_terms"] = "<p>Warunki: Musisz zaakceptować warunki serwisu</p>"; //error message
			$_SESSION["all_errors"] .= $_SESSION["error_terms"]; //collecting error messages
			
		}
		
		//checking if all errors is not equal to empty string and printing it when it is not, also exiting the script
		
		if($_SESSION["all_errors"]!="") {
			
			$_SESSION["all_errors"] = "<p class='phperror'>W twoim formularzu występują błędy:</p>".$_SESSION["all_errors"]; //error message
			echo $_SESSION["all_errors"];
			
			//print_r($_SESSION);
			
			header("Location: register.php");
			exit();
		}
	
	//starting database connection if everything is ok
	
	include("../database/connect.php");
	//exceptions 
	mysqli_report(MYSQLI_REPORT_STRICT);
		
		//starting try
		try{
			
			//establishing connection
			$link = new mysqli($host, $user, $password, $database);
			
			if($link -> connect_errno != 0) { //checking if we have a connection
				
				throw new Exception($link -> error);//
				
			}
			
			else {
				include_once("functions.php");
				
				$email = $link -> real_escape_string($email); //securing email
				$nick = $link -> real_escape_string($nick); //securing nick
				
				$row = checkUser($link,"email", $email); //checking if email exists in database my function
				//if it does
				if($row>0) {
					
					$_SESSION["email_used"] = "<p> Podany email istnieje już w naszej bazie, użyj innego lub zaloguj się na swoje konto. </p>"; //error message
					$_SESSION["db_errors"] .= $_SESSION["email_used"]; //collecting error messages
					
				}
				
				$row = checkUser($link,"nick", $nick); //checking if nick exists my function
				//if it does
				if($row>0) {
					
					$_SESSION["nick_used"] = "<p> Podany nick istnieje już w naszej bazie, użyj innego lub zaloguj się na swoje konto. </p>";//error message
					$_SESSION["db_errors"] .= $_SESSION["nick_used"]; //collecting error messages
					
					
					
				}
				//if ther are db errors printing them on the screen and closing connection
				if($_SESSION["db_errors"]!=""){
					
					$_SESSION["db_errors"] = "<div class='phperror'>W twoim formularu wystąpiły błędy:".$_SESSION["db_errors"]."</div>";
					
					//echo $_SESSION["db_errors"];
					
					
					header("Location: ../../index.php");
					$link -> close();
					exit();
					
				}
				
				
				//if everything is ok printing success message and closing connection
				else {
					
					if($link -> query("INSERT INTO users VALUES(NULL, '$nick', '$email', '$hashedPassword')")) {
						
						$_SESSION["ok"] = "<p id='phpok'> Udało Ci się założyć konto, możesz się już zalogować. </p>";//succes message
						header("Location: ../../index.php");
						$link -> close();
						exit();
					
					}
					//if something wrong
					else{
						
						throw new Exception($link -> error);
					}
					
					
					
					}
				
			}
		
		}
		
		catch(Exception $e){
			
			echo "Maintenance in progress. Please try again later.";
			
		}
		
		
		//echo "wszystko ok";
		
		
		$link -> close();
	}
//if there are no nick and email, going to register.php
else {
	header("Location: ../../index.php");
}










?>