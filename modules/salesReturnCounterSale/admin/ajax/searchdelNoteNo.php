<?php
require_once("../../../../modules/salesInvoice/admin/models/m_salesInvoice.php");

$objsalesInvoice		=	new M_salesInvoice();

if(isset($_GET['term']))
{
	$delNoteNo			=	$_GET['term'];
	$resDelNoteNoList 	= 	$objsalesInvoice->getDelNoteNoComplete($delNoteNo);
	if($resDelNoteNoList)
	{
		$j_array=array();

		while($row = mysqli_fetch_array($resDelNoteNoList))
		{
			$array['key']   		= 	$row['deliveryNoteId'];
			$array['value'] 		= 	$row['delNoteNo'];
			array_push($j_array,$array);
		}

	}

	echo json_encode($j_array);

}
?>