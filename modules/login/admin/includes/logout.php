<?php //ob_clean();
	ob_start();
   session_start();
   require('../../../../libraries/class/utils.php');
   $objUtils=new Utils();
   $objUtils->unsetSession('sesUsername');
   $objUtils->unsetSession('sesPassword');
   $objUtils->unsetSession('privillegeId');
   session_destroy();
   
   setcookie('sesUsername', $strUsername,time()-86400,'/'); 
   setcookie('sesPassword', $strPassword,time()-86400,'/'); 
   setcookie('privillegeId', $rowbln['privilegeId'],time()-86400,'/'); 
   setcookie('userId', $rowbln['loginId'],time()-86400,'/'); 
   setcookie('branchId', $rowbln['branchId'],time()- 86400,'/');
   setcookie('mainBranch', $rowbln['mainBranch'],time()- 86400,'/');
   setcookie('finacialYear', $finacialYear,time()- 86400,'/');
  // exit(header("Location: ../../../../index.php"));
  if(headers_sent()) 
   	header("Location: ../../../../index.php");
   else
        header("Location: ../../../../index.php");
?>