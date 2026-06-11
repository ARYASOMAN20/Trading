<?php
	require_once("../../../../modules/purchase/admin/class/m_purchase.php");
	$objMPurchase = new M_Purchase();
	require_once("../../../../modules/salesInvoice/admin/models/m_salesInvoice.php");
	$objMSalesInvoice	= 	new M_salesInvoice();
	if(isset($_POST['itemMasterId']))
	{
		$unitOption				= '';
		$itemMasterId	   		= $_POST['itemMasterId'];
		$cartonFraction			=	'';
		$cartonPrice			=	'';
		$resMaterialsUnitList 	= $objMSalesInvoice->getMaterialsUnitAutoComplete($itemMasterId);
		if($resMaterialsUnitList)
	{

		while($row = mysqli_fetch_array($resMaterialsUnitList))
		{
			if($row['unitName']=='CARTON')
			{
				$cartonFraction	=	$row['multiple'];
			}
		}

	}
	
	echo $cartonFraction;
	}


?>