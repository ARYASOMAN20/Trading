<?php 
require_once("../../../../settings/connect_db.php");
class Invoicesearchbyinvoiceno_model {
 
 public function invoiceNoAutocomplete($my_data,$branchId){
			global $con;
			/* $privilageId       	 	=   	$_COOKIE['privillegeId'];
			$branchId        		=   	$_COOKIE['branchId'];
			$userId					=		$_COOKIE['userId']; */
	    	/*$query   = "SELECT invoiceId,invoiceNo  
					 	FROM invoice 
						WHERE  invoiceNo LIKE '$my_data%' AND branchId='$branchId' AND privilageId='$privilageId'";
			$result  = mysqli_query($con,$query);
			return $result;*/
			// if($privilageId==12){
	    	$query   = "SELECT invoiceId,invoiceNo  
					 	FROM invoice 
						WHERE  invoiceNo LIKE '$my_data%' and status=1 AND branchId='$branchId'";
			$result  = mysqli_query($con,$query);
			return $result;
			/* }else{
			    
				$query   = "SELECT invoiceId,invoiceNo  
					 	FROM invoice 
						WHERE  invoiceNo LIKE '$my_data%' AND branchId='$branchId' AND privilageId='$privilageId' and status=1";
			$result  = mysqli_query($con,$query);
			return $result;
			} */
		}
		
public	function getInvoiceBasicDetails($invoiceId)
	{
		global $con; 
		  $query = "SELECT I.invoiceNo,I.invoiceDate,I.totalAmount,I.discountAmount,I.discountPercent,I.totalAmountAfterDiscount,I.vatPercent,I.vatAmount,I.totalAmountWithVat,RC.customerName,RC.vatNumber,RC.dueDate,V.vesselName,I.privilageId
				  FROM invoice I
				  INNER JOIN regularCustomer RC ON I.regularCustomerId=RC.regularCustomerId
				  LEFT JOIN vessel V ON I.vesselId=V.vesselId
				  WHERE invoiceId='".$invoiceId."'
				  ";		  
		$result = mysqli_query($con,$query);
		return $result;
	}
	
public function getInvoiceDetails($invoiceId)
	{
		global $con; 
		  $query = "SELECT invoiceDetails.itemCode,invoiceDetails.description,invoiceDetails.packageSize,invoiceDetails.itemUnitId,invoiceDetails.quantity,invoiceDetails.unitPrice,invoiceDetails.discountPercent,invoiceDetails.amount,invoiceDetails.vatPercent,invoiceDetails.vatAmount,invoiceDetails.amountWithVat,unit.unitName  
				  FROM invoiceDetails
				  LEFT JOIN itemUnit ON itemUnit.itemUnitId=invoiceDetails.itemUnitId
				  LEFT JOIN unit ON unit.unitId=itemUnit.unitId
				  WHERE invoiceDetails.invoiceId='".$invoiceId."'
				  ";		  
		$result = mysqli_query($con,$query);
		return $result;
	}
}
?>
