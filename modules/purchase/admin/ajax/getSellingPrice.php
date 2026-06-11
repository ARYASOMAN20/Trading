<?php
require_once("../../../../modules/salesInvoice/admin/models/m_salesInvoice.php");

$objsalesInvoice		=	new M_salesInvoice();

$sellingPrice				=	'';
$itemMasterId				=	$_POST['itemMasterId'];
$regularCustomerId			=	$_POST['regularCustomerId'];

$sellingPriceData			=	$objsalesInvoice->getSellingPrize($regularCustomerId,$itemMasterId);
if(mysqli_num_rows($sellingPriceData)>0)
{
	while ($rowsellingPrice = 	mysqli_fetch_array($sellingPriceData))
		{
			$sellingPrice	=	$rowsellingPrice['sellingPrice'];
		} 
}else{
			$sellingPrice	=	0;
	
}


echo $sellingPrice;
?>