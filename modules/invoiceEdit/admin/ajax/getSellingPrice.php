<?php
require_once('../../../../modules/deliveryNode/admin/models/Deliverynodemodel.php');
$objDeliverynodemodel	= 	new Deliverynodemodel();

$sellingPrice				=	'';
$itemMasterId				=	$_POST['itemMasterId'];
$regularCustomerId			=	$_POST['regularCustomerId'];

$sellingPriceData			=	$objDeliverynodemodel->getSellingPrize($regularCustomerId,$itemMasterId);
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