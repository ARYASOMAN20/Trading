 <?php ob_start();
   define("SOFTWAREMODE", "development");
   // define("SOFTWAREMODE", "production");
   //  define("SOFTWAREMODE", "testing");
	
	
	
  if(SOFTWAREMODE=='production'){	
  // echo 'inside production';
	  define('DB1', 'alsharqs_wwwalsha_esafe'); 
	  define('DB1USER', 'alsharqs_user'); 
	  define('DB1PASS', 'rootroot'); 
	  
	  define('DB2', 'wwwstjoh_alsharq_trade'); 
	  define('DB2USER', 'wwwstjoh_user'); 
	  define('DB2PASS', 'rootroot'); 
	  define("DOM" , "http://alsharqschool.edu.sa/esafe/"); 
	  define('SEND_MESSAGE', TRUE); 
  }else if(SOFTWAREMODE=='development'){	
	  define('DB1', 'alsharq'); 
	  define('DB1USER', 'root'); 
	  define('DB1PASS', 'nopassword'); 
	  
	  define('DB2', 'wwwstjoh_alsharq_trade'); 
	  define('DB2USER', 'wwwstjoh_user'); 
	  define('DB2PASS', 'rootroot'); 
	  define("DOM" , "http://localhost/alsharq/"); 
	  define('SEND_MESSAGE', FALSE); 
  }else if(SOFTWAREMODE=='testing'){	
	  define('DB1', 'wwwstjoh_alsharq'); 
	  define('DB1USER', 'wwwstjoh_user'); 
	  define('DB1PASS', 'rootroot'); 
	  
	  define('DB2', 'wwwstjoh_alsharq_trade'); 
	  define('DB2USER', 'wwwstjoh_user'); 
	  define('DB2PASS', 'rootroot'); 
	  define("DOM" , "http://stjohnsrsk.in/alsharq/"); 
	  define('SEND_MESSAGE', FALSE); 
  }
  
   define("DOMExtendUs" , DOM."system/school/admin/php/"); 
    define("DOMExtendCode" , DOM."form/config/control/cod/index.php/"); 
   
   
   define('URL_MAIL_FOR_RESETPASSWORD',DOM.'modules/privacy/admin/view/resetPassword.php');
   define('DEFAULT_SITE_URL',DOM.'system/school/admin/php/welcome.php');
   define('URL_MAIL_FOR_FORGETPASSWORD',DOM.'modules/privacy/admin/view/forgetPassword.php');
   
  
  ?>