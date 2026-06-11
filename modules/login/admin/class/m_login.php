<?php
require_once("../../../../settings/connect_db.php");
class M_Login
{
	function isLoginValidate($username,$password)
	{
		global $con;
		$query = "SELECT loginId , username ,password,privilegeId,branchId,mainBranch	       
				  FROM  login 
				  WHERE username =  '".$username."' 
				  AND password ='".$password."' AND status=1";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		return $result;
	}
}
?>