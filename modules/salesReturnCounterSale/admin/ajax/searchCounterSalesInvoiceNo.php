<?php
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

require_once("../../../../modules/salesReturnCounterSale/admin/models/SalesReturnItemWiseM.php");

$objsalesInvoice		=	new SalesReturnItemWiseM();

if(isset($_GET['term']))
{
	$invoiceNo			=	$_GET['term'];
	$resDelNoteNoList 	= 	$objsalesInvoice->getcountersalesInvoiceNo($invoiceNo);
	if($resDelNoteNoList)
	{
		$j_array=array();

		while($row = mysqli_fetch_array($resDelNoteNoList))
		{
			$array['key']   		= 	$row['invoiceId'];
			$array['value'] 		= 	$row['invoiceNo'];
			array_push($j_array,$array);
		}

	}

	echo json_encode($j_array);

}
?>