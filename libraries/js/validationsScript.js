/*
	paymodeHideDisplay(inputId, divId);
	confirmMessage():
	displayCalender(targetId);
	checkNumeric(argId)
	printReport();
	ajaxFunction(strMethod, strUrl, targetId);
	isEmpty(formName, startLoop, endLoop, valueAlert);
*/

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


function checkMobileForAttendance(id){ 
	var inputstr=document.getElementById(id).value;
	var regex=/^[\d\s,]*$/;
	if (!regex.test(inputstr)){
		alert("Invalid Phone No");
		document.getElementById(id).value= '';
	}
	
}


function paymodeHideDisplay(inputId, divId) {
 //alert("paymodeHideDisplay");	
 var optionvalue=document.getElementById(inputId).value;
 var elementId=document.getElementById(divId);
 if(optionvalue=="1" || optionvalue=="0" )  //0=select 1=cash 
	 elementId.style.display='none';
 else 
	 elementId.style.display='block';
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


function checkNumeric(argId){
	
	var quantity = (document.getElementById(argId).value);
	if(quantity == "")
		document.getElementById(argId).value = 0;	
	else{
		if(isNaN(quantity) == true){
			quantity = quantity.trim();
			var tempQuantity= quantity.replace(/\D+/, '');
			
			if(tempQuantity  == "")
			document.getElementById(argId).value = 0;
			else
			document.getElementById(argId).value = tempQuantity;
			
		}

	}
}


function printReport() {
 window.print();	
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


/*function checkNumericQuantity(i,check){
	if (isNaN(check)== true) {
	    var value1 = check.replace(/\D+/, '');
		document.getElementById("quantity2"+i).value= value1;
	    document.getElementById("quantity2"+i).focus();
	    alert('This is not a number!');
	 }
}
*/
function isEmpty(formName, startLoop, endLoop, valueAlert) {  
	
	
	for (var i=startLoop;i<=endLoop; i++) {
		 var currentValue=document.forms[formName][i].value;
		 if(valueAlert[i][1]=="text") { 
		    if(currentValue==null || currentValue=="" || currentValue.trim().length==0) {
	    	   alert("Enter "+valueAlert[i][0]);
	   		   return false;
		    }
		 } else if(valueAlert[i][1]=="dropDown") { 
		    if(currentValue=="0") {
	           alert("Select "+valueAlert[i][0]);
	           return false;
	        }
		 }  else if(valueAlert[i][1]=="radio") { 
		    var vRadio=document.forms[formName][i]; 
			
			alert (vRadio[0].value +" : "+vRadio[1].value)
	        var vValue="false";
	        for(var j = 0; j < vRadio.length; j++) {
               if(vRadio[j].checked) {
		          vValue="true";
		          break;
                }
            }
    
	        if(vValue=="false") {
	         //alert("Select Gendor");
		     alert("Select "+valueAlert[i][0]);
	         return false;
	        }
		 }
		 
		 //max. length validation
		 if(valueAlert[i][2]!='0') { 
		    if(currentValue.length > valueAlert[i][2]) {
	    	   alert(valueAlert[i][0]+" do not exceed "+valueAlert[i][2]+" charectors");
	   		   return false;
		    }
		 }
		 
		 
		 //integer validation
		 if(valueAlert[i][3]=='integer') { 
		    var intRegex = /^\d+$/;            
            if( ! intRegex.test(currentValue)) {
               alert('Invalid '+valueAlert[i][0]);
	           return false;
			}
		 }
		 
		  //email validation
		 if(valueAlert[i][3]=='email') {
		    var atpos=currentValue.indexOf("@");
	        var dotpos=currentValue.lastIndexOf(".");
		    if ( atpos<1 || dotpos<atpos+2 || dotpos+2>=currentValue.length ) {
  	            alert("Invalid e-mail address");
			    return false;
  	        } 		
		 }
		 
		  //phone validation  ????
		  
		  //double validation 
		  
		  if(valueAlert[i][3]=='double') {
			  //alert('double');
			var min=0;
			var max=2;
			var re = new RegExp("^-?\\d+\\.\\d{" + min + "," + max + "}?$");
			var doubleOrNot=re.test(currentValue);  
			if(doubleOrNot==false) {   //if 2,3,.. false for double
			  var intRegex = /^\d+$/;            
              if( ! intRegex.test(currentValue)) { 
			     alert('Invalid '+valueAlert[i][0]);
                 return false;
			  }
			}
		 }
		 
    }  	
	
 }


 