<?php
require_once('../../../../modules/itemMasterEdit/admin/controller/c_ItemMasterEdit.php');
$objCItemMasterEdit				= 	new ItemMasterEditController();
$itemMasterDetailsDataArray		=	'';

if(isset($_POST['itemMasterId']))
{
	$itemMasterId	=	$_POST['itemMasterId'];
	// $branchId     	=	$_POST['branchId'];
	$itemMasterDetailsDataArray		=	$objCItemMasterEdit->getitemMasterDetails($itemMasterId);	
	
}
echo json_encode($itemMasterDetailsDataArray);
?>