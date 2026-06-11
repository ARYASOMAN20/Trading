<?php
require_once("../../../../modules/salesInvoice/admin/models/m_salesInvoice.php");

$objsalesInvoice		=	new M_salesInvoice();

if(isset($_GET['term']))
{
	$customerCode		=	$_GET['term'];
	
	$resCustomerList 	= 	$objsalesInvoice->getCustomerForAutoComplete($customerCode);
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