<?php
	require_once("../../../../modules/purchase/admin/class/m_purchase.php");
	$objMPurchase = new M_Purchase();
	if(isset($_GET['itemMasterId']))
	{
		$unitOption				= '';
		$itemMasterId	   		= $_GET['itemMasterId'];
		$resMaterialsUnitList 	= $objMPurchase->getMaterialsUnitAutoComplete($itemMasterId);
		if($resMaterialsUnitList)
	{

		while($row = mysqli_fetch_array($resMaterialsUnitList))
		{
			if($row['unitName']=='CARTON')
			{
				$selected	=	'selected';
			}else{
				$selected	=	'';
			}
			$unitOption	.=	'<option value="'.$row['itemUnitId'].'-'.$row['multiple'].'" '.$selected.'>'.$row['unitName'].'</option>';
		}

	}

	echo json_encode($unitOption);
	}


?>