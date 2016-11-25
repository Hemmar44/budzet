<?php

session_start();

if(isset($_SESSION["con_error"])) {echo["con_error"];}
//$_SESSION["ok"] ='';
?>




<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	
	<title>Budzet domowy - rejestracja</title>
	
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
	<script type="text/javascript" src="jquery-3.1.1.min.js"></script>
	<script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="script.js"></script>

	
</style>


</head>

<body>
<noscript><p style="color:red">This page needs Javascript enabled to work properly.</p></noscript>
<section class="container-fluid">
	<div class="col-md-12 text-md-center start" >
	<h1>Zaplanuj swój domowy budżet </h1>

	<div id="addAccount">Nie masz jeszcze konta? <span id="popUp">Załóż je tutaj.</span></div>
	
	
	</div>
		


	<form action="login.php" method="post">
		<?php //if((array_key_exists("ok",$_SESSION)) and ($_SESSION["ok"] !='')) {
		if(isset($_SESSION["ok"])){
		echo "<div class='alert alert-success col-md-6 offset-md-3 text-md-center' role='alert'>".$_SESSION["ok"]."</div>"; 
		unset ($_SESSION["ok"]);
		}
		?>
		<?php
		if(isset($_SESSION["log_error"])){
		echo "<div class='alert alert-danger col-md-6 offset-md-3 text-md-center' role='alert'>". $_SESSION["log_error"]."</div>" ; 
		unset ($_SESSION["log_error"]);
		}
		
		?>
		
	<div class="form-group row">
      <label for="logInput1" class="col-md-1 offset-md-4 col-form-label text-md-right">Nick:</label>
      <div class="col-md-3">
        <input type="text" class="form-control" id="logInput1" placeholder="Nick" name="login"/>
      </div>
    </div>
    <div class="form-group row">
      <label for="logInput" class="col-md-1 offset-md-4 col-form-label text-md-right">Hasło:</label>
      <div class="col-md-3">
        <input type="password" class="form-control" id="logInput2" placeholder="Hasło" name="pass"/>
      </div>
    </div>
	<div class="text-md-center logButton">
		<input type="submit" class="btn btn-primary" value="Zaloguj" />
	</div>
	</form>
</section>

<div class="register disappear card col-md-6 offset-md-3">

	<div class="closePopUp">       
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
	</div>
	
	<form method="post" action="verify.php">
	<h5 class="text-md-center">Wypełnij wszystkie pola, żeby się zarejestrować.</h5>

		
	<!--<div class="form-group row">
      <label for="logInput1" class="col-md-1 offset-md-4 col-form-label text-md-right">Nick:</label>
      <div class="col-md-3">
        <input type="text" class="form-control" id="logInput1" placeholder="Nick" name="login"/>
      </div>
    </div>-->
		
		
		<div class="inputDiv form-group row">
			<div class="fixHeight">
						<?php 
						if((isset($_SESSION["all_errors"])) and ($_SESSION["all_errors"]!='')) { 
						echo "<div class='alert alert-danger col-md-10 offset-md-1 text-md-center' role='alert'>".$_SESSION["all_errors"]."</div>";
						unset($_SESSION["all_errors"]);
						}
		
						if((isset($_SESSION["db_errors"])) and ($_SESSION["db_errors"]!='')) {
						echo "<div class='alert alert-danger col-md-10 offset-md-1 text-md-center' role='alert'>".$_SESSION["db_errors"]."</div>";
						unset($_SESSION["db_errors"]);
						}
						?>
				<div id="regError" class="alert alert-warning text-md-center col-md-10 offset-md-1" role="alert">

				</div>
			</div>
			<label for="nick" class="col-form-label col-md-1 offset-md-1 text-md-right">Nick:</label>
		<div class="col-md-9">
			<input type="text" name="nick" id="nick" class="form-control" placeholder="Nick"/>
		</div>
		</div>
		
		<div class="inputDiv form-group row">
			<label for="email" class="col-form-label col-md-2 text-md-right">E-mail:</label>
			<div class="col-md-9">
			<input type="text" name="email" id="email"  class="form-control" placeholder="email" disabled="disabled"/>
			</div>
		</div>
		<div class="inputDiv form-group row">
			<label for="password1" class="col-form-label col-md-2  text-md-right">Password:</label>
			<div class="col-md-9">
			<input type="password" name="password1" id="password1" class="form-control" disabled="disabled" placeholder="password"/>
			</div>
		</div>
		<div class="inputDiv form-group row">
			<label for="password2" class="col-form-label col-md-2 text-md-right">Repeat:</label>
			<div class="col-md-9">
			<input type="password" name="password2" id="password2" class="form-control" disabled="disabled" placeholder="repeat password"/>
			</div>
		</div>
		
		<div class="form-group row text-md-center">
			<input type="checkbox" name="terms" id="terms" disabled="disabled"/>
			<label for="terms">Accept <span id="termsPopUp">terms of use</span></label>
		</div>
		<div class="text-md-center regButton">
		<input type="submit" value="Register" disabled="disabled"  class="btn btn-primary"/>
		</div>
	</form>
</div>

<div id="termsOfUse" class="disappear col-md-10 offset-md-1 card">
	<div class="closePopUp">		
		 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		 </button>
	</div>
<br/><br/>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque eu congue sem. Donec eget dictum diam. Aliquam in lorem eu lorem accumsan molestie ut in mauris. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla facilisi. Mauris sit amet tortor tincidunt, rhoncus ex in, elementum orci. Maecenas libero ipsum, imperdiet vitae laoreet at, vehicula eu odio. Cras mollis mollis nunc, at aliquet ipsum malesuada vitae. Morbi consectetur ultricies mauris. Ut pellentesque porttitor elementum. Suspendisse sollicitudin nisl sit amet sapien varius malesuada. Morbi consequat velit a metus bibendum laoreet.<br/><br/>

In pretium orci eget tellus volutpat, vel rhoncus ante auctor. Duis id nunc sapien. Praesent posuere metus et felis aliquet, at imperdiet felis maximus. Curabitur non enim vitae tellus tincidunt ultrices id sed velit. Proin ullamcorper arcu vestibulum faucibus feugiat. Praesent ut molestie diam. Quisque finibus ultricies risus congue blandit. Etiam feugiat purus mauris, sit amet condimentum ipsum molestie eu. Proin imperdiet vitae erat sed iaculis. Donec pharetra ex ligula, vel condimentum nisl viverra quis. Duis ac nisi non elit vehicula tempor vitae vitae enim. Duis fringilla malesuada metus, quis fringilla felis tempor sed. Nam enim magna, tempus sit amet sapien ultricies, rutrum mollis ante. Integer ornare justo sed purus egestas finibus. Nam dolor nulla, accumsan ac mauris non, eleifend tempus ligula. Fusce eget massa mauris.
<br/><br/>

Quisque congue lectus rhoncus nunc lacinia, ut rutrum arcu consectetur. Quisque luctus nec augue a pellentesque. Quisque vehicula in diam sed hendrerit. Donec cursus suscipit tempor. Cras a arcu consectetur, bibendum risus et, dignissim dui. Nam nec tellus tortor. Donec id augue a nisl tempus imperdiet ut et purus. Praesent in feugiat ipsum. Sed in nisi in dolor pretium euismod ac sit amet quam. Proin maximus metus arcu, ut aliquet leo convallis eget. Donec euismod at lectus id porta. Duis quis placerat massa. Pellentesque ut tincidunt sapien, posuere vehicula felis. Ut maximus augue quis malesuada eleifend.
<br/><br/>
Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. In pretium, nibh nec bibendum sodales, justo nibh gravida ligula, ac tristique orci est a turpis. Ut at turpis sapien. Praesent pellentesque et turpis vitae volutpat. Morbi in risus a tortor lacinia imperdiet. Sed a eros ut urna aliquet tempus. Donec tristique arcu quis purus iaculis placerat. Praesent vitae interdum lectus. Vestibulum viverra venenatis maximus. Morbi id malesuada est, bibendum ultricies justo. Suspendisse semper mi quis neque fermentum, in euismod mauris scelerisque. Donec vel ultricies mauris. Aliquam a condimentum libero. Integer id aliquam massa. Nunc pulvinar risus in turpis varius ullamcorper.
<br/><br/>

Quisque vulputate urna tincidunt vehicula lobortis. In sit amet tempus sapien. Donec id diam at metus commodo dapibus. Morbi dui diam, tempor in enim ut, consequat luctus elit. Quisque viverra velit malesuada magna tincidunt lacinia. Nam vel vestibulum erat. Curabitur accumsan nibh erat, eu auctor sem consectetur ut. Nullam aliquet nunc ac metus fringilla placerat. Etiam sed enim consequat, tempor ligula quis, luctus nulla. Integer ligula orci, ornare cursus mollis non, vulputate quis massa. Vestibulum hendrerit arcu posuere ipsum semper varius. Maecenas finibus risus nisl, id gravida mauris commodo eget.
<br/><br/>

Etiam et nibh a odio porttitor finibus. Integer sem leo, semper at lacinia nec, bibendum nec sapien. Ut cursus sapien nunc, non ullamcorper ipsum pretium vitae. Fusce id ultricies diam, vel imperdiet augue. Vivamus vel turpis tempor, elementum nisl ac, tempus risus. Nam sed efficitur magna. Praesent condimentum elit eget eleifend ultrices. In pretium, turpis non venenatis laoreet, sapien lorem cursus quam, a vestibulum diam enim eget augue. Donec efficitur convallis sem nec tempor. Nunc in faucibus arcu. Sed non urna vitae sem laoreet viverra. Donec semper mattis sem, non viverra odio pharetra at.
<br/><br/>
In volutpat nibh eget mi interdum, vitae tempor nisi viverra. Aliquam pulvinar sodales sapien, tempus blandit nisl consequat a. Phasellus quis mi feugiat, tincidunt quam in, mollis lorem. Praesent ullamcorper orci dolor, sit amet pretium quam malesuada sed. Ut imperdiet feugiat ipsum sit amet tincidunt. Quisque imperdiet, velit sed malesuada ultrices, massa erat varius nisl, et sagittis lorem erat sit amet turpis. Pellentesque at magna a odio pharetra scelerisque.
<br/><br/>
Proin maximus elementum aliquam. Sed venenatis porttitor lacus. Nam tellus augue, posuere a purus non, placerat efficitur ante. Cras ornare eros sapien, et vulputate nulla interdum sed. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc lacinia tortor eros, quis aliquam velit finibus molestie. Ut pellentesque rutrum odio, sed porttitor augue sodales id.
<br/><br/>
			<nav class="text-md-center">
			<button id="termsResign" class="btn btn-danger">Resign</button>
			<button id="termsBack" class="btn btn-primary">Back</button>
			</nav>

</div>

</body>
</html>