<main>
<section class="costs set">
	<div><h1>Kredyty</h1></div>
	<span>Czy posiadasz kredyty?</span>
	<div class="yesno">
	<label><input type="radio" value="yes" name="credits" id="creditsYes"/>Tak</label>
	<label><input type="radio" value="no" name="credits" id="creditsNo"/>Nie</label>
	</div>
	<div id="loans" class="withSpan">
	<span>Dodaj koszt</span>
	<select name="select" class="list">
		<option selected value="0" >Select</option> 
		<option value="Mortgage" name="Mortgage">Hipoteka</option> 
		<option value="Retail">Gotówkowy</option>
		<option value="Card">Karta Kredytowa</option>
		<option value="Debit">Limit w Koncie</option>
		<option value="Other">Inne</option>
		</select>
	<button class="end">Zakończ</button>
	<button class="add" disabled="disabled">Dodaj kredyt</button>
	</div>
	<div  class="show"></div>
</section>

<section  class="costs receive">
	<div  class="divCosts">
		<table  class="costsT table-bordered table-sm table-hover <?php if((isset($creditsTable)) and ($creditsTable!='')) echo 'table';?>" id="loansCosts">
			<thead "thead-inverse">
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
	<button  class="edit">Edytuj</button>
	<button  class="cancel">Zakończ</button>
	<button  class="delCheck">Usuń Zaznaczone</button>
		<div class="sum" id="sumCredits">
			<?php 
			if((isset($totalLoans)) and ($totalLoans!='')) echo $totalLoans;
			?>	
		</div>
	</div>
</section>

</main>

<main>
<section class="costs set">
	<div><h1>Koszty stałe</h1></div>
	<span>Czy inne miesięczne płatności?</span>
	<div class="yesno">
	<label><input type="radio" value="yes" name="monthly" id="monthlyYes"/>Tak</label>
	<label><input type="radio" value="no" name="monthly" id="monthlyNo"/>Nie</label>
	</div>
	<div id="mpay" class="withSpan">
	<span>Dodaj koszt</span>
	<select name="select" id="monthlyList">
		<option selected value="0" >Select</option> 
		<option value="ren" name="Mortgage">Czynsz</option> 
		<option value="ele">Prąd</option>
		<option value="gaz">Gaz</option>
		<option value="wat">Woda</option>
		<option value="mob">Telefon</option>
		<option value="int">Internet</option>
		<option value="inn">Inne</option>
		</select>
	<button  class="end">Zakończ</button>
	<button  class="add"  disabled="disabled">Dodaj kredyt</button>
	</div>
	<div  class="show"></div>
</section>

<section  class="costs receive">
	<div  class="divCosts">
		<table  class="costsT table-bordered table-sm table-hover <?php if((isset($mpayTable)) and ($mpayTable!='')) echo 'table';?>" id="mpayCosts">
			<thead "thead-inverse">
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
	<button  class="edit">Edytuj</button>
	<button  class="cancel">Zakończ</button>
	<button  class="delCheck">Usuń Zaznaczone</button>
			<div class="sum" id="sumMpay">
			<?php 
			if((isset($totalMpay)) and ($totalMpay!='')) echo $totalMpay;
			?>	
		</div>
	</div>
</section>
</main>


<main>

<section  class="costs set">
<div><h1>Koszty zmienne</h1></div>
<span>Czy inne miesięczne płatności?</span>
	<div  class="yesno">
	<label><input type="radio" value="yes" name="monthly" id="monthlyYes"/>Tak</label>
	<label><input type="radio" value="no" name="monthly" id="monthlyNo"/>Nie</label>
	</div>
	<div id="life" class="withSpan">
	<span>Dodaj koszt</span>
	<select name="select" id="monthlyList">
		<option selected value="0" >Select</option> 
		<option value="foo" name="Mortgage">Jedzenie</option> 
		<option value="che">Chemia</option>
		<option value="fue">Paliwo</option>
		<option value="gar">Ogród</option>
		<option value="hom">Dom</option>
		<option value="rtv">RTV/AGD</option>
		<option value="iot">Inne</option>
		</select>
	<button  class="end">Zakończ</button>
	<button  class="add"  disabled="disabled">Dodaj kredyt</button>
	</div>
	<div  class="show"></div>
</section>

<section  class="costs receive">
	<div  class="divCosts">
		<table  class="costsT table-bordered table-sm table-hover <?php if((isset($lifeTable)) and ($lifeTable!='')) echo 'table';?>" id="lifeCosts">
			<thead "thead-inverse">
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
	<button  class="edit">Edytuj</button>
	<button  class="cancel">Zakończ</button>
	<button  class="delCheck">Usuń Zaznaczone</button>
		<div class="sum" id="sumLife">
		<?php 
		if((isset($totalLife)) and ($totalLife!='')) echo $totalLife;
		?>	
		</div>
	</div>
</section>

</main>

<main>
<section class="summary sumData">
	<article><h2>Sumy</h2>
		<div>Total income: <span id="summaryIncome"></span></div>
		<div>Total credits: <span id="summaryCredits"></span></div>
		<div>Total monthly: <span id="summaryMpay"></span></div>
		<div>Total life: <span id="summaryLife"></span></div>
		<div>Total costs: <span id="allCosts"></span></div>
	</article>
</section>
<section class="summary sumCharts">
	<article><h2>Koszty do przychodu</h2>
		<div>Credits to Income: <span id="creditsToIncome"></span></div>
		<div>Monthly to income: <span id="mpayToIncome"></span></div>
		<div>Fixed to income: <span id="fixedToIncome"></span></div>
		<div>Life to income: <span id="lifeToIncome"></span></div>
		<div>Costs to income: <span id="costToIncome"></span></div>
		<div>Difference: <span id="incomeMinusCosts"></span></div>
	</article>
	<article><h2>Struktura Kosztów</h2></article>
		<div>Credits to Costs: <span id="creditsToCosts"></span></div>
		<div>Mpay to Costs: <span id="mpayToCosts"></span></div>
		<div>Fixed to Costs: <span id="fixedToCosts"></span></div>
		<div>Life to Costs: <span id="lifeToCosts"></span></div>
	</article>


</section>


</main>

</div>
