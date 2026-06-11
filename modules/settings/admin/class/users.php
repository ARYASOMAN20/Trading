<?php
require_once("../../../../settings/connect_db.php");

class Users

{

	function resListUsers()

	{

		global $con;

		$query  = "SELECT L.*

				   FROM  login L

					WHERE L.privilegeId >= 1 AND L.status=1 ";

		//echo "<br>".$query."<br>";

		$result = mysqli_query($con,$query);

		return $result;

	}
	
	
	
function deleteUser($userId)

	{

		global $con;

		$query  = "UPDATE login SET status=0 where loginId='$userId'";
        $result = mysqli_query($con,$query);
    	return $result;

	}


	

	function blnInsertUsers($username,$privelegeId,$password,$branchId,$mainBranch)

	{

		global $con;

		$status = FALSE;

		$query  = "INSERT INTO login(`username`, `password`, `privilegeId`,branchId,mainBranch)

		           VALUES ('".$username."', '".$password."', '".$privelegeId."','".$branchId."','".$mainBranch."')";

		//echo "<br>".$query."<br>";

		mysqli_query($con,$query);

		if(mysqli_affected_rows($con))

			$status = TRUE;

		return $status;

	}



	function blnResetPassword($userId,$password)

	{

		global $con;

		$status = FALSE;

		$query  = "UPDATE  login

				   SET    `password`     = '".$password."'

		           WHERE  `loginId`     = '".$userId."'   ";

		echo "<br>".$query."<br>";

		mysqli_query($con,$query);

		if(mysqli_affected_rows($con))

			$status = TRUE;

		return $status;query($con,$query);

		return $result;

	}
 function getSalesArea($branch1,$userType){
	global $con;	
			$query  = "SELECT branchName,branchId FROM branch WHERE status='1' and privillageId='".$userType."' and mainBranch='".$branch1."'" ;
			$result = mysqli_query($con, $query);	
			return $result;	
	 
 }


}

?>