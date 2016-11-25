<?php

//include_once("connect.php");

//$link = new mysqli($host, $user, $password, $database);
//checking if email or nick exists. used in verify.php
function checkUser($link, $data, $user) {
	
	$result = $link -> query("SELECT id FROM users WHERE $data = '$user' ");
	
	if(!$result) {
		
		 throw new Exception($link -> error);
		
		}
		
	else {
		
		return $how_many = $result -> num_rows;
		
		
	}
	
}


	
function tableDrawer($result) {
			$rowAmount = $result -> num_rows;
			$table='';
			for($j=1; $j<=$rowAmount; $j++) {
			$row = $result -> fetch_assoc();
			$table .= "<tr><td class='savedSources'>".$row["source"]."</td><td class='savedValues'>".$row["value"]."</td></tr>";
			}
			
			return $table; 
	}

function costTableDrawer($result, $value1, $value2, $value3, $class1, $class2 ) {
			$rowAmount = $result -> num_rows;
			$table='';
			for($j=1; $j<=$rowAmount; $j++) {
			$row = $result -> fetch_assoc();
			$table .= "<tr><td><input type='text' disabled='disabled' value='".$row[$value1]."'/></td><td ><input type='text' disabled='disabled' class='".$class1."' value='".$row[$value2]."' /><td class='".$class2."'><input type='text' disabled='disabled' value='".$row[$value3]."' /></td><td class='deleteCheckbox'><input type='checkbox'/></td></tr>";
			}
			
			return $table; 
	}
	
function tableDrawerImp($value1, $value2, $klass) {
		
		$table ='';
		//"<table><th>Source</th><th>Value</th>"
			
			$table ="<tr><td><input type='text' disabled='disabled' value='".$value1."'/></td><td><input type='text' disabled='disabled' value='".$value2."' class='".$klass."'/></td><td class='deleteCheckbox' style='display:none'><input type='checkbox' style='border:none' /></td></tr>";
			
			//"<tr><td><input type='text'/></td><td><input type='text'/></td>";

		
		return $table;
	}
	


function onLoadTable($tableName) {
			
			include("../database/connect.php");

			$link = new mysqli($host, $user, $password, $database);
			
			$id = $link ->real_escape_string($_SESSION['id']);
			
			$query = "SELECT credit, payment, id FROM $tableName WHERE userid = '".$_SESSION['id']."'";
	
			
			$result = $link -> query($query);
			if(!$result) throw new Exception($link -> error);
			
			$rowAmount = $result -> num_rows;
			
			if($rowAmount >0) {
			
			$j = 1;
			
			$tableBody = costTableDrawer($result, "credit", "payment", "id", "payments", "hidden");
	
			return $tableBody;
			
			}
			
	}
			
			function oneRow($tableName) {
			
			include("../database/connect.php");

			$link = new mysqli($host, $user, $password, $database);
			
			$id = $link ->real_escape_string($_SESSION['id']);
			
			$query = "SELECT credit, payment, id FROM $tableName WHERE userid = '".$_SESSION['id']."' ORDER BY id DESC LIMIT 1";
			//$query = "SELECT source, value FROM income WHERE userid = $id";
			
			//echo $query;
			
			$result = $link -> query($query);
			if(!$result) throw new Exception($link -> error);
			
			$rowAmount = $result -> num_rows;
			
			if($rowAmount >0) {
			
			$j = 1;
			
			//$tableHeader = "<table class='costsT'><th>Rodzaj</th><th>Kwota</th>";
			$tableBody = costTableDrawer($result, "credit", "payment", "id", "payments", "hidden");
			
			//$query = "SELECT sum(payment) FROM income WHERE userid = '".$_SESSION['id']."'";
			
			//$result = $link -> query($query);
			//if(!$result) throw new Exception($link -> error);
			
			//$row = $result -> fetch_assoc();
			//$total = $row["sum(payment)"];
			//echo (is_string ($total));
			
			//$total = intval($total);
			//echo $total;
			//print_r($row);
			
			//$tableFooter = "<tr><td style='font-weight:bold' id='total'>Total</td><td style='font-weight:bold' id='totalValue'>$total</td></tr></table>";
			
			//$tableFooter="</table>";
			
			//$table = $tableHeader.$tableBody.$tableFooter;
			
			return $tableBody;
			
			}
		
		}
		
		function getSum($column, $table, $id) {
			
			include("../database/connect.php");

			$link = new mysqli($host, $user, $password, $database);
			
			if($link -> connect_errno !=0){
			
			throw new Exception($link -> error);	

			}
			//query to get sum
			$query = "SELECT sum($column) FROM $table WHERE userid = '".$id."'";
			//getting sum
			$result = $link -> query($query);
			
			if(!$result) throw new Exception($link -> error);
			//getting array
			$row = $result -> fetch_assoc();
			//getting value
			$total = $row["sum($column)"];
			//returning value
			return $total;
		}
			
		function receivingIncome($id) {
			
			include("../database/connect.php");

			$link = new mysqli($host, $user, $password, $database);
			
			if($link -> connect_errno !=0){
			
			throw new Exception($link -> error);	

			}
			
			$query = "SELECT source, value FROM income WHERE userid = '".$id."'";
			
			//geting result
			$result = $link -> query($query);
			//if something is wrong
			if(!$result) throw new Exception($link -> error);
			
			//how many result
			$rowAmount = $result -> num_rows;
			
			//if it's greater then 0;
			if($rowAmount >0) {
			
			//echo $rowAmount;
			$j = 1;
			
			$tableHeader = "<table id='savedIncomeTable' class='table-bordered table-sm	table thead-inverse table-hover'><th>Source</th><th>Value</th>";
			//using table drawer function
			$tableBody = tableDrawer($result);
			
			
			$total = getSum("value", "income", $id);
			//selecting sum 
			
			
			$tableFooter = "<tr><td style='font-weight:bold' id='total'>Total</td><td style='font-weight:bold' id='totalValue'>$total</td></tr></table>";
			//creating table
			
			$table = $tableHeader.$tableBody.$tableFooter;
			
			//sending table 
			return $table;
			
			
			}
			
		}

?>