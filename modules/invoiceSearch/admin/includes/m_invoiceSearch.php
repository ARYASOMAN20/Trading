
<?php 
require_once("../../../../settings/connect_db.php");

class M_InvoiceSearch {
	
	function otherChargesDetails($invoiceId)
	{
			global $con;
	
				 $query = " SELECT Q.labourCharges AS totalLabour,SQ.otherCharges AS totalOtherCharges,
								SUM(U.fraction * QMD.quantity * QMD.unitPrice) AS total
								
								FROM materials M 

								INNER JOIN quotationMaterialDetails QMD ON QMD.materialsId = M.materialsId 
								INNER JOIN unit U ON U.unitId = QMD.unitId 
								INNER JOIN quotation Q  ON Q.quotationId = QMD.quotationId 
								INNER JOIN quotationInvoice QI ON QI.quotationId = Q.quotationId
			                    WHERE QI.quotationInvoiceId ='".$invoiceId."' 
						";
						//echo '<br />'.$query.'<br />';
						$result  = mysqli_query($con,$query);
			return $result;

	}
	
	function quotationVoucherSearch($invoiceId){
	global $con;
	$query = " SELECT QA.amountDate,QA.amountPaid,QA.quotationVoucherNo
		   FROM quotationInvoice QI
		   INNER JOIN quotationAmount QA ON QA.quotationInvoiceId = QI.quotationInvoiceId
		   INNER JOIN quotation Q ON Q.quotationId = QI.quotationId
		   WHERE QI.quotationInvoiceId ='".$invoiceId."'";
		    //echo '<br />'.$query.'<br />';
	$result = mysqli_query($con,$query);
	return $result;
}
	
	function listInvoiceNo($my_data)
	{
			global $con;
	    	$query   = "SELECT quotationInvoiceId,quotationInvoiceNo  
					 	FROM quotationInvoice 
						WHERE quotationInvoiceNo LIKE '%$my_data%' ";
			$result  = mysqli_query($con,$query);
			return $result;

	}
	
	
	function  invoiceSearch($invoiceId){
	global $con;
	 $query = "SELECT Q.quotationNo,QI.quotationInvoiceNo,Q.otherCharges,Q.labourCharges,Q.quotationTotalAmount,
       		  		M.materialsName,U.unitName,U.fraction,QM.quantity,QM.unitPrice,R.customerName,R.contactNo_1,
					Q.quotationId,R.customerNo,Q.quotationDate,Q.labourCharges,Q.otherCharges
			  FROM quotation Q
			  INNER JOIN quotationMaterialDetails QM ON QM.quotationId = Q.quotationId
			  INNER JOIN unit U ON U.unitId = QM.unitId
			  INNER JOIN materials M ON M.materialsId = QM.materialsId
			  INNER JOIN regularCustomer R ON R.regularCustomerId = Q.customerId
			  INNER JOIN quotationInvoice QI ON QI.quotationId = Q.quotationId
			  WHERE QI.quotationInvoiceId ='".$invoiceId."' 
			 ";
			//echo '<br />'.$query.'<br />';


	$result = mysqli_query($con,$query);
	return $result;
	}
	
}  

	

	
	

	?>