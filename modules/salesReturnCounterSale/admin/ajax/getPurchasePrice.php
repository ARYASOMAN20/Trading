<?php
require_once("../../../../modules/salesInvoice/admin/models/m_salesInvoice.php");

$objsalesInvoice		=	new M_salesInvoice();
$PurchasePriceOfItem=0;
if(isset($_POST['itemMasterId']))
{
	$itemMasterId			=	$_POST['itemMasterId'];	$importLocalStatus		=	$_POST['importLocalStatus'];
		if($importLocalStatus=='IMP')	
		{	
			$purchasePrices     = 0;
			$costPriceInKg   = 0;
		    $purchasePrices 	= 	$objsalesInvoice->getAvgPurchasePrice($itemMasterId);
			$count              =  $objsalesInvoice->getrowCount($itemMasterId);
			$checkIfOpeningStock =$objsalesInvoice->getOpeningStock($expiryDate,$itemMasterId,$privilageId,$branchId);
			if($checkIfOpeningStock>0){
			$resCustomerList1 	= 	$objsalesInvoice->getCostPrice($itemMasterId);
			$multiple          =   $objsalesInvoice->getmultipleOfCarton($itemMasterId);	 
			$costPriceInKg	    =   $resCustomerList1/$multiple; 	
			}	   
				
				if($resCustomerList1>0 || $count==0){
					 $count=$count+1;
			}
			 $PurchasePriceOfItem =($purchasePrices+$costPriceInKg)/$count;
		}else	
		{		
			$locPurchaseData 	= 	$objsalesInvoice->getPurchasePriceForLocalPurchase($itemMasterId);	
			while($row = mysqli_fetch_array($locPurchaseData))		
				{			
					$PurchasePriceOfItem	=	number_format($row['purchasePrice'], 2, '.', '');	
				}	
		}
	//$resCustomerList 	= 	$objsalesInvoice->getPurchasePrice($itemMasterId);
					
					/*$unitPurchasePrice              =  0;
					$sumOfPurchasePrice             =  0;
                   $count=mysqli_num_rows($resCustomerList);
				 
					while($row = mysqli_fetch_array($resCustomerList))
					{
						//$unitPurchasePrice              =   $row['purchasePrice'];
                        $sumOfPurchasePrice             =   $sumOfPurchasePrice+$row['purchasePrice'];
                        					
					}
				$resCustomerList1 	= 	$objsalesInvoice->getCostPrice($itemMasterId);	
			
			if($resCustomerList1>0 || $count==0){
				$count=$count+1;
			}
			$PurchasePriceOfItem =($sumOfPurchasePrice+$resCustomerList1)/$count;
			$PurchasePriceOfItem = number_format($PurchasePriceOfItem, 2, '.', '');*/
			if($PurchasePriceOfItem==0||$PurchasePriceOfItem==null)
			{
				$PurchasePriceOfItem	=	null;
			}
	echo $PurchasePriceOfItem;

}
?>