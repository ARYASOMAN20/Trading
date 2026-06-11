// JavaScript Document
function checkNumeric(argId)
{	
//alert(argId);
	var quantity = (document.getElementById(argId).value);	
	quantity 	 = quantity.replace(/\s/g,'');	
	document.getElementById(argId).value = quantity;	
	quantity     = (document.getElementById(argId).value);	
	if(quantity == "")		
		document.getElementById(argId).value = 0;	
	else{				
		//alert(quantity);		
		if(isNaN(quantity) == true){			
			quantity = quantity.trim();			
			var tempQuantity= quantity.replace(/[^0-9$.]/g,'');			
			if(tempQuantity  == "")			
				document.getElementById(argId).value = 0;			
			else			
				document.getElementById(argId).value = tempQuantity;					
		}	
	} 
}

function isLandLineNumber(Id) {
                var landLine = document.getElementById(Id).value;
                var landLineReg = /^\d{7,12}$/;
                if (!landLineReg.test(landLine)) {
                        document.getElementById(Id).value ="";
                        alert('Invalid Phone No');
                }
    return true;
}


function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        alert('Enter numbers');
        return false;
    }
    return true;
}

function isMobileNumber(Id) {
                var mobile = document.getElementById(Id).value;
                var mobileReg = /^\d{9,10}$/;
                if (!mobileReg.test(mobile)) {
                        document.getElementById(Id).value ="";
                        alert('Invalid Mobile No');
                }
    return true;
}

function validateEmail(Id){
                var email = document.getElementById(Id).value;
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                if (!emailReg.test(email)) {
                        document.getElementById(Id).value ="";
                        alert('Invalid Email');
                } else {
                        return true;
                }
                //validateEmail(email);
}

function confirmMessage(){
  if (confirm('Are you sure you want to save ?')) 
	 return true;
  else 
	return false;
}

function displayCalender(targetId) {
  new JsDatePick({
	 useMode:2,
	 target:targetId,
	 dateFormat:"%d-%M-%Y" 
  });	
}

function ajaxFunction(strMethod, strUrl, targetId) {
  var xmlhttp="";
  if (window.XMLHttpRequest) 
     xmlhttp=new XMLHttpRequest();
  else 
     xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  
  xmlhttp.onreadystatechange=function() {
   if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById(targetId).innerHTML=xmlhttp.responseText;
	  //function_two(itemId,companyId); 
   }
  }  
 xmlhttp.open(strMethod, strUrl, true);
 xmlhttp.send();	
}

