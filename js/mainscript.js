$(function(){
		var savedSources =[];
		var savedValues = [];
		var valuesToInt = [];
		var collectSources = "";
		var collectValues = "";
		var incomeChartArray = [];
		var firstRow = ["Pozycja", "Wartość"];
		
		var totalIncome = $("#totalValue").text(); //value needet for charts

		$('#myTab a:last').addClass("disabled"); //when there is no income summary tab is disabled
		
		//after an income has been added
		
		if($("#incomeTable").hasClass("divTable")){ //checking if table has class (added with php if table exists);
		$("#incomeSource").hide();//an if it does changin div html will work on it later
		$("#editButton").show(); //showing the edit button
		$('#myTab a:last').tab('show').removeClass("disabled"); //removing disabled class from last tab
		savedSources = collectFromTable("#incomeTable  .savedSources"); //building an array from table column
		savedValues = collectFromTable("#incomeTable  .savedValues");//building an array from table column
		valuesToInt = intMaker(savedValues); //changing values to int
		var incomeValues = arrayBuilder(savedSources,valuesToInt); //building a mulidimensional array;
		incomeValues.unshift(firstRow); // adding first row to that array as it is needed in chart
		
	}

		

	//draw table with inputs when user selects number of income sources
	$("#income").on("change", function(){
		var selectedValue = $("#income option:selected").val();//how many row of that table
		var tableBegin = "<table class='table table-bordered table-sm table-hover'><thead class='thead-inverse'><th>Source</th><th>Value</th></thead>";
		var tableEnd = "</table>";
		
		if(selectedValue==0){
			$("#output").hide(); //hides table header
			$("#incomeSubmit").fadeOut(5); //fadeOut cause it's showing up again when using hide
			$("#confirmChange").attr("disabled","disabled"); 
		}
		else
			$("#output").slideDown("slow").html(tableBegin+tableDrawer(selectedValue)+tableEnd); //show and draw table
			$("#incomeSubmit").fadeIn().attr("disabled","disabled"); //show button
	});
	
	//checkin inputs for proper values onle when proper values are in user can save his income
	$("#output").on("keyup", "input.int, input.text", function() {
		
		var notNums = false; //set to false, the button must be set to disabled in html
		
		$("input.int").each(function(){
					if(!numeric($(this).val())) { //if not all values are integers notNums = true
				
					notNums=true;
					}
			});
		
		 var empty = false;

		$("input.text").each(function(){
			if ($(this).val() == '') {//if at least one empty empty = true;
                
				empty = true;
			}
		});
		//column with sources must not be epmty column with values must not be empty and be numeric
		if(notNums || empty) {
			$("#incomeSubmit").attr("disabled","disabled").addClass("disabled");
			$("#confirmChange").attr("disabled","disabled").addClass("disabled");
		}
		else {//activate button only when source is not empty and values are numeric
			$("#incomeSubmit").removeAttr("disabled","disabled").removeClass("disabled");
			$("#confirmChange").removeAttr("disabled","disabled").removeClass("disabled");
			$("#message").hide();
		}
			
	});
	
	//variables needed to collect values from tables;
	var valuesArray =[];
	var length = 0;
	var text =[];
	var amount = [];
	

	
	$("#incomeSubmit").on("click", function(){ //collecting values from imputs 
		$("#incomeSource").hide(); //changing value of div will work on it later
		$('#myTab a:last').removeClass("disabled");
		valuesArray = recievingValFromTable("input.values")
		length = valuesArray.length; 
		
		var x=0;
		var y=0;
		
		for(var i = 0; i<length; i++) {
			if(i%2==0) {
				text[x] = valuesArray[i];//even values goes to text array
				x++;
				//alert(typeof text[x])
			}
		else {
				amount[y] = valuesArray[i]; //odd values goes to values array
				y++;
			}
		}
		$.ajax({ //sending request and recivieng nice table from the server
		method: "POST",
		url: "updateincome.php",
		data: { text: text, values: amount } 
		})
		.done(function( msg ) {
		$("#incomeTable").html(msg); //setting html of that div to table from php
		});

		$("#editButton").show(); 

});


	
	$("#editButton").on("click", function(){

		$("#incomeSource").slideDown();
		$("#incomeSubmit").remove();
		$(".changes").show();
		$(this).hide();
	});
	
	$("#cancelChange").on("click", function(){
		$("#incomeSource").slideUp();
		$("#editButton").show();
	});
	
	
	$("#confirmChange").on("click", function(){
		text=[];//setting those values back to zero after first edit;
		amount = [];
		valuesArray=[];
		var x=0;
		var y=0;
		valuesArray = recievingValFromTable("input.values"); 
		length = valuesArray.length; 
		for(var i = 0; i<length; i++) {
			if(i%2==0) {
				text[x] = valuesArray[i];//even values goes to text array
				x++;
			}
		else {
				amount[y] = valuesArray[i]; //odd values goes to values array  //trying to change the type of a variable, not sure if it works
				y++;
			}
		}
		$.ajax({ //sending request and recivieng nice table from the server
		method: "POST",
		url: "editincome.php",
		data: { text: text, values: amount } 
		})
		.done(function( msg ) {
		$("#incomeTable").html(msg);
	
		});
		
		$("#incomeSource").slideUp();
		$("#editButton").show();
		

	});
	
		incomeChartArray = arrayBuilder(savedSources, valuesToInt);
		
		
	

/////////////////////////////////////////debit section//////////////////////////////////////////////////////////////////////////////////////////////////
	//var value ='';
	var creditType =''
	var payment ='';
	var sumCredits;
	var sumMpay;
	var sumLife;
	var allCosts=0;
	
	sumCredits=Number($("#sumCredits").text());
	sumMpay =Number($("#sumMpay").text());
	sumLife =Number($("#sumLife").text());
	//alert(sumCredits);
	//alert(sumMpay);
	//alert(sumLife);

	allCosts = sumCredits + sumMpay + sumLife;
	//alert(allCosts);
	
	$("#summaryIncome").text(totalIncome);
	$("#summaryCredits").text(sumCredits);
	$("#summaryMpay").text(sumMpay);
	$("#summaryLife").text(sumLife);
	$("#allCosts").text(allCosts);
	

	
	if($("#loansCosts").hasClass("table")){
	//alert($(this).attr("class");
	$("#loansCosts").show().closest("section").find(".edit").show();
	}
	if($("#mpayCosts").hasClass("table")){
	$("#mpayCosts").show().closest("section").find(".edit").show();
	}
	if($("#lifeCosts").hasClass("table")){
	$("#lifeCosts").show().closest("section").find(".edit").show();
	}
	

	//$("#endCredits").on("click", function(){
	//	$("#withSpan, #addCredit").hide();
		
	//});
	
	$(".end").on("click", function(){
	$(this).closest(".set").find(".withSpan").hide();
	$(this).next("button").hide();
	$(this).closest("section").find(".show").hide();
	});
	
	$(".yesno").on("click", "input[type='radio']:checked", function(){
		if($(this).val()=="yes"){
			//alert($(this).val())
			//$("#withSpan").show();
			$(this).closest(".set").find(".withSpan").show()
			//$("#addCredits").attr("disabled","disabled");
			$(this).closest(".set").find(".add").show().attr("disabled","disabled");
		}
		else {
			//$("#withSpan, #addCredit").hide();
			$(this).closest(".set").find(".withSpan").hide();
			$(this).closest(".set").find(".show").hide();
		}
	});
	/*
	$("#addCredits").on("click", function(){
		$("#creditsTable").show().append(tableDrawerImp(1, creditType, payment, "payments"));
		$(".payments").attr("disabled","disabled");
		$(".deleteCheckbox, #deleteChecked, #paymentHeader, #cancelCosts").hide();
		$("#creditCosts, #editCosts").show();
	});*/
	
	
	$(".add").on("click", function(){
		var main = $(this).closest("main");
		//var addRow = tableDrawerImp(1, creditType, payment, "payments");
		var name = $(this).closest("section").find(".withSpan").attr("id");
		main.find(".costsT").show();     //.append(addRow);
		main.find(".payments").attr("disabled","disabled");
		main.find(".deleteCheckbox").hide();
		main.find(".delCheck").hide();
		main.find(".payHead").hide();
		main.find(".cancel").hide();
		main.find(".divCosts").show();
		main.find(".edit").show();
	
		$.ajax({ //sending request and recivieng nice table from the server
		method: "POST",
		url: "editcosts.php",
		data: { type: creditType, values: payment, table: name},
		context: $(this),
		//var dfd = $.Deferred(),
		//promise = dfd.promise();
		})
		.done(function( msg ) {
		var data = msg.split("|");
		//alert(data);
		$(this).closest("main").find(".costsT").append(data[0]);
		var sum = $(this).closest("main").find(".sum");
		sum.html(data[1]);
		if(sum.attr("id")=="sumCredits"){
		$("#summaryCredits").html(data[1]);
		//alert("number data " + Number(data[1]))
		//alert("sumMpay " + sumMpay);
		//alert("sumLife " + sumLife);
		sumCredits = Number(data[1]);
		allCosts = sumCredits + sumMpay + sumLife;
		//alert("allCosts " + allCosts);
		$("#allCosts").text(allCosts);
		//calculations();
		//alert(allCosts);
		}
		else if (sum.attr("id")=="sumMpay"){
		$("#summaryMpay").html(data[1]);
		sumMpay = Number(data[1]);
		allCosts = sumMpay + sumCredits + sumLife;
		$("#allCosts").text(allCosts);
		//calculations();
		//alert(allCosts);
		}
		else if (sum.attr("id")=="sumLife"){
		$("#summaryLife").html(data[1]);
		sumLife = Number(data[1]);
		allCosts = sumLife + sumCredits + sumMpay;
		$("#allCosts").text(allCosts);
		//calculations();
		//alert(allCosts);
		}
		})
	});
	
	$("#loans").on("change", "select", function(){
		value = $(this).val();
		creditType= $(this).find("option:checked").text();
		//alert(value);
		var sectionShow = $(this).closest("section").find(".show").show();
		var addDisabled = $(this).closest("section").find(".add").attr("disabled","disabled");
		
		if(value=="Mortgage"){
			//$("#addCredit").show().html("<span>Hipoteka:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='rata'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="Retail") {
			//$("#addCredit").show().html("<span>Gotówkowy:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='rata'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="Card") {
			//$("#addCredit").show().html("<span>Karta kredytowa:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='rata'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="Debit") {
			//$("#addCredit").show().html("<span>Debet:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='rata'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="Other") {
			//$("#addCredit").show().html("<span>Inne:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='rata'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}				
		else {
			//addCredit").html('');
			sectionShow.html('');
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
	});
		
		$("#mpay").on("change", "select", function(){
		value = $(this).val();
		creditType= $(this).find("option:checked").text();
		//alert(value);
		var sectionShow = $(this).closest("section").find(".show").show();
		var addDisabled = $(this).closest("section").find(".add").attr("disabled","disabled");
		
		if(value=="ren"){
			//$("#addCredit").show().html("<span>Hipoteka:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="ele") {
			//$("#addCredit").show().html("<span>Gotówkowy:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="gaz") {
			//$("#addCredit").show().html("<span>Karta kredytowa:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="wat") {
			//$("#addCredit").show().html("<span>Debet:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="mob") {
			//$("#addCredit").show().html("<span>Inne:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="int") {
			//$("#addCredit").show().html("<span>Inne:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="tv") {
			//$("#addCredit").show().html("<span>Inne:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="sch") {
			//$("#addCredit").show().html("<span>Inne:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="kin") {
			//$("#addCredit").show().html("<span>Inne:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="ins") {
			//$("#addCredit").show().html("<span>Inne:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}				
		else {
			//addCredit").html('');
			sectionShow.html('');
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
	});
	
		$("#life").on("change", "select", function(){
		value = $(this).val();
		creditType= $(this).find("option:checked").text();
		var sectionShow = $(this).closest("section").find(".show").show();
		var addDisabled = $(this).closest("section").find(".add").attr("disabled","disabled");
		
		if(value=="foo"){
			//$("#addCredit").show().html("<span>Hipoteka:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="che") {
			//$("#addCredit").show().html("<span>Gotówkowy:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="fue") {
			//$("#addCredit").show().html("<span>Karta kredytowa:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="gar") {
			//$("#addCredit").show().html("<span>Debet:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="hom") {
			//$("#addCredit").show().html("<span>Inne:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="rtv") {
			//$("#addCredit").show().html("<span>Inne:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
		else if(value=="iot") {
			//$("#addCredit").show().html("<span>Inne:</span><input type='text' placeholder='rata'/>").find("input").focus();
			sectionShow.html("<input type='text' class='form-control' placeholder='kwota'/>").find("input").focus();
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}				
		else {
			//addCredit").html('');
			sectionShow.html('');
			//$("#addCredits").attr("disabled","disabled");
			addDisabled;
		}
	});
		
		
		
		$(".show").on("blur", "input", function(){
		payment = ($(this).val());
		});
	
		$(".show").on("keyup", "input", function(){
		var notNums = false; //set to false, the button must be set to disabled in html
		
		if(!numeric($(this).val())) { //if not all values are integers notNums = true
			
			notNums=true;
		}
					
		if(notNums) {
			$(this).closest("main").find(".add").attr("disabled","disabled");

		}
		
		else {
			$(this).closest("main").find(".add").removeAttr("disabled");
		}
			
		});
		
		$(".divCosts").on("keyup", "input", function(){
		var notNums = false; //set to false, the button must be set to disabled in html
	
		if(!numeric($(this).val())) { //if not all values are integers notNums = true
			
			notNums=true;
		}
					
		if(notNums) {
			$(this).closest("section").find(".cancel").attr("disabled","disabled");
		}
		
		else {
			$(this).closest("section").find(".cancel").removeAttr("disabled");
		}
			
		});
		/*
		$("#editCosts").on("click", function(){
			$(".deleteCheckbox, #deleteChecked").show();
			$(".payments").removeAttr("disabled");
			$("#paymentHeader, #cancelCosts").show();
			$(this).hide();
		});*/
		
		$(".edit").on("click", function(){
			var section = $(this).closest("section");
			var main = $(this).closest("main");
			section.find(".deleteCheckbox").show();
			section.find(".delCheck").show();
			section.find(".payHead").show();
			section.find(".cancel").show();
			section.find(".payments").removeAttr("disabled");
			//main.find(".withSpan").hide();
			//main.find(".show").hide();
			main.find(".set").find('*').attr("disabled","disabled");
			$(this).hide();
			
		});
		/*
		$("#cancelCosts").on("click", function(){
			$("#editCosts").show();
			$("#paymentHeader, #cancelCosts, .deleteCheckbox, #deleteChecked").hide();
			$(".payments").attr("disabled","disabled");
			$(this).hide();
		});
		*/
		
		$(".cancel").on("click", function(){
			var section = $(this).closest("section");
			var main = $(this).closest("main");
			section.find(".edit").show();
			section.find(".payHead").hide();
			section.find(".deleteCheckbox").hide();
			section.find(".delCheck").hide();
			section.find(".payments").attr("disabled","disabled");
			//main.find(".withSpan").show();
			//main.find(".show").show();
			main.find(".set").find('*').removeAttr("disabled","disabled");
			$(this).hide();
			
		});
		
		$(".delCheck").on("click", function(){
			var id = [];
			var name = $(this).closest("main").find(".withSpan").attr("id");
			var rows = $(this).closest("section").find(".costsT").find("tr").length;
			var checkbox = $(this).closest("div").find("input[type='checkbox']:checked");
			checkbox.closest("tr").find(".hidden").find("input").each(function(key, element){
				id[key]= $(element).val();

			})
			if(id.length === 0){
			alert("Musisz zaznaczyć przynajmniej jeden rząd");
			}
			else{
				if(confirm("Dane zostaną utracone na zawsze, jesteś pewien???")){
				rows -= id.length;
				checkbox.closest("tr").remove();
				$.ajax({ //sending request and recivieng nice table from the server
				method: "POST",
				url: "deletecosts.php",
				context: $(this),
				data: { deleteId: id, table: name }
					})
				.done(function( msg ) {
				var sum = $(this).closest("section").find(".sum")
				sum.html(msg);
				if(sum.attr("id")=="sumCredits"){
				$("#summaryCredits").html(msg);
				sumCredits =Number(msg);
				allCosts = sumCredits + sumMpay + sumLife;
				$("#allCosts").text(allCosts);
				//calculations();
				}
				else if (sum.attr("id")=="sumMpay"){
				$("#summaryMpay").html(msg);
				sumMpay =Number(msg);
				allCosts = sumCredits + sumMpay + sumLife;
				$("#allCosts").text(allCosts);
				//calculations();
				}
				else if (sum.attr("id")=="sumLife"){
				$("#summaryLife").html(msg);
				sumLife = Number(msg);
				allCosts = sumCredits + sumMpay + sumLife;
				$("#allCosts").text(allCosts);
				//calculations();
				}
				})
				
				}
				else {
					return false
				}
			}
	
			if(rows==1){
				$("#creditCosts, #paymentHeader").hide();
				$(this).closest("section").find(".divCosts").hide();
				$(this).closest("section").find(".payHead").hide();
				$(this).hide();
				$(this).closest("main").find('*').removeAttr("disabled","disabled");
				}
			
		});
		
		
		$(".costsT").on("keyup","input.payments", function(){
			var id = $(this).parent().next("td").find("input").val();
			var value = $(this).val();
			var name = $(this).closest("main").find(".withSpan").attr("id");
			$.ajax({ //sending request and recivieng nice table from the server
				method: "POST",
				url: "updatecosts.php",
				context:$(this),
				data: { updateId:id, value: value, table: name  }
				})
				.done(function( msg ) {
				var sum = $(this).closest("section").find(".sum")
				sum.html(msg);
				if(sum.attr("id")=="sumCredits"){
				$("#summaryCredits").html(msg);
				sumCredits =Number(msg);
				allCosts = sumCredits + sumMpay + sumLife;
				$("#allCosts").text(allCosts);
				//calculations();
				}
				else if (sum.attr("id")=="sumMpay"){
				$("#summaryMpay").html(msg);
				sumMpay =Number(msg);
				allCosts = sumCredits + sumMpay + sumLife;
				$("#allCosts").text(allCosts);
				//calculations();
				}
				else if (sum.attr("id")=="sumLife"){
				$("#summaryLife").html(msg);
				sumLife =Number(msg);
				allCosts = sumCredits + sumMpay + sumLife;
				$("#allCosts").text(allCosts);
				//calculations();
				}
				
				})

		});
		
		
		
		$("main").on("mouseenter", function(){
			creditType = $(this).find("option:checked").text();
			//alert(cos);
		});
		
		$('#chartDrawer').on("click", function(){
		location.reload();

		calculations();
		});
		calculations();
		//getIncomeVal
		
		/*$("#getIncomeVal > .savedSources").each(function(index, element){
		collectSources += "," + $(element).text();
			});
		savedSources = collectSources.split(",");
		savedSources.shift(); //array with sources element from stored table!;
		$("#getIncomeVal > .savedValues").each(function(index, element){
			collectValues += "," + $(element).text();
			});
		savedValues = collectValues.split(",");
		savedValues.shift();*/
		//alert(savedValues);
		//alert(savedSources);
		//valuesToInt = intMaker(savedValues);
		

///////////////////////////////////////////functions and charts/////////////////////////////////////////////////////////////////////////////////////	
		
		//function to retrieve array from table column
		function collectFromTable(location) {
		var name = [];
		$(location).each(function(index, element){ //collecting text from the income table
			name += "," + $(element).text();
			});
		name = name.split(","); //
		name.shift(); //array with sources element from stored table!;
			
		return name;
		}
		
		function recievingValFromTable(location) {
		var collect="";
		$(location).map(function(index, element){
		collect += "," + $(element).val() ;
		});
		collect = collect.split(","); //spliting values
		collect.shift(); //removing first value from array (empty string);
		return collect;
		}
		
		
		function calculations() {
	
		var creditsToIncome = (sumCredits/totalIncome*100).toFixed(2);
		var mpayToIncome = (sumMpay/totalIncome*100).toFixed(2);
		var fixedToIncome = ((sumCredits+sumMpay)/totalIncome*100).toFixed(2);
		var lifeToIncome =  (sumLife/totalIncome*100).toFixed(2);
		var costToIncome = (allCosts/totalIncome*100).toFixed(2);
		var incomeMinusCosts = totalIncome-allCosts;
		var creditsToCosts = (sumCredits/allCosts*100).toFixed(2);
		var mpayToCosts = (sumMpay/allCosts*100).toFixed(2);
		var fixedToCosts = ((sumCredits+sumMpay)/allCosts*100).toFixed(2);
		var lifeToCosts = (sumLife/allCosts*100).toFixed(2);
		/*
		if(creditsToIncome> 65 ) {
		$("#creditsToIncome").html("<span class='alert-danger'>" + creditsToIncome + " %</span>");	
		}
		else if (creditsToIncome>50) {
		$("#creditsToIncome").html("<span class='alert-warning'>" + creditsToIncome + " %</span>");	
		}
		else {
		$("#creditsToIncome").html("<span class='alert-success'>"+ creditsToIncome + "%</span>");
		}*/
		alerts("creditsToIncome", creditsToIncome, 65, 50);
		alerts("mpayToIncome", mpayToIncome, 65, 50);
		alerts("fixedToIncome", fixedToIncome, 50, 40);
		alerts("lifeToIncome", lifeToIncome, 80, 60);
		alerts("costToIncome", costToIncome, 95, 90);
		
		
		//$("#mpayToIncome").text(mpayToIncome + "%");
		//$("#fixedToIncome").text(fixedToIncome + "%");
		//$("#lifeToIncome").text(lifeToIncome + "%");
		//$("#costToIncome").text(costToIncome + "%");
		if(incomeMinusCosts<0){
		$("#incomeMinusCosts").html("<span class='alert-danger'>" + incomeMinusCosts + " PLN</span>");
		}
		else{
		$("#incomeMinusCosts").html("<span class='alert-success'>" + incomeMinusCosts + " PLN</span>");
		}
		alerts("creditsToCosts", creditsToCosts, 50, 40);
		alerts("mpayToCosts", mpayToCosts, 50, 40);
		alerts("fixedToCosts", fixedToCosts, 75, 60);
		alerts("lifeToCosts", lifeToCosts, 85, 70);
		//$("#creditsToCosts").text(creditsToCosts + " %");
		//$("#mpayToCosts").text(mpayToCosts + " %");
		//$("#fixedToCosts").text(fixedToCosts + " %");
		//$("#lifeToCosts").text(lifeToCosts + " %");
		}
		
		function alerts(id, value, border1, border2) {
		if (!isFinite(value)) { //sprawdza czy infinity lub NaN
		$("#" + id +"").html("<span class='alert-secondary'>Podaj dane.</span>");		
		}
		else if(value> border1 ) {
		$("#" + id+"").html("<span class='alert-danger'>" + value + " %</span>");	
		}
		else if (value> border2) {
		$("#" + id +"").html("<span class='alert-warning'>" + value + " %</span>");	
		}
		else {
		$("#" + id +"").html("<span class='alert-success'>"+ value + "%</span>");
		}
		}
		
		function numeric(inputtxt)  
		{  
		var number = /^[0-9]+$/;  
		if((inputtxt.match(number)))   
		{  
		return true;
		}  
		else  
		{   
		return false;   
		}  
		};  
	

	//drawing tables
	function tableDrawer(numrows) {
		var tableRows = 0;
		var table =''
		//"<table><th>Source</th><th>Value</th>";
		for(tableRows; tableRows<numrows; tableRows++) {
			
			table +="<tr><td><input type='text' class='text values'/></td><td><input type='text' class='int values'/></td>";
			
			//"<tr><td><input type='text'/></td><td><input type='text'/></td>";
		}
		
		return table;
	}
	
	function tableDrawerImp(numrows, value1, value2, klass) {
		var tableRows = 0;
		var table =''
		//"<table><th>Source</th><th>Value</th>";
		for(tableRows; tableRows<numrows; tableRows++) {
			
			table +="<tr><td><input type='text' disabled='disabled' value='"+value1+"'/></td><td><input type='text' disabled='disabled' value='"+value2+"' class='"+klass+"'/></td><td class='deleteCheckbox'><input type='checkbox' /></td></tr>";
			
			//"<tr><td><input type='text'/></td><td><input type='text'/></td>";
		}
		
		return table;
	}
	//building mulidimensional array from two arrays
	function arrayBuilder(arr1, arr2) {
		var array = [];
		var multiarray = [];
		var length = arr1.length;
	
	for(var j=0; j<length; j++) {
		array[0] = arr1.shift();
		array [1] = arr2.shift();
		multiarray[j] = array;
		array = [];
	}
	return multiarray;
	}
	
	//changing variables to numbers
	function intMaker(arr) {
	numbers = [];
	for(var i = 0; i<arr.length; i++) {
	numbers[i] = Number(arr[i]);
	}
	return numbers;
	};

/////////////////////////////////////////////////////////////////////Charts//////////////////////////////////////////////////////////////////////////////////

	  google.charts.load('current', {'packages':['corechart', 'bar']});
	  
      google.charts.setOnLoadCallback(drawFirstSumChart);
	  
      function drawFirstSumChart() {
		var value1 = Number(totalIncome);
		var value2 = Number(allCosts);
		var value3 = value1 - value2;
        var data = google.visualization.arrayToDataTable([
          ['', 'Przychód', 'Koszty', 'Dochód/strata'],
          ['Podsumowanie', value1, value2, value3]
          
        ]);

        var options = {
          chart: {
            title: 'Podsumowanie przychodu i kosztów',
            subtitle: 'Przychody i koszty Twojego gospodarstwa domowego',
			},
		  titleTextStyle: 
			{ color: "grey",
			fontName: "Roboto",
			fontSize: 16,
			bold: false,
			italic: false },
		  fontName: "Roboto",
		  fontSize:14,
		  //chartArea: {left:100, top: 10, width: '90%', height:'80%'},
		  height: 450,
		  width:700
        };

        var chart = new google.charts.Bar(document.getElementById('firstSumChart'));

        chart.draw(data, options);

      }
	  
	  google.charts.setOnLoadCallback(drawSecondSumChart);
      
	  function drawSecondSumChart() {
		var value1 = Number(totalIncome);
		var value2 = Number(allCosts);
		var value3 = Number(sumCredits);
		var value4 = Number(sumMpay);
		var value5 = Number(sumLife);
        var data = google.visualization.arrayToDataTable([
          ['', 'Przychód', 'Suma kosztów', 'Kredyty', 'Koszty stałe', 'Koszty zmienne'],
          ['Pozycja', value1, value2, value3, value4, value5]
        ]);

        var options = {
          chart: {
            title: 'Zestawienie przychodów i kosztów',
            subtitle: 'Poszczególne składniki kosztów wchodzące w skład kosztu całkowitego',
          },
		  titleTextStyle: 
			{ color: "grey",
			fontName: "Roboto",
			fontSize: 16,
			bold: false,
			italic: false },
		  fontName: "Roboto",
		  fontSize:16,
          bars: 'horizontal', // Required for Material Bar Charts.
		  height: 450,
		  width:700
        };

        var chart = new google.charts.Bar(document.getElementById('secondSumChart'));

        chart.draw(data, options);
      }
	  
	  google.charts.setOnLoadCallback(drawThirdSumChart);
	  
	function drawThirdSumChart() {
		//var value1 = Number(sumCredits);
		//var value2 = Number(sumMpay);
		//var value3 = Number(sumLife);
        var data = google.visualization.arrayToDataTable(incomeValues);

        var options = {
		  title: "Udział przychodów w przychodzie całkowitym",
		  titleTextStyle: 
			{ color: "grey",
			fontName: "Roboto",
			fontSize: 16,
			bold: false,
			italic: false },
		  fontName: "Roboto",
		  fontSize:14,
          pieHole: 0.3,
		  height: 450,
		  width:700
        };

        var chart = new google.visualization.PieChart(document.getElementById('thirdSumChart'));
        chart.draw(data, options);
      }

	  google.charts.setOnLoadCallback(drawFourthSumChart);
     
	 function drawFourthSumChart() {
		var value1 = Number(sumCredits);
		var value2 = Number(sumMpay);
		var value3 = Number(sumLife);
        var data = google.visualization.arrayToDataTable([
          ['Pozycja', 'Udział'],
          ['Kredyty', value1],
          ['Koszty stałe', value2],
          ['Koszty zmienne', value3]
        ]);

        var options = {
		  title: "Udział kosztów w koszcie całkowitym",
		  titleTextStyle: 
			{ color: "grey",
			fontName: "Roboto",
			fontSize: 16,
			bold: false,
			italic: false },
		  fontName: "Roboto",
		  fontSize:14,
          pieHole: 0.3,
		  height: 450,
		  width:700
        };

        var chart = new google.visualization.PieChart(document.getElementById('fourthSumChart'));
        chart.draw(data, options);
      }

	
		  
   
});

