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
		 $importLocalStatus 	= $objMSalesInvoice->getImportLocalStatus($itemMasterId);
		 
		if($importLocalStatus=='IMP')	
		{	
			$purchasePrices     	= 	0;
			$costPriceInKg   		= 	0;
		    $purchasePrices 		= 	$objMSalesInvoice->getAvgPurchasePrice($itemMasterId);
			$count              	=  	$objMSalesInvoice->getrowCount($itemMasterId);

			$resCustomerList1 		= 	$objMSalesInvoice->getCostPrice($itemMasterId);
			$multiple          		=   $objMSalesInvoice->getmultipleOfCarton($itemMasterId);	 
			/*$costPriceInKg	    	=   $resCustomerList1/$multiple; */	
				
			$costPriceInKg	    	=   $resCustomerList1; 	
   
				
				if($resCustomerList1>0 || $count==0)
				{
					 $count=$count+1;
				}
			 $PurchasePriceOfItem =($purchasePrices+$costPriceInKg)/$count;
			// $PurchasePriceOfItem	=	number_format($PurchasePriceOfItem, 2, '.', '');	
		}else	
		{		
			$locPurchaseData 	= 	$objMSalesInvoice->getPurchasePriceForLocalPurchase($itemMasterId);	
			$numRows			=	mysqli_num_rows($locPurchaseData);
			if($numRows>0)
			{
			while($row = mysqli_fetch_array($locPurchaseData))		
				{			
					$PurchasePriceOfItem	=	number_format($row['purchasePrice'], 2, '.', '');	
				}	
			}else{
				$costPrices				=	$objMSalesInvoice->getCostPrice($itemMasterId);
				$multiple          		=   $objMSalesInvoice->getmultipleOfCarton($itemMasterId);	 
				/*$PurchasePriceOfItem	=	number_format($costPrices/$multiple, 2, '.', '');*/
			$PurchasePriceOfItem	=	$costPrices;
			}
			
		}
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
	//$priceDeta	=	$objMSalesInvoice->getItemCartonPrice($itemMasterId); commented by gg
	// $priceDeta	=	$objMSalesInvoice->getPurchasePrice($itemMasterId);
	// while($row1 = mysqli_fetch_array($priceDeta))
	// 	{
	// 		$unitPrice1	=	$row1['purchasePrice'];

	// 	}
		/*if($array[1]>0){*/
		if($PurchasePriceOfItem==''|| $PurchasePriceOfItem==INF){
			$PurchasePriceOfItem=0;
		}
		if($unitFraction==''){
			$unitFraction=0;
		}
		$unitPrice1		= $PurchasePriceOfItem*$unitFraction;
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