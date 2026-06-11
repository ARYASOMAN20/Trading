<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>

<body>
<script>
	
	var stateEmail = 1;			var stateAccessEmail = 0;			var idEmale = "";
	var statePhone = 1;			var stateAccessPhone = 0;			var idPhone = "";
	var stateName = 1;			var stateAccessName = 0;			var idName = "";
	var stateWeb = 1;			var stateAccessWeb = 0;				var idWeb = "";
	var stateNull = 1;			var stateAccessNull = 0;			var idNull = "";
	var stateChara = 1;			var stateAccessChara = 0;			var idChara = "";
	var stateDesi = 1;			var stateAccessDesi = 0;			var idDesi = "";
	var stateInt = 1;			var stateAccessInt = 0;				var idInt = "";
	var stateMax = 1;			var stateAccessMax = 0;				var idMax = "";
	
	function validateEmail(email) 
	{	
		stateAccessEmail = 1;
  		var pattern = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
		var mail = $("#"+email).val();
		idEmale = email;
    	if(mail=="")
        {
        	$("#"+email).next().html("Please enter Email Id");
            stateEmail = 0;
        }
		else if(!pattern.test(mail))
		{
			$("#"+email).next().html("Email Id is not valid");
			stateEmail = 0;
		}
		else
		{
			$("#"+email).next().html("");
			stateEmail = 1;
		}
	}
	
	function validatePhone(phone)
	{
		stateAccessPhone = 1;
		var pattern = /^\d{10}$/;
		var phoneNo = $("#"+phone).val();
		idPhone = phone;
		if(phoneNo == "")
		{
			$("#"+phone).next().html("Please enter Phone number");
			statePhone = 0;
		}
		else if(!pattern.test(phoneNo))   
		{
			$("#"+phone).next().html("Phone number is not valid");
			statePhone = 0;
		}
		else
		{
			$("#"+phone).next().html("");
			statePhone = 1;
		}
	}
	
	function validateName(nam)
	{	
		stateAccessName = 1;
		var pattern = /^[a-zA-Z ]*$/;
		var name = $("#"+nam).val();
		idName = nam;
		if(name == "")
		{
			$("#"+nam).next().html("Please enter Name");
			stateName = 0;
		}
		else if(!pattern.test(name))   
		{
			$("#"+nam).next().html("Name is not valid");
			stateName = 0;
		}
		else
		{
			$("#"+nam).next().html("");
			stateName = 1;
		}
	}
	
	function validateWeb(web)
	{	
		stateAccessWeb = 1;
		var pattern = /\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/;
		var site = $("#"+web).val();
		idWeb = web;
		if(site == "")
		{
			$("#"+web).next().html("Please enter Website");
			stateWeb = 0;
		}
		else if(!pattern.test(site))   
		{
			$("#"+web).next().html("Website is not valid");
			stateWeb = 0;
		}
		else
		{
			$("#"+web).next().html("");
			stateWeb = 1;
		}
	}
	
	function validateNull(val)
	{	
		stateAccessNull = 1;
		var value = $("#"+val).val();
		idNull = val;
		if(value == "")
		{
			$("#"+val).next().html("Please enter a value");
			stateNull = 0;
		}
		else
		{
			$("#"+val).next().html("");
			stateNull = 1;
		}
	}
	
	function validateChara(chara)
	{	
		stateAccessChara = 1;
		var pattern = /^[a-zA-Z]*$/;
		var value = $("#"+chara).val();
		idChara = chara;
		if(value == "")
		{
			$("#"+chara).next().html("Please enter value");
			stateChara = 0;
		}
		else if(!pattern.test(value))   
		{
			$("#"+chara).next().html("Value is not valid. Enter only characters");
			stateChara = 0;
		}
		else
		{
			$("#"+chara).next().html("");
			stateChara = 1;
		}
	}
	
	
	function validateDecimal(desi)
	{	
		stateAccessChara = 1;
		var pattern = /^[-+]?[0-9]+\.[0-9]+$/;
		var value = $("#"+desi).val();
		idDesi = desi;
		if(value == "")
		{
			$("#"+desi).next().html("Please enter value");
			stateDesi = 0;
		}
		else if(!pattern.test(value))   
		{
			$("#"+desi).next().html("Value is not valid. Enter only Decimal Number");
			stateDesi = 0;
		}
		else
		{
			$("#"+desi).next().html("");
			stateDesi = 1;
		}
	}
	
	function validateInteger(intgr)
	{	
		stateAccessInt = 1;
		var pattern = /^\d+$/;
		var value = $("#"+intgr).val();
		idInt = intgr;
		if(value == "")
		{
			$("#"+intgr).next().html("Please enter value");
			stateInt = 0;
		}
		else if(!pattern.test(value))   
		{
			$("#"+intgr).next().html("Value is not valid. Enter only Intrger Number");
			stateInt = 0;
		}
		else
		{
			$("#"+intgr).next().html("");
			stateInt = 1;
		}
	}
	
	function validateMax(maxm,limit)
	{	
		stateAccessMax = 1;
		var value = $("#"+maxm).val();
		//var limit = 10;
		var x=value.length;
		idMax = maxm;
		if(value == "")
		{
			$("#"+maxm).next().html("Please enter value");
			stateMax = 0;
		}
		else if(x>limit)   
		{
            $("#"+maxm).next().html("Value more than maxmum limit. Please change the value");
			stateMax = 0;
        }
		else
		{
			$("#"+maxm).next().html("");
			stateMax = 1;
		}
	}
	
	function errorEmail(val)
	{
		if(stateAccessEmail == 0)
		{
			$("#"+val).next().html("Please enter a value");
			stateAccessEmail = 1;
			stateEmail = 0;
		}
	}
	
	function errorPhone(val)
	{
		if(stateAccessPhone == 0)
		{
			$("#"+val).next().html("Please enter a value");
			stateAccessPhone = 1;
			statePhone = 0;	
		}
	}
	
	function errorName(val)
	{
		if(stateAccessName == 0)
		{
			$("#"+val).next().html("Please enter a value");
			stateAccessName = 1;
			stateName = 0;	
		}
	}
	
	function errorWeb(val)
	{
		if(stateAccessWeb == 0)
		{
			$("#"+val).next().html("Please enter a value");
			stateAccessWeb = 1;
			stateWeb = 0;	
		}
	}
	
	function errorNull(val)
	{
		if(stateAccessNull == 0)
		{
			$("#"+val).next().html("Please enter a value");
			stateAccessNull = 1;
			stateNull = 0;	
		}
	}
	
	function errorChara(val)
	{
		if(stateAccessChara == 0)
		{
			$("#"+val).next().html("Please enter a value");
			stateAccessChara = 1;
			stateChara = 0;	
		}
	}
	
	function errorDecimal(val)
	{
		if(stateAccessDesi == 0)
		{
			$("#"+val).next().html("Please enter a value");
			stateAccessDesi = 1;
			stateDesi = 0;	
		}
	}
	
	function errorInteger(val)
	{
		if(stateAccessInt == 0)
		{
			$("#"+val).next().html("Please enter a value");
			stateAccessInt = 1;
			stateInt = 0;	
		}
	}
	
	function errorMax(val)
	{
		if(stateAccessMax == 0)
		{
			$("#"+val).next().html("Please enter a value");
			stateAccessMax = 1;
			stateMax = 0;	
		}
	}
	
	function validateForm()
	{
		if( 
			((stateAccessEmail == 1 && stateEmail == 1) || stateAccessEmail == 0)  && 
			((stateAccessPhone == 1  && statePhone == 1) || stateAccessPhone == 0) &&
			((stateAccessName == 1 && stateName ==1) || stateAccessName == 0) && 
			((stateAccessWeb == 1 && stateWeb == 1) || stateAccessWeb ==0) &&
			((stateAccessNull == 1 && stateNull == 1) || stateAccessNull == 0) && 
			((stateAccessChara == 1 && stateChara == 1) || stateAccessChara == 0) && 
			((stateAccessDesi == 1 && stateDesi == 1) || stateAccessDesi == 0) && 
			((stateAccessInt == 1 && stateInt == 1) || stateAccessInt == 0) && 
			((stateAccessMax == 1 && stateMax == 1) || stateAccessMax == 0)
			)
			{
				if(stateEmail == 1 && statePhone == 1 && stateName == 1 && stateWeb == 1 && stateNull == 1 && stateChara == 1 && stateDesi == 1 && stateInt == 1 && stateMax == 1)
				{
					return true;
				}
				else 
				{
					if (stateEmail == 0)
					{
						$("#"+idEmale).next().html("Email Id is not valid");
					}
					if (statePhone == 0)
					{
						$("#"+idPhone).next().html("Phone Number is not valid");
					}
					if (stateName == 0)
					{
						$("#"+idName).next().html("Name is not valid");
					}
					if (stateWeb == 0)
					{
						$("#"+idWeb).next().html("Website is not valid");
					}
				
					if (stateNull == 0)
					{
						$("#"+idNull).next().html("This field is empty");
					}
					if (stateChara == 0)
					{
						$("#"+idChara).next().html("This field is empty");
					}
					if (stateDesi == 0)
					{
						$("#"+idDesi).next().html("This field is empty");
					}
					if (stateInt == 0)
					{
						$("#"+idInt).next().html("This field is empty");
					}
					if (stateMax == 0)
					{
						$("#"+idMax).next().html("This field is empty");
					}
					
					return false;
				}
		}
		else
		{
			//alert("Please fill the required details");
			return false;
		}
	}
</script>
</body>
</html>