<?php
	require_once("../../../../modules/salesReturnCounterSale/admin/models/SalesReturnItemWiseM.php");
	$SalesReturnItemWiseM = new SalesReturnItemWiseM();
	if(isset($_GET['itemMasterId']))
	{
		$unitOption				= '';
		$itemMasterId	   		= $_GET['itemMasterId'];
		$resMaterialsUnitList 	= $SalesReturnItemWiseM->getMaterialsUnitAutoComplete($itemMasterId);
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