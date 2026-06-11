<?php
require_once("../../../../modules/purchase/admin/class/m_purchase.php");
$objMPurchase = new M_Purchase();
	if(isset($_POST['itemMasterId']))
	{
		$cartonFraction			=	'';
		$itemMasterId			=	$_POST['itemMasterId'];
		$resMaterialsUnitList 	= 	$objMPurchase->getMaterialsUnitAutoComplete($itemMasterId);
		if($resMaterialsUnitList)
		{

			while($row = mysqli_fetch_array($resMaterialsUnitList))
			{
				if($row['unitName']=='CARTON')
				{
					$cartonFraction			=	$row['multiple'];
				}
			}

		}
		echo $cartonFraction;
	}
?>