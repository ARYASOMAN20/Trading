<?php
/*------------------------------------Coding And Design By AK---------------------------------------*/
/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); */

// require_once("../../../../libraries/class/utils.php");
require_once("../../../../modules/salesReturnCounterSale/admin/controllers/SalesReturnItemWiseC.php");
//require_once("../../../../settings/path.php");

//$objPath          		= 	new Path();
$SalesReturnItemWiseC		= 	new SalesReturnItemWiseC();
$currencyData =null;

$maxInvoiceNo 			= $SalesReturnItemWiseC->getlastSalesReturnNo();

$currencyData			=	$SalesReturnItemWiseC->getCurrencyData();

$salesPaymentVoucherNo	=	'';
$customerSalesPaymentId	=	''; 
$netAmountWithExRate	=	0;
$totalCostValue         =   0;
$table                  =  '';
$privilageId            =  '';
$userId                 =  '';
$userId                 =  '';
$regularCustomerId		=$selectBoxCurrency = $selectBoxVessel= $tbody= '';
if(isset($_COOKIE['privillegeId'])) {
	$privilageId       	 	=   	$_COOKIE['privillegeId'];
	$branchId        		=   	$_COOKIE['branchId'];
	$userId					=		$_COOKIE['userId'];
}
else{
	$privilageId       	 	=  '6' ;	
	$branchId        		=  '5' ;	
	$userId					=	'6';	
}
if(isset($_POST['search'])) {
	$totalQty					=	0;
	$totalNetWeight				=	0;
	$SalesInvoiceNo			    =	$_POST['invoiceNo'];
	$salesInvoiceId				=	$_POST['invoiceId'];

	$branchDetails     		=	$SalesReturnItemWiseC->getBranchDetailsOfInvoice($salesInvoiceId);
	while($row=mysqli_fetch_array($branchDetails))
	{
		$privilageId       	 	=   	$row['privilageId'];
		$branchId        		=   	$row['branchId'];
		$userId					=		$row['userId'];
		$mainBranch        		= 		$row['mainBranch'];
	}

	$invoiceDetails     		=	$SalesReturnItemWiseC->getInvoiceDetails($salesInvoiceId,$privilageId,$branchId);
	
	$invoiceDate=$invoiceNo=$transactionType=$poNo=$quotationNo=$customerName=$customerNo=$vatNumber=$discountAmount=$vatPercent=$totalAmountAfterDiscount='';
	$vesselName=$currencyName=$regularCustomerId=$vesselId=$currencyId=$totalWithOutvat=$vatAmount=$totalWithVat=$discountPercent=$damagedGoodsReturn=$damagedGoodsAmount=$transactionType=$discountPercentInvoice='';
	
	while($fetch_invoiceDetails= mysqli_fetch_array($invoiceDetails)){
		$invoiceId    	    =	$fetch_invoiceDetails['invoiceId'];
		$invoiceDate    	=	$fetch_invoiceDetails['invoiceDate'];
		$invoiceNo			=	$fetch_invoiceDetails['invoiceNo'];
		$transactionType    =	$fetch_invoiceDetails['transactionType'];
		if($transactionType==1)
		{
			$transactionTypeCss		=	'';
			$transactionTypeName	=	'<option value="1" selected >Cash Invoice</option>
										<option value="2">Credit Invoice</option>';
		}else{
			$transactionTypeCss		=	'';
			$transactionTypeName	=	'<option value="1"  >Cash Invoice</option>
										<option value="2" selected >Credit Invoice</option>';
		}
		$invoiceRefId       =   $fetch_invoiceDetails['invoiceRefId'];
		$customerName		=	$fetch_invoiceDetails['customerName'];
		$customerNo			=	$fetch_invoiceDetails['customerNo']; 
		$regularCustomerId	=	$fetch_invoiceDetails['regularCustomerId'];
		$currencyId     	=	$fetch_invoiceDetails['currencyId'];
		$round             = $fetch_invoiceDetails['round'];
		$roundAmount             = $fetch_invoiceDetails['roundAmount'];
		$totalWithOutvat	=	$fetch_invoiceDetails['totalAmount'];
		if($totalWithOutvat==0)
		{
			$totalWithOutvat       =	'';
		}else{
			$totalWithOutvat       = number_format($totalWithOutvat,2,'.','');
		}
	    $vatAmount			=	$fetch_invoiceDetails['vatAmount'];
		if($vatAmount==0)
		{
			$vatAmount       =	'';
		}else{
			$vatAmount       	= number_format($vatAmount,2,'.','');
		}
	    $totalWithVat		=	$fetch_invoiceDetails['totalAmountWithVat'];
		if($totalWithVat==0)
		{
			$totalWithVat       =	'';
		}else{
			$totalWithVat       = number_format($totalWithVat,2,'.','');
		}
		$discountAmount		=	$fetch_invoiceDetails['discountAmount'];
		if($discountAmount==0)
		{
			$discountAmount       =	'';
		}else{
			$discountAmount     = number_format($discountAmount,2,'.','');
		}
	    $discountPercent	=	$fetch_invoiceDetails['discountPercent'];
	
		$discountInAmounts  = ($totalWithOutvat*$discountPercent)/100;
			if($discountPercent==0)
		{
			$discountPercent       =	'';
		}
		
		$discountInAmounts  = number_format($discountInAmounts,2,'.','');
		$vatPercent     	=	$fetch_invoiceDetails['vatPercent'];
		if($vatPercent==0)
		{
			$vatPercent       =	'';
		}
		$totalAmountAfterDiscount =	$fetch_invoiceDetails['totalAmountAfterDiscount'];
		if($totalAmountAfterDiscount==0)
		{
			$totalAmountAfterDiscount       =	'';
		}else{
			$totalAmountAfterDiscount       = number_format($totalAmountAfterDiscount,2,'.','');
		}
		$exRate             =   $fetch_invoiceDetails['exRate']; 		
		$damagedGoodsReturn =   $fetch_invoiceDetails['damagedGoodsReturn']; 		
		$damagedGoodsAmount =   $fetch_invoiceDetails['damagedGoodsAmount']; 
		if($damagedGoodsAmount==0)
		{
			$damagedGoodsAmount       =	'';
		}else{
			$damagedGoodsAmount       = number_format($damagedGoodsAmount,2,'.','');
		}
		$customerNameInvoice =   $fetch_invoiceDetails['customerNameInvoice']; 
		$customerPhone 		=   $fetch_invoiceDetails['customerPhone']; 
		if($privilageId==2)
		{
			$customerName	=	$customerNameInvoice;
		}
	}
	
	
	if($privilageId==3)
	{
		$customerNameReadOnly	=	'readOnly';	
	}else{
		$customerNameReadOnly	=	'';	
	}
	$paymentDetails     		=	$SalesReturnItemWiseC->getPaymentDetails($salesInvoiceId);
	if($paymentDetails>0 && $transactionType==2)
	{
		$customerCodeReadOnly	=	'readOnly';	
	}else{
		$customerCodeReadOnly	=	'';	
	}
	//if($paymentDetails==0&& $transactionType==2){
	
	
	$getCurrecy                =   $SalesReturnItemWiseC->getCurrecy();
	$getVessel                 =   $SalesReturnItemWiseC->getVessel();
	
	$selectBoxCurrency .='<select style="width:100%" class="input-sm" id="currencyId" onchange="getExchangeRate(this.value);" name="currencyId" >';
	while($fetch_getCurrecy= mysqli_fetch_array($getCurrecy)){
			if($fetch_getCurrecy['currencyId']==$currencyId){
						$selected='selected';
					}else{
						$selected='';
					}
					$selectBoxCurrency .='<option value="'.$fetch_getCurrecy['currencyId'].'/'.$fetch_getCurrecy['exRate'].'" '.$selected.'>'.$fetch_getCurrecy['currencyName'].'</option>';
				}
				$selectBoxCurrency .='</select>'; 
				
				$selectBoxVessel .='<select style="width:100%" class="input-sm" id="vesselId" name="vesselId" >';
	while($fetch_getVessel= mysqli_fetch_array($getVessel)){
			if($fetch_getVessel['vesselId']==$vesselId){
						$selected='selected';
					}else{
						$selected='';
					}
					$selectBoxVessel .='<option value="'.$fetch_getVessel['vesselId'].'" '.$selected.'>'.$fetch_getVessel['vesselName'].'</option>';
				}
				$selectBoxVessel .='</select>'; 
	 
	$i=1;
	$k=1;
	$totalWithOutvatInvoice=0;
	$bodyDetails                =   $SalesReturnItemWiseC->printInvoiceBody($salesInvoiceId);
	
	while($fetch_bodyDetails= mysqli_fetch_array($bodyDetails)){
		$getAllUnits=$selectBox=$selected=$itemMasterId=$editTextBox=$selectBoxOld=null;
		$actualQuantity			=	$fetch_bodyDetails['quantity'];//dschange
		$invoiceDetailsId		=	$fetch_bodyDetails['invoiceDetailsId'];//dschange 
		$actualNetWeight		=	$fetch_bodyDetails['netWeight'];//dschange
		$itemMasterId			=	$fetch_bodyDetails['itemMasterId'];
		$returnedQuantity1		=	$SalesReturnItemWiseC->getReturnedQuantity($salesInvoiceId,$itemMasterId,$invoiceDetailsId);//dschange
		$returnedQuantity		=	$returnedQuantity1['returnedQuantity'];//dschange
		$returnedWeight			=	$returnedQuantity1['returnedWeight'];//dschange
		$quantity				=	$actualQuantity-$returnedQuantity;//dschange
		$weight				=	$actualNetWeight-$returnedWeight;//dschange		
		// echo '<center><br>returnedQuantity='.$returnedQuantity;	 //dschange	
		// echo '<br>actualQuantity='.$actualQuantity;  //dschange
		// echo '<br>returnedWeight='.$returnedWeight;	 //dschange	
		// echo '<br>actualNetWeight='.$actualNetWeight;  //dschange

		$unitPriceInvoice 				= 	$fetch_bodyDetails['unitPrice']; //dschange
		$rowAmountInvoice				=	$quantity*$unitPriceInvoice;	 //dschange
		$rowAmountInvoice				=	number_format($rowAmountInvoice, 2, '.', ''); //dschange
		$vatPercentInvoice				=	$fetch_bodyDetails['vatPercent']; //dschange
		$vatAmountInvoice				=	$fetch_bodyDetails['vatAmount']; //dschange	

		$vatAmountRowInvoice			=	($rowAmountInvoice*$vatPercentInvoice)/100; //dschange		

		$vatAmountRowInvoice			=	number_format($vatAmountRowInvoice, 2, '.', ''); //dschange

		$amountWithVatRowInvoice		=	$rowAmountInvoice+$vatAmountRowInvoice; //dschange
		$amountWithVatRowInvoice		=	number_format($amountWithVatRowInvoice, 2, '.', ''); //dschange

		$totalWithOutvatInvoice			=	$totalWithOutvatInvoice+$rowAmountInvoice;
		$totalWithOutvatInvoice			=	number_format($totalWithOutvatInvoice, 2, '.', ''); //dschange


		$discountPercentInvoice			=	$discountPercent; //dschange
		if($discountPercentInvoice==0 || $discountPercentInvoice=='') //dschange
		{
			$discountPercentInvoice       =	'';//dschange
		}
		$discountInAmountInvoice1  		= ((float)$totalWithOutvatInvoice*(float)$discountPercentInvoice)/100; //dschange
		$discountInAmountInvoice1     	= number_format($discountInAmountInvoice1,2,'.',''); //dschange

		$discountInAmountInvoiceHidden     = number_format($discountInAmountInvoice1,2,'.','');		 //dschange

		if($round!=''){
			$discountInAmountInvoice		=	$discountInAmountInvoice1+$roundAmount;//dschange
			$discountInAmountInvoice     	= 	number_format($discountInAmountInvoice,2,'.','');//dschange

		}
		else{
			$discountInAmountInvoice		=	$discountInAmountInvoice1;//dschange
		}

		


		$totalAmountAfterDiscountInvoice		=	$totalWithOutvatInvoice-$discountInAmountInvoice;//dschange
		$totalAmountAfterDiscountInvoice     	= number_format($totalAmountAfterDiscountInvoice,2,'.','');//dschange
		$damagedGoodsAmountInvoice				=	$damagedGoodsAmount;
		$amountAfterDamageInvoice				=	$totalAmountAfterDiscountInvoice-(float)$damagedGoodsAmountInvoice;//dschange		
		$amountAfterDamageInvoice     			= 	number_format($amountAfterDamageInvoice,2,'.','');//dschange
		$vatAmountInvoice						=	($amountAfterDamageInvoice*$vatPercent)/100;//dschange
		$vatAmountInvoice     					= 	number_format($vatAmountInvoice,2,'.','');//dschange
		$totalWithVatInvoice					=	$amountAfterDamageInvoice+$vatAmountInvoice;//dschange
		$totalWithVatInvoice     				= 	number_format($totalWithVatInvoice,2,'.','');//dschange

		// echo '<br>vatPercent:-'.$vatPercent;//dschange
		// echo '<br>amountAfterDamageInvoice:-'.$amountAfterDamageInvoice;//dschange
		// echo '<br>vatAmountInvoice:-'.$vatAmountInvoice.'</center>';//dschange
		if($itemMasterId!=0){
			$selectBoxReturn='<select  class="input-sm itemUnitRow" name="itemUnitRow" id="itemUnitRow'.$i.'" onchange="checkUnit('.$i.') required style=" width: 100%;"><option value="'.$fetch_bodyDetails['itemUnitId'].'-'.$fetch_bodyDetails['multiple'].'" selected >'.$fetch_bodyDetails['unitName'].'</option></select>';

// 		$getAllUnits=$SalesReturnItemWiseC->getAllUnits($itemMasterId);
		
// 	$selectBox .='<select  class="input-sm itemUnitRow" name="itemUnitRow" id="itemUnitRow'.$i.'" onchange="checkUnit('.$i.') required style="
//     width: 100%;
// ">
// 	                <!--<option value="">-unit-</option>-->';
// 		while($fetch_rowsOfUnit= mysqli_fetch_array($getAllUnits)){
// 			if($fetch_rowsOfUnit['itemUnitId']==$fetch_bodyDetails['itemUnitId']){
// 						$selected='selected';
// 					}else{
// 						$selected='';
// 					}
// 					$selectBox .='<option value="'.$fetch_rowsOfUnit['itemUnitId'].'-'.$fetch_rowsOfUnit['multiple'].'" '.$selected.'>'.$fetch_rowsOfUnit['unitName'].'</option>';
// 				}
// 				$selectBox .='</select>'; 	
		}
		$sumOfPurchasePrice=0;
		$importLocalStatus	=	$fetch_bodyDetails['importLocalStatus'];
		$PurchasePriceOfItem 	= 	$SalesReturnItemWiseC->getPurchasePrice($itemMasterId,$importLocalStatus);

		
		$itemUnitId		=	$fetch_bodyDetails['itemUnitId'];
		$unitName    	=   $SalesReturnItemWiseC->getUnitName($itemUnitId);
		if($unitName=='OTHER')
		{
			$readonly	=	'';
		}else{
			$readonly	=	'readonly';
		}
		$stockValue		=	$SalesReturnItemWiseC->getStockValue($fetch_bodyDetails['stockId'],$privilageId,$branchId);
		$totalStockValue	=	$stockValue+$fetch_bodyDetails['netWeight'];
		$totalStockValue	=	number_format($totalStockValue, 2, '.', '');
		
		$minimumRate		=	$fetch_bodyDetails['minimumRate'];
		$maxretailPrice		=	$fetch_bodyDetails['maxretailPrice'];
		
			$vatTble='';
		
		if($invoiceRefId>'0'){
		    	$vatTble='	<input style="width: 40%;" class="input-sm vatPercentRow" type="hidden" value="0" id="vatPercentRow'.$i.'" onkeyup="checkNumber(this.id); calculateRowTotal('.$i.');" readonly>

						<input style="width:50% !important" value="0" type="hidden" id="vatAmountRow'.$i.'"  class=" input-sm vatAmountRowTotal vatAmountRowTotalForSum" readonly/>
					<input style="width: 100%;" class="input-sm amountWithWithVatRowTotal" type="hidden" value="0" id="amountWithWithVatRow'.$i.'" readonly>';
		  
		    
		}else{
		      $vatTble='	<td>						
						<input style="width: 40%;" class="input-sm vatPercentRow" type="text" value="'.$fetch_bodyDetails['vatPercent'].'" id="vatPercentRow'.$i.'" onkeyup="checkNumber(this.id); calculateRowTotal('.$i.');" readonly>

						<input style="width:50% !important" value="'.$vatAmountRowInvoice.'" type="text" id="vatAmountRow'.$i.'"  class=" input-sm vatAmountRowTotal vatAmountRowTotalForSum" readonly/>
						</td>


						<td style="direction: rtl;">
						<input style="width: 100%;" class="input-sm amountWithWithVatRowTotal" type="text" value="'.$amountWithVatRowInvoice.'" id="amountWithWithVatRow'.$i.'" readonly>
						</td>
                    ';
	
		}
		
		
		
		$tbody .= '<tr id="trRow'.$i.'" class="trRow" >

						<td style="text-align:center"><span class="indexNo indexNoHide" id="indexNo'.$i.'">'.$k++.'</span>
						</td>
						<td>
							<input type="hidden" id="invoiceDetailsId'.$i.'" class="input-sm invoiceDetailsId" value="'.$fetch_bodyDetails['invoiceDetailsId'].'">
							<input type="hidden" value="1" id="status'.$i.'" class="statusRow">
							<input type="hidden" value="'.$i.'" id="sNo'.$i.'" class="sNo">
							<input type="hidden" value="'.$fetch_bodyDetails['stockId'].'" id="stockIdRow'.$i.'" class="stockIdRow">
							<input type="hidden" id="itemCodeRow'.$i.'"  class="form-control input-sm itemCodeRow" value="'.$fetch_bodyDetails['itemCode'].'" >
							<input type="hidden" id="itemMasterId'.$i.'" class="form-control input-sm itemMasterId" value="'.$fetch_bodyDetails['itemMasterId'].'">
							<input type="hidden" id="stockValue'.$i.'" class="form-control input-sm stockValue" value="'.$totalStockValue.'">
							'.$fetch_bodyDetails['itemCode'].'/'.$fetch_bodyDetails['itemName'].'
						</td>
						
						<td>
							<input style="width:100% !important;direction: rtl;float: left;" type="text" id="quantityRow'.$i.'" onkeyup="checkNumber(this.id);calculateRowTotal('.$i.');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'.$i.',this.id);" onchange="checkNumber(this.id);calculateRowTotal('.$i.');clearDiscount();clearRound();" value="'.$quantity.'" class=" input-sm quantityRow quantityRowForSum">

							<input type="hidden" id="oldQuantity'.$i.'" class="oldQuantity bg-info" value="'.$quantity.'" /><!--dschange-->
						</td>
						
						<td>'.$selectBoxReturn.'</td>
						
						<td>
							<input  value="'.$weight.'"  id="netWeightRow'.$i.'" style="width: 100%;direction: rtl;" type="text" onkeyup="checkNumber(this.id);calculateRowTotal('.$i.');clearDiscount();clearRound();" onchange="checkNumber(this.id);calculateRowTotal('.$i.');clearDiscount();clearRound();" class=" input-sm netWeightRow netWeightRowForSum" '.$readonly.'>
							<input type="hidden" id="netWeightOld'.$i.'"  class="input-sm netWeightOldRow" value="'.$weight.'">

							<input type="hidden" id="oldWeight'.$i.'" class="oldWeight bg-info" value="'.$weight.'" /><!--dschange-->
						</td>
						<td>
							<input style="width:100% !important;direction: rtl;" value="'.$unitPriceInvoice.'" id="unitPriceRow'.$i.'" onkeyup="checkNumber(this.id);calculateRowTotal('.$i.');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'.$i.',this.id);" onchange="checkNumber(this.id);checkminimumRate('.$i.');calculateRowTotal('.$i.');clearDiscount();clearRound();" type="text" class=" input-sm amountRowTotal" readonly>
						</td>
						
						<td>
							<input style="width:100% !important;direction: rtl;" type="text"  id="amountWithOutDiscount'.$i.'" value="'.$rowAmountInvoice.'" class="input-sm amountRowWithOutDiscount amountRowWithOutDiscountForSum" readonly="">						
							<input type="hidden" id="purchasePrice'.$i.'" class="purchasePrice" value="'.$PurchasePriceOfItem.'" />
							<input type="hidden" id="sellingPriceHiddenVal'.$i.'" class="sellingPriceHiddenVal" value="'.$maxretailPrice.'" />
							<input type="hidden" id="minimumRate'.$i.'" value="'.$minimumRate.'" class="minimumRate" />
						</td>'.$vatTble.'

						<td><button type="button" onclick="deleteRow('.$i.')" id="deleteBtn" class="btn btn-danger btnSubmit HideBtn btn-xs deleteBtn"><i class="fa fa-times"></i></button></td>
				    
				   </tr>';
				   $totalQty		=	$totalQty+$quantity; //dschange
				   $totalNetWeight	=	$totalNetWeight+$weight; //dschange
				   $i++;
		}
}


if(isset($_POST['submit'])) 
{
	/*-------------------------------insert To  invoice Table------------------------------------*/
	$returnNo				=	$SalesReturnItemWiseC->getMaxSalesReturnNo();
	$returnDate				=	implode("-",array_reverse(explode("-",$_POST['returnDate'])));
	$regularCustomerId		=	$_POST['regularCustomerId'];
	
	$currencyData			=	$_POST['currencyId']; 
	$currencyDataArray		=	explode('/',$currencyData);
	$currencyId				=	$currencyDataArray[0];
	$exRate					=	$_POST['exRate'];

	$totalAmount			=	$_POST['totalAmount'];
	$discountInPercent		=	$_POST['discountInPercent'];
	$discountInAmount		=	$_POST['discountInAmount'];
	
	$totalAfterDiscount		=	$_POST['amountAfterDiscountTotal'];
	$vatPercent				=	$_POST['vatInPercent'];
	$vatAmount				=	$_POST['vatAmount'];
	$netAmount				=	$_POST['netAmount'];
	$roundOff               =   $_POST['roundOff'];
	$roundAmount            =   $_POST['roundAmount'];
	$transactionType		= 	$_POST['transactionType'];
	if(isset($_COOKIE['privillegeId'])) {
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		$userId					=		$_COOKIE['userId'];
		$mainBranch        		= 		$_COOKIE['mainBranch'];
	}
	else{
		$privilageId       	 	=   	'6';
		$branchId        		=   	'5';
		$userId					=		'6';
		$mainBranch        		= 		'J';
	}
	$invoiceIdToSave            =   $_POST['invoiceIdToSave'];
	
	$cuttingCharge=0;
	$damagedGoodsAmount=$_POST['damagedGoodsAmount'];
	if($damagedGoodsAmount==''|| $damagedGoodsAmount==null || $damagedGoodsAmount==0 )
			{
				$damagedGoodsAmount	=	0;
			}
	
	if($exRate==''|| $exRate==null || $exRate==0 )
			{
				$exRate	=	1;
			}
	$netAmountWithExRate	=	number_format(($netAmount*$exRate), 2, '.', '');
	$cuttingCharge      =   number_format(($cuttingCharge*$exRate), 2, '.', '');
	$salesReturnId		=	$SalesReturnItemWiseC->insertToSalesReturn($returnNo,$returnDate,$regularCustomerId,
								$currencyId,$exRate,$totalAmount,$discountInPercent,$discountInAmount
								,$totalAfterDiscount,$vatPercent,$vatAmount,$netAmount,
								$netAmountWithExRate,$userId,$branchId,$privilageId,$mainBranch,$roundOff,$roundAmount,$invoiceIdToSave,$damagedGoodsAmount,$transactionType);

	/*-------------------------------insert To  invoice Table Ends------------------------------------*/
	/*-------------------------------insert To  invoiceDetails Table------------------------------------*/
	 
	 $tableValueArray	= json_decode($_POST['tableValueArray']);
	 for($i=0; $i<count($tableValueArray); $i++)
	 {	 
		if($tableValueArray[$i][1]!=null)
		{
			$stockIdRow[]				=	$tableValueArray[$i][4];
			$itemMasterId[]				=	$tableValueArray[$i][5];
			$quantityRow[]				=	$tableValueArray[$i][6];
			$itemUnitRow[]				=	$tableValueArray[$i][7];
			$netWeightRow[]				=	$tableValueArray[$i][8];
			$unitPriceRow[]				=	$tableValueArray[$i][10];
			$rowTotal[]					=	$tableValueArray[$i][11];
			$vatPercentageRow[]			=	$tableValueArray[$i][13];
			$vatAmountRow[]				=	$tableValueArray[$i][14];
			$rowTotalWithVatRow[]		=	$tableValueArray[$i][15];  
		}
	 }
	
		
		$totalCostValue =0;

	
		for($i=0;$i<count($itemMasterId);$i++)
		{
			if ($quantityRow[$i]>0) 
			{
				$itemUnitRowArray 		=	explode("-",$itemUnitRow[$i]);
				$itemUnitId				=	$itemUnitRowArray [0];
				$unitFraction			=	$itemUnitRowArray [1];
				
				
				$salesReturnDetailsId=$SalesReturnItemWiseC->insertIntoSalesReturnDetails($salesReturnId,$stockIdRow[$i],$itemMasterId[$i],
					$itemUnitId,$unitFraction,$quantityRow[$i],$netWeightRow[$i],$unitPriceRow[$i],$rowTotal[$i],$vatPercentageRow[$i],$vatAmountRow[$i],$rowTotalWithVatRow[$i]);
					
				$SalesReturnItemWiseC->addStock($privilageId,$branchId,$stockIdRow[$i],$netWeightRow[$i]);
				// new
				$remainingStock		=	$SalesReturnItemWiseC->getRemainingStockFromStockTable($stockIdRow[$i],$privilageId,$branchId);
				$SalesReturnItemWiseC->insertItemTransferDetails($returnDate,$returnNo,$regularCustomerId,
						$itemMasterId[$i],$stockIdRow[$i],$quantityRow[$i],$itemUnitId,$unitFraction,$netWeightRow[$i],
						$salesReturnDetailsId,$privilageId,$branchId,$userId,$mainBranch,$remainingStock);
						
						
				$getPurchasePrice =$purchasePrice=0;			
				$localImportStatus = $SalesReturnItemWiseC->localImportStatus($itemMasterId[$i]);
					
				if($localImportStatus=='IMP'){
					$getPurchasePrice = $SalesReturnItemWiseC->getImportPurchasePrice($itemMasterId[$i]);
				}else{
					$getPurchasePrice = $SalesReturnItemWiseC->getLocalPurchasePrice($itemMasterId[$i]);
				}

				$purchasePrice          =   $getPurchasePrice*$netWeightRow[$i];
				
				$totalCostValue  			= 	$totalCostValue + $purchasePrice;
				
			}
			/*$accountJournalCreditAmount	=	$totalAfterDiscount-$damagedGoodsAmount;
			$netAmountExRate 			= $netAmount*$exRate;
			$totalAmountExRate 			= $accountJournalCreditAmount*$exRate;
			$vatAmountExRate  			= $vatAmount*$exRate;
			$discountInAmountExRate  	= (float)$discountInAmount*(float)$exRate;*/
			
			/*$SalesReturnItemWiseC->insertInvoiceToAccountJournel($netAmountExRate,$totalAmountExRate,
						$vatAmountExRate,$discountInAmountExRate,$returnNo,$regularCustomerId,
						$salesReturnId,$returnDate,$userId,$privilageId,$branchId,$mainBranch,$totalCostValue,$cuttingCharge);
			
			//$objPath->setHeader('salesReturnCounterSale',"Success!!!  Sales Return No $returnNo",'salesReturnCounterSale');
			//header("Location: salesReturnCounterSalePrint.php?salesReturnId=" . urlencode($salesReturnId) . "&referanceNo=" . urlencode(1) );

			header("Location:welcome.php?page=salesReturnCounterSalePrint&salesReturnId=$salesReturnId&referanceNo=1");*/

		}
		$accountJournalCreditAmount	=	$totalAfterDiscount-$damagedGoodsAmount;
		$netAmountExRate 			= number_format(($netAmount*$exRate),2,'.','');
		$totalAmountExRate 			= number_format(($accountJournalCreditAmount*$exRate),2,'.','');
		$vatAmountExRate  			= number_format(($vatAmount*$exRate),2,'.','');
		$discountInAmountExRate  	= number_format((float)$discountInAmount*(float)$exRate,2,'.','');
		
		$SalesReturnItemWiseC->insertInvoiceToAccountJournel($netAmountExRate,$totalAmountExRate,
					$vatAmountExRate,$discountInAmountExRate,$returnNo,$regularCustomerId,
					$salesReturnId,$returnDate,$userId,$privilageId,$branchId,$mainBranch,$totalCostValue,$cuttingCharge,$transactionType);
		
		//$objPath->setHeader('salesReturnCounterSale',"Success!!!  Sales Return No $returnNo",'salesReturnCounterSale');
		//header("Location: salesReturnCounterSalePrint.php?salesReturnId=" . urlencode($salesReturnId) . "&referanceNo=" . urlencode(1) );

		header("Location:welcome.php?page=salesReturnCounterSalePrint&salesReturnId=$salesReturnId&referanceNo=1");
		
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
 <style >.ui-autocomplete { height: 200px; overflow-y: scroll; overflow-x: hidden;}</style> 
<style>
.modal{
	position: fixed;
	margin-top:10%;
}
.modal-footer {
    padding: 6px;
    text-align: right;
	border-top: 3px solid #0d967d;
	}



.btn-success {
	padding: 2px 7px !important;
    background-color: #848090 !important;
}

.submitBtn {
	background-color: #848090 !important;
    padding: 3px 8px !important;
}


.dropdown-menu 
{
	width: 16% !important;
}

element.style {
}
.table-bordered {
    /* border: 1px solid #f4f4f4; */
    border: 1px solid #999 !important;
}
.table-bordered {
    border: 1px solid #ddd;
}
@media only screen and (max-width: 600px) {
  .example {min-width: 1000px;}
}
#salesItems td {
	padding:0px !important;
}
label {
    font-size: 11px !important;
}
#salesItems input:focus , #salesItems select:focus {
    background-color: #bff2f5 !important;
}
.ui-state-focus{
	background-color:#bff2f5 !important;
}
#salesItems input:focus , #addPurchaseItemTable select:focus , #damagedGoodsReturn:focus  {
    background-color: #bff2f5 !important;
}


#addPurchaseItemTable td ,#addPurchaseItemTable th {
	padding:0px !important;
}
</style>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


</head>

<div class="row">        
 <div class="col-sm-12 col-md-12 col-lg-12">
	<div class="panel panel-info">
		<div class="panel-heading" >
			<form method="post">
					<table width="100%" border="0">
							<tr>
								<td width="30%"><i class="fa fa-list-ul"></i><strong>&nbsp;SALES RETURN FOR COUNTER SALE</strong></td>
								<td width="30%">&nbsp;</td>
								<td width="8%" align="right">&nbsp;</td>
								<td width="25%" align="right">
									<input type='text' id='invoiceNo' name='invoiceNo' placeholder="INVOICE NO" class="form-control input-sm" required style="width: 50%;color:black;"> 
									<input type='hidden' id='invoiceId' name='invoiceId' required> 
								</td>
								<td width="2%" align="right">&nbsp;</td>
								<td width="5%">
								<button type='submit' name='search'  class='btn btn-info btn-sm' style="float:right;"><i style='color:#fff' class="fa fa-search"></i>&nbsp;<span style='color:#fff'>Search</span></button>
								</td>
							</tr>
						</table>
			</form>
								
		</div>
		<?php if(isset($_POST['search'])) {?>
				<div class="panel-body" >
			
			<form action="" method="POST" enctype="multipart/form-data" id="salesReturnForm"  onsubmit="return confirm('Do you want to continue?')"> 
			<div class="col-sm-12 col-md-12 col-lg-12">
					<input type='hidden' id='tableValueArray' name='tableValueArray'> 
					<div class="row" >
							
							<div class="form-group col-sm-2 col-md-2 col-lg-2">
								<label for="poNumber">LAST RETURN NUMBER</label>
								<span style="color:#F00" class="mandatory">*</span>
								<input type="text" class="form-control input-sm" id="returnNo" value="<?php echo $maxInvoiceNo; ?>" name="returnNo" onkeyup="checkInvNumber(this.id);" >
							</div>
								<div class="form-group col-sm-2 col-md-2 col-lg-2">
									<label >DATE</label>
									<span style="color:#F00" class="mandatory">*</span>
									<input name="returnDate" type="text" required class="input-sm form-control  datepicker" id="returnDate" 
									   value="<?php echo date('d-m-Y');?>" autocomplete="off">
							
								</div> 
							<div class="form-group col-sm-2 col-md-2 col-lg-2"  >
									<label for="poNumber">CUSTOMER CODE</label>
									<span style="color:#F00" class="mandatory">*</span>
									<input type="text" class="form-control input-sm" id="customerCode" name="customerCode"  <?php if(isset($_COOKIE['privillegeId'])) { if($_COOKIE['privillegeId']==3){ echo 'required';}}?> readOnly value="<?php echo $customerNo; ?>">
									<input type="hidden" name="regularCustomerId" id="regularCustomerId" value="<?php echo $regularCustomerId; ?>"/>
									<input type="hidden" name="invoiceRefId" id="invoiceRefId" value="<?php echo $invoiceRefId; ?>"/>
									<input type="hidden" name="transactionType" id="invoiceRefId" value="<?php if (isset($_POST['search'])){echo $transactionType;}  ?>"/>
								</div>
								<div class="form-group col-sm-2 col-md-2 col-lg-2">
									<label for="poNumber">CUSTOMER NAME</label>
									<span style="color:#F00" class="mandatory">*</span>
									<input type="text" class="form-control input-sm" id="customerName" name="customerName" <?php if(isset($_COOKIE['privillegeId'])) {if($_COOKIE['privillegeId']==3){ echo 'required';}}?> readOnly value="<?php echo $customerName; ?>">
								</div>
									
								
								<div class="form-group col-sm-2 col-md-2 col-lg-2" >
									<label for="vendorName">CURRENCY</label> <span style="color:#F00" class="mandatory">*</span> 
									<!-- <select name="currencyId" class="input-sm form-group" id="currencyId" required="required" onchange="getExchangeRate(this.value);"  style="width: 100%;"> -->
										<!-- <option value="">Select</option> -->
										<?php 
										if(isset($invoiceDetails)) {
											echo $selectBoxCurrency;
										}else{
											echo $selectBoxCurrencyFirst;
										}			
										?>
									<!-- </select> -->
									
								</div>
								<div class="form-group col-sm-2 col-md-2 col-lg-2">
									<label for="poNumber">EX. RATE</label>
									<span style="color:#F00" class="mandatory">*</span>
									<input type="text" name="exRate" id="exRate" class="form-control input-sm" onkeyup="checkNumber(this.id);checlExrate(this.value)"  value="<?php echo $exRate; ?>" readOnly />
								</div>
					</div>
					<div class="row">
							<!-- <div class="form-group col-sm-4 col-md-4 col-lg-4">
								<label for="item" >BARCODE/ITEM</label>
								<input type="text" class="form-control input-sm"  id="materialSearch" name="materialSearch"  >
							</div> -->
							<div class="form-group col-sm-2 col-md-2 col-lg-2">
								<label for="item" >INVOICE NO</label>
								<input type="text" class="form-control input-sm" readonly required id="invoiceNo" name="invoiceNo" value="<?php echo $invoiceNo; ?>" >
								<input type="hidden" name="invoiceIdToSave" id="invoiceIdToSave" value="<?php echo $invoiceId; ?>" required/>
							</div>
				</div>		
				
			
			
		<div class='row'>
			<div class="table-responsive" >
			   <table width="100%" border="1" cellpadding="0" cellspacing="0" id="addPurchaseItemTable" class="table table-bordered" style="font-size: 11px !important;" >
									<thead style="background-color:#d0e8d2">
                                       <tr>
											<th width="3%">#</th>
											<th width="22%">Barcode/Item Description</th>
											<th width="10%">Qty</th>
											<th width="10%">Unit</th>
											<th width="10%">Weight</th>
											<th width="10%">Price</th>
											<th width="10%">Amount</th>
											<th width="10%">vat %</th>
                                            <th width="7%">Amnt.With Vat</th>
											<th width="3%">&nbsp;</th>
										</tr>
									</thead>
									<tbody id="materialDetailsTbody">
									<?php 
				if(isset($_POST['search'])){echo $tbody;}
				?> 									</tbody>
									<tfoot>
									<tr>
					<td colspan="2" align="right">Total</td>
					<td>
						<input type="text" name="quantityTotal" id="quantityTotal" class="form-control input-sm" style="text-align: right;" autocomplete="off" readonly="" value= "<?php echo $totalQty; ?>" >
					</td>
					<td>&nbsp;</td>
					<td>
						<input type="text" name="netWeightTotal" id="netWeightTotal" class="form-control input-sm" style="text-align: right;" autocomplete="off" readonly="" value= "<?php echo $totalNetWeight; ?>">										
					</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
										
				</tr>
				<tr>
					<th colspan='7' style="text-align: right;" ><span class='footerOfTable'>TOTAL</span></th>
					<td colspan='3' >
						<input type="text" name="totalAmount" id="totalAmount" class="input-sm"  readonly  style="text-align: right;width: 100%" value="<?php echo $totalWithOutvatInvoice; ?>"/>
					</td>
					
				</tr>
				<tr>
					<th colspan='7' style="text-align: right;"><span class='footerOfTable'>DISCOUNT</span></th>
					<td colspan='3'  >
					<input type="text" style="width: 30%;float:left;direction: rtl;" name="discountInPercent" id="discountInPercent" class="input-sm" onkeyup="getDiscountAmount();checkNumber(this.id);clearRound()" onchange="getDiscountAmount();checkNumber(this.id);clearRound()"  value="<?php echo $discountPercent; ?>"   />
					<input type="text"  style="width:10%;padding: 0%;border: 0px !important;" class="input-sm" value="%" />

					<input type="text" style="text-align: right;width: 60%;float: right;" name="discountInAmount" id="discountInAmount" class="input-sm" onkeyup="getDiscountPercent();checkNumber(this.id);clearRound()" onchange="getDiscountPercent();checkNumber(this.id);clearRound()" value="<?php echo $discountInAmountInvoice; ?>"  />
					
					<input type="hidden" id="discountInAmountHidden" value="<?php echo $discountInAmountInvoiceHidden; ?>"/>
					</td>
					<!--  value="discountInAmountHidden" -->
					

				</tr>
				<tr>
				<th colspan='7' style="text-align: right;"><span class='footerOfTable'>AMOUNT AFTER DISCOUNT</span></th>
				<td colspan='3'><input type="text" name="amountAfterDiscountTotal" id="amountAfterDiscountTotal" class="input-sm"  readonly  style="text-align: right;width: 100%"  style="text-align: right;" value="<?php echo $totalAmountAfterDiscountInvoice; ?>"/></td>
				
				
				</tr>
				<tr>
				<!-- <th style="text-align: right;" colspan="7"><span class="footerOfTable">DAMAGED GOODS AMOUNT</span></th> -->
				<!-- <td colspan="3"> -->
					<input type="hidden" name="damagedGoodsAmount" id="damagedGoodsAmount" value="<?php echo $damagedGoodsAmount;?>" class="input-sm" onkeyup="checkNumber(this.id);getDiscountAmount();clearRound();calculateSum();" onchange="checkNumber(this.id);getDiscountAmount();clearRound();calculateSum();" style="text-align: right;width: 100%">

					<input type="hidden" name="amountAfterDamage" id="amountAfterDamage" value="<?php echo $amountAfterDamageInvoice;?>" />
				<!-- </td> -->
					
				</tr>
				<tr>
					<th  style="text-align: right;"  colspan="7"><span class='footerOfTable'>VAT AMOUNT</span></th>
					<td colspan='3' >
						<input type="text" style="width: 30%;float:left;direction: rtl;" name="vatInPercent" id="vatInPercent" class="input-sm" onkeyup="getDiscountAmount();clearRound();calculateSum();checkNumber(this.id);" onchange="getDiscountAmount();clearRound();calculateSum();checkNumber(this.id);" value="<?php echo $vatPercent; ?>"   />
						<input type="text"  style="width:10%;padding: 0%;border: 0px !important;" class="input-sm" value="%" />
						<input type="text" name="vatAmount" id="vatAmount"    class="input-sm"   style="text-align: right;width: 60%;float:right" onchange="clearRound();calculateSum();checkNumber(this.id);" readOnly value="<?php echo $vatAmountInvoice; ?>">
					</td>
					
					
				</tr>
				<tr>
					<th  style="text-align: right;"  colspan="7"><span class='footerOfTable'>NET AMOUNT</span></th>
					<td colspan='3'><input type="text" name="netAmount" id="netAmount" class="input-sm"  value="<?php echo $totalWithVatInvoice; ?>" readonly  style="text-align: right;width: 100%" /></td>
				</tr>
				<tr>
					<th colspan='7' style="text-align: right;"><span class='footerOfTable'>ROUND</span></th>
					<td colspan='3'  >
					<!--<input type="hidden" name="discountId" id="discountId" class="discountId" />-->
					<input type="text" style="width: 30%;float:left;direction: rtl;" name="roundOff" id="roundOff" class="input-sm" onkeyup="checkNumber(this.id);calculateRound();" onchange="checkNumber(this.id);calculateRound();"  value="<?php echo $round; ?>"   />
					
					<input type="text" style="text-align: right;width: 60%;float: right;" name="roundAmount" id="roundAmount" class="input-sm" readonly value="<?php echo $roundAmount; ?>"  />
					</td>
					

				</tr>
			</tfoot>
	</table>
		</div>
	</div>	
			
			
            <div class="form-row" >
				<div class="form-group col-md-6"> 
				<button type='submit' name='submit' id="invoiceReturnSubmit" onclick='addArray();' class='btn btn-info btn-sm' style="float:right;"><i style='color:#fff' class="fa fa-save"></i>&nbsp;<span style='color:#fff'>Save</span></button>
				</div>
			</div>
					
				
                </form>
            </div>
			<?php }?>
	</div>


 </div>
 </div>
 <!-- starts -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- stops -->
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"> 
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script type="text/javascript">
var count = $('#materialDetailsTbody tr').length;
var i=count+1;

$(function(){
	
$("#materialSearch").autocomplete({
   source: function(request, response) {
     $.getJSON("../../../../modules/salesReturnCounterSale/admin/ajax/searchMaterials.php", {
		 term  : $('#materialSearch').val(),regularCustomerId:$('#regularCustomerId').val()}, 
              response);
  },
      minLength: 0,
      focus: function( event, ui ) {
        $("#materialSearch").html( ui.item.value );
        return false;
      },
      select: function( event, ui ) {
		 var regularCustomerId	= $('#regularCustomerId').val();
		 var itemMasterId = ui.item.key;
		 var itemName = ui.item.itemName;
		 var itemCode = ui.item.itemCode;
		 var stockId = ui.item.stockId;
		 var stockValue=ui.item.stockValue;
		  
		 getMaterialRow(itemMasterId,itemName,itemCode,stockId,regularCustomerId,stockValue,ui.item.minimumRate)
		$('#materialSearch').val(null);
		 return false;
      } 
   });
});

$(function(){
$("#customerCode").autocomplete({
   source: function(request, response) {
     $.getJSON("../../../../modules/salesInvoice/admin/ajax/searchCustomer.php", {
		 term  : $('#customerCode').val()}, 
              response);
  },
      minLength: 0,
     
      select: function( event, ui ) {
		  $("#regularCustomerId").val( ui.item.key )
		  $("#customerCode").val( ui.item.customerNo );
		  $("#customerName").val( ui.item.customerName );
			return false;
      } ,
	  change: function (event, ui) {
             if (ui.item == null) 
			 {
				$("#customerName").val('');
				$("#customerCode").val('');
				$("#regularCustomerId").val('');
			}
	}
 });
});
 
$(function(){
$("#invoiceNo").autocomplete({
   source: function(request, response) {
     $.getJSON("../../../../modules/salesReturnCounterSale/admin/ajax/searchCounterSalesInvoiceNo.php", {
		 term  : $('#invoiceNo').val()}, 
              response);
  },
      minLength: 0,
	  select: function( event, ui ) {
		 $('#invoiceId').val(ui.item.key);
		//  console.log(ui.item.key);
		 $('#invoiceNo').val(ui.item.value);
		 return false;
      }  ,
	  change: function (event, ui) {
             if (ui.item == null) 
			 {
			   $('#invoiceId').val('');
			   $('#invoiceNo').val('');
		    
			 }
		}
   });
});
 
function getMaterialRow(itemMasterId,itemName,itemCode,stockId,regularCustomerId,stockValue,minimumRate)

{
	var invoiceRefId=$('#invoiceRefId').val();//('#invoiceRefId').val();
	/* if(vat==null)
	{
		vat = '';
	}
	if(sellingPrice==null)
	{
		sellingPrice = '';
	}
	 */  vat=sellingPrice=purchasePrice='';
	var materialTableRow=null;
	$.ajax({
                type: "GET",
                url: "../../../../modules/salesReturnCounterSale/admin/ajax/getMaterialUnit.php?itemMasterId="+itemMasterId,
                success: function(data)
                {
                    	var vatValue = sellingPrice*15/100;
				  var selectBoxForUnit	=	'<select  class="input-sm form-group itemUnitRow" style="width: 100% !important;" name="itemUnitRow[]" id="itemUnitRow'+i+'" onchange="checkUnit('+i+');" required >'+JSON.parse(data)+'</select>'	;
					  materialTableRow	+=	'<tr id="trRow'+i+'"><td style="text-align:center"><span class="indexNo indexNoHide" id="indexNo'+i+'">'+i+'</span></td>'; 
					  materialTableRow	+=	'<td><input type="hidden" id="invoiceDetailsId'+i+'" class="input-sm invoiceDetailsId" value="0">';
					  materialTableRow	+=	'<input type="hidden" value="2" id="status'+i+'" class="statusRow">';
					  materialTableRow	+=	'<input type="hidden" value="'+i+'" id="sNo'+i+'" class="sNo">';
					  materialTableRow	+=	'<input type="hidden" value="'+stockId+'" id="stockIdRow'+i+'" class="stockIdRow">';
					  materialTableRow	+=	'<input type="hidden" id="itemCodeRow'+i+'" style="width:100% !important" class="form-control input-sm itemCodeRow" value="'+itemCode+'" readonly />';
					  materialTableRow	+=	'<input type="hidden"  id="itemMasterId'+i+'" class="form-control input-sm itemMasterId" value="'+itemMasterId+'" />';
					   materialTableRow	+=	'<input type="hidden"  id="stockValue'+i+'" class="form-control input-sm stockValue" value="'+stockValue+'" />'+itemCode+'/'+itemName+'</td>';
					 
					  materialTableRow	+=	'<td><input style="width:100% !important;direction: rtl;float: left;" type="text"  id="quantityRow'+i+'" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'+i+',this.id);" onchange="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();" value=" "  class=" input-sm quantityRow quantityRowForSum" /></td>';
					  materialTableRow	+=	'<td>'+selectBoxForUnit+'</td>';
					  materialTableRow	+=	'<td><input type="hidden" id="netWeightOld'+i+'" class="netWeightOldRow" value="0"><input name="netWeightRow" value="" id="netWeightRow'+i+'" style="width: 100%;direction: rtl;" type="text" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();" onchange="checkNumber(this.id);checkminimumRate('+i+'); calculateRowTotal('+i+');clearDiscount();clearRound();" class=" input-sm netWeightRow netWeightRowForSum"  readonly=""></td>';
					  materialTableRow	+=	'<td><input style="width:100% !important;direction: rtl;"  value="'+sellingPrice+'" id="unitPriceRow'+i+'" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'+i+',this.id);"  onchange="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();"   type="text" class=" input-sm amountRowTotal"  /><input type="hidden" id="minimumRate'+i+'" value="'+minimumRate+'" class="minimumRate" /></td>';
					  materialTableRow	+=	'<td><input type="hidden" id="purchasePrice'+i+'" class="purchasePrice" value="'+purchasePrice+'" /><input type="hidden" id="sellingPriceHiddenVal'+i+'" class="sellingPriceHiddenVal" value="'+sellingPrice+'" /><input style="width:100% !important;direction: rtl;" type="text" name="amountWithOutDiscount" id="amountWithOutDiscount'+i+'" value=""  class="input-sm amountRowWithOutDiscount amountRowWithOutDiscountForSum" readonly/></td>';						 
					 
	if(invoiceRefId==''){ 
					  materialTableRow	+=	'<td><input style="width:40% !important"  value="15" type="text" id="vatPercentRow'+i+'" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');"" onblur="tabPressFocus()" class=" input-sm vatPercentRow" /><input style="width:60% !important"  value="'+vatValue+'" type="text" id="vatAmountRow'+i+'"  class=" input-sm vatAmountRowTotal vatAmountRowTotalForSum" readonly/></td>';
					 
                      materialTableRow	+=	'<td><input style="width:100% !important"  value="0" id="amountWithWithVatRow'+i+'" type="text" class=" input-sm amountWithWithVatRowTotal" readonly="" /></td>';

					  
					   }else{ 
  materialTableRow	+=	'<input style="width:40% !important"  value="0" type="hidden" id="vatPercentRow'+i+'" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');"" onblur="tabPressFocus()" class=" input-sm vatPercentRow" /><input style="width:60% !important"  value="0" type="hidden" id="vatAmountRow'+i+'"  class=" input-sm vatAmountRowTotal vatAmountRowTotalForSum" readonly/>';
					 
                      materialTableRow	+=	'<input style="width:100% !important"  value="0" id="amountWithWithVatRow'+i+'" type="hidden" class=" input-sm amountWithWithVatRowTotal" readonly="" />';

} 

					  materialTableRow	+=	'<td><button type="button" onclick="deleteRow('+i+')" id="deleteBtn" class="btn btn-danger btnSubmit btn-xs deleteBtn" ><i class="fa fa-times"></i></button></td>';
					  materialTableRow	+=	'</tr>';
					  $('#materialDetailsTbody').append(materialTableRow);
					$('#quantityRow'+i).focus();
					checkUnit(i);
					idChange();
				  i++;
				  clearDiscount();	
clearRound();				  
				}
            })		
	  
	/* var materialTableRow=null;
	var i = $('#materialDetailsTbody tr').length;
	i++;
	$.ajax({ 
				url: "../../../../modules/salesReturnItemWise/admin/ajax/getMaterialUnit.php",
                type: "POST",
				data:{regularCustomerId:regularCustomerId,itemMasterId:itemMasterId},
				dataType:"JSON",
				success: function(data)
                {  
					
				
				  var selectBoxForUnit	=	'<select  class="input-sm itemUnitRow" name="itemUnitRow" id="itemUnitRow'+i+'" onchange="checkUnit('+i+');" required style="width:100% !important;">'+data.selectBox+'</select>'	;
				  console.log(selectBoxForUnit);
					  materialTableRow	+=	'<tr class="trRow" id="trRow'+i+'" ><td style="text-align:center" ><span class="sNo">'+i+'</span></td>'; 
					  materialTableRow	+=	'<td><input type="hidden" value="'+stockId+'" id="stockIdRow'+i+'" class="stockIdRow">';
					  materialTableRow	+=	'<input type="hidden"  id="itemMasterId'+i+'" class="itemMasterId" value="'+itemMasterId+'">'+itemCode+'/'+itemName+'</td>';
					  materialTableRow	+=	'<td><input style="width:100% !important;direction: rtl;" type="text"  id="quantityRow'+i+'" onkeyup="checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'+i+',this.id);" onchange="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();"   class="input-sm quantityRow" /></td>';
					  materialTableRow	+=	'<td>'+selectBoxForUnit+'</td>';
					  materialTableRow	+=	'<td><input name="netWeightRow" value="" id="netWeightRow'+i+'" style="width: 100%;direction: rtl;" type="text" onkeyup="checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound();" onchange="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();" class="input-sm netWeightRow"  readonly=""></td>';
					  materialTableRow	+=	'<td><input style="width:100% !important;direction: rtl;"  value="'+data.unitPrice+'" id="unitPriceRow'+i+'" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'+i+',this.id);"  onchange="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();"  type="text" class="input-sm unitPriceRow"  /></td>';
					  materialTableRow	+=	'<td><input style="width:100% !important;direction: rtl;" type="text"  id="rowTotal'+i+'" value=""  class="input-sm rowTotal" readonly/></td>';	
					 materialTableRow	+= '<td><input style="width:40% !important"  value="15" id="vatPercentRow'+i+'" onkeypress="checkEnterKey(event,'+i+',this.id);" onkeyup="checkNumber(this.id); calculateRowTotal('+i+'); checkEnterKey(event,'+i+',this.id);" onblur="tabPressFocus()" type="text" class="input-sm vatPercentRow left"  /><input style="width:60% !important;float:right;"  value="0" type="text" id="vatAmountRow'+i+'"  class=" input-sm vatAmountRowTotal" readonly/</td>';
                      materialTableRow	+=	'<td><input style="width:100% !important;direction: rtl;"  value="0" id="amountWithWithVatRow'+i+'" type="text" class=" input-sm amountWithWithVatRowTotal" readonly="" onblur="tabPressFocus()" /></td>';
					   materialTableRow	+=	'<td style="padding:3px !important"><button type="button" onclick="deleteRow('+i+')"  class="btn btn-danger btnSubmit btn-xs input-xs deleteBtn" id="deleteBtn'+i+'" style="width:100%"><i class="fa fa-times"></i></button></td>';
					  materialTableRow	+=	'</tr>';
					 
					 $('#materialDetailsTbody').append(materialTableRow);
					 $('#quantityRow'+i).focus();
					i++;
					clearDiscount();
				  clearRound();
				  calculateSum(i)
				}
            })				 */
}

	function clearDiscount()
	{
		$('#discountInPercent').val(null);
		$('#discountInAmount').val(null);
		$('#discountInAmountHidden').val(null);
		calculateSum();
		
	}
 function idChange()
{
	//$('[data-toggle="popover"]').popover({ trigger: "hover" });   
/* Sno */
	var i=1;
	$('.indexNo').each(function(){
		var indexNo= 'indexNo'+i;
		 $(this).attr('id',""+indexNo+"");
		i++;
	});
	var i=1;
	$('.indexNoHide').each(function(){
		$(this).html(i);
		i++;
	});
		var i=1;
	$('.minimumRate').each(function(){
		
		var minimumRate= 'minimumRate'+i;
		//alert(quantityRow);
        $(this).attr('id',""+minimumRate+"");
		
		i++;
	    
	});
	var i=1;
	$('.sellingPriceHiddenVal').each(function(){
		
		var sellingPriceHiddenVal= 'sellingPriceHiddenVal'+i;
		//alert(quantityRow);
        $(this).attr('id',""+sellingPriceHiddenVal+"");
		
		i++;
	    
	});

	var i=1;
	
	$('.quantityRow').each(function(){
		
		var quantityRow= 'quantityRow'+i;
		//alert(quantityRow);
        $(this).attr('id',""+quantityRow+"");
		  $(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound();');
		  $(this).attr('onChange','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound();');
		  $(this).attr('onkeypress','checkEnterKey(event,'+i+',this.id);');
		i++;
	    
	});  
	var i=1;
	$('.descriptionRow').each(function(){
		
		var descriptionRow= 'descriptionRow'+i;
		//alert(quantityRow);
        $(this).attr('id',""+descriptionRow+"");
		
		i++;
	    
	});
	var i=1;
	$('.packageSizeRow').each(function(){
		
		var packageSizeRow= 'packageSizeRow'+i;
		$(this).attr('id',""+packageSizeRow+"");
		i++;
	    
	});
	var i=1;
	$('.amountRowTotal').each(function(){
		
		var unitPriceRow= 'unitPriceRow'+i;
		$(this).attr('id',""+unitPriceRow+"");
		 $(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound();');
		 $(this).attr('onChange','checkNumber(this.id);checkminimumRate('+i+');calculateRowTotal('+i+');clearDiscount();clearRound();');
		 $(this).attr('onkeypress','checkEnterKey(event,'+i+',this.id);');
		i++;
	    
	});
	var i=1;
	$('.amountRowWithOutDiscount').each(function(){
		
		var amountWithOutDiscount= 'amountWithOutDiscount'+i;
		$(this).attr('id',""+amountWithOutDiscount+"");
		 
		i++;
	    
	});
	
var i=1;
	$('.itemMasterId').each(function(){
		
		var itemMasterId= 'itemMasterId'+i;
		$(this).attr('id',""+itemMasterId+"");
		
		i++;
	    
	});  
	var i=1;
	$('.sNo').each(function(){
		
		var sNo= 'sNo'+i;
		$(this).attr('id',""+sNo+"");
		
		i++;
	    
	});

var i=1;
	$('.purchasePrice').each(function(){
		
		var purchasePrice= 'purchasePrice'+i;
		$(this).attr('id',""+purchasePrice+"");
		
		i++;
	    
	});		  
var i=1;
	$('.itemUnitRow').each(function(){
		
		var itemUnitRow= 'itemUnitRow'+i;
		$(this).attr('id',""+itemUnitRow+"");
		$(this).attr('onChange','checkUnit('+i+')');
		i++;
	    
	});

var i=1;
	$('.itemCodeRow').each(function(){
		
		var itemCodeRow= 'itemCodeRow'+i;
		$(this).attr('id',""+itemCodeRow+"");
		i++;
	    
	});   	

	var i=1;
	$('.stockIdRow').each(function(){
		
		var stockIdRow= 'stockIdRow'+i;
		$(this).attr('id',""+stockIdRow+"");
		
		i++;
	    
	});	
	var i=1;
	$('.netWeightRow').each(function(){
		
		var netWeightRow= 'netWeightRow'+i;
		$(this).attr('id',""+netWeightRow+"");
		 $(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound();');
		 $(this).attr('onChange','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound();');
		i++;
	    
	});

	var i=1;
	$('.invoiceDetailsId').each(function(){
		
		var invoiceDetailsId= 'invoiceDetailsId'+i;
		$(this).attr('id',""+invoiceDetailsId+"");
		i++;
	    
	});
	
	var i=1;
	$('.statusRow').each(function(){
		
		var status= 'status'+i;
		$(this).attr('id',""+status+"");
		i++;
	    
	});	
	
	var i=1;
	$('.netWeightOldRow').each(function(){
		
		var status= 'netWeightOld'+i;
		$(this).attr('id',""+status+"");
		i++;
	    
	});	
	
	var i=1;
	$('.stockValue').each(function(){
		
		var stockValue= 'stockValue'+i;
		$(this).attr('id',""+stockValue+"");
		i++;
	    
	});	
	
		var i=1;
	$('.vatPercentRow').each(function(){
		
		var vatPercentRow= 'vatPercentRow'+i;
		$(this).attr('id',""+vatPercentRow+"");
		  $(this).attr('onKeyUp','checkNumber("'+vatPercentRow+'");calculateRowTotal('+i+')');
		i++;
	    
	}); 

	var i=1;
	$('.vatAmountRowTotal').each(function(){
		
		var vatAmountRow= 'vatAmountRow'+i;
		$(this).attr('id',""+vatAmountRow+"");
		  //$(this).attr('onKeyUp','checkNumber("'+vatAmountRow+'");calculateRowTotal('+i+')');
		i++;
	    
	});  
	var i=1;
	$('.amountWithWithVatRowTotal').each(function(){
		
		var amountWithWithVatRow= 'amountWithWithVatRow'+i;
		$(this).attr('id',""+amountWithWithVatRow+"");
		  $(this).attr('onKeyUp','checkNumber("'+amountWithWithVatRow+'");calculateRowTotal('+i+')');
		i++;
	    
	}); 
	
	var i=1;
	$('.trRow').each(function(){
		
		var row= 'trRow'+i;
		$(this).attr('id',""+row+"");
		i++; 
	});
	var i=1;
	$('.deleteBtn').each(function(){
		
		var deleteBtn= 'deleteBtn'+i;
		$(this).attr('id',""+deleteBtn+"");
		$(this).attr('onclick','deleteRow('+i+')');
		i++;
	});  

	/* -row--*/
/* 	var i=1;
	$('.trRow').each(function(){
		
		var row= 'trRow'+i;
		$(this).attr('id',""+row+"");
		i++; 
	});   
	
	
	var i=1;
	$('.deleteBtn').each(function(){
		
		var deleteBtn= 'deleteBtn'+i;
		$(this).attr('id',""+deleteBtn+"");
		$(this).attr('onclick','deleteRow('+i+')');
		i++;
	});  
	
	
	var i=1;
	$('.itemMasterId').each(function(){
		
		var itemMasterId= 'itemMasterId'+i;
		$(this).attr('id',""+itemMasterId+"");
		
		i++;
	    
	});  
	
	var i=1;
	$('.stockIdRow').each(function(){
		var stockIdRow= 'stockIdRow'+i;
		$(this).attr('id',""+stockIdRow+"");
		i++;
	});	
	
	
	var i=1;
	$('.sNo').each(function(){
		$(this).html(i);
		i++;
	});
	
	
	var i=1;
	$('.quantityRow').each(function(){
		var quantityRow= 'quantityRow'+i;
        $(this).attr('id',""+quantityRow+"");
		$(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound();');
		$(this).attr('onChange','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound();');
		$(this).attr('onkeypress','checkEnterKey(event,'+i+',this.id);');

		i++;
	});  
	
	
	var i=1;
	$('.itemUnitRow').each(function(){
		
		var itemUnitRow= 'itemUnitRow'+i;
		$(this).attr('id',""+itemUnitRow+"");
		$(this).attr('onChange','checkUnit('+i+')');
		i++;
	    
	});
	
	
	var i=1;
	$('.netWeightRow').each(function(){
		
		var netWeightRow= 'netWeightRow'+i;
		$(this).attr('id',""+netWeightRow+"");
		 $(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound();');
		 $(this).attr('onChange','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound();');
		i++;
	    
	});	
	
	
	
	var i=1;
	$('.unitPriceRow').each(function(){
		var unitPriceRow= 'unitPriceRow'+i;
		$(this).attr('id',""+unitPriceRow+"");
		 $(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound();');
		 $(this).attr('onChange','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound();');
		 $(this).attr('onkeypress','checkEnterKey(event,'+i+',this.id);');
		i++;
	});	
	
		var i=1;
	$('.vatPercentRow').each(function(){
		
		var vatPercentRow= 'vatPercentRow'+i;
		$(this).attr('id',""+vatPercentRow+"");
		  $(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotal('+i+')');
		i++;
	    
	}); 
		var i=1;
	$('.vatAmountRowTotal').each(function(){
		
		var vatAmountRow= 'vatAmountRow'+i;
		$(this).attr('id',""+vatAmountRow+"");
		  //$(this).attr('onKeyUp','checkNumber("'+vatAmountRow+'");calculateRowTotal('+i+')');
		i++;
	    
	}); 

	var i=1;
	$('.amountWithWithVatRowTotal').each(function(){
		
		var amountWithWithVatRow= 'amountWithWithVatRow'+i;
		$(this).attr('id',""+amountWithWithVatRow+"");
		  $(this).attr('onKeyUp','checkNumber("'+amountWithWithVatRow+'");calculateRowTotal('+i+')');
		i++;
	    
	}); 
	
	var i=1;
	$('.rowTotal').each(function(){
		
		var rowTotal= 'rowTotal'+i;
		$(this).attr('id',""+rowTotal+"");
		i++;
	    
	});
		 */
}
 function checkNumber(argId)
{
	//alert('numeric');
        var quantity = (document.getElementById(argId).value);
        if(quantity == "")
                document.getElementById(argId).value = null;
        else{
                if(isNaN(quantity) == true){
                        quantity = quantity.trim();
                        var tempQuantity= quantity.replace(/\D+/, '');
                        if(tempQuantity  == "")
                        document.getElementById(argId).value = null;
                        else
                        document.getElementById(argId).value = tempQuantity;
                }
        }	
}
function checkInvNumber(a)
{
	var x=document.getElementById(a).value;
	if(isNaN(x))
	{
		alert("Enter a Valid Number");
		 document.getElementById(a).value		=	'';
		a.focus();	 
	}		
}

function checkUnit(i)
{
	var unitName = $("#itemUnitRow"+i+" option:selected").text();
	if(unitName =='OTHER')
	{
		$('#netWeightRow'+i).prop('readonly', false);	
		calculateRowTotal(i);
	}/*else if(unitName =='CARTON')
	{
		var itemMasterId	=	parseFloat($('#itemMasterId'+i).val());
			$.ajax({
						type: "POST",
						url: '../../../../modules/salesInvoice/admin/ajax/getCartonSellingPrice.php',
						data: {itemMasterId:itemMasterId},
						success: function(data){
							
							$('#unitPriceRow'+i).val(data);
							$('#netWeightRow'+i).prop('readonly', false);
							calculateRowTotal(i)					  
						}
					});
		
	}*/
		else{
		
			var itemMasterId	=	parseFloat($('#itemMasterId'+i).val());
			var unitId = $("#itemUnitRow"+i).val();
			$.ajax({
						type: "POST",
						url: '../../../../modules/salesReturnCounterSale/admin/ajax/getUnitPriceFromCartonFraction.php',
						data: {itemMasterId:itemMasterId,unitId:unitId},
						success: function(data){
							
							$('#unitPriceRow'+i).val(data);
							$('#netWeightRow'+i).prop('readonly', true);
							calculateRowTotal(i);					  
						}
					});
		
	}
}
function calculateRowTotal(i)
   {
	  
	   /* var quantityRow			=	parseFloat($('#quantityRow'+i).val());
	   var unitPriceRow			=	parseFloat($('#unitPriceRow'+i).val());
	   var stockIdRow			=	$('#stockIdRow'+i).val();
	   var value 				= 	$("#itemUnitRow"+i+" option:selected").val();
	   var unitName 			= 	$("#itemUnitRow"+i+" option:selected").text();
	   
	   if(isNaN(quantityRow))
	   {
		 quantityRow = 0;  
	   } 
	   if(isNaN(unitPriceRow))
	   {
		 unitPriceRow = 0;  
	   }
	//  console.log(value);
	  var arry = value.split('-');
		if(isNaN(arry[1])){
			var fraction = 0;
		}else{
			var fraction = parseFloat(arry[1]);
		}
		if(unitName =='OTHER')
		{
			var newNeightWeight	= parseFloat($('#netWeightRow'+i).val())		
		}else{
			var newNeightWeight = quantityRow*fraction;
		}
	  if(newNeightWeight==''||isNaN(newNeightWeight))
			{
				newNeightWeight=0;
			}
			
		if(unitName =='CARTON')
		{
			var rowTotal		=	quantityRow*unitPriceRow;
		}else{
			var rowTotal		=	newNeightWeight*unitPriceRow;
		}
		
		 
					
	 if(newNeightWeight==0||isNaN(newNeightWeight))
		{
			$('#netWeightRow'+i).val(null);
		}else{
			$('#netWeightRow'+i).val(newNeightWeight);
		}
		if(rowTotal==0||isNaN(rowTotal))
		{
			$('#rowTotal'+i).val(null);
		}else{
			$('#rowTotal'+i).val(rowTotal.toFixed(2)); 
		}
	   	calculateRowVat(i);
		calculateSum();	    */
		clearRound();
		var oldQuantity			=	parseFloat($('#oldQuantity'+i).val());//dschange
	   var quantityRow			=	parseFloat($('#quantityRow'+i).val());

	   if(quantityRow > oldQuantity)
	   {
		   alert('Added Quantity is Greater Than The Available Quanity !!!');
		   $('#quantityRow'+i).val(oldQuantity);
		   quantityRow		=	oldQuantity;
	   }

	   var unitPriceRow			=	parseFloat($('#unitPriceRow'+i).val());
	   var value 				= 	$("#itemUnitRow"+i+" option:selected").val();
	   var unitName 			= 	$("#itemUnitRow"+i+" option:selected").text();
	   
	   if(isNaN(quantityRow))
	   {
		 quantityRow = 0;  
	   } 
	   if(isNaN(unitPriceRow))
	   {
		 unitPriceRow = 0;  
	   }
	  
	  var arry = value.split('-');
		if(isNaN(arry[1])){
			var fraction = 0;
		}else{
			var fraction = parseFloat(arry[1]);
		}
		if(unitName =='OTHER')
		{
			var newNeightWeight	= parseFloat($('#netWeightRow'+i).val())		
		}else{
			var newNeightWeight = quantityRow*fraction;
		}
	  if(newNeightWeight==''||isNaN(newNeightWeight))
			{
				newNeightWeight=0;
			}
			
		if(unitName =='CARTON')
		{
			var rowTotal		=	quantityRow*unitPriceRow;
		}else{
			var rowTotal		=	newNeightWeight*unitPriceRow;
		}
		
		var privilageId		= $('#privilageIdUpdate').val();
		var stockValue		= parseFloat($('#stockValue'+i).val());
		
		if(privilageId==3)
		{
			if(newNeightWeight<=stockValue)
	
				{
					 if(newNeightWeight==0||isNaN(newNeightWeight))
						{
							$('#netWeightRow'+i).val(null);
						}else{
							$('#netWeightRow'+i).val(newNeightWeight);
						}
						if(rowTotal==0||isNaN(rowTotal))
						{
							$('#amountWithOutDiscount'+i).val(null);
						}else{
							$('#amountWithOutDiscount'+i).val(rowTotal.toFixed(3)); 
						}
				}else{
					alert("Only "+stockValue+" is Available ln Stock");
					$('#quantityRow'+i).val(null);
					$('#netWeightRow'+i).val(null);
					$('#amountWithOutDiscount'+i).val(null);
				}
		}else{
		 if(newNeightWeight==0||isNaN(newNeightWeight))
			{
				$('#netWeightRow'+i).val(null);
			}else{
				$('#netWeightRow'+i).val(newNeightWeight);
			}
			if(rowTotal==0||isNaN(rowTotal))
			{
				$('#amountWithOutDiscount'+i).val(null);
			}else{
				$('#amountWithOutDiscount'+i).val(rowTotal.toFixed(3)); 
			}
		}
			calculateRowVat(i);
		calculateSum();	   
	   
   }
function calculateRowTotalCartonUnit(i)
{
	var unitPriceRow		=	parseFloat($('#unitPriceRow'+i).val());
	var quantityRow			=	parseFloat($('#quantityRow'+i).val());
	var value 				= 	$("#itemUnitRow"+i+" option:selected").val();
		var arry = value.split('-');
		if(isNaN(arry[1])){
			var fraction = 0;
		}else{
			var fraction = parseFloat(arry[1]);
		}
	   var stockIdRow			=	$('#stockIdRow'+i).val();
		
		var rowTotal		= quantityRow*unitPriceRow;
		var newNeightWeight = quantityRow*fraction;
		
		if(newNeightWeight==''||isNaN(newNeightWeight))
			{
				newNeightWeight=0;
			}
			
		 $.ajax({
						type: "POST",
						url: '../../../../modules/salesInvoice/admin/ajax/checkStockValue.php',
						data: {stockId:stockIdRow,neightWeight:newNeightWeight},
						success: function(data){
							var res = data.split("-");
							var stock		=	res[0];
							var stockValue	=	res[1];
						  if(stock==1)
						  {
							   if(newNeightWeight==0||isNaN(newNeightWeight))
								{
									$('#netWeightRow'+i).val(null);
								}else{
									$('#netWeightRow'+i).val(newNeightWeight.toFixed(2));
								}
								if(rowTotal==0||isNaN(rowTotal))
								{
									$('#rowTotal'+i).val(null);
								}else{
									$('#rowTotal'+i).val(rowTotal.toFixed(2)); 
								}
						  }else{
							alert("Only "+stockValue+" is Available ln Stock");
							  $('#quantityRow'+i).val(null);
							  $('#netWeightRow'+i).val(null);
							  $('#itemUnitRow'+i).val(null);
							  $('#unitPriceRow'+i).val(null);
							  $('#rowTotal'+i).val(null);
						  }							  
						}
					});
		
	   	calculateRowVat(i);
	   calculateSum();
}
function calculateRowTotalOtherUnit(i)
{
	
	   var unitPriceRow			=	parseFloat($('#unitPriceRow'+i).val());
	   var netWeightRow			=	parseFloat($('#netWeightRow'+i).val());
	   var stockIdRow			=	$('#stockIdRow'+i).val();
		if(netWeightRow==''||isNaN(netWeightRow))
			{
				netWeightRow=0;
			}
		var rowTotal		= netWeightRow*unitPriceRow;
		 $.ajax({
						type: "POST",
						url: '../../../../modules/salesInvoice/admin/ajax/checkStockValue.php',
						data: {stockId:stockIdRow,neightWeight:netWeightRow},
						success: function(data){
							var res = data.split("-");
							var stock		=	res[0];
							var stockValue	=	res[1];
						  if(stock==1)
						  {
							   if(rowTotal==0||isNaN(rowTotal))
								{
									$('#rowTotal'+i).val(null);
								}else{
									 
									$('#rowTotal'+i).val(rowTotal.toFixed(2));
								}
						  }else{
								alert("Only "+stockValue+" is Available ln Stock");
							  $('#quantityRow'+i).val(null);
							  $('#netWeightRow'+i).val(null);
							  $('#itemUnitRow'+i).val(null);
							  $('#unitPriceRow'+i).val(null);
							  $('#rowTotal'+i).val(null);
						  }							  
						}
					});
	   	calculateRowVat(i);
	   calculateSum();
}


    function calculateRowDiscount(i)
{
	var amountRow			=	$('#amountWithOutDiscount'+i).val();
	var discountPercentRow	=	$('#discountPercentRow'+i).val();
	if(discountPercentRow>0)
	{
		var discountAmount	=	(parseFloat(amountRow)*parseFloat(discountPercentRow))/100;
		var AmountAfterDiscount	= amountRow-discountAmount;	
		$('#amountAfterDiscountRow'+i).val(AmountAfterDiscount.toFixed(2));
		$('#amountWithWithVatRow'+i).val(AmountAfterDiscount.toFixed(2));
		$('#dis'+i).val(discountAmount.toFixed(2));
	}else{
			$('#amountAfterDiscountRow'+i).val(parseFloat(amountRow).toFixed(2));
			$('#amountWithWithVatRow'+i).val(parseFloat(amountRow).toFixed(2));
			$('#dis'+i).val(0);
	}
	calculateRowVat(i);
}
   function calculateRowVat(i)
{ 
	var amountRow			=	$('#amountWithOutDiscount'+i).val();
	var vatPercentRow		=	$('#vatPercentRow'+i).val();
	if(isNaN(amountRow) || amountRow=='')
	   amountRow=0;
	if(isNaN(vatPercentRow) || vatPercentRow=='')
	   vatPercentRow=0;
	if(vatPercentRow>0)
	{
		var vatAmount		=	(parseFloat(amountRow)*parseFloat(vatPercentRow))/100;
		var AmountWithVat	= parseFloat(amountRow)+parseFloat(vatAmount);	
		$('#amountWithWithVatRow'+i).val(AmountWithVat.toFixed(2));
		$('#vatAmountRow'+i).val(vatAmount.toFixed(2));
		
	}else{
			$('#amountWithWithVatRow'+i).val(parseFloat(amountRow).toFixed(2));
			$('#vatAmountRow'+i).val(0);
		
	}
	calculateSum();
}

function calculateSum()
   { 
	
		  var amountRowWithOutDiscount	=	0;
	$('.amountRowWithOutDiscountForSum').each(function(){
		var rowValue	=	parseFloat(this.value);
		if(rowValue==''||isNaN(rowValue))
			{
				rowValue=0;
			}
    amountRowWithOutDiscount = amountRowWithOutDiscount+rowValue;
	});
   
  	var totalQuantity = 0;
	$('.quantityRowForSum').each(function(){
		var qtyRow =	parseFloat(this.value);
		if(isNaN(qtyRow))
		{
			qtyRow	=	0;
		}
    totalQuantity +=qtyRow;
	});
	
	var netWeightTotal = 0;
	$('.netWeightRowForSum').each(function(){
		var nerWeightRow =	parseFloat(this.value);
		if(isNaN(nerWeightRow))
		{
			nerWeightRow	=	0;
		}
    netWeightTotal +=nerWeightRow;
	});
	

  
	
		if(amountRowWithOutDiscount==0||isNaN(amountRowWithOutDiscount)||amountRowWithOutDiscount=='')
		{
			$('#totalAmount').val(null);
		}
		else{
		$('#totalAmount').val(round2Fixed(amountRowWithOutDiscount));
		}

		if(totalQuantity==0||isNaN(totalQuantity))
		{
			$('#quantityTotal').val(null);
		}else{
			 
			$('#quantityTotal').val(totalQuantity);
		}
		if(netWeightTotal==0||isNaN(netWeightTotal))
		{
			$('#netWeightTotal').val(null);
		}else{
			 
			$('#netWeightTotal').val(netWeightTotal.toFixed(2));
		} 
   getAmountAfterDoscount();
   }
   function getAmountAfterDoscount()
 {
	var totalAmount		=	parseFloat($('#totalAmount').val());
   if(totalAmount==''||isNaN(totalAmount))
			{
				totalAmount=0;
			}
	var discountInAmount		=	parseFloat($('#discountInAmount').val());
   if(discountInAmount==''||isNaN(discountInAmount))
			{
				discountInAmount=0;
			}
	
	
   if(discountInAmount>totalAmount)
   {
	   alert('Discount is Greater Than Total Amount');
	   $('#discountInAmount').val(null)
	   $('#discountInPercent').val(null)
	   if(totalAmount==0||isNaN(totalAmount)||totalAmount=='')
		{
			$('#amountAfterDiscountTotal').val(null);	 
		}else{
			$('#amountAfterDiscountTotal').val(round2Fixed(totalAmount));	 
		}
   }else{
	   var totalAmountWithDiscount		=	totalAmount-discountInAmount; 
	
	if(totalAmountWithDiscount==0||isNaN(totalAmountWithDiscount)||totalAmountWithDiscount=='')
		{
			$('#amountAfterDiscountTotal').val(null);	 
		}else{
			$('#amountAfterDiscountTotal').val(round2Fixed(totalAmountWithDiscount));	 
		}
   }
   
   	
	getAmountAfterDamage();	
 }
 function getAmountAfterDamage()
 {
	 var amountAfterDiscountTotal		=	parseFloat($('#amountAfterDiscountTotal').val());
   if(amountAfterDiscountTotal==''||isNaN(amountAfterDiscountTotal))
			{
				amountAfterDiscountTotal=0;
			}
	 var damagedGoodsAmount		=	parseFloat($('#damagedGoodsAmount').val());
   if(damagedGoodsAmount==''||isNaN(damagedGoodsAmount))
			{
				damagedGoodsAmount=0;
			}
	if(damagedGoodsAmount>amountAfterDiscountTotal)
	{
		alert('Damaged Goods Amount Greater Than Amount After Discount')
		var amountAfterDamage	=	0;
	}else{
		if(amountAfterDiscountTotal>0)
		{
				var amountAfterDamage	=	amountAfterDiscountTotal-damagedGoodsAmount;	
		}else{
			var amountAfterDamage	=	0;
		}
	}
	
	if(amountAfterDamage==0||isNaN(amountAfterDamage)||amountAfterDamage=='')
		{
			$('#amountAfterDamage').val(null);	 
		}else{
			$('#amountAfterDamage').val(round2Fixed(amountAfterDamage));	 
		}
	calculateVatAmount();	
 }
 function calculateVatAmount()
 {
	  var vatInPercent			=	parseFloat($('#vatInPercent').val());
   if(vatInPercent==''||isNaN(vatInPercent))
			{
				vatInPercent=0;
			} 
	var amountAfterDamage			=	parseFloat($('#amountAfterDamage').val());
   if(amountAfterDamage==''||isNaN(amountAfterDamage))
			{
				amountAfterDamage=0;
			}
   var vatAmountTotal		=	(amountAfterDamage*vatInPercent)/100;
	
	
	var netAmount					=	amountAfterDamage+vatAmountTotal;
	 if(vatAmountTotal==0||isNaN(vatAmountTotal)||vatAmountTotal=='')
		{
			$('#vatAmount').val(null);	 
		}else{
			$('#vatAmount').val(round2Fixed(vatAmountTotal));	 
		}
	  if(netAmount==0||isNaN(netAmount)||netAmount=='')
		{
			$('#netAmount').val(null); 
		}else{
			$('#netAmount').val(round2Fixed(netAmount)); 
		}		
 }
 function checkminimumRate(i){}
    function round2Fixed(value) 
   {
		  value = +value;

		  if (isNaN(value))
			return 0;

		  // Shift
		  value = value.toString().split('e');
		  value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + 2) : 2)));

		  // Shift back
		  value = value.toString().split('e');
		  return (+(value[0] + 'e' + (value[1] ? (+value[1] - 2) : -2))).toFixed(2);
	} 
	
	
   function getDiscountAmount()
   {
	  var totalAmount		=	parseFloat($('#totalAmount').val());
	  var discountInPercent =	parseFloat($('#discountInPercent').val());
   if(isNaN(discountInPercent)||discountInPercent==0||discountInPercent=='')
	 {
		  $('#discountInPercent').val(null);
		  $('#discountInAmount').val(null);
		   $('#discountInAmountHidden').val(null);
		  
	 }else{
		 var discountAmount	=	(totalAmount*discountInPercent)/100;
		  $('#discountInAmount').val(discountAmount.toFixed(2));
		  $('#discountInAmountHidden').val(discountAmount.toFixed(2));
	 }
	 
	  calculateSum();
	   
   }
   function getDiscountPercent()
   {
	  var totalAmount		=	parseFloat($('#totalAmount').val());
	  var discountInAmount =	parseFloat($('#discountInAmount').val());

	  if(isNaN(discountInAmount)||discountInAmount==0||discountInAmount=='')
	 {
		  $('#discountInPercent').val(null);
		  $('#discountInAmount').val(null);
		  $('#discountInAmountHidden').val(null);
	   
	 }else{
		  var discountPercent	=	(discountInAmount*100)/totalAmount;
		  $('#discountInPercent').val(discountPercent.toFixed(2));
		  $('#discountInAmountHidden').val(discountInAmount.toFixed(2));
		
	 }
	  calculateSum();
	    
   }
   
   function deleteRow(i)
{
	$('#trRow'+i).remove();
	calculateSum();
	idChange();
	clearDiscount();
	clearRound();
	enableSubmitButton();
   
}

function calculateRound(){
	
	var roundOff			=	$('#roundOff').val();
	if(isNaN(roundOff)||roundOff==0||roundOff=='')
	 {
		 roundOff=0;
	 }
	var roundAmount   =   roundOff/115;
	if(isNaN(roundAmount)||roundAmount==0||roundAmount=='')
	 {
		 roundAmount=0;
	 }
    $('#roundAmount').val(roundAmount.toFixed(2));
	var discountInAmount			=	$('#discountInAmountHidden').val();//ds change

	// var discountInAmount			=	$('#discountInAmount').val(); //ds change

	if(isNaN(discountInAmount)||discountInAmount==0||discountInAmount=='')
	 {
		 discountInAmount=0;
	 }
	var TotalDiscount               = parseFloat(discountInAmount)+parseFloat(roundAmount);
	if(isNaN(TotalDiscount)||TotalDiscount==0||TotalDiscount=='')
	 {
		 TotalDiscount=0;
		 
	 }
	  $('#discountInAmount').val(TotalDiscount.toFixed(2));
	calculateSum();
}

function clearRound()
	{
		$('#roundOff').val(null);
		$('#roundAmount').val(null);
		calculateSum();
		
	}
</script>
<script>
function addArray(){

	var invoiceData	  = [[],[]];
	var table 	= document.getElementById("materialDetailsTbody");
	var rowCount = table.rows.length;

	var j=0;
	var sNo = 0;

	for(var i=1;i<=(rowCount); i++){
		var sNo = "sNo"+i;
		sNo = document.getElementById(sNo).value;
		if(sNo!=0){
			if(!invoiceData[j]){
            	invoiceData[j] = []
			}
			j++;
		}
	}

	var k =0;
	for(var i=1;i<=(rowCount); i++){
		
	  sNo=itemMasterId=quantityRow=itemUnitRow=unitPriceRow=discountPercentRow=amountAfterDiscountRow=itemCodeRow=descriptionRow=packageSizeRow=vatPercentRow=vatAmountRow='';
	        var invoiceDetailsId 		= document.getElementById("invoiceDetailsId"+i).value;
	        var status 					= document.getElementById("status"+i).value;
			var sNo 					= document.getElementById("sNo"+i).value;
	    	var stockIdRow				= document.getElementById("stockIdRow"+i).value;
	        var itemMasterId 			= document.getElementById("itemMasterId"+i).value;
	        var quantityRow 			= document.getElementById("quantityRow"+i).value;
			var itemUnitRow 			=  $("#itemUnitRow"+i+" option:selected").val();
			var netWeightRow			= document.getElementById("netWeightRow"+i).value;
			var netWeightOld			= document.getElementById("netWeightOld"+i).value;
	        var unitPriceRow 			= document.getElementById("unitPriceRow"+i).value;
			var amountWithOutDiscount 	= document.getElementById("amountWithOutDiscount"+i).value;			
	    	var purchasePriceRow		= document.getElementById("purchasePrice"+i).value;
	    	
	    	//vat
			var vatPercentRow			= document.getElementById("vatPercentRow"+i).value;
			var vatAmountRow			= document.getElementById("vatAmountRow"+i).value;
			var amountWithWithVatRow	= document.getElementById("amountWithWithVatRow"+i).value;
	    	
			invoiceData[k][1]	= invoiceDetailsId;
	    	invoiceData[k][2]   = status;
	    	invoiceData[k][3]   = sNo;
	    	invoiceData[k][4]   = stockIdRow;
	        invoiceData[k][5]   = itemMasterId;
	    	invoiceData[k][6]   = quantityRow;
	    	invoiceData[k][7]   = itemUnitRow;
			invoiceData[k][8]   = netWeightRow;
			invoiceData[k][9]   = netWeightOld;
			invoiceData[k][10]   = unitPriceRow;
			invoiceData[k][11]  = amountWithOutDiscount;
	    	invoiceData[k][12]  = purchasePriceRow;	
	    	invoiceData[k][13]  = vatPercentRow;	
			invoiceData[k][14]  = vatAmountRow;	
			invoiceData[k][15]  = amountWithWithVatRow;	
			k++;

    }

var json_text = JSON.stringify(invoiceData);
document.getElementById("tableValueArray").value = json_text;
	/* var invoiceData	  = [[],[]];
	var table 	= document.getElementById("materialDetailsTbody");
	var rowCount = table.rows.length;

	var j=0;
	var stockIdRow = 0;

	for(var i=1;i<=(rowCount); i++){
		var stockIdRow = "stockIdRow"+i;
		stockIdRow = document.getElementById(stockIdRow).value;
		if(stockIdRow!=0){
			if(!invoiceData[j]){
            	invoiceData[j] = []
			}
			j++;
		}
	}

	var k =0;
	for(var i=1;i<=(rowCount); i++){
		
			var stockIdRow				= document.getElementById("stockIdRow"+i).value;
			var itemMasterId 			= document.getElementById("itemMasterId"+i).value;
	        var quantityRow 			= document.getElementById("quantityRow"+i).value;
			var itemUnitRow 			= $("#itemUnitRow"+i+" option:selected").val();
			var netWeightRow			= document.getElementById("netWeightRow"+i).value;
			var unitPriceRow 			= document.getElementById("unitPriceRow"+i).value;
			var rowTotal 				= document.getElementById("rowTotal"+i).value;
			var vatPercentRow			=  document.getElementById("vatPercentRow"+i).value;
			var vatAmountRow			=  document.getElementById("vatAmountRow"+i).value;
			var amountWithWithVatRow	=  document.getElementById("amountWithWithVatRow"+i).value;
			
			invoiceData[k][0]	= stockIdRow;
	    	invoiceData[k][1]   = itemMasterId;
	    	invoiceData[k][2]   = quantityRow;
	    	invoiceData[k][3]   = itemUnitRow;
	        invoiceData[k][4]   = netWeightRow;
			invoiceData[k][5]   = unitPriceRow;
	    	invoiceData[k][6]   = rowTotal;
	    	invoiceData[k][7]   = vatPercentRow;
			invoiceData[k][8]   = vatAmountRow;
			invoiceData[k][9]   = amountWithWithVatRow;
	    	
			k++;

    }

var json_text = JSON.stringify(invoiceData);
document.getElementById("tableValueArray").value = json_text; */
}

</script>
<script>
function changeAllVat()
{
	var vat	=	$('#addVatPervent').val();
	var i=1
	$('.vatPercentRow').each(function(){
  // $(this).val(vat);
   calculateRowTotal(i)
   i++
	});
	
}
function changeAllDisc()
{
	var disc	=	$('#addDiscPervent').val();
	var i=1
	$('.discountRowTotal').each(function(){
   calculateRowTotal(i)
   i++
	});
}
function searchItemData()
{
	var itemName			=	$('#itemNameSearch').val();
	if( itemName==null || itemName=='')
	{
		alert('Add Any Item Name !!!!');
	}else{
		$.ajax({
		type: "GET",
		url: "../../../../modules/salesInvoice/admin/ajax/itemNameSearch.php?",
		data: {itemName:itemName},
		success: function(result)
		{
			$("#modal-body").html(result);
		}
  });
	}
	
	
}

</script>
<script>
function getExchangeRate(currencyId)
{
	  $.ajax({
	type: "POST",
    url: '../../../../modules/salesInvoice/admin/ajax/getExchangeRate.php',
    data: {currencyId:currencyId},
    success: function(data){
      $('#exRate').val(data); 
    }
});
}

function checlExrate(exRate)
{
	var exRateCheck	=	parseFloat(exRate);
	if(exRateCheck<=0)
	{
		$('#exRate').val(0);
		$('#currencyId').val('');
		alert('Ex. Rate Shuld Be Greater Than Zero !!! ');
	}
}



</script>

<!--<script type="text/javascript">
$(document).on('keydown', function(e) {
   if (e.key === "Enter") {
        e.preventDefault();

        var $canfocus = $(':tabbable:visible');
        var index = $canfocus.index(document.activeElement) + 1;

        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
    }


});
$('body').on('keydown', 'input, select', function(e) {
    if (e.key === "Enter") {
        var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
        focusable = form.find('input,select,textarea').filter(':visible');
        next = focusable.eq(focusable.index(this)+1);
		
        if (next.length-1) {
            next.focus();
        } else {
            $('#materialSearch').focus();
        }
        return false;
    }
});
</script>-->
<script>
$('#salesReturnForm').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
function checkEnterKey(e,i,id)
{
	
	if (e.key === "Enter") 
	{
		e.preventDefault();
		if(id=='quantityRow'+i)
		{
			$('#unitPriceRow'+i).focus();
		}else{
			$('#materialSearch').focus();
		}
	
	}
}


$(document).ready(function() {
     $(':input[id="invoiceReturnSubmit"]').prop('disabled', true);
	 enableSubmitButton();
	//  clearDiscount();
	//  clearRound();
 });
 
 function enableSubmitButton(){
	 var value=$('#netAmount').val();
	 if(value>0){
		  $(':input[id="invoiceReturnSubmit"]').prop('disabled', false);
	 }else{
		  $(':input[id="invoiceReturnSubmit"]').prop('disabled', true);
		 }
}

</script>