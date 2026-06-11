<?php
/*------------------------------------Coding And Design By Dipin D----------------------------------------*/
if(ISSET($_GET['qrCodeInvoiceId'])){
	$filepath='../../../../modules/salesInvoice/admin/includes/qrCodeGenerator/temp/'.$_GET['qrCodeInvoiceId'].'.png';
	$exits = file_exists($filepath);
	if($exits==1){
			unlink($filepath);
	}
}

$salesInvoiceId='';
// require_once("../../../../libraries/class/utils.php");
require_once("../../../../modules/invoiceEdit/admin/controller/invoiceEditController.php");
require_once('../../../../modules/invoiceEdit/admin/models/invoiceEditmodel.php');
require_once("../../../../modules/salesInvoice/admin/controllers/c_salesInvoice.php");
require_once("../../../../modules/purchase/admin/controllers/c_purchase.php");
// require_once("../../../../settings/path.php");


// $objPath          		= 	new Path();
// $objUtils 	 			= 	new Utils();
$objinvoiceEditmodel	= 	new invoiceEditmodel();
$objCPurchase 			= 	new C_Purchase();
$objCSalesInvoice		= 	new C_salesInvoice();
$objCinvoiceEdit		= 	new invoiceEditController();
$currencyData			=	$objCPurchase->getCurrencyData();
$vesselData				=	$objCSalesInvoice->getVesselData();
$invoiceRefId           =  '';
$selectBoxCurrencyFirst	=	'';

$selectBoxCurrencyFirst	=	'<select style="width:100%" class="input-sm" id="currencyId" onchange="getExchangeRate(this.value);" name="currencyId" >';
$getCurrecy                =   $objCinvoiceEdit->getCurrecy();
while($fetch_getCurrecy= mysqli_fetch_array($getCurrecy))
{		
	$selectBoxCurrencyFirst .='<option value="'.$fetch_getCurrecy['currencyId'].'/'.$fetch_getCurrecy['exRate'].'" >'.$fetch_getCurrecy['currencyName'].'</option>';
}
$selectBoxCurrencyFirst .='</select>'; 
$tbody=$selectBoxCurrency=$selectBoxVessel=$selectBoxOld='';
$discountPercentage='';

		$privilageId       	=   '';
		$branchId        	=   '';
		$userId				=	'';
		$mainBranch        	= 	'';
		$invoiceId    	    =	'';
		$invoiceDate    	=	'';
		$invoiceNo			=	'';
		$transactionType    =	'';
		$transactionTypeName	=	'';
		$customerName		=	'';
		$customerNo			=	'';
		$regularCustomerId	=	'';
		$currencyId     	=	'';
		$totalWithOutvat	=	'';
	    $vatAmount			=	'';
	    $totalWithVat		=	'';
		$discountAmount		=	'';
	    $discountPercent	=	'';
		$vatPercent     	=	'';
		$totalAmountAfterDiscount =	'';
		$exRate             =   '';	
		$damagedGoodsReturn =  '';		
		$damagedGoodsAmount =  ''; 
		$customerNameInvoice =   ''; 
		$customerPhone 		=   '';
		$paymentDetails			=	'';
		$totalNetWeight		=	'';
		 $totalQty		=	'';
		$customerNameReadOnly	=''; 
		$customerCodeReadOnly	=''; 
		$transactionTypeCss		=	'';
		$updateZeroAmount	=	0;
		$round		=	'';
		$roundAmount		=	'';
		$discountInAmounts=0;
		$discountInAmount=0;
		
if(isset($_POST['search']))
{
	$totalQty					=	0;
	$totalNetWeight				=	0;
	$SalesInvoiceNo			    =	$_POST['SalesInvoiceNo'];
	$salesInvoiceId				=	$_POST['salesInvoiceId'];

	$branchDetails     		=	$objCinvoiceEdit->getBranchDetailsOfIncoice($salesInvoiceId);
	while($row=mysqli_fetch_array($branchDetails))
	{
		$privilageId       	 	=   	$row['privilageId'];
		$branchId        		=   	$row['branchId'];
		$userId					=		$row['userId'];
		$mainBranch        		= 		$row['mainBranch'];
	}

	$invoiceDetails     		=	$objCinvoiceEdit->getInvoiceDetails($salesInvoiceId,$privilageId,$branchId);
	
	$invoiceDate=$invoiceNo=$transactionType=$poNo=$quotationNo=$customerName=$customerNo=$vatNumber=$discountAmount=$vatPercent=$totalAmountAfterDiscount='';
	$vesselName=$currencyName=$regularCustomerId=$vesselId=$currencyId=$totalWithOutvat=$vatAmount=$totalWithVat=$discountPercent=$damagedGoodsReturn 
	=$damagedGoodsAmount=$transactionType='';
	
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
		$customerVatNo 		=   $fetch_invoiceDetails['customerVatNo'];
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
	$paymentDetails     		=	$objCinvoiceEdit->getPaymentDetails($salesInvoiceId);
	if($paymentDetails>0 && $transactionType==2)
	{
		$customerCodeReadOnly	=	'readOnly';	
	}else{
		$customerCodeReadOnly	=	'';	
	}
	//if($paymentDetails==0&& $transactionType==2){
	
	
	$getCurrecy                =   $objCinvoiceEdit->getCurrecy();
	$getVessel                 =   $objCinvoiceEdit->getVessel();
	
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
	$bodyDetails                =   $objCinvoiceEdit->printInvoiceBody($salesInvoiceId);
	
	while($fetch_bodyDetails= mysqli_fetch_array($bodyDetails)){
		$getAllUnits=$selectBox=$selected=$itemMasterId=$editTextBox=$selectBoxOld=null;
		$itemMasterId=$fetch_bodyDetails['itemMasterId'];
		if($itemMasterId!=0){
		$getAllUnits=$objCinvoiceEdit->getAllUnits($itemMasterId);
	$selectBox .='<select style="width:100%" class="input-sm itemUnitRow" onchange="checkUnit('.$i.')" onkeypress="checkEnterKey(event,'.$i.',this.id);" id="itemUnitRow'.$i.'" required >
	                <option value="">-unit-</option>';
		while($fetch_rowsOfUnit= mysqli_fetch_array($getAllUnits)){
			if($fetch_rowsOfUnit['itemUnitId']==$fetch_bodyDetails['itemUnitId']){
						$selected='selected';
					}else{
						$selected='';
					}
					$selectBox .='<option value="'.$fetch_rowsOfUnit['itemUnitId'].'-'.$fetch_rowsOfUnit['multiple'].'" '.$selected.'>'.$fetch_rowsOfUnit['unitName'].'</option>';
				}
				$selectBox .='</select>'; 	
		}
		$sumOfPurchasePrice=0;
		$importLocalStatus	=	$fetch_bodyDetails['importLocalStatus'];
		$PurchasePriceOfItem 	= 	$objCinvoiceEdit->getPurchasePrice($itemMasterId,$importLocalStatus);

		
		$itemUnitId		=	$fetch_bodyDetails['itemUnitId'];
		$unitName    	=   $objCinvoiceEdit->getUnitName($itemUnitId);
		if($unitName=='OTHER')
		{
			$readonly	=	'';
		}else{
			$readonly	=	'readonly';
		}
		$stockValue		=	$objCinvoiceEdit->getStockValue($fetch_bodyDetails['stockId'],$privilageId,$branchId);
		$totalStockValue	=	$stockValue+$fetch_bodyDetails['netWeight'];
		$totalStockValue	=	number_format($totalStockValue, 2, '.', '');
		
		$minimumRate		=	$fetch_bodyDetails['minimumRate'];
		$maxretailPrice		=	$fetch_bodyDetails['maxretailPrice'];
		
			$vatTble='';
		
		if($invoiceRefId>'0'){
		    	$vatTble='	<input style="width: 40%;" class="input-sm vatPercentRow" type="hidden" value="0" id="vatPercentRow'.$i.'" onkeyup="checkNumber(this.id); calculateRowTotal('.$i.');">

						<input style="width:50% !important" value="0" type="hidden" id="vatAmountRow'.$i.'"  class=" input-sm vatAmountRowTotal vatAmountRowTotalForSum" readonly/>
					<input style="width: 100%;" class="input-sm amountWithWithVatRowTotal" type="hidden" value="0" id="amountWithWithVatRow'.$i.'" >
						';
		  
		    
		}else{
		      $vatTble='	<td>						
						<input style="width: 40%;" class="input-sm vatPercentRow" type="text" value="'.$fetch_bodyDetails['vatPercent'].'" id="vatPercentRow'.$i.'" onkeyup="checkNumber(this.id); calculateRowTotal('.$i.');">

						<input style="width:50% !important" value="'.$fetch_bodyDetails['vatAmount'].'" type="text" id="vatAmountRow'.$i.'"  class=" input-sm vatAmountRowTotal vatAmountRowTotalForSum" readonly/>
						</td>


						<td style="direction: rtl;">
						<input style="width: 100%;" class="input-sm amountWithWithVatRowTotal" type="text" value="'.$fetch_bodyDetails['amountWithVat'].'" id="amountWithWithVatRow'.$i.'" >
						</td>
                    ';
	
		}
		
		
		
		$tbody .= '<tr id="tr'.$i.'" >

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
						<td>'.$selectBox.'</td>
						<td>
							<input style="width:100% !important;direction: rtl;float: left;" type="text" id="quantityRow'.$i.'" onkeyup="checkNumber(this.id);calculateRowTotal('.$i.');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'.$i.',this.id);" onchange="checkNumber(this.id);calculateRowTotal('.$i.');clearDiscount();clearRound();" value="'.$fetch_bodyDetails['quantity'].'" class=" input-sm quantityRow quantityRowForSum">
						</td>
						
						
						
						<td>
							<input  value="'.$fetch_bodyDetails['netWeight'].'"  id="netWeightRow'.$i.'" style="width: 100%;direction: rtl;" type="text" onkeyup="checkNumber(this.id);calculateRowTotal('.$i.');clearDiscount();clearRound();" onchange="checkNumber(this.id);calculateRowTotal('.$i.');clearDiscount();clearRound();" class=" input-sm netWeightRow netWeightRowForSum" '.$readonly.'>
							<input type="hidden" id="netWeightOld'.$i.'"  class="input-sm netWeightOldRow" value="'.$fetch_bodyDetails['netWeight'].'">
						</td>
						<td>
							<input style="width:100% !important;direction: rtl;" value="'.$fetch_bodyDetails['unitPrice'].'" id="unitPriceRow'.$i.'" onkeyup="checkNumber(this.id);calculateRowTotal('.$i.');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'.$i.',this.id);" onchange="checkNumber(this.id);checkminimumRate('.$i.');calculateRowTotal('.$i.');clearDiscount();clearRound();" type="text" class=" input-sm amountRowTotal">
						</td>
						
						<td>
							<input style="width:100% !important;direction: rtl;" type="text"  id="amountWithOutDiscount'.$i.'" value="'.$fetch_bodyDetails['amount'].'" class="input-sm amountRowWithOutDiscount amountRowWithOutDiscountForSum" readonly="">						
							<input type="hidden" id="purchasePrice'.$i.'" class="purchasePrice" value="'.$PurchasePriceOfItem.'" />
							<input type="hidden" id="sellingPriceHiddenVal'.$i.'" class="sellingPriceHiddenVal" value="'.$maxretailPrice.'" />
							<input type="hidden" id="minimumRate'.$i.'" value="'.$minimumRate.'" class="minimumRate" />
						</td>'.$vatTble.'

						<td><button type="button" onclick="deleteRowFromDb('.$i.');" class="btn btn-danger btnSubmit HideBtn btn-xs"><i class="fa fa-times"></i></button></td>
				    
				   </tr>';
				   $totalQty		=	$totalQty+$fetch_bodyDetails['quantity'];
				   $totalNetWeight	=	$totalNetWeight+$fetch_bodyDetails['netWeight'];
				   $i++;
		}
	/*}
	else{
		$objPath->setHeader('invoiceEdit','Cannot Edit!!!','invoiceEdit');
		
	}*/
	
}

if(isset($_POST['submit']))
{

	/*-------------------------------insert To  invoice Table------------------------------------*/
	$invoiceNo				=	$_POST['invoiceNo'];
	$invoiceIdUpdate		=	$_POST['invoiceIdUpdate'];
	$branchDetails     		=	$objCinvoiceEdit->getBranchDetailsOfIncoice($invoiceIdUpdate);
	while($row=mysqli_fetch_array($branchDetails))
	{
		$privilageId       	 	=   	$row['privilageId'];
		$branchId        		=   	$row['branchId'];
		$userId					=		$row['userId'];
		$mainBranch        		= 		$row['mainBranch'];
	}
	$invoiceCount 			= 	$objCinvoiceEdit->checkInvoiceNoExistOrNot($invoiceNo,$invoiceIdUpdate);
	
	if($invoiceCount==0)
	{
	$invoiceNo				=	$_POST['invoiceNo'];
	$regularCustomerId		=	$_POST['regularCustomerId'];
	$regularCustomerIdOld	=	$_POST['regularCustomerIdOld'];
	$customerName			=	$_POST['customerName'];
	$customerPhone			=	$_POST['customerPhone'];
	$customerVatNumber		=	$_POST['vatNumber'];
	$invoiceDate			=	$_POST['invoiceDate'];
	$invoiceDate			=	date("Y-m-d", strtotime($invoiceDate));
	$poNo					=	'';//$_POST['poNo'];
	$quotationNo			=	'';//$_POST['quotationNo'];
	$currencyDetails			=	$_POST['currencyId'];
	$currencyDetailsArray		=	explode("/",$currencyDetails);
	$currencyId					=	$currencyDetailsArray[0];	
	$vesselId				=	'';
	echo "totalAmount". (float)$totalAmount			=	$_POST['totalAmount'];
	$discountInPercent		=	$_POST['discountInPercent'];
	echo "discountInAmount". (float)$discountInAmount		=	$_POST['discountInAmount'];
	$totalAfterDiscount		=	'';//$_POST['totalAfterDiscount']
	$amountAfterDiscountTotal	=	$_POST['amountAfterDiscountTotal'];
	$damagedGoodsAmount		=	$_POST['damagedGoodsAmount'];
	$damagedGoodsReturn		=	$_POST['damagedGoodsReturn'];
	$vatInPercent			=	$_POST['vatInPercent'];
	$vatAmount				=	$_POST['vatAmount'];
	$netAmount				=	$_POST['netAmount'];
	$transactionType		=	$_POST['typeOfTransactionId'];  
	$transactionTypeOld		=	$_POST['transactionTypeOld'];  
	$exRate                 =   $_POST['exRate'];
	$amountWithExRate1      =  $netAmount * $exRate;
	$amountWithExRate       = number_format($amountWithExRate1,2,'.','');
	$roundOff               =   $_POST['roundOff'];
	$roundAmount              =   $_POST['roundAmount'];
	
/*---------------------------------Total Calculation unsing PHP Start-----------------------------*/
	$amountAfterDiscountTotal		=	(float)$totalAmount-(float)$discountInAmount;//$_POST['amountAfterDiscountTotal'];
	$amountAfterDamage		=	(float)$amountAfterDiscountTotal-(float)$damagedGoodsAmount;	
	$vatAmount				=	($amountAfterDamage*$vatInPercent)/100;
	$netAmount				=	$amountAfterDamage+$vatAmount;
	
	$totalAmount			=	number_format($totalAmount, 2, '.', '');
	$amountAfterDiscountTotal		=	number_format($amountAfterDiscountTotal, 2, '.', '');
	$vatAmount				=	number_format($vatAmount, 2, '.', '');
	$netAmount				=	number_format($netAmount, 2, '.', '');
	/*---------------------------------Total Calculation unsing PHP Ends-----------------------------*/

	$objCinvoiceEdit->updateInvoiceTable($invoiceDate,$currencyId,$totalAmount,$discountInPercent,$discountInAmount,
					$amountAfterDiscountTotal,$damagedGoodsAmount,$vatInPercent,$vatAmount,$netAmount,$invoiceIdUpdate,
								$exRate,$amountWithExRate,$damagedGoodsReturn,$regularCustomerId,$customerName,$customerPhone,$transactionType,$roundOff,$roundAmount,$customerVatNumber);
	
	
	$salesPaymentVoucherNo='';
	if($transactionType==2&&$transactionTypeOld	==1)
	{
		$updateZeroAmount	=	0;
		$objCinvoiceEdit->updateCustomerSalesPaymentTableWithStatusZero($invoiceIdUpdate,$invoiceDate,$updateZeroAmount);
	}
	if($transactionType==1  && $transactionTypeOld	==1)
	{
		$objCinvoiceEdit->updateCustomerSalesPaymentTable($invoiceIdUpdate,$invoiceDate,$netAmount);
	}
	 if($transactionType==1 && $transactionTypeOld	==2){
	$salesPaymentVoucherNo				=	$objCinvoiceEdit->getSalesPaymentVoucherNo($branchId);
	$customerSalesPaymentId				=	$objCinvoiceEdit->insertToCustomerSalesPayment($invoiceIdUpdate,$invoiceDate,$netAmount,$salesPaymentVoucherNo,$exRate,$branchId,$privilageId,$userId,$mainBranch);
	
	}
	/*-------------------------------insert To  invoice Table Ends------------------------------------*/
	/*-------------------------------insert To  invoiceDetails Table------------------------------------*/
	 
	$tableValueArray	= json_decode($_POST['tableValueArray']);
	 echo count($tableValueArray);
	 //exit;
	 for($i=0; $i<count($tableValueArray); $i++)
	 {	 
		if($tableValueArray[$i][1]!=null)
		{
		
		$invoiceDetailsId[]		=	$tableValueArray[$i][1];
		$statusRow[]			=	$tableValueArray[$i][2];
		$sNo[]					=	$tableValueArray[$i][3];
		$stockIdRow[]			=	$tableValueArray[$i][4];
		$itemMasterId[]			=	$tableValueArray[$i][5];
		$quantityRow[]			=	$tableValueArray[$i][6];
		$itemUnitRow[]			=	$tableValueArray[$i][7];
		$netWeightRow[]			=	$tableValueArray[$i][8];
		$netWeightOld[]			=	$tableValueArray[$i][9];
		$unitPriceRow[]			=	$tableValueArray[$i][10];
		$amountWithOutDiscount[]=	$tableValueArray[$i][11]; 
        $purchasePriceRow[]		=	$tableValueArray[$i][12];
        
        $vatPercentRow[]			=	$tableValueArray[$i][13];
		$vatAmountRow[]				=	$tableValueArray[$i][14];
		$amountWithWithVatRow[]		=	$tableValueArray[$i][15]; 
		$itemCodeRow[]				=	$tableValueArray[$i][16];
        	
		}
	 }
	$totalCostValue         =   0;
	if($invoiceIdUpdate>0)
	{ 
		for($i=0;$i<count($itemMasterId);$i++)
		{
			$status					=	$statusRow[$i];
			$itemUnitRowArray 		=	explode("-",$itemUnitRow[$i]);
			$itemUnitId				=	$itemUnitRowArray [0];
			$unitFraction			=	$itemUnitRowArray [1];
			if($status!=0)
			{
				$purchasePrice          =   $purchasePriceRow[$i]*$netWeightRow[$i];
				$totalCostValue         =   $totalCostValue+$purchasePrice;
			}
			

			$objCinvoiceEdit->updateInvoiceDetails($invoiceIdUpdate,$invoiceNo,$invoiceDate,$customerName,$stockIdRow[$i],$itemMasterId[$i],
								$itemUnitId,$unitFraction,$quantityRow[$i],$unitPriceRow[$i],$invoiceDetailsId[$i],$amountWithOutDiscount[$i],
								$netWeightRow[$i],$netWeightOld[$i],$status,$privilageId,$branchId,$mainBranch,$userId,$vatPercentRow[$i],$vatAmountRow[$i],$amountWithWithVatRow[$i],$itemCodeRow[$i]);
		}
			
	}
	if($exRate=='' || $exRate==0 )
		$exRate=1;
	
	$netAmount1           = $netAmount * $exRate;
	$netAmount            = number_format($netAmount1,2,'.','');
	$discountInAmount1    = (float)$discountInAmount * (float)$exRate;
	$discountInAmount     = number_format($discountInAmount1,2,'.','');
	
	$totalAmount1         = (float)$totalAmount-(float)$damagedGoodsAmount;
	$totalAmount1         = $totalAmount1 * $exRate;
	$totalAmount          = number_format($totalAmount1,2,'.','');
	$vatAmount1           = $vatAmount * $exRate;
	$vatAmount            = number_format($vatAmount1,2,'.','');
	$totalCostValue       = number_format(($totalCostValue*$exRate),2,'.','');
	if($privilageId==2)
	{
	    if($regularCustomerId>0 )
	    	$subAccountHeadId 	  = $objCinvoiceEdit->getSubAccountId($regularCustomerId);
	    	else
		$subAccountHeadId 	  = $objCinvoiceEdit->getSubAccountIdByBranchId($branchId);
		if($regularCustomerIdOld>0)
			$subAccountHeadIdOld  = $objCinvoiceEdit->getSubAccountId($regularCustomerIdOld);
			else
		$subAccountHeadIdOld  =	$objCinvoiceEdit->getSubAccountIdByBranchId($branchId);
	    
	}
	else{
		$subAccountHeadId 	  = $objCinvoiceEdit->getSubAccountId($regularCustomerId);
		$subAccountHeadIdOld  = $objCinvoiceEdit->getSubAccountId($regularCustomerIdOld);		       

	}
	
	$updateToAccountJournelDebit	=	$objCinvoiceEdit->updateAccountJournel($invoiceDate,$netAmount,$subAccountHeadId,$subAccountHeadIdOld,$invoiceNo,
	$customerName,$invoiceIdUpdate,$discountInAmount,$totalAmount,$vatAmount,$totalCostValue,$transactionType,$transactionTypeOld,$privilageId,$branchId,$salesPaymentVoucherNo,$regularCustomerId,$userId,$mainBranch);
	/*-------------------------------update To  invoiceDetails Table Ends------------------------------------*/

	
	//header("location:welcome.php?page=salesInvoicePrint&invoiceId=$invoiceIdUpdate&referanceNo=3");
	//header("location:welcome.php?page=countersalesInvoicePrint&invoiceId=$invoiceIdUpdate&referanceNo=1");
	header("location:welcome.php?page=counterSalesInvoiceThermalPrint&invoiceId=$invoiceIdUpdate&referanceNo=1");
	
	
	// header("../../../../modules/salesInvoice/admin/includes/salesInvoicePrint?invoiceId=$invoiceIdUpdate&referanceNo=3");

	// header("Location: ../../../../modules/salesInvoice/admin/includes/salesInvoicePrint.php?invoiceId=$invoiceIdUpdate&referanceNo=3");


	}else{
		$objPath->setHeader('invoiceEdit','Invoice Number Duplication!!!','invoiceEdit');
	}
}

if(isset($_POST['printInvoice'])){
	echo $invoiceIdUpdate = $_POST['invoiceIdForPrint'];
	
	header("location:welcome.php?page=salesInvoicePrint&invoiceId=$invoiceIdUpdate&referanceNo=4");
}

/*if(isset($_POST['updateData']))
{
	$stockId	=	'';
	$netWeight	=	0;
	$branchId	=	'';
	$privilageId	=	'';
	$totalInSTock	=	0;
	$totalOutSTock	=	0;
	$deleteData	=	$objinvoiceEditmodel->getDeletedItems();
	while($row=mysqli_fetch_array($deleteData))
	{
		$stockId		=	$row['stockId'];
		$branchId		=	$row['branchId'];
		$privilageId	=	$row['privilageId'];
		$totalInSTock			=	$objinvoiceEditmodel->getTotalInstockFromItemTransferDetailsTable($stockId,$branchId,$privilageId);
		$totalOutSTock			=	$objinvoiceEditmodel->getTotalOutstockFromItemTransferDetailsTable($stockId,$branchId,$privilageId);
		$totalStockValue		=	$totalInSTock-$totalOutSTock;
		$objinvoiceEditmodel->updateStockInStoctTable($stockId,$totalStockValue,$branchId,$privilageId);
	}
}*/
?>

<!DOCTYPE html>
<html lang="en">
<head>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).on('keydown', function(e) {
   if (e.key === "Enter") {
        e.preventDefault();

        var $canfocus = $(':tabbable:visible');
        var index = $canfocus.index(document.activeElement) + 1;

        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
    }


});
</script>
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
</style>
</head>
    <body>
<!--<form method="POST">
	<button type="submit" name="updateData" id="updateData">Update</button>
</form>-->
  
 
 <div class="col-sm-12 col-md-12 col-lg-12">
	<div class="panel panel-info">
		<div class="panel-heading" style="padding: 13px 9px !important;">
					<i class="fa fa-list-ul"></i>  <strong>&nbsp; Sales Invoice Edit	</strong>
				
						<table width="30%" border="0" style="float: right !important;">
						<tbody style="overflow:auto !important;">
						<tr>
							<td width="20%" style="border:0px !important;padding: 1px 3px !important" >Invoice No:</td>
							<td width="40%" style="border:0px !important;padding: 1px 3px !important" valign="top" >
							<form action="" method="POST" enctype="multipart/form-data" > 
								<input type="text" class="form-control input-sm" id="SalesInvoiceNo" value="" name="SalesInvoiceNo" required >
								<input type="hidden" name="salesInvoiceId" id="salesInvoiceId" value="" />
							</td>
							<td width="20%" style="border:0px !important;padding: 1px 3px !important background-color:#FFF" valign="top" >
							<button type='submit' name='search' class='btn submitBtn ' style="background-color: #97a795d1 !important;padding: 3px 4px !important;" ><i style='color:#fff' class="fa fa-search"></i>&nbsp;</button>
							
							</form>	
							</td>
						</tr>
						</tbody>
						</table>
								
								
						
								
					
		</div>
				<div class="panel-body" style="">
			<div class="col-sm-12 col-md-12 col-lg-12">
				
			</div>		
			<form action="" method="POST" enctype="multipart/form-data"  onsubmit="return hideSaveBtn();"> 
			<div class="col-sm-12 col-md-12 col-lg-12">
					<input type='hidden' id='tableValueArray' name='tableValueArray'> 
					<div class="row" >
							
							<div class="form-group col-sm-2 col-md-2 col-lg-2">
								<label for="poNumber">Invoice Number</label>
								<input type="text" class="form-control input-sm" id="invoiceNo" value="<?php if(isset($invoiceDetails)) { echo $invoiceNo;} else{echo null;} ?>" name="invoiceNo" onkeyup="checkInvNumber(this.id);" required readonly >
								<input type="hidden" id="invoiceIdUpdate" name="invoiceIdUpdate" value="<?php echo $invoiceId; ?>" />
								<input type="hidden" id="branchIdUpdate" name="branchIdUpdate" value="<?php echo $branchId; ?>" />
								<input type="hidden" id="privilageIdUpdate" name="privilageIdUpdate" value="<?php echo $privilageId; ?>" />
							</div>
								<div class="form-group col-sm-2 col-md-2 col-lg-2">
									<label >Date</label>
									<input class='form-control input-sm datepicker' type='text' name='invoiceDate' value="<?php if(isset($invoiceDetails)) { if($invoiceDate==''){ echo null; } else{ echo date("d-m-Y", strtotime($invoiceDate)); }}  ?>" required >
									 <input type="hidden" name="countNewItem" id="countNewItem" value="0" />
							
								</div>
								<?php
								if($privilageId==3)
								{
								?>
								<div class="form-group col-sm-2 col-md-2 col-lg-2">
									<label for="poNumber">Customer Code</label>
									<input type="text" class="form-control input-sm" id="customerCode" name="customerCode" value="<?php if(isset($invoiceDetails)) { echo $customerNo; } else{echo null;} ?>"  required <?php echo $customerCodeReadOnly; ?> >
									</div>
								<?php 
								}
								?>
								<div class="form-group col-sm-4 col-md-4 col-lg-4">
									<label for="poNumber">Customer Name</label>
									<input type="text" class="form-control input-sm" id="customerName" name="customerName" value="<?php if(isset($invoiceDetails)) { echo $customerName;} else{echo null;} ?>" required  <?php echo $customerNameReadOnly; ?> >
										<input type="hidden" name="regularCustomerId" id="regularCustomerId" value="<?php if(isset($invoiceDetails)) { echo $regularCustomerId; } else{echo null;} ?>" />
									<input type="hidden" name="regularCustomerIdOld" id="regularCustomerIdOld" value="<?php if(isset($invoiceDetails)) { echo $regularCustomerId; } else{echo null;} ?>" />
							
								</div>
								<?php
								// if($privilageId==2)
								// {
								?>
								<div class="form-group col-sm-2 col-md-2 col-lg-2" style=" display:block">
									<label for="poNumber">PHONE NO</label>
									<span style="color:#F00" class="mandatory">*</span>
									<input type="text" class="form-control input-sm" id="customerPhone" name="customerPhone" value="<?php if(isset($invoiceDetails)) { echo $customerPhone;} else{echo null;} ?>" readonly>
								</div>
								<?php 
								//}
								?>
								<div class="form-group col-sm-2 col-md-2 col-lg-2">
									<label>VAT NUMBER</label>
									<span style="color:#F00" class="mandatory">*</span>
									<input type="text" class="form-control input-sm" readonly id="vatNumber" onkeypress="checkEnterKey(event,'',this.id);" name="vatNumber" value="<?php if(isset($invoiceDetails)) { echo $customerVatNo;} else{echo null;} //if(isset($deliveryNoteDetails)) { echo $customerName;} ?>"   >
							
								</div>
								
								
								
								
					</div>
							<div class="row">
								
								<div class="form-group col-sm-4 col-md-4 col-lg-4">
									<label for="item" >Item Code/Item Name</label>
									<input type="text" class="form-control input-sm"  id="materialSearch" name="materialSearch"  >
								</div>
								<div class="form-group col-sm-2 col-md-2 col-lg-2">
									<label>Mode Of Pay</label>
									<input type="hidden" name="transactionTypeOld" id="transactionTypeOld" value="<?php echo $transactionType;?>" />
									<select   name="typeOfTransactionId" id="typeOfTransactionId" style="width: 100%;<?php echo $transactionTypeCss;?>" class="input-sm form-group" required >
										<?php echo $transactionTypeName;?>
									</select>
									
								</div>
								<div class="form-group col-sm-2 col-md-2 col-lg-2" >
								
									<label for="vendorName">CURRENCY</label> <span style="color:#F00" class="mandatory">*</span> <br/>
									
										<?php 
										if(isset($invoiceDetails)) {
											echo $selectBoxCurrency;
										}else{
											echo $selectBoxCurrencyFirst;
										}			
										?>
										
										</select>
									
								
								</div>
								<div class="form-group col-sm-2 col-md-2 col-lg-2">
									<label for="poNumber">Ex. Rate</label>
								<input type="text" name="exRate" id="exRate" onkeyup="checkNumber(this.id);checkAmountZero();" required class="form-control input-sm" 
									value="<?php echo $exRate; ?>" />
								</div>
								
					
					</div>
									
							
					
			</div>		

		<div class='col-sm-12 col-md-12 col-lg-12'>
		<table class="table table-bordered" width='100%' id="salesItems" style="font-size: 11px !important;">
			<thead style="background-color:#d0e8d2">
			<tr>
				<th width="5%">#</th>
				<th width="22%">Barcode/Item Description</th>
			
				<th width="10%">Unit</th>
					<th width="10%">Qty</th>
				<th width="10%">Weight</th>
				<th width="10%">Price</th>
				<th width="10%">Amount</th>
				<?php if($invoiceRefId==''){ ?>
				<th width="10%">vat %</th>
				<th width="6%">Amnt.With Vat</th>
				<?php } ?>
				<th width="3%">&nbsp;</th>
			</tr>
			</thead>
			<tbody id="materialDetailsTbody" >
			
				<?php 
				if(isset($_POST['search'])){echo $tbody;}
				?> 
			</tbody>
			<tfoot>
			<tr>
					<td colspan="3"  align="right" style="text-align: right;">Total</td>
					<td >
						<input type="text" name="quantityTotal" id="quantityTotal"  value= "<?php echo $totalQty; ?>" class="form-control input-sm" style="text-align: right;" autocomplete="off" readonly="">
					</td>
				
					<td> 
						<input type="text" name="netWeightTotal" id="netWeightTotal" value= "<?php echo $totalNetWeight; ?>" class="form-control input-sm" style="text-align: right;" autocomplete="off" readonly="">										
					</td>
					<td colspan="3">&nbsp;</td>
					
					
					
				</tr>
				<?php if($invoiceRefId==''){ ?>
				<tr>
					<th colspan="7" style="text-align: right;"><span class="footerOfTable">TOTAL</span></th>
					<td colspan="3">
						<input type="text" name="totalAmount" id="totalAmount" class="input-sm" value="<?php echo $totalWithOutvat; ?>" readonly style="text-align: right;width: 100%">
					</td>
					
				</tr>
				
				<tr>
					<th colspan="7" style="text-align: right;"><span class="footerOfTable">DISCOUNT</span></th>
					<td colspan="3">
					<input type="text" style="width: 30%;float:left;direction: rtl;" name="discountInPercent" id="discountInPercent" class="input-sm" onkeyup="getDiscountAmount();checkNumber(this.id);clearRound()" onchange="getDiscountAmount();checkNumber(this.id);clearRound()" value="<?php echo $discountPercent; ?>">
					<input type="text" style="width:10%;padding: 0%;border: 0px !important;" class="input-sm" value="%">
					<input type="text" style="text-align: right;width: 60%;float: right;" name="discountInAmount" id="discountInAmount" class="input-sm" onkeyup="getDiscountPercent();" onchange="getDiscountPercent();" value="<?php echo $discountAmount; ?>">
					<input type="hidden" id="discountInAmountHidden" name="discountInAmountHidden" value="<?php echo $discountInAmounts; ?>" />
					</td> 
					

				</tr>
					

				<tr>
					<th colspan="7" style="text-align: right;"><span class="footerOfTable">AMOUNT AFTER DISCOUNT</span></th>
					<td colspan="3"><input type="text" name="amountAfterDiscountTotal" id="amountAfterDiscountTotal" class="input-sm" value="<?php echo $totalAmountAfterDiscount; ?>" readonly="" style="text-align: right;width: 100%"></td>

					<input type="hidden" name="damagedGoodsReturn" id="damagedGoodsReturn" value="<?php echo $damagedGoodsReturn;?>" class="input-sm" onkeyup="checkNumber(this.id);getDiscountAmount();clearRound();calculateSum();" onchange="checkNumber(this.id);getDiscountAmount();clearRound();calculateSum();" >
					<input type="hidden" name="damagedGoodsAmount" id="damagedGoodsAmount" value="<?php echo $damagedGoodsAmount;?>" class="input-sm" onkeyup="checkNumber(this.id);getDiscountAmount();clearRound();calculateSum();" onchange="checkNumber(this.id);getDiscountAmount();clearRound();calculateSum();" style="text-align: right;width: 100%">
					<input type="hidden" name="amountAfterDamage" id="amountAfterDamage" />

				</tr>
				<!-- <tr>
					<th >
						<span class="footerOfTable">DAMAGED GOODS RETURN</span>
						<textarea name="damagedGoodsReturn" id="damagedGoodsReturn" style="width: 100%;" rows="6">			
							<?php //echo $damagedGoodsReturn;?>
						</textarea>
					</th>
		
					<th style="text-align: right;" colspan="8"><span class="footerOfTable">DAMAGED GOODS AMOUNT</span></th>
					<td colspan="2">
						<input type="text" name="damagedGoodsAmount" id="damagedGoodsAmount" value="<?php //echo $damagedGoodsAmount;?>" class="input-sm" onkeyup="checkNumber(this.id);getDiscountAmount();clearRound();calculateSum();" onchange="checkNumber(this.id);getDiscountAmount();clearRound();calculateSum();" style="text-align: right;width: 100%">
					</td>
					<input type="hidden" name="amountAfterDamage" id="amountAfterDamage" />
				</tr> -->
				<tr>
					<th style="text-align: right;" colspan="7"><span class="footerOfTable">VAT AMOUNT</span></th>
					<td colspan="3">
						<input type="text" style="width: 25%;float:left;direction: rtl;" name="vatInPercent" id="vatInPercent" class="input-sm" onkeyup="getDiscountAmount();clearRound();calculateSum();checkNumber(this.id);" onchange="getDiscountAmount();clearRound();calculateSum();checkNumber(this.id);" value="<?php echo $vatPercent; ?>">
						<input type="text" style="width:10%;padding: 0%;border: 0px !important;" class="input-sm" value="%">
						<input type="text" name="vatAmount" id="vatAmount" value="<?php echo $vatAmount; ?>" class="input-sm" readonly="" style="text-align: right;width: 65%;float:right">
					</td>		
				</tr>
				
				
				<tr>
					<th style="text-align: right;" colspan="7"><span class="footerOfTable">NET AMOUNT</span></th>
					<td colspan="3"><input type="text" name="netAmount" id="netAmount" class="input-sm" value="<?php echo $totalWithVat; ?>" readonly="" style="text-align: right;width: 100%"></td>		
				</tr>
				
	              <tr>
					<th colspan='7' style="text-align: right;"><span class='footerOfTable'>ROUND</span></th>
					<td colspan='3'  >
					<!--<input type="hidden" name="discountId" id="discountId" class="discountId" />-->
					<input type="text" style="width: 30%;float:left;direction: rtl;" name="roundOff" id="roundOff" class="input-sm" onkeyup="checkNumber(this.id);calculateRound();" onchange="checkNumber(this.id);calculateRound();"  value="<?php echo $round; ?>" autocomplete="off"  />
					
					<input type="text" style="text-align: right;width: 60%;float: right;" name="roundAmount" id="roundAmount" class="input-sm" readonly value="<?php echo $roundAmount; ?>"  />
					</td>
					

				</tr>
				<?php }else{ ?>
					<tr>
					<th colspan="6" style="text-align: right;"><span class="footerOfTable">TOTAL</span></th>
					<td colspan="2">
						<input type="text" name="totalAmount" id="totalAmount" class="input-sm" value="<?php echo $totalWithOutvat; ?>" readonly style="text-align: right;width: 100%">
					</td>
					
				</tr>
				
				<tr>
					<th colspan="6" style="text-align: right;"><span class="footerOfTable">DISCOUNT</span></th>
					<td colspan="2">
					<input type="text" style="width: 30%;float:left;direction: rtl;" name="discountInPercent" id="discountInPercent" class="input-sm" onkeyup="getDiscountAmount();checkNumber(this.id);clearRound()" onchange="getDiscountAmount();checkNumber(this.id);clearRound()" value="<?php echo $discountPercent; ?>">
					<input type="text" style="width:10%;padding: 0%;border: 0px !important;" class="input-sm" value="%">
					<input type="text" style="text-align: right;width: 60%;float: right;" name="discountInAmount" id="discountInAmount" class="input-sm" onkeyup="getDiscountPercent();" onchange="getDiscountPercent();" value="<?php echo $discountAmount; ?>">
					<input type="hidden" id="discountInAmountHidden" name="discountInAmountHidden" value="<?php echo $discountInAmounts; ?>" />
					</td> 
					

				</tr>
					

				<tr>
					<th colspan="6" style="text-align: right;"><span class="footerOfTable">AMOUNT AFTER DISCOUNT</span></th>
					<td colspan="2"><input type="text" name="amountAfterDiscountTotal" id="amountAfterDiscountTotal" class="input-sm" value="<?php echo $totalAmountAfterDiscount; ?>" readonly="" style="text-align: right;width: 100%"></td>
				</tr>
				<tr>
				<th colspan="4" rowspan="3">
					<span class="footerOfTable">DAMAGED GOODS RETURN</span>
					<textarea name="damagedGoodsReturn" id="damagedGoodsReturn" style="width: 100%;" rows="6">			
					<?php echo $damagedGoodsReturn;?>
					</textarea>
				</th>
		
				<th style="text-align: right;" colspan="2"><span class="footerOfTable">DAMAGED GOODS AMOUNT</span></th>
				<td colspan="2">
					<input type="text" name="damagedGoodsAmount" id="damagedGoodsAmount" value="<?php echo $damagedGoodsAmount;?>" class="input-sm" onkeyup="checkNumber(this.id);getDiscountAmount();clearRound();calculateSum();" onchange="checkNumber(this.id);getDiscountAmount();clearRound();calculateSum();" style="text-align: right;width: 100%"></td>
					<input type="hidden" name="amountAfterDamage" id="amountAfterDamage" />
				</tr>
				<tr>
					<th style="text-align: right;" colspan="2"><span class="footerOfTable">VAT AMOUNT</span></th>
					<td colspan="2">
						<input type="text" style="width: 25%;float:left;direction: rtl;" name="vatInPercent" id="vatInPercent" class="input-sm" onkeyup="getDiscountAmount();clearRound();calculateSum();checkNumber(this.id);" onchange="getDiscountAmount();clearRound();calculateSum();checkNumber(this.id);" value="<?php echo $vatPercent; ?>">
						<input type="text" style="width:10%;padding: 0%;border: 0px !important;" class="input-sm" value="%">
						<input type="text" name="vatAmount" id="vatAmount" value="<?php echo $vatAmount; ?>" class="input-sm" readonly="" style="text-align: right;width: 65%;float:right">
					</td>		
				</tr>
				
				
				<tr>
					<th style="text-align: right;" colspan="2"><span class="footerOfTable">NET AMOUNT</span></th>
					<td colspan="2"><input type="text" name="netAmount" id="netAmount" class="input-sm" value="<?php echo $totalWithVat; ?>" readonly="" style="text-align: right;width: 100%"></td>		
				</tr>
				
	              <tr>
					<th colspan='6' style="text-align: right;"><span class='footerOfTable'>ROUND</span></th>
					<td colspan='2'  >
					<!--<input type="hidden" name="discountId" id="discountId" class="discountId" />-->
					<input type="text" style="width: 30%;float:left;direction: rtl;" name="roundOff" id="roundOff" class="input-sm" onkeyup="checkNumber(this.id);calculateRound();" onchange="checkNumber(this.id);calculateRound();"  value="<?php echo $round; ?>" autocomplete="off"  />
					
					<input type="text" style="text-align: right;width: 60%;float: right;" name="roundAmount" id="roundAmount" class="input-sm" readonly value="<?php echo $roundAmount; ?>"  />
					</td>
					

				</tr>
				<?php } ?>
			</tfoot>
		</table>
	</div>	
			
            <div class="form-row" >
				<div class="form-group col-md-12"> 
				<center><button type='submit' name='submit' id="hideBtn" onclick='addArray();' class='btn submitBtn btn-lg' ><i style='color:#fff' class="fa fa-save"></i>&nbsp;<span style='color:#fff'>Save</span></button></center>
				</div>
			</div>

	
	 </form>

            </div>
	</div>


 </div>
 
 <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="row">
					<div class="form-group col-sm-4 col-md-4 col-lg-4">
						<label for="item" >Item Name</label>
						<input type="text" class="form-control input-sm"  id="itemNameSearch" name="itemNameSearch" />
					</div>
					<div class="form-group col-sm-2 col-md-2 col-lg-2">
						</br>
						<button type="button"  class="btn btn-success" onclick="searchItemData();" ><i style='color:#fff' class="fa fa-search"></i></button>
					 </div>
				</div>	
	  </div>
      <div class="modal-body" id="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<style >.ui-autocomplete { height: 200px; overflow-y: scroll; overflow-x: hidden;}</style>

<script type="text/javascript">


var count = $('#materialDetailsTbody tr').length;
 var i=count+1;

$(function(){
$("#SalesInvoiceNo").autocomplete({
   source: function(request, response) {
     $.getJSON("../../../../modules/invoiceEdit/admin/ajax/ajaxForInvoiceNo.php", {
		 term  : $('#SalesInvoiceNo').val()}, 
              response);
  },
      minLength: 0,
	  select: function( event, ui ) {
		 $('#salesInvoiceId').val( ui.item.key);
		 $('#SalesInvoiceNo').val(ui.item.value);
		 return false;
      }  ,
	  change: function (event, ui) {
             if (ui.item == null) 
			 {
			   $('#salesInvoiceId').val('');
			   $('#SalesInvoiceNo').val('');
		    
			 }
		}
   });
});
$(function(){
$("#customerCode").autocomplete({
   source: function(request, response) {
     $.getJSON("../../../../modules/invoiceEdit/admin/ajax/searchCustomer.php", {
		 term  : $('#customerCode').val(),branchId  : $('#branchIdUpdate').val()}, 
              response);
  },
      minLength: 0,
     
      select: function( event, ui ) {
		  $("#regularCustomerId").val( ui.item.key )
		  $("#customerCode").val( ui.item.customerNo );
		  $("#customerName").val( ui.item.customerName );
		  // $("#taxId").val( ui.item.vatNumber );
		  // $("#materialSearch").attr("readonly", false); 
		  // $('#searchItemName').prop("disabled",false);
		 return false;
      } ,
	  change: function (event, ui) {
             if (ui.item == null) 
			 {
            $("#customerName").val('');
			$("#customerCode").val('');
			$("#regularCustomerId").val('');
			//$("#materialSearch").attr("readonly",true); 
		  // $('#searchItemName').prop("disabled",true);
			 }
		}
	 
   });
});

// start barcode 
var lastEnterTime = 0;
$('#materialSearch').on('keydown', function(e) {
    if (e.key === "Enter") {
        var now = Date.now();
        var elapsedTime = now - lastEnterTime;

        // Check if the Enter key was pressed again within 500 milliseconds
        if (elapsedTime < 500) {
            // Ignore this Enter key press
            return;
        }

        lastEnterTime = now;

        var barcode = $('#materialSearch').val().trim(); // Trim to remove leading/trailing spaces
        if (barcode !== '') {
            $.ajax({
                type: "POST",
                url: '../../../../modules/counterSalesInvoice/admin/ajax/checkBarcode.php',
                data: {barcode: barcode},
                success: function(data) {
                    getBarcodeData(barcode, data);
					
                    $('#materialSearch').val(''); // Clear input
                    $('#materialSearch').focus(); // Focus back on the input
                }
            });
        }
    }
});

function chunkString (str, len) {
  const size = Math.ceil(str.length/len)
  const r = Array(size)
  let offset = 0
  
  for (let i = 0; i < size; i++) {
    r[i] = str.substr(offset, len)
    offset += len
  }
  
  return r
}


function getBarcodeData(barcode,data)
{
	
if(data==1){
		//alert();
	var cat1 = chunkString(barcode, 2);
	var newBarcode = barcode.slice(2);
	var barcode1 = chunkString(newBarcode, 5);


	// console.log("category is :"+barcode1[0]);
	// console.log("barcode is :"+barcode1[0]);
	// console.log("quantity is :"+barcode1[1]);
if(barcode1[1]=='' || isNaN(barcode1[1]))
	barcode1[1]=1;
	var barcodeSliced = barcode1[0];
	var quantity = barcode1[1];
	var isBarcode = 1;
	
}else {
	var quantity = 1;
	var isBarcode =2;
	var barcodeSliced=barcode;	
}
	$.ajax({
	type: "POST",
	cache:false,
	dataType:"json",
	url: '../../../../modules/counterSalesInvoice/admin/ajax/searchMaterialsForBarCode.php',
	data: {barcode:barcodeSliced},
	success: function(data)
	{	
		
		if(data.key == null && data.itemCode == null)
		{
			$('#materialSearch').val(null);
			//$('#materialSearch').focus();
			setTimeout(function() 
			{
        		$('#materialSearch').focus();
    		}, 1);
			$('#flag').val(0); 

			// Close the autocomplete after processing the barcode
			// $("#materialSearch").autocomplete("close");

			processBarcode();
			
		}	
		else 
		{

			getPurchasePrice(data.key,data.itemName,data.itemCode,data.vat,data.sellingPrice,regularCustomerId,data.stockId,data.importLocalStatus,data.stockValue,data.minimumRate);


			$('#materialSearch').val(null);
			$('#materialSearch').focus();
			$('#flag').val(1); 

			processBarcode();

			 // Close the autocomplete after processing the barcode
			//  $("#materialSearch").autocomplete("close");
		}		
	}
	});	
	
}

// Example of closing the autocomplete after processing the barcode
function processBarcode() {
			//console.log("hello");            
			$("#materialSearch").blur();
        }	


$(function(){
	
$("#materialSearch").autocomplete({
   source: function(request, response) {
     $.getJSON("../../../../modules/invoiceEdit/admin/ajax/searchMaterials.php", {
		 term  : $('#materialSearch').val(),regularCustomerId:null,invoiceId:$('#invoiceIdUpdate').val()}, 
              response);
  },
      minLength: 0,
      focus: function( event, ui ) {
        $("#materialSearch").html( ui.item.value );
        return false;
      },
      select: function( event, ui ) {
		 var regularCustomerId	= null;
		getPurchasePrice(ui.item.key,ui.item.itemName,ui.item.itemCode,ui.item.vat,ui.item.sellingPrice,regularCustomerId,ui.item.stockId,ui.item.importLocalStatus,ui.item.stockValue,ui.item.minimumRate);
		$('#materialSearch').val(null);
		 return false;
      } 
   });
});


 
 function getPurchasePrice(itemMasterId,itemName,itemCode,vat,sellingPrice,regularCustomerId,stockId,importLocalStatus,stockValue,minimumRate)
  {
	  $.ajax({
	type: "POST",
    url: '../../../../modules/salesInvoice/admin/ajax/getPurchasePrice.php',
    data: {itemMasterId:itemMasterId,importLocalStatus:importLocalStatus},
    success: function(data){
       // alert(data);  
		getMaterialRow(itemMasterId,itemName,itemCode,vat,sellingPrice,data,stockId,stockValue,minimumRate);
    }
});
	   
  }
  
 function getMaterialRow(itemMasterId,itemName,itemCode,vat,sellingPrice,purchasePrice,stockId,stockValue,minimumRate)
{
	
	if(vat==null)
	{
		vat = '';
	}
	if(sellingPrice==null)
	{
		sellingPrice = '';
	}
	
	var materialTableRow=null;
	$.ajax({
                type: "GET",
                url: "../../../../modules/salesInvoice/admin/ajax/getMaterialUnit.php?itemMasterId="+itemMasterId,
                success: function(data)
                {
                    	var vatValue = sellingPrice*15/100;
				  var selectBoxForUnit	=	'<select  class="input-sm form-group itemUnitRow" style="width: 100% !important;" name="itemUnitRow[]" id="itemUnitRow'+i+'" onchange="checkUnit('+i+');" required >'+JSON.parse(data)+'</select>'	;
					  materialTableRow	+=	'<tr><td style="text-align:center"><span class="indexNo indexNoHide" id="indexNo'+i+'">'+i+'</span></td>'; 
					  materialTableRow	+=	'<td><input type="hidden" id="invoiceDetailsId'+i+'" class="input-sm invoiceDetailsId" value="0">';
					  materialTableRow	+=	'<input type="hidden" value="2" id="status'+i+'" class="statusRow">';
					  materialTableRow	+=	'<input type="hidden" value="'+i+'" id="sNo'+i+'" class="sNo">';
					  materialTableRow	+=	'<input type="hidden" value="'+stockId+'" id="stockIdRow'+i+'" class="stockIdRow">';
					  materialTableRow	+=	'<input type="hidden" id="itemCodeRow'+i+'" style="width:100% !important" class="form-control input-sm itemCodeRow" value="'+itemCode+'" readonly />';
					  materialTableRow	+=	'<input type="hidden"  id="itemMasterId'+i+'" class="form-control input-sm itemMasterId" value="'+itemMasterId+'" />';
					   materialTableRow	+=	'<input type="hidden"  id="stockValue'+i+'" class="form-control input-sm stockValue" value="'+stockValue+'" />'+itemCode+'/'+itemName+'</td>';
					  materialTableRow	+=	'<td>'+selectBoxForUnit+'</td>';
					  materialTableRow	+=	'<td><input style="width:100% !important;direction: rtl;float: left;" type="text"  id="quantityRow'+i+'" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'+i+',this.id);" onchange="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();" class=" input-sm quantityRow quantityRowForSum" required/></td>';
					  materialTableRow	+=	'<td><input type="hidden" id="netWeightOld'+i+'" class="netWeightOldRow" value="0"><input name="netWeightRow"  id="netWeightRow'+i+'" style="width: 100%;direction: rtl;" type="text" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();" onchange="checkNumber(this.id);checkminimumRate('+i+'); calculateRowTotal('+i+');clearDiscount();clearRound();" class=" input-sm netWeightRow netWeightRowForSum"  readonly="" required></td>';
					  materialTableRow	+=	'<td><input style="width:100% !important;direction: rtl;"  value="" id="unitPriceRow'+i+'" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'+i+',this.id);"  onchange="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();"   type="text" class=" input-sm amountRowTotal"  /><input type="hidden" id="minimumRate'+i+'" value="'+minimumRate+'" class="minimumRate" /></td>';
					  materialTableRow	+=	'<td><input type="hidden" id="purchasePrice'+i+'" class="purchasePrice" value="'+purchasePrice+'" /><input type="hidden" id="sellingPriceHiddenVal'+i+'" class="sellingPriceHiddenVal" value="'+sellingPrice+'" /><input style="width:100% !important;direction: rtl;" type="text" name="amountWithOutDiscount" id="amountWithOutDiscount'+i+'" value=""  class="input-sm amountRowWithOutDiscount amountRowWithOutDiscountForSum" readonly/></td>';						 
					 
	<?php if($invoiceRefId==''){ ?>
					  materialTableRow	+=	'<td><input style="width:40% !important"  value="15" type="text" id="vatPercentRow'+i+'" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');"" onblur="tabPressFocus()" class=" input-sm vatPercentRow" /><input style="width:60% !important"  value="'+vatValue+'" type="text" id="vatAmountRow'+i+'"  class=" input-sm vatAmountRowTotal vatAmountRowTotalForSum" readonly/></td>';
					 
                      materialTableRow	+=	'<td><input style="width:100% !important"  value="'+sellingPrice+'" id="amountWithWithVatRow'+i+'" type="text" class=" input-sm amountWithWithVatRowTotal" readonly="" /></td>';

					  
					  <?php }else{ ?>
  materialTableRow	+=	'<input style="width:40% !important"  value="0" type="hidden" id="vatPercentRow'+i+'" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');"" onblur="tabPressFocus()" class=" input-sm vatPercentRow" /><input style="width:60% !important"  value="0" type="hidden" id="vatAmountRow'+i+'"  class=" input-sm vatAmountRowTotal vatAmountRowTotalForSum" readonly/>';
					 
                      materialTableRow	+=	'<input style="width:100% !important"  value="'+sellingPrice+'" id="amountWithWithVatRow'+i+'" type="hidden" class=" input-sm amountWithWithVatRowTotal" readonly="" />';

<?php } ?>

					  materialTableRow	+=	'<td><button type="button" onclick="deleteRow(this)"  class="btn btn-danger btnSubmit btn-xs" ><i class="fa fa-times"></i></button></td>';
					  materialTableRow	+=	'</tr>';
					  $('#materialDetailsTbody').append(materialTableRow);
					//$('#quantityRow'+i).focus();
					$('#materialSearch').focus();
					
					//checkUnit(i);
					calWithOutVats(i);
					idChange();
				  i++;
				  clearDiscount();	
					clearRound();				  
				}
            })				
}

	function clearDiscount()
	{
		$('#discountInPercent').val(null);
		$('#discountInAmount').val(null);
		$('#discountInAmountHidden').val(null);
		calculateSum();
		
		
		
	}
</script>
<script>
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
function checkUnitreverse(i){
	
	var unitName = $("#itemUnitRow"+i+" option:selected").text();
	if(unitName =='OTHER')
	{
		$('#netWeightRow'+i).prop('readonly', false);
calculateRowTotalReverse(i);		
	
	}
		else{
		
			var itemMasterId	=	parseFloat($('#itemMasterId'+i).val());
				var unitId = $("#itemUnitRow"+i).val();
			$.ajax({
						type: "POST",
						url: '../../../../modules/salesInvoice/admin/ajax/getUnitPriceFromCartonFraction.php',
						data: {itemMasterId:itemMasterId,unitId:unitId},
						success: function(data){
							
							$('#amountWithWithVatRow'+i).val(data);
							$('#netWeightRow'+i).prop('readonly', true);
							calculateRowTotalReverse(i);
							
							
						}
					});
		
	}
	
}


function calculateRowTotalReverse(i)
   {
	  clearRound();
	   var quantityRow			=	parseFloat($('#quantityRow'+i).val());
	   var unitPriceRow			=	parseFloat($('#unitPriceRow'+i).val());
	   var stockIdRow			=	$('#stockIdRow'+i).val();
	   var value 				= 	$("#itemUnitRow"+i+" option:selected").val();
	   var unitName 			= 	$("#itemUnitRow"+i+" option:selected").text();
	    var stockValue           =   $('#stockValue'+i).val(); 
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
			var newNeightWeight	= $('#netWeightRow'+i).val();		
		}else{
			var newNeightWeight = quantityRow*fraction;
		}
	  if(newNeightWeight==''||isNaN(newNeightWeight))
			{
				newNeightWeight=0;
			}
			var rowTotal		=	newNeightWeight*unitPriceRow;
		
		 var privilageId = <?php echo $privilageid = $_COOKIE['privillegeId']; ?>;
		 //alert(privilageId);
		 if(privilageId==3 || privilageId==2 || privilageId==6){
			 if(parseFloat(newNeightWeight)<=parseFloat(stockValue))
	
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
									$('#amountWithOutDiscount'+i).val(rowTotal.toFixed(2)); 
								}
									calculateRowVat(i);	
								calculateSum();	  
						  }else{
						
								alert("Only "+stockValue+" is Available ln Stock");
							  $('#quantityRow'+i).val(null);
							  $('#netWeightRow'+i).val(null);
							  //$('#itemUnitRow'+i).val(null);
							 // $('#unitPriceRow'+i).val(null);
							  $('#amountWithOutDiscount'+i).val(null);
							 	calculateRowVat(i);	
							calculateSum();	  
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
					$('#amountWithOutDiscount'+i).val(rowTotal.toFixed(2)); 
				}
				calculateRowVat(i);	
								calculateSum();	
		 }			 
		 
   }
   
function checkUnit(i)
{
	var unitName = $("#itemUnitRow"+i+" option:selected").text();
	if(unitName =='OTHER')
	{
		$('#netWeightRow'+i).prop('readonly', false);	
		calculateRowTotal(i);
	}else if(unitName =='CARTON')
	{
		var itemMasterId	=	parseFloat($('#itemMasterId'+i).val());
			$.ajax({
						type: "POST",
						url: '../../../../modules/salesInvoice/admin/ajax/getCartonSellingPrice.php',
						data: {itemMasterId:itemMasterId},
						success: function(data){
							
							$('#unitPriceRow'+i).val(data);
							$('#netWeightRow'+i).prop('readonly', true);
							calculateRowTotal(i)					  
						}
					});
	}
		else{
		
			var itemMasterId	=	parseFloat($('#itemMasterId'+i).val());
			$.ajax({
						type: "POST",
						url: '../../../../modules/salesInvoice/admin/ajax/getUnitPriceFromCartonFraction.php',
						data: {itemMasterId:itemMasterId},
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
   clearRound();
	   var quantityRow			=	parseFloat($('#quantityRow'+i).val());
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
		
		// if(privilageId==3)
		if(privilageId==3 || privilageId==2 || privilageId==6)
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
							$('#amountWithOutDiscount'+i).val(rowTotal.toFixed(2)); 
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
				$('#amountWithOutDiscount'+i).val(rowTotal.toFixed(2)); 
			}
		}
			calculateRowVat(i);
		calculateSum();	   
	   
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
		}else{
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
 function idChange()
{
	$('[data-toggle="popover"]').popover({ trigger: "hover" });   
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
}
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
	var discountInAmount			=	$('#discountInAmountHidden').val();
	//alert();
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
 function getDiscountAmount()
   {
	  var totalAmount		=	parseFloat($('#totalAmount').val());
	  var discountInPercent =	parseFloat($('#discountInPercent').val());
   if(isNaN(discountInPercent)||discountInPercent==0||discountInPercent=='')
	 {
		  //$('#discountInPercent').val(null);
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
		 $('#discountInAmountHidden').val(null);
	   
	 }else{
		  var discountPercent	=	(discountInAmount*100)/totalAmount;
		  $('#discountInPercent').val(discountPercent.toFixed(2));
		$('#discountInAmountHidden').val(discountInAmount.toFixed(2));
	 }
	  calculateSum();
	    
   }
   
   function deleteRowFromDb(i)
{
   $('#tr'+i).attr('hidden','hidden');
	$('#amountWithOutDiscount'+i).removeClass("amountRowWithOutDiscountForSum");
	$('#indexNo'+i).removeClass("indexNoHide");
	$('#quantityRow'+i).removeClass("quantityRowForSum");
	$('#netWeightRow'+i).removeClass("netWeightRowForSum");
	$('#status'+i).val(0);
	calculateSum();
	idChange();
	clearDiscount();
	clearRound();
	alert('To Complete Delete Operation Click Submit Button');
}
  function deleteRow(r)
{
   var i = r.parentNode.parentNode.rowIndex;
   document.getElementById("salesItems").deleteRow(i);
   calculateSum();
	idChange();
	clearDiscount();
	clearRound();
}
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
	
	function checkminimumRate(i){
	 
	    var minimumRate		=	parseFloat($('#minimumRate'+i).val());
	   var sellingPriceHiddenVal		=	parseFloat($('#sellingPriceHiddenVal'+i).val());
	    var minimumPrice    =   sellingPriceHiddenVal-minimumRate;
	     var unitPriceRow		=	parseFloat($('#unitPriceRow'+i).val());
	   	var unitName = $("#itemUnitRow"+i+" option:selected").text();
	   	if(parseFloat(sellingPriceHiddenVal)>0){
	if(unitName =='CARTON')
	{
	  
	   if(parseFloat(unitPriceRow)<parseFloat(minimumPrice)){
	       alert("Selling Price Less Than Minimum Rate");
	       $('#unitPriceRow'+i).val(sellingPriceHiddenVal);
	       calculateRowTotal(i);
	   }
	}else if(unitName =='KG'){
	    	var itemMasterId	=	parseFloat($('#itemMasterId'+i).val());
			$.ajax({
						type: "POST",
						url: '../../../../modules/salesInvoice/admin/ajax/getCartoonMultiple.php',
						data: {itemMasterId:itemMasterId},
						success: function(data){
							
							var minimumPriceKg  = minimumPrice/data;
							
		 if(parseFloat(unitPriceRow)<parseFloat(minimumPriceKg)){
	       alert("Selling Price Less Than Minimum Rate");
	       var kgPrice  = sellingPriceHiddenVal/data;
	      
	       $('#unitPriceRow'+i).val(kgPrice);
	       calculateRowTotal(i);
	   }
						}
					});
	    
	    
	
	}
	
	   	} 
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

			var itemCodeRow				= document.getElementById("itemCodeRow"+i).value;
			console.log(itemCodeRow);
	    	
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
			invoiceData[k][16]  = itemCodeRow;	
			k++;

    }

var json_text = JSON.stringify(invoiceData);
document.getElementById("tableValueArray").value = json_text;
}
function hideSaveBtn() {
    $("#hideBtn").css("display", "none");
    return true;
}

function calWithOutVats(i)
{
	var amountWithWithVatRow	=	parseFloat($('#amountWithWithVatRow'+i).val());
	var unitPriceRow 			= 	amountWithWithVatRow / (1 + (15/100));	 
	if(isNaN(unitPriceRow))
	{
		unitPriceRow = 0; 
	}
	var vat = unitPriceRow*15/100;
	if(isNaN(vat) || vat=='')
	{
		vat = 0;  
	}
	 var netweigt			=	parseFloat($('#netWeightRow'+i).val());
	 if(isNaN(netweigt) || netweigt=='')
	{
		netweigt = 1;  
	}
	 var unitprice          = unitPriceRow/netweigt;
		
		$('#unitPriceRow'+i).val(unitprice.toFixed(2));
		$('#sellingPriceHiddenVal'+i).val(unitprice.toFixed(2));

	$('#vatAmountRow'+i).val(vat.toFixed(2)); 

	$('#amountWithOutDiscount'+i).val(unitPriceRow.toFixed(2));
	
	calculateSum(); 
}

// customer auto complete starts
$(function(){
$("#customerName").autocomplete({
   source: function(request, response) {
     $.getJSON("../../../../modules/salesInvoice/admin/ajax/searchCustomer.php", {
		 term  : $('#customerName').val()}, 
              response);
  },
      minLength: 0,
     
      select: function( event, ui ) {
		  $("#regularCustomerId").val( ui.item.key )
		 // $("#customerCode").val( ui.item.customerNo );
		  $("#customerName").val( ui.item.customerName );
		   $("#vatNumber").val( ui.item.vatNumber ); 
		   $("#customerPhone").val( ui.item.contactNo_1 );
		  // $("#materialSearch").attr("readonly", false); 
		  // $('#searchItemName').prop("disabled",false);
		 return false;
      } ,
	  change: function (event, ui) {
             if (ui.item == null) 
			 {
          //  $("#customerName").val('');
		//	$("#customerCode").val('');
			$("#regularCustomerId").val('');
			$("#vatNumber").val('');
			$("#customerPhone").val('');
			//$("#materialSearch").attr("readonly",true); 
		  // $('#searchItemName').prop("disabled",true);
			 }
		}
	 
   });
});
//  customer auto complete ends

</script>