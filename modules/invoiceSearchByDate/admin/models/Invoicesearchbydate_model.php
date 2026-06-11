<?php 
require_once("../../../../settings/connect_db.php");
class Invoicesearchbydate_model {
	function getInvoiceDetails($fromDate,$toDate){
	  global $con;
	  $query   = "SELECT I.invoiceId,I.invoiceNo,I.invoiceDate,I.totalAmountWithoutVat,I.vatAmount,I.totalAmountWithVat,I.discount,I.advanceAmount,RC.customerName
				  FROM invoice I 
				  INNER JOIN regularCustomer RC ON I.regularCustomerId=RC.regularCustomerId
				  WHERE I.invoiceDate BETWEEN '".$fromDate."'  AND '".$toDate."'
				  AND I.status='1'
				  ORDER BY I.invoiceDate";
	  $result  = mysqli_query($con,$query);
	   // print_r($query);
	  return $result;
  }
  
 function  getInvoiceDetailsView($invoiceId){
	 
	  global $con;
	  	 $query   = "SELECT SM.modelCode,SM.modelName,SU.unitName,ID.quantity,ID.unitPrice,ID.amount,
	                     I.totalAmountWithoutVat,I.vatAmount,I.totalAmountWithVat,I.discount,I.transactionType,
						 I.advanceAmount,I.invoiceNo,I.invoiceDate,RC.customerName
				  FROM invoice I INNER JOIN regularCustomer RC ON I.regularCustomerId=RC.regularCustomerId
				                 INNER JOIN invoiceDetails ID ON ID.invoiceId=I.invoiceId 
				                 INNER JOIN salesUnit SU ON ID.salesUnitId=SU.salesUnitId
				                 INNER JOIN salesModel SM ON SM.salesModelId=ID.salesModelId
				  WHERE ID.invoiceId='".$invoiceId."'";
				
				 
	  $result  = mysqli_query($con,$query);
	   // print_r($query);
	  return $result;
	 
 }
 
 /*function getInvoiceAmount($invoiceId){
	  global $con;
	  $query   = "SELECT totalAmountWithoutVat,vatAmount,totalAmountWithVat,discount,advanceAmount
				  FROM invoice 
				  WHERE invoiceId='".$invoiceId."'";
				 
	  $result  = mysqli_query($con,$query);
	   // print_r($query);
	  return $result;
  }*/
}
?>
