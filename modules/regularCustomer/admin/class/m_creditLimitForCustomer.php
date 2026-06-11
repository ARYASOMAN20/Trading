<?php
include_once("../../../../system/soft/php/admin/gateway.php");
require_once("../../../../settings/connect_db.php");
class M_CreditLimitForCustomer{
	
	function totalbillAmountForCustomer($branchId,$regularCustomerId){
		global  $con;
		$query   = " SELECT IFNULL(SUM(BR.billTotal),0) AS billAmount
					 FROM ".$branchId."_branchReceipt BR,regularCustomer R
					 WHERE R.regularCustomerId ='".$regularCustomerId."'
					 AND BR.regularCustomerId = R.regularCustomerId
					 GROUP BY R.regularCustomerId
				   ";
				//$result  = mysqli_query($con,$query);
		$result  = mysqli_query($con,$query);
		return $result;
	}
	function calculatePaidAmount($regularCustomerId){
		$sessionBranchId   = $_SESSION['sessionBranchId'];
		global  $con;
		$query   = " SELECT IFNULL(SUM(BA.amountPaid),0) AS paidAmount,BR.branchReceiptId
					 FROM ".$sessionBranchId."_branchReceipt BR,regularCustomer R,".$sessionBranchId."_branchReceiptAmount BA
					 WHERE R.regularCustomerId ='".$regularCustomerId."'
					 AND BR.regularCustomerId = R.regularCustomerId
					 AND BR.branchReceiptId = BA.branchReceiptId
					 GROUP BY R.regularCustomerId
					 
				   ";
				//$result  = mysqli_query($con,$query);
		$result  = mysqli_query($con,$query);
		return $result;
	}	
	function calculateReturnAmount($regularCustomerId){
		$sessionBranchId   = $_SESSION['sessionBranchId'];
		global  $con;
		$query   = " SELECT IFNULL(SUM(SR.salesReturnAmount),0) AS returnAmount
					 FROM ".$sessionBranchId."_salesReturn SR,".$sessionBranchId."_branchReceipt BR,regularCustomer R
					 WHERE R.regularCustomerId ='".$regularCustomerId."'
					 AND BR.regularCustomerId = R.regularCustomerId
					 AND BR.branchReceiptId = SR.branchReceiptId
					 GROUP BY R.regularCustomerId 
				   ";
				//$result  = mysqli_query($con,$query);
		$result  = mysqli_query($con,$query);
		return $result;
	}
	function exchangeAmount($regularCustomerId,$branchId){
		$sessionBranchId   = $_SESSION['sessionBranchId'];
		global  $con;
		$query   = " SELECT  IFNULL(SUM(SR.returnVoucherAmount) ,0) AS returnVoucherAmount,R.regularCustomerId
					 FROM  ".$sessionBranchId."_salesReturn SR,".$sessionBranchId."_branchReceipt BR,regularCustomer R,
					 		".$sessionBranchId."_billExchange BE
					 WHERE  R.regularCustomerId ='".$regularCustomerId."' 
					 AND R.regularCustomerId = BR.regularCustomerId 	
					 AND BR.branchReceiptId = BE.newBranchReceiptId	 
                                         AND BE.oldBranchReceiptId = SR.branchReceiptId	
                                         AND BE.salesReturnId = SR.salesReturnId
					 GROUP BY R.regularCustomerId 
				   ";
				//$result  = mysqli_query($con,$query);
		$result  = mysqli_query($con,$query);
		return $result;
	}
	function regularCustomerList(){
		global  $con;
		$query   = " SELECT regularCustomerId,customerName,customerNo,creditLimit
					 FROM  regularCustomer 
				   ";
				//$result  = mysqli_query($con,$query);
		$result  = mysqli_query($con,$query);
		return $result;
	}
	function customerDetails($regularCustomerId){
		$sessionBranchId   = $_SESSION['sessionBranchId'];
		global  $con;
		$query   = " SELECT regularCustomerId,customerName,customerNo,creditLimit
					 FROM  regularCustomer 
					 WHERE regularCustomerId ='".$regularCustomerId."'
					
				   ";
				//$result  = mysqli_query($con,$query);
		$result  = mysqli_query($con,$query);
		return $result;
	}										
}
?>