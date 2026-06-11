<?php
require_once("../../../../settings/connect_db.php");
class dailyReportByWarehouseWiseModel
{
	
	 
	
	
	function getCustomerStatement($fromDate, $toDate, $subAccountHeadId){ 
		
		global $con;
		$fromDate=date("Y-m-d", strtotime($fromDate));
		$toDate=date("Y-m-d", strtotime($toDate));
		$branchId = $_COOKIE['branchId'];
		$mainBranch             =   	$_COOKIE['mainBranch'];
		
		 $query = 'SELECT j_debit,j_credit,j_dateOfPayment,j_particulars,j_referenceId,j_remarks,j_voucherNo,j_narration
				  FROM accountJournal
				  WHERE `j_dateOfPayment` BETWEEN "'.$fromDate.'"  AND "'.$toDate.'" 
				        AND j_sub_account_id="'.$subAccountHeadId.'"
						AND j_status=1 AND j_branchId="'.$branchId.'"
				  ORDER BY j_dateOfPayment';
				  
	
		//print_r($query);
		$result = mysqli_query($con,$query);
   		return $result;
	
	}
	
	function getSubAccountDetails($branchId)
	{
		global $con;
		  $query = "SELECT subAccountHeadId,accountHeadId,subAccountHeadName
					FROM subAccountHead
					WHERE subAccountSalesareaId='$branchId'
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	
	function getDebitAmount($fromDate,$subAccountHeadId){
		global $con;
		
		$fromDate=date("Y-m-d", strtotime($fromDate));
		
		 $query = 'SELECT IFNULL(sum(j_debit),0) AS j_debit
				  FROM accountJournal
				  WHERE j_dateOfPayment<"'.$fromDate.'"
				        AND j_sub_account_id="'.$subAccountHeadId.'"
						AND j_status=1
				  ORDER BY j_sub_account_id';
				  
	
		//print_r($query);
		$result = mysqli_query($con,$query);
   		return $result;
		
	}
	
	function getCreditAmount($fromDate,$subAccountHeadId){
		global $con;
		
		$fromDate=date("Y-m-d", strtotime($fromDate));
		
		 $query = 'SELECT IFNULL(sum(j_credit),0) AS j_credit
				  FROM accountJournal
				  WHERE j_dateOfPayment<"'.$fromDate.'"
				        AND j_sub_account_id="'.$subAccountHeadId.'"
						AND j_status=1
				  ORDER BY j_sub_account_id';
				  
	
		//print_r($query);
		$result = mysqli_query($con,$query);
   		return $result;
		
	}
	
}
?>