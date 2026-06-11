<?php
 /*
   formatDate($strDate);
   unsetSession($sesName); 
   strGetPreviousDate($strDate);
   strGetFinancialYear($strDate); 
   strGetGender($genderValue); 
 */
class Utils {

    //input validation
    function cleanInput($string, $type = '')
    {
        $string = str_replace('-', '', $string); // Replaces hyphens with spaces .
        $string = str_replace('.', ' ', $string);
        return preg_replace('/[^A-Za-z0-9\- ]/', '', $string); // Removes special chars.
    }

 
   function displayDateWithZero()
   {
	   $resArray = array();
	   for($i=1;$i<=31;$i++){
		  $i = str_pad($i, 2, "0", STR_PAD_LEFT); #to add zero to the left of i from 1-9
		  /*if($i<=9) 
		   $i='0'.$i;*/
		  $resArray.= "<option value='$i'>$i</option>";
		}
		return $resArray;
	}


 function formatDateWithZero($strDate) {
   $arrDate = explode('-', $strDate); 
   $month=$arrDate[1];   
 if($month=="JAN")    $month='01';
   else if($month=="FEB")   $month='02';
   else if($month=="MAR")   $month='03';
   else if($month=="APR")   $month='04';
   else if($month=="MAY")   $month='05';
   else if($month=="JUN")   $month='06';
   else if($month=="JUL")   $month='07';
   else if($month=="AUG")   $month='08';
   else if($month=="SEP")   $month='09';
   else if($month=="OCT")   $month='10';
   else if($month=="NOV")   $month='11';
   else if($month=="DEC")   $month='12';   
   $strDate=$arrDate[2]."-".$month."-".$arrDate[0];
   //echo $strDate; 
   return $strDate;  
  }
 
 
 function convert_number_to_words($number) {
    
     $hyphen      = '-';
     $conjunction = ' ';
     $separator   = ', ';
     $negative    = 'negative ';
     $decimal     = ' point ';
     $dictionary  = array(
         0                   => 'ZERO',
         1                   => 'ONE',
         2                   => 'TWO',
         3                   => 'THREE',
         4                   => 'FOUR',
         5                   => 'FIVE',
         6                   => 'SIX',
         7                   => 'SEVEN',
         8                   => 'EIGHT',
         9                   => 'NINE',
         10                  => 'TEN',
         11                  => 'ELEVEN',
         12                  => 'TWELVE',
         13                  => 'THIRTEEN',
         14                  => 'FOURTEEN',
         15                  => 'FIFTEEN',
         16                  => 'SIXTEEN',
         17                  => 'SEVENTEEN',
         18                  => 'EIGHTEEN',
         19                  => 'NINETEEN',
         20                  => 'TWENTY',
         30                  => 'THIRTY',
         40                  => 'FOURTY',
         50                  => 'FIFTY',
         60                  => 'SIXTY',
         70                  => 'SEVENTY',
         80                  => 'EIGHTY',
         90                  => 'NINETY',
         100                 => 'HUNDRED',
         1000                => 'THOUSAND',
         1000000             => 'MILLION',
         1000000000          => 'BILLION',
         1000000000000       => 'TRILLION',
         1000000000000000    => 'quadrillion',
         1000000000000000000 => 'quintillion'
     );
    
     if (!is_numeric($number)) {
         return false;
     }
    
     if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
         trigger_error(
             'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
             E_USER_WARNING
         );
         return false;
     }

     if ($number < 0) {
         return $negative . $this -> convert_number_to_words(abs($number));
     }
    
     $string = $fraction = null;
    
     if (strpos($number, '.') !== false) {
         list($number, $fraction) = explode('.', $number);
     }
    
     switch (true) {
         case $number < 21:
             $string = $dictionary[$number];
             break;
         case $number < 100:
             $tens   = ((int) ($number / 10)) * 10;
             $units  = $number % 10;
             $string = $dictionary[$tens];
             if ($units) {
                 $string .= $hyphen . $dictionary[$units];
             }
             break;
         case $number < 1000:
             $hundreds  = $number / 100;
             $remainder = $number % 100;
             $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
             if ($remainder) {
                 $string .= $conjunction . $this->convert_number_to_words($remainder);
             }
             break;
         default:
             $baseUnit = pow(1000, floor(log($number, 1000)));
             $numBaseUnits = (int) ($number / $baseUnit);
             $remainder = $number % $baseUnit;
             $string = $this -> convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
             if ($remainder) {
                 $string .= $remainder < 100 ? $conjunction : $separator;
                 $string .= $this -> convert_number_to_words($remainder);
             }
             break;
     }
    
     if (null !== $fraction && is_numeric($fraction)) {
         $string .= $decimal;
         $words = array();
         foreach (str_split((string) $fraction) as $number) {
             $words[] = $dictionary[$number];
         }
         $string .= implode(' ', $words);
     }
    
     return $string;
 }
	
     function getCurrentDate(){
		date_default_timezone_set('Asia/Riyadh');
     	$strCurrentDate = date("Y-m-d");
     	$strCurrentDate=$this->reversFormatDate($strCurrentDate);
    	return $strCurrentDate; 
	 }
 
	function formatMonth($strMonth) {
   
	   if($strMonth=="January"){
			  $month = '01';	$days = 31;
	   }
	   else if($strMonth=="February"){
			  $month = '02';	$days = 28;
	   }   
	   else if($strMonth=="March"){
			  $month = '03';	$days = 31;
	   }   
	   else if($strMonth=="April") {
			  $month = '04';	$days = 30;
	   }  
	   else if($strMonth=="May"){
			  $month = '05';	$days = 31;
	   }  
	   else if($strMonth=="June"){
			  $month = '06';	$days = 30;
	   }   
	   else if($strMonth=="July"){
			  $month = '07';	$days = 31;
	   }   
	   else if($strMonth=="August"){
			  $month = '08';	$days = 31;
	   }   
	   else if($strMonth=="September"){
			  $month = '09';	$days = 30;
	   }   
	   else if($strMonth=="October") {
			  $month = '10';	$days = 31;
	   }  
	   else if($strMonth=="November"){
			  $month = '11';	$days = 30;
	   }   
	   else if($strMonth=="December") {
			  $month = '12';	$days = 31;
	   }  		
	   
		return $month."-".$days;  
	}
	 
	function displayYearRange($startYear, $endYear){
		$resArray = array();
		for($i = $startYear; $i < $endYear ; $i++){
			$resArray .= "<option value='$i'>$i</option>";
		}
		return $resArray;
}
 
 function loadDropDown($resultArray,$valueColumn,$nameColumn){
	 $resArray = "";
	 while($row = mysqli_fetch_array($resultArray)){
	 	$resArray.= "<option value= '".$row[$valueColumn]."'>".$row[$nameColumn]."</option>";	 
		}
	return $resArray; 
 }
 
 function formatDate($strDate) {
   $arrDate = explode('-', $strDate); 
   $month=$arrDate[1];			
	if($month=="JAN")   $month=01;
   else if($month=="FEB")   $month=02;
   else if($month=="MAR")   $month=03;
   else if($month=="APR")   $month=04;
   else if($month=="MAY")   $month=05;
   else if($month=="JUN")   $month=06;
   else if($month=="JUL")   $month=07;
   else if($month=="AUG")   $month=8;
   else if($month=="SEP")   $month=9;
   else if($month=="OCT")   $month=10;
   else if($month=="NOV")   $month=11;
   else if($month=="DEC")   $month=12;			
   $strDate=$arrDate[2]."-".$month."-".$arrDate[0];
   return $strDate;  
  }
  
   function reversFormatDate($strDate) { 
   $arrDate = explode('-', $strDate); 
   $month=$arrDate[1];			
	if($month=="01")   $month="JAN";
   else if($month=="02")   $month="FEB";
   else if($month=="03")   $month="MAR";
   else if($month=="04")   $month="APR";
   else if($month=="05")   $month="MAY";
   else if($month=="06")   $month="JUN";
   else if($month=="07")   $month="JUL";
   else if($month=="08")   $month="AUG";
   else if($month=="09")   $month="SEP";
   else if($month=="10")   $month="OCT";
   else if($month=="11")   $month="NOV";
   else if($month=="12")   $month="DEC";			
   $strDate=$arrDate[2]."-".$month."-".$arrDate[0];
   return $strDate;  
  }
  /* 
	 ...................
     //note: 
  */
  function unsetSession($sesName) {
    if(isset($_SESSION[$sesName]))
  	   unset($_SESSION[$sesName]);  
  }
  
  
  /* 
	...................
    //note: 
  */
  function strGetPreviousDate($strDate) {
	$strDate=date('Y-m-d', strtotime($strDate.' -1 days'));
	return $strDate;  
  }


  /* 
	 ...................
    //note: 
  */
  function strGetFinancialYear($strDate) {	
   	$arrDate=explode("-", $strDate); 
   	$year=$arrDate[2];
   	$month=$arrDate[1];
   	$day=$arrDate[0];

   	$strStartYear="";
   	$strEndYear="";
   	if($month >=4 && $month <=12) { 
   		$strStartYear.=$year."-4-1";
   		$strEndYear.=($year+1)."-3-1";  
	} else if($month >=1 && $month <=3) { 
    		$strStartYear.=($year-1)."-4-1";
   		$strEndYear.=$year."-3-1";  
	}
	$strFinancialYear=$strStartYear."/".$strEndYear;
	return  $strFinancialYear;
 }


 /* 
	...................
   //note: 
 */
 function strGetGender($genderValue) {
	$gender="";
	if($genderValue=="M")      $gender="Male";
	else if($genderValue=="F") $gender="Female";
	return $gender;  
  }
  
  
 function displayDate(){
	$resArray = array();
	for($i=1;$i<=31;$i++){
		$resArray.= "<option value='$i'>$i</option>";
	}
	return $resArray;
 }
		
function displayMonth(){
	$resArray = array();
	$monthArray = array(
   					 	1  => "JAN",
   						2  => "FEB",
    					3  => "MAR",
   						4  => "APR",
						5  => "MAY",
   						6  => "JUN",
						7  => "JUL",
   						8  => "AUG",
						9  => "SEP",
   						10  => "OCT",
						11  => "NOV",
   						12  => "DEC"
						);
			for($i=1;$i<=12;$i++){
				$resArray.= "<option value='$monthArray[$i]'>$monthArray[$i]</option>";
			}
			return $resArray;
		}
		
function displayYear(){
	$resArray = array();
	for($i=1990;$i<=date("Y");$i++){
		$resArray.= "<option value='$i'>$i</option>";
	}
	return $resArray;
	}

}



/****************************************************
 
/*
function  : formatDate();
   			unsetSession(); 
   			strGetPreviousDate();
   			strGetFinancialYear(); 
   			strGetGender(); 
Date      : 26.08-2013   
modified  : Naveen MRK 
note      : function created
*/
?>