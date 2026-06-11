<?php
require_once('../../../../modules/invoiceEdit/admin/models/invoiceEditmodel.php');

$objinvoiceEditmodel	= 	new invoiceEditmodel();

if(isset($_GET['term']))
{
	$customerCode		=	$_GET['term'];
	$branchId			=	$_GET['branchId'];
	
	$resCustomerList 	= 	$objinvoiceEditmodel->getCustomerForAutoComplete($customerCode,$branchId);
		if($resCustomerList)
	{
		$j_array=array();

		while($row = mysqli_fetch_array($resCustomerList))
		{
			$array['key']   		= 	$row['regularCustomerId'];
			$array['value'] 		= 	$row['customerNo'].'/ '.$row['customerName'];				
			$array['customerNo'] 	= 	$row['customerNo'];
			$array['customerName'] 	= 	$row['customerName'];
			$array['vatNumber'] 	= 	$row['vatNumber'];
			array_push($j_array,$array);
		}

	}

	echo json_encode($j_array);


}
?>