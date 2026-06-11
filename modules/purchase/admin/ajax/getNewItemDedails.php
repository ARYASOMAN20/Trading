<?php
require_once("../../../../modules/purchase/admin/class/m_purchase.php");
$objMPurchase = new M_Purchase();

if(isset($_POST['itemMasterId']))
{
	$itemMasterId	=	$_POST['itemMasterId'];
	$resultArry		=	'';
	
	$itemData		=	$objMPurchase->getNewItemDetails($itemMasterId);
	while($row	=	mysqli_fetch_array($itemData))
	{
		$itemName		=	$row['itemName'];
		$itemCode		=	$row['itemCode'];
		$vat			=	$row['vat'];
		$importLocalStatus			=	$row['importLocalStatus'];
		
	}
	$resultArry			=	array(
									'itemName'=>$itemName,
									'itemCode'=>$itemCode,
									'vat'=>$vat,
									'importLocalStatus'=>$importLocalStatus
								);
echo json_encode($resultArry);
}

?>