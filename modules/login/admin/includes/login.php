<?php  
ob_start();
  @session_start();
  require_once("../../../../settings/connect_db.php");
  require_once("../../../../modules/login/admin/class/m_login.php");
  $objLogin= new M_Login();
  $strUsername = mysqli_real_escape_string($con,$_POST['username']);
  $strPassword = mysqli_real_escape_string($con,$_POST['password']);
  $finacialYear = $_POST['finacialYear'];
 if(isset($_POST['login'])){
  $blnValue = $objLogin->isLoginValidate($strUsername, $strPassword);

   if($rowbln = mysqli_fetch_array($blnValue)) {
      $_SESSION['sesUsername'] = $strUsername;
	  $_SESSION['sesPassword'] = $strPassword;
	  $_SESSION['privillegeId'] = $rowbln['privilegeId'];
	  $_SESSION['userId'] =$rowbln['loginId'];
	  
	  setcookie('sesUsername', $strUsername,time()+ 86400,'/'); 
	  setcookie('sesPassword', $strPassword,time()+ 86400,'/'); 
	  setcookie('privillegeId', $rowbln['privilegeId'],time()+ 86400,'/'); 
	  setcookie('userId', $rowbln['loginId'],time()+ 86400,'/');
	  setcookie('branchId', $rowbln['branchId'],time()+ 86400,'/');
	  setcookie('mainBranch', $rowbln['mainBranch'],time()+ 86400,'/');
	  setcookie('finacialYear', $finacialYear,time()+ 86400,'/');
	  //echo 'inside if';
     //header('Location:../../../../assets/system/php/dashboard/welcome.php?page=&message=');
     header('Location:../../../../assets/system/php/dashboard/welcome.php?page=');
     //echo 'userId'.$_SESSION['userId'];

   } else 
   {
	   
	 //echo 'inside else';
     header('Location: ../../../../index.php?page=error');
   }
 }
			
?>
