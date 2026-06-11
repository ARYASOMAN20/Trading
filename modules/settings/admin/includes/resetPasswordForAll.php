<?php
require_once("../../../../modules/settings/admin/class/users.php");
require_once("../../../../settings/connect_db.php");
require_once('../../../../settings/path.php');
$objPath  = new Path();
$objUsers = new Users();
if(isset($_POST['save']) ){
	$message       = 'Incorrect Password';
	$userId        = $_COOKIE['userId'];
	$newPassword   = mysqli_real_escape_string($con,$_POST['newPassword']);
	$blnUpdate     = $objUsers->blnResetPassword($userId, $newPassword);
	if ($blnUpdate == TRUE)
		$message   = 'Success';
	$objPath->setHeader('resetPasswordForAll',$message);
}
?>

<script type="text/javascript" src="../../../../libraries/js/validationsScript.js"></script>
<script type="text/javascript">
function pvalidate() {
	if (document.changePassword.newPassword.value != document.changePassword.confirmPassword.value){
			  document.getElementById("errorMsg").innerHTML = 'Passwords did not match!';
			  //alert('Passwords did not match!');
			  return false;
	  }
	  else{
		  document.getElementById("errorMsg").innerHTML = ' ';
		  return true;
	  }
}
</script>
<style type="text/css">
	.form-group{margin-bottom: 5px;}
	.form-group label{margin-bottom: 2px;}
</style>
<h3>Reset Password</3>
<form name="changePassword" method="post" onsubmit="return pvalidate()"  >
<input type="hidden" name="userId" value="<?= $_POST['userId'];?>" id="userId" >
<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
    	<div class="box box-solid box-primary">
        	<div class="box-body">
                <div class="form-group">
                    <label for="newPassword">New Password :</label> <strong class="mandatory">*</strong>
                    <input name="newPassword" type="password" size="25" id="newPassword" required="required"
                             onkeyup="pvalidate()" onblur="pvalidate()" class="form-control input-sm" >
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password :</label> <strong class="mandatory">*</strong>
                    <input name="confirmPassword" type="password" size="25" id="confirmPassword" required="required"
                             onkeyup="pvalidate()" onblur="pvalidate()" class="form-control input-sma" />
                    <label id="errorMsg" style="color:red"></label>
                </div>
                <div class="form-group">
                	<center>
                        <button name="save" type="submit" class="btn btn-success" id="save" value="Submit">
                            <i class="fa fa-save"></i> Submit
                        </button>
                    </center>
                </div>
    		</div>
        </div>
    </div>
</div>
</form>

