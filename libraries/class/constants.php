<?php
include_once( "../../../../libraries/class/designConstants.php" );
 /*
   getImageExtensions()
   getImageFormats()
   getTextExtensions()
   getTextFormats() 
 */
 
 //define('AllOWANCE', '1');
 //define('DEDUCTION', '2'); 
 
 

 define("JPG", ".jpg");
 define("TXT", ".txt");
 
 define("IMAGE_DEFAULT", "0".JPG);
 define("TEXT_DEFAULT",  "0".TXT);
 
 define("TEXT_FILE",  "text");
 define("IMAGE_FILE", "image");
 
 define("STAFF_START_YEAR", "1950", true);
 define("STAFF_END_YEAR", "2000", true);//  
 //
 define("STUDENT_PHOTO_PATH", "../../../../uploads/student/");
 define("STAFF_PHOTO_PATH", "../../../../uploads/staff/");
 define("DEFAULT_PHOTO_PATH", "../../../../uploads/default");
 
 define("PATH_FOR_STUDENT_RECEIPT",DOM."system/school/admin/php/welcome.php?page=studentFeeDebit");
 define("HEADER_FOR_STUDENT_FEE_DEBIT","../../../../modules/fees/admin/includes/receipt");
 
define("PATH_FOR_STUDENT_BUSFEE_RECEIPT",DOM."system/school/admin/php/welcome.php?page=busFee_admin_studentFeeDebit");


define("STUDENT_PHOTO_EXPORT_PATH", "../../../../export/student/"); 
define("STUDENT_PHOTO_COMPRESS_PATH", "../../../../export/compressed.zip"); 
define("PATH_FOR_EXPORT",DOM."export/compressed.zip");


define("PATH_FOR_STUDENT_SPECIALFEE_RECEIPT",DOM."system/school/admin/php/welcome.php?page=specialFee_admin_studentFeeDebit");

define("PATH_FOR_LIBRARY_POPUP", DOM."system/school/admin/php/welcome.php?page=librarySystem");
define("PATH_FOR_SITE", DOM."bridge/unmodules/inventory/");

//define("JQUERY_PATH","../../../../libraries/js/jquery-1.10.2.js");
define("JQUERY_PATH","http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js");
 

 define("PATH", "../../../../uploads/staffUploads/", true);
 define("MAX_SIZE","20000000",true);
 define("ALLOWE_EXTENSIONS_ARRAY",serialize(array('pdf', 'doc', 'docx')),true);
 
 define("PATH_FOR_STAFF_PAYROLL_RECEIPT",DOM."system/school/admin/php/welcome.php?page=payroll_admin_staffSalaryPayment");

 define("IMPORT_STUDENT_DETAILS_EXCEL_UPLOAD_PATH", "../../../../modules/ExcelToDataBase/admin/uploads");

 define("PATH_FOR_STUDENT_RECEIPT_MISCFEE",
 DOM."system/school/admin/php/welcome.php?page=miscFee_admin_miscFeePayment");
 
 define('PAID_LEAVE', '1');
 define('NON_PAID_LEAVE', '0');
 
 define("IMPORT_STUDENT_MARKS_DETAILS_EXCEL_UPLOAD_PATH", "../../../../modules/common/studentMarks/uploads");
 
 define('LEAVE_STATUS', '2');
 

 
  
 define('USER_ID',1);//$_SESSION['userId']);
 

 function getImageExtensions() {
  return array("gif", "jpeg", "jpg", "png");
 }
	
	
 function getImageFormats() {
  return array("image/jpeg", "image/jpg", "image/pjpeg");
 }
	
	
 function getTextExtensions() {
  return array("txt");
 }
	
	
 function getTextFormats() {
  return array("text/plain");
 }
 
 
function getWeekDays() {
  return array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
 }
 
 function getMonthsOfYear() {
  return array("January","February","March","April","May","June","July","August",
  				"September","October","November","December");
 }
 //****************************************************
 
/*
function  : getImageExtensions()
			getImageFormats()
			getTextExtensions()
 			getTextFormats()
Date      : 26.08-2013   
modified  : Naveen MRK 
note      : function created
*/
?>