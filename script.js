$(function(){
		var storePassword;
		var storePassword2;
		//wyskakiwanie okienka rejestracji
		if($(".phperror").length > 0) {
			
			$(".register").show();
		
		}
		
		if($("#phpok").length > 0) {
			
			$("#addAccount").html("<h4>Gratulujemy!!!<h4>")
		}
		
		$("#popUp").on("click", function(){
			$(".register").fadeIn();
			$("#nickError").focus();
		
		});
		
		$(".closePopUp, #back").on("click", function(){
			$(this).closest(".disappear").fadeOut();
			//$("body").css("background-color", "white");
			$(".phperror").hide();
		});
		
		$("#resign").on("click", function(){
			$(".disappear").fadeOut();

		});
		
		$("#termsPopUp").on("click", function(){
			$("#termsOfUse").fadeIn();
		});
		//sprawdzanie inputów

		$("input[name='nick']").on("keyup",function(){
			//alert($(this).val());
			var nickValue = $(this).val();
			//sprawdzenie długości nicka
			if(((nickValue.length)<=3) || ((nickValue.length)>20)) {
				$("#regError").fadeIn().text("Więcej niż trzy i mniej niż dwadzieścia znaków");
				$("input[name='email']").attr("disabled","disabled");
			}
			//sprawdzanie czy tylko alphanumeryczne
			else if(!alphanumeric(nickValue)) {
				$("#regError").fadeIn().text("Tylko cyfry i litery, bez polskich znaków");
				$("input[name='email']").attr("disabled","disabled");
			}
			//jeżeli wszystko ok
			else{
				$("#regError").fadeOut();
				$("input[name='email']").removeAttr("disabled");
			}
		});
		
		$("input[name='email']").on("keyup",function(){
			var emailValue = $(this).val();
			if(!emailVal(emailValue)) {
				$("#regError").fadeIn().text("To nie jest poprawny adres email");
				$("input[name='password1']").attr("disabled","disabled");
			}
			else if(emailValue==""){
				$("#regError").fadeIn().text("Musisz wpisać poprawny adres email");
				$("input[name='password1']").attr("disabled","disabled");
			}
			else{
				$("#regError").fadeOut();
				$("input[name='password1']").removeAttr("disabled");
			}
		});
		
		$("input[name='password1']").on("keyup", function(){
			var password1Value=$(this).val();
			if(((password1Value.length)<6) || ((password1Value.length)>20)) {
				$("#regError").fadeIn().text("Minimum sześć i maksymalnie dwadzieścia znaków");
				$("input[name='password2']").attr("disabled","disabled");
			}
			else {
				$("#regError").fadeOut();
				$("input[name='password2']").removeAttr("disabled");
				$("input[name='terms']").attr("disabled","disabled");
				storePassword = password1Value;
					if(storePassword2 === storePassword) {
						$("#regError").fadeOut();
						$("input[name='terms']").removeAttr("disabled");
				}
			}
		});
		
		$("input[name='password2']").on("keyup", function(){
			var password2Value=$(this).val();
			storePassword2 = password2Value;
			
			if(storePassword2 === storePassword) {
				$("#regError").fadeOut();
				$("input[name='terms']").removeAttr("disabled");

			}
			else {
				$("#regError").fadeIn().text("Hasła nie są identyczne");
				$("input[name='terms']").attr("disabled","disabled");
				$("input[name='password1']").removeAttr("disabled");
			}
		});
		
		$("input[type='checkbox']").on("click", function(){
			//if(($(this).val()!='')){
				if($(this).prop("checked", true)) {
					$("input[type='submit']").removeAttr("disabled");
				}
				
		
		});
		
		$("#termsBack").on("click", function(){
			$(this).closest(".disappear").fadeOut();
		});
		
		$("#termsResign").on("click", function(){
			$(this).closest("body").children(".disappear").fadeOut();
		})
		
		function alphanumeric(inputtxt)  
		{  
		var letterNumber = /^[0-9a-zA-Z]+$/;  
		if((inputtxt.match(letterNumber)))   
		{  
		return true;
		}  
		else  
		{   
		return false;   
		}  
		};  
		
		function emailVal(inputtxt)  
		{  
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/
		if((inputtxt.match(emailReg)))   
		{  
		return true;
		}  
		else  
		{   
		return false;   
		}  
		}  
		
		

		
		
		
		
	});
	
	
