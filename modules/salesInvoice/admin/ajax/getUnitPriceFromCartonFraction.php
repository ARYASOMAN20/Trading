<?php
	require_once("../../../../modules/purchase/admin/class/m_purchase.php");
	$objMPurchase = new M_Purchase();
	require_once("../../../../modules/salesInvoice/admin/models/m_salesInvoice.php");
	$objMSalesInvoice	= 	new M_salesInvoice();
	if(isset($_GET['itemMasterId']))
	{
		$unitOption				= '';
		$unitFraction=0;
		$itemMasterId	   		= $_GET['itemMasterId'];
		$itemunitId                 =  $_GET['unitId'];
		$itemUnitRowArray 		=	explode("-",$itemunitId);
		$itemUnitId				=	$itemUnitRowArray [0];
		$unitFraction			=	$itemUnitRowArray [1];
		$cartonFraction			=	'';
		$cartonPrice			=	'';
		$PurchasePriceOfItem=0;
		
		//$importLocalStatus		=	$_POST['importLocalStatus'];

		/*$resMaterialsUnitList 	= $objMPurchase->getMaterialsUnitIdAutoComplete($itemMasterId);
		if($resMaterialsUnitList)
	{

		while($row = mysqli_fetch_array($resMaterialsUnitList))
		{
			if($row['itemUnitId']=='unitId')
			{
				$cartonFraction	=	$row['multiple'];
			}
		}

	}*/
	//$array  = explode('-',$unitId);
	 //commented by gg
	 $highermultiple	=	$objMSalesInvoice->getMaterialsUnitAutoComplete($itemMasterId);
	 $rows = mysqli_fetch_array($highermultiple);
	 $unitFraction	=	$rows['multiple'];
	 $unitId        =   $rows['itemUnitId'];
	 $priceDeta	=	$objMSalesInvoice->getItemCartonPrice($itemMasterId);
	 if($row1 = mysqli_fetch_array($priceDeta))
	 	{
	 		$unitPricerow =	$row1['maxretailPrice'];

	 	}
		/*if($array[1]>0){*/
		if($unitPricerow==''|| $unitPricerow==INF){
			$unitPricerow=0;
		}
		if($unitFraction==''){
			$unitFraction=1;
		}
		if($itemUnitId==$unitId)
			$unitPrice1		= $unitPricerow;
		else
		$unitPrice1		= $unitPricerow/$unitFraction;
		// }else{
		// 	$unitPrice1		= $cartonPrice;
		// }
	//	echo $PurchasePriceOfItem;

		if($unitPrice1==null||$unitPrice1==0)
		{
			$unitPrice		=	null;
		}else{
			$unitPrice		=	number_format($unitPrice1, 2, '.', '');
		}
	echo $unitPrice;
	}


?>