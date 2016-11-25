<?php

session_start();

if((isset($_SESSION["login"])) and ($_SESSION["login"]!='')) {

		include_once("connect.php"); 
	
		try {
			
		$link = new mysqli($host, $user, $password, $database);

			if($link -> connect_errno !=0){
			
			throw new Exception($link -> error);
				
			}

			include_once("functions.php");
			$id=$_SESSION["id"];

			
			$table = receivingIncome($id);
			
		
			$creditsTable = onLoadTable("loans");
		
			$totalLoans = getSum("payment", "loans",$id);
		
			$mpayTable = onLoadTable("mpay");
		
			$totalMpay = getSum("payment", "mpay", $id);
		
			$lifeTable = onLoadTable("life");
		
			$totalLife = getSum("payment", "life", $id);
		

		}
	
		catch(Exception $e) {
		
		echo "Maintenance in progress. Please try again later.";
		
		}

		$link -> close();
}

else {
	
	header("Location: register.php");
}

if(isset($_GET["logout"])) {
	
	session_unset();
	header("Location: register.php");
}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	
	<title>Budżet domowy</title>
	
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/stylemain.css"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
	<script type="text/javascript" src="jquery-3.1.1.min.js"></script>
	<script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="js/mainscript.js"></script>

	



</head>

<body>
<div class="container-fluid">

<div class="row">
<header class="col-md-12">
	<span class="logout">Jesteś zalogowany jako <?php  echo $_SESSION["login"] ?>   	
	<form style="display:inline" method="get">
		<button type="submit" name="logout" class="btn btn-secondary btn-sm">Wyloguj</button>
	</form>
	</span>

	<h1 class="display-3">Budżet Domowy</h1>
	<h4>Zaplanuj swój domowy budżet</h4>

</header>
</div>


<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#tabIncome" role="tab" aria-controls="home">Przychody</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#tabCredits" role="tab" aria-controls="profile">Kredyty</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#tabMpay" role="tab" aria-controls="messages">Koszty stałe</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#tabLife" role="tab" aria-controls="settings">Koszty zmienne</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#tabSummary" role="tab" aria-controls="settings" id="chartDrawer">Podsumowanie</a>
  </li>
</ul>

<div class="tab-content">
<div class="tab-pane fade in active" id="tabIncome" role="tabpanel">
	<main class="row">
		<section id="firstSection" class="col-md-12">
			<div id="incomeSource">
				<p>Wybierz ilość źródeł dochodu i uzupełnij tabelę</p>
				<div class="howMany"><span>Ile źródeł?</span></div>
				<select name="select" id="income" class="form-control">
					<option value="0">Wybierz</option> 
					<option value="1">1</option> 
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<div id="output"></div>
				<button id="incomeSubmit" disabled="disabled" class="disabled btn btn-primary">Save</button>
				<button id="confirmChange" class="changes btn btn-primary" disabled="disabled" >Confirm</button>
				<button id="cancelChange" class="changes btn btn-warning">Cancel</button>
			</div>
		</section>
	</main>
	<main id="incomeSummary" class="row">
		<div id="saveIncome" class="col-md-6">
			<div id="incomeTable" <?php if((isset($table)) and ($table!='')) echo "class='divTable'";?>>
				<?php 
				if((isset($table)) and ($table!='')) echo $table;
				?>
			</div>
			<button id="editButton" class="btn btn-primary">Edit</button>
		</div>
		<div id="incomeCharts" class="col-md-6">
			<div id="chart_div"></div>
		</div>
	</main>
</div>
<div class="tab-pane fade" id="tabCredits" role="tabpanel">
	<main class="row">
		<section class="costs set col-md-6">
			<div><h1>Kredyty</h1></div>
			<span>Czy chcesz dodać kredyt lub inne zobowiązania bankowe?</span>
			<div class="yesno">
				<label><input type="radio" value="yes" name="credits" id="creditsYes"/>Tak</label>
				<label><input type="radio" value="no" name="credits" id="creditsNo"/>Nie</label>
			</div>
			<div id="loans" class="withSpan">
				<select name="select" class="list form-control">
					<option selected value="0" >Wybierz</option> 
					<option value="Mortgage" name="Mortgage">Hipoteka</option> 
					<option value="Retail">Gotówkowy</option>
					<option value="Card">Karta Kredytowa</option>
					<option value="Debit">Limit w Koncie</option>
					<option value="Other">Inne</option>
				</select>
				<button class="end btn btn-secondary">Zakończ</button>
				<button class="add btn btn-primary" disabled="disabled">Dodaj</button>
			</div>
			<div  class="show"></div>
		</section>
		<section  class="costs receive col-md-6">
			<div  class="divCosts">
				<table  class="costsT table-bordered table-sm table-hover <?php if((isset($creditsTable)) and ($creditsTable!='')) echo 'table';?>" id="loansCosts">
					<thead class="thead-inverse">
						<tr>
							<th>Rodzaj</th>
							<th>Kwota</th>
							<th class="hidden">id</th>
							<th class="payHead">Usuń</th>
						</tr>
					</thead>
					<?php 
					if((isset($creditsTable)) and ($creditsTable!='')) echo $creditsTable;
					?>
				</table>
				<button  class="edit btn btn-primary">Edytuj</button>
				<button  class="cancel btn btn-primary">Zakończ</button>
				<button  class="delCheck btn btn-warning">Usuń Zaznaczone</button>
				<div class="sum" id="sumCredits">
					<?php 
					if((isset($totalLoans)) and ($totalLoans!='')) echo $totalLoans;
					?>	
				</div>
			</div>
		</section>
	</main>
 </div>
<div class="tab-pane fade" id="tabMpay" role="tabpanel">
	<main class="row"> 
		<section class="costs set col-md-6">
			<div><h1>Koszty stałe</h1></div>
			<span>Czy chcesz dodać inną niż kredytową stałą miesięczną płatność?</span>
			<div class="yesno">
				<label><input type="radio" value="yes" name="monthly" id="monthlyYes"/>Tak</label>
				<label><input type="radio" value="no" name="monthly" id="monthlyNo"/>Nie</label>
			</div>
			<div id="mpay" class="withSpan">
				<select name="select" id="monthlyList" class="form-control">
					<option selected value="0" >Wybierz</option> 
					<option value="ren">Czynsz</option> 
					<option value="ele">Prąd</option>
					<option value="gaz">Gaz</option>
					<option value="wat">Woda</option>
					<option value="mob">Telefon</option>
					<option value="int">Internet</option>
					<option value="tv">Telewizja</option>
					<option value="sch">Szkoła</option>
					<option value="kin">Przedszkole</option>
					<option value="ins">Ubezpieczenie</option>
					<option value="inn">Inne</option>
				</select>
				<button  class="end btn btn-secondary">Zakończ</button>
				<button  class="add btn btn-primary"  disabled="disabled">Dodaj</button>
			</div>
			<div  class="show"></div>
		</section>
		<section  class="costs receive col-md-6">
			<div  class="divCosts">
				<table  class="costsT table-bordered table-sm table-hover <?php if((isset($mpayTable)) and ($mpayTable!='')) echo 'table';?>" id="mpayCosts">
					<thead class="thead-inverse">
						<tr>
							<th>Rodzaj</th>
							<th>Kwota</th>
							<th class="hidden">id</th>
							<th class="payHead">Usuń</th>
						</tr>
					</thead>
						<?php 
						if((isset($mpayTable)) and ($mpayTable!='')) echo $mpayTable;
						?>
				</table>
				<button  class="edit btn btn-primary">Edytuj</button>
				<button  class="cancel btn btn-primary">Zakończ</button>
				<button  class="delCheck btn btn-warning">Usuń Zaznaczone</button>
				<div class="sum" id="sumMpay">
				<?php 
				if((isset($totalMpay)) and ($totalMpay!='')) echo $totalMpay;
				?>	
				</div>
			</div>
		</section>
	</main>
 </div>
<div class="tab-pane fade" id="tabLife" role="tabpanel">
	<main class="row">
		<section  class="costs set col-md-6">
			<div><h1>Koszty zmienne</h1></div>
			<span>Czy chcesz dodać nieregularny miesięczny wydatek?</span>
			<div  class="yesno">
				<label><input type="radio" value="yes" name="monthly" id="monthlyYes"/>Tak</label>
				<label><input type="radio" value="no" name="monthly" id="monthlyNo"/>Nie</label>
			</div>
			<div id="life" class="withSpan">
				<select name="select" id="monthlyList" class="form-control">
					<option selected value="0" >Wybierz</option> 
					<option value="foo">Jedzenie</option> 
					<option value="che">Chemia</option>
					<option value="fue">Paliwo</option>
					<option value="gar">Ogród</option>
					<option value="hom">Dom</option>
					<option value="rtv">RTV/AGD</option>
					<option value="iot">Inne</option>
				</select>
				<button  class="end btn btn btn-secondary">Zakończ</button>
				<button  class="add btn btn btn-primary"  disabled="disabled">Dodaj</button>
			</div>
			<div  class="show"></div>
			</section>
		<section  class="costs receive col-md-6">
			<div  class="divCosts">
				<table  class="costsT table-bordered table-sm table-hover <?php if((isset($lifeTable)) and ($lifeTable!='')) echo 'table';?>" id="lifeCosts">
					<thead class="thead-inverse">
						<tr>
							<th>Rodzaj</th>
							<th>Kwota</th>
							<th class="hidden">id</th>
							<th class="payHead">Usuń</th>
						</tr>
					</thead>
						<?php 
						if((isset($lifeTable)) and ($lifeTable!='')) echo $lifeTable;
						?>
				</table>
				<button  class="edit btn btn-primary">Edytuj</button>
				<button  class="cancel btn btn-primary">Zakończ</button>
				<button  class="delCheck btn btn-warning">Usuń Zaznaczone</button>
				<div class="sum" id="sumLife">
					<?php 
					if((isset($totalLife)) and ($totalLife!='')) echo $totalLife;
					?>	
				</div>
			</div>
		</section>
	</main>
</div>

<div class="tab-pane fade" id="tabSummary" role="tabpanel">
	
	<main class="row">
		<!--<div class="mode"><img src="loader.gif" alt="loader"/></div>-->
		<section class="col-md-12">
			<div class="col-md-4">
			Róznica przychodu i kosztów: <span id="incomeMinusCosts"></span>
			</div>
			<div class="col-md-8">
			<div id="firstSumChart"></div>
			</div>
		</section>
	</main>
	<main class="row">
		<section class="summary sumData col-md-12">
				<div class="col-md-4 sumTable">
					<table class="table table-bordered table-sm table-hover">
						<thead class="thead-inverse" >
							<tr>
								<th>Pozycja</th>
								<th>Wartość</th>
							</tr>
						</thead>
							<tr>
								<td>Przychód całkowity</td>
								<td id="summaryIncome"></td>
							</tr>
							<tr>
								<td>Raty kredytów</td>
								<td id="summaryCredits"></td>
							</tr>
							<tr>
								<td>Koszty stałe</td>
							<td id="summaryMpay"></td>
							</tr>
							<tr>
								<td>Koszty zmienne</td>
								<td id="summaryLife"></td>
							</tr>
							<tr>
								<td>Koszt całkowity</td>
								<td id="allCosts"></td>
							</tr>
						</table>
					</div>
				<div id="secondSumChart" class="col-md-8"></div>
		</section>
	</main>
	<main class="row">
		<section class="summary sumCharts col-md-12 row">
			<div id="getIncomeVal" class="col-md-4 sumTable <?php if((isset($table)) and ($table!='')) echo 'divTable';?>">
				<?php 
				if((isset($table)) and ($table!='')) echo $table;
				?>
			</div>
				<div id="thirdSumChart" class="col-md-8"></div>
		</section>
	</main>	
	
	<main class="row">
			<section class="summary sumData col-md-12 row ">
				<div class="col-md-4 sumTable">
					<table class="table table-bordered table-sm table-hover">
						<thead class="thead-inverse" >
							<tr>
								<th>Pozycja</th>
								<th>Udział w kosztach</th>
							</tr>
						</thead>
							<tr>
								<td>Kredyty </td>
								<td id="creditsToCosts"></td>
							</tr>
							<tr>
								<td>Koszty stałe</td>
								<td id="mpayToCosts"></td>
							</tr>
							<tr>
								<td>Koszty zmienne</td>
								<td id="lifeToCosts"></td>
							</tr>
						</table>
					</div>
					<div id="fourthSumChart" class="col-md-8"></div>
				</section>
			</main>
</div>
</div>

<div class="row">
<footer class="col-md-12">
	<div id="contactUs" class="text-md-center">
		<span> 
			<a href="mailto:hedrzak.marcin@gmail.com">Skontaktuj się z nami</a>  
		</span>
	</div>
	<div id="version">
		<span >
			&copy Hemmar, "Home Budget" Ver. 1.01
		</span>
</div>
</footer>
</div>
</div>

</body>
</html>