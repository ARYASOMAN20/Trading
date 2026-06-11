<?php
/*------------------------------------Coding And Design By DIPIN D----------------------------------------*/

if(ISSET($_GET['qrCodeInvoiceId'])){
	$filepath='../../../../modules/salesInvoice/admin/includes/qrCodeGenerator/temp/'.$_GET['qrCodeInvoiceId'].'.png';
	$exits = file_exists($filepath);
	if($exits==1){
			unlink($filepath);
	}
}

require_once("../../../../libraries/class/utils.php");
require_once("../../../../modules/salesInvoice/admin/controllers/c_salesInvoice.php");
require_once("../../../../modules/purchase/admin/controllers/c_purchase.php");
require_once("../../../../settings/path.php");
require_once("../../../../modules/salesInvoice/admin/models/m_salesInvoice.php");

$objPath          		= 	new Path();
$objUtils 	 			= 	new Utils();
$objCPurchase 			= 	new C_Purchase();
$objCSalesInvoice		= 	new C_salesInvoice();
$objMSalesInvoice		= 	new M_salesInvoice();

$maxInvoiceNo			=	$objCSalesInvoice->getMaxInvoiceNo();
$prevInvNo				=	$objCSalesInvoice->getPrevInvoiceNo();
$currencyData			=	$objCPurchase->getCurrencyData();
$vesselData				=	$objCSalesInvoice->getVesselData();

$salesPaymentVoucherNo	=	'';
$customerSalesPaymentId	=	'';
$netAmountWithExRate	=	0;
$totalCostValue         =   0;
$table                  =  '';
$privilageId            =  '';
$userId                 =  '';
$userId                 =  '';
$regularCustomerId		=  '';
$paymentModeOptions		=	'';

$privilageId       	 	=   $_COOKIE['privillegeId'];
$branchId        		=   $_COOKIE['branchId'];
$userId					=	$_COOKIE['userId'];
$mainBranch        		= 	$_COOKIE['mainBranch'];
if($privilageId	==2 || $privilageId	==6)
{
	$required			=	'';
	$readOnly			=	'';
	$showPhone			=	'display:block';
	$showCustomerCode	=	'display:none';
	$cashInvoiceSelected =	'selected';
	$creditIncoiceSelected 	=	'';
	$paymentModeOptions	=	'<option value="1" '.$cashInvoiceSelected.'>Cash Invoice</option>
	                         <option value="2"  '.$creditIncoiceSelected.'>Credit Invoice</option>';

}else{
	$required			=	'required';
	$readOnly			=	'readonly';
	$showPhone			=	'display:none';
	$showCustomerCode	=	'display:block';
	$cashInvoiceSelected =	'';
	$creditIncoiceSelected 	=	'selected';
	$paymentModeOptions	=	'<option value="1" '.$cashInvoiceSelected.'>Cash Invoice</option>
							<option value="2"  '.$creditIncoiceSelected.'>Credit Invoice</option>';
}
if($privilageId==2&&$mainBranch=='M')
{
	$thernalPrintSelect='checked';
	$wholeSaleSelect='checked';
	$normalPrintSelect='';
	$cuttingChargeShow='style="display:contents;"';
	$incoiceTypeShow='style=""';
	$rowspan			=	4;
}else{
	$thernalPrintSelect='';
	$normalPrintSelect='checked';
	$wholeSaleSelect='';
	$cuttingChargeShow='style="display:none;"';
	$incoiceTypeShow='style="display:none;"';
	$rowspan			=	3;
}


if(isset($_POST['search']))
{
	$delNoteNo					=	$_POST['delNoteNo'];
	$deliveryNoteId				=	$_POST['deliveryNoteId'];
	$deliveryNoteExist			=	$objCSalesInvoice->checkDeliveryNoteDuplication($deliveryNoteId);
	if($deliveryNoteExist>0)
	{
		$objPath->setHeader('salesInvoice','Invoice For This Delivery Note Already Done !!!','salesInvoice');

	}else{
		
	$deliveryNoteDetails		=	$objCSalesInvoice->getDeliveryNoteDetails($deliveryNoteId);
	
	$tbody						=	$deliveryNoteDetails['tbody'];
	$regularCustomerId			=	$deliveryNoteDetails['regularCustomerId'];
	$customerName				=	$deliveryNoteDetails['customerName'];
	$vatNumber					=	$deliveryNoteDetails['vatNumber'];
	$customerNo					=	$deliveryNoteDetails['customerNo'];
	$quotation					=	$deliveryNoteDetails['quotation'];	
	$poNo						=	$deliveryNoteDetails['poNo'];	
	$modeOfPayment				=	$deliveryNoteDetails['modeOfPayment'];	
	$currencyOptionValue		=	$deliveryNoteDetails['currencyOptionValue'];
	$vesselOptionValue			=	$deliveryNoteDetails['vesselOptionValue'];
	$totalWithOutvat			=	$deliveryNoteDetails['totalWithOutvat'];
	$vatAmount					=	$deliveryNoteDetails['vatAmount'];
	$totalWithVat				=	$deliveryNoteDetails['totalWithVat'];
	$exRate						=	$deliveryNoteDetails['exRate'];
	}
	
}
if(isset($_POST['submit']))
{
	/*-------------------------------insert To  invoice Table------------------------------------*/
	$invoiceNo				=	$objCSalesInvoice->getMaxInvoiceNo();//$_POST['invoiceNo'];
	$invoiceCount 			= 	$objCSalesInvoice->checkInvoiceNoExistOrNot($invoiceNo);
	$maxOfinvoiceNumericNo	=	$objCSalesInvoice->getMaxOfinvoiceNumericNo();

	
	if($invoiceCount==0)
	{
	$regularCustomerId		=	$_POST['regularCustomerId'];
	$customerName			=	$_POST['customerName'];
	$invoiceDate			=	$_POST['invoiceDate'];
	$invoiceDate			=	date("Y-m-d", strtotime($invoiceDate));
	$poNo					=	$_POST['poNo'];
	$quotationNo			=	$_POST['quotationNo'];
	$currencyData			=	$_POST['currencyId'];
	$currencyDataArray		=	explode('/',$currencyData);
	$currencyId				=	$currencyDataArray[0];
	$vesselId				=	'';
	$totalAmount			=	$_POST['totalAmount'];
	//if($privilageId==11){
	$discountInPercent		=	$_POST['discountInPercent'];
	$discountId				=	'';//$_POST['discountId'];
	$discountInAmount		=	$_POST['discountInAmount'];
	if($discountInAmount=='')
	{
		$discountInAmount		=	0;
	}
	/*}
	else{
		$discountInPercent	=	'';
	$discountId				=	'';
	$discountInAmount		=   '';
	}*/
	$vatNumber              =  $_POST['vatNumber'];
	if($vatNumber>0)
     $zakatInvoiceType = '0100000';
  else
   $zakatInvoiceType='0200000';
	
	
	$vatPercent				=	$_POST['vatInPercent'];
	$vatAmount				=	$_POST['vatAmount'];
	$netAmount				=	$_POST['netAmount'];
	$transactionType		=	$_POST['transactionType'];
	$deliveryNoteId			=	'';//$_POST['deliveryNoteId'];
	$exRate					=	$_POST['exRate'];
	$damagedGoodsReturn		=	$_POST['damagedGoodsReturn'];
	$damagedGoodsAmount		=	$_POST['damagedGoodsAmount'];
	$customerPhone			=	$_POST['customerPhone'];
	$customerName			=	$_POST['customerName'];
	$cuttingCharge			=	$_POST['cuttingCharge'];
	if($cuttingCharge=='')
	{
		$cuttingCharge		=	0;
	}
	if($damagedGoodsAmount=='')
	{
		$damagedGoodsAmount		=	0;
	}
	$invType				=	$_POST['invType'];
	$roundOff               =   $_POST['roundOff'];
	$roundAmount              =   $_POST['roundAmount'];
	
	/*---------------------------------Total Calculation unsing PHP Start-----------------------------*/
	$discountInAmount		=	number_format($discountInAmount, 2, '.', '');
	$totalAfterDiscount		=	$totalAmount-$discountInAmount;//$_POST['amountAfterDiscountTotal'];
	$amountAfterDamage		=	$totalAfterDiscount-$damagedGoodsAmount;	
	$amountWithCuttingCharge =	$amountAfterDamage+$cuttingCharge;
	$vatAmount				=	($amountWithCuttingCharge*$vatPercent)/100;
	$netAmount				=	$amountWithCuttingCharge+$vatAmount;
	
	$totalAmount			=	number_format($totalAmount, 2, '.', '');
	$totalAfterDiscount		=	number_format($totalAfterDiscount, 2, '.', '');
	$vatAmount				=	number_format($vatAmount, 2, '.', '');
	$netAmount				=	number_format($netAmount, 2, '.', '');
	/*---------------------------------Total Calculation unsing PHP Ends-----------------------------*/
	$privilageId       	 	=   	$_COOKIE['privillegeId'];
	$branchId        		=   	$_COOKIE['branchId'];
	$userId					=		$_COOKIE['userId'];
	
	if($exRate==''|| $exRate==null || $exRate==0 )
			{
				$exRate	=	1;
			}
	$netAmountWithExRate	=	number_format(($netAmount*$exRate), 2, '.', '');
	
	$invoiceId				=	$objCSalesInvoice->insertToInvoiceTable($invoiceNo,$regularCustomerId,$invoiceDate,
								$poNo,$quotationNo,$currencyId,$vesselId,$totalAmount,$discountInPercent,$discountInAmount
								,$totalAfterDiscount,$vatPercent,$vatAmount,$netAmount,$transactionType,$deliveryNoteId,$exRate,
								$netAmountWithExRate,$userId,$branchId,$discountId,$privilageId,$damagedGoodsReturn,$damagedGoodsAmount,
								$customerPhone,$customerName,$cuttingCharge,$invType,$maxOfinvoiceNumericNo,$roundOff,$roundAmount,$vatNumber,$zakatInvoiceType);

	/*-------------------------------insert To  invoice Table Ends------------------------------------*/
	/*-------------------------------insert To  invoiceDetails Table------------------------------------*/
	 
	 $tableValueArray	= json_decode($_POST['tableValueArray']);
	 for($i=0; $i<count($tableValueArray); $i++)
	 {	 
		if($tableValueArray[$i][1]!=null)
		{
		
		$itemMasterId[]				=	$tableValueArray[$i][1];
		$quantityRow[]				=	$tableValueArray[$i][2];
		$itemUnitRow[]				=	$tableValueArray[$i][3];
		$unitPriceRow[]				=	$tableValueArray[$i][4];
		$discountPercentRow[]		=	$tableValueArray[$i][5];
		$amountAfterDiscountRow[]	=	$tableValueArray[$i][6];
		$itemCodeRow[]				=	$tableValueArray[$i][7];
		$descriptionRow[]			=	$tableValueArray[$i][8];
		$packageSizeRow[]			=	$tableValueArray[$i][9];
		$vatPercentRow[]			=	$tableValueArray[$i][10];
		$vatAmountRow[]				=	$tableValueArray[$i][11];
		$amountWithWithVatRow[]		=	$tableValueArray[$i][12];  
		$amountWithOutDiscountRow[]	=	$tableValueArray[$i][13];
		$purchasePriceRow[]			=	$tableValueArray[$i][14];
		$discountIdRow[]			=	$tableValueArray[$i][15];
		$discountAmountRow[]		=	$tableValueArray[$i][16];
		$stockIdRow[]				=	$tableValueArray[$i][17];
		$netWeightRow[]				=	$tableValueArray[$i][18];
		}
	 }
	
	
	if($invoiceId>0)
	{
		for($i=0;$i<count($itemMasterId);$i++)
		{
			if($purchasePriceRow[$i]=='')
			  $purchasePriceRow[$i]=0;
			  if($netWeightRow[$i]=='')
			  $netWeightRow[$i]=0;  
			$itemUnitRowArray 		=	explode("-",$itemUnitRow[$i]);
			$itemUnitId				=	$itemUnitRowArray [0];
			$unitFraction			=	$itemUnitRowArray [1];
			$purchasePrice          =   $purchasePriceRow[$i]*$netWeightRow[$i];//$unitFraction*$quantityRow[$i];
			$totalCostValue         =   $totalCostValue+$purchasePrice;
			
			$invoiceDetailsId = $objCSalesInvoice->insertToInvoiceDetails($invoiceId,$itemMasterId[$i],$itemUnitId,$unitFraction,
								$quantityRow[$i],$unitPriceRow[$i],$discountPercentRow[$i],$amountAfterDiscountRow[$i],$itemCodeRow[$i],
								$descriptionRow[$i],$packageSizeRow[$i],$vatPercentRow[$i],$vatAmountRow[$i],$amountWithWithVatRow[$i],
								$amountWithOutDiscountRow[$i],$branchId,$privilageId,$discountIdRow[$i],$discountAmountRow[$i],
								$stockIdRow[$i],$netWeightRow[$i]);
			
			
				 $stock         =  $objCSalesInvoice->getRemainingStock($branchId,$privilageId,$stockIdRow[$i]);	 
		
			$objCSalesInvoice->insertItemTransferDetails($invoiceDate,$invoiceNo,$itemMasterId[$i],$quantityRow[$i],$itemUnitId,$unitFraction,$invoiceDetailsId,$customerName,$branchId,$stock,$privilageId,$userId,$netWeightRow[$i],$stockIdRow[$i]);
		}
		//echo 'coatValue'.$totalCostValue;
			$subAccountHeadId = $objCSalesInvoice->getSubAccountId($regularCustomerId);
			if($transactionType==1)
			{
				$salesPaymentVoucherNo				=	$objCSalesInvoice->getSalesPaymentVoucherNo();
				$customerSalesPaymentId				=	$objCSalesInvoice->insertToCustomerSalesPayment($invoiceId,$invoiceDate,$netAmount,$salesPaymentVoucherNo,$exRate,$userId);
			}
			    
		    
	       $insertNetAmountToAccountJournelDebit	=	$objCSalesInvoice->insertToAccountJournel($invoiceDate,$netAmount,$subAccountHeadId,$invoiceNo,$customerName,$invoiceId,$discountInAmount,$totalAmount,$vatAmount,$transactionType,$salesPaymentVoucherNo,$exRate,$totalCostValue,$damagedGoodsAmount,$cuttingCharge,$regularCustomerId);
	}
	
	/*-------------------------------insert To  invoiceDetails Table Ends------------------------------------*/

	
	$objPath->setHeader('salesInvoice','Success!!!','salesInvoice');
	}else{
		$objPath->setHeader('salesInvoice','Invoice Number Duplication!!!','salesInvoice');
	}
}
if(isset($_POST['submitAndPrint']))
{
	/*-------------------------------insert To  invoice Table------------------------------------*/
	$invoiceNo				=	$objCSalesInvoice->getMaxInvoiceNo();//$_POST['invoiceNo'];
	$invoiceCount 			= 	$objCSalesInvoice->checkInvoiceNoExistOrNot($invoiceNo);
	$maxOfinvoiceNumericNo	=	$objCSalesInvoice->getMaxOfinvoiceNumericNo();
	
	if($invoiceCount==0)
	{
	$regularCustomerId		=	$_POST['regularCustomerId'];
	$customerName			=	$_POST['customerName'];
	$invoiceDate			=	$_POST['invoiceDate'];
	$invoiceDate			=	date("Y-m-d", strtotime($invoiceDate));
	$poNo					=	$_POST['poNo'];
	$quotationNo			=	$_POST['quotationNo'];
	$currencyData			=	$_POST['currencyId'];
	$currencyDataArray		=	explode('/',$currencyData);
	$currencyId				=	$currencyDataArray[0];
	$vesselId				=	'';
	$totalAmount			=	$_POST['totalAmount'];
	//if($privilageId==11){
	$discountInPercent		=	$_POST['discountInPercent'];
	$discountId				=	'';//$_POST['discountId'];
	$discountInAmount		=	$_POST['discountInAmount'];
	/*}
	else{
		$discountInPercent	=	'';
	$discountId				=	'';
	$discountInAmount		=   '';
	}*/
	$vatNumber              =  $_POST['vatNumber'];
	
		if($vatNumber>0)
     $zakatInvoiceType = '0100000';
  else
   $zakatInvoiceType='0200000';
   
   
   
   
	$vatPercent				=	$_POST['vatInPercent'];
	$vatAmount				=	$_POST['vatAmount'];
	$netAmount				=	$_POST['netAmount'];
	$transactionType		=	$_POST['transactionType'];
	$deliveryNoteId			=	'';//$_POST['deliveryNoteId'];
	$exRate					=	$_POST['exRate'];
	$damagedGoodsReturn		=	$_POST['damagedGoodsReturn'];
	$damagedGoodsAmount		=	$_POST['damagedGoodsAmount'];
	$customerPhone			=	$_POST['customerPhone'];
	$customerName			=	$_POST['customerName'];
	$printType				=	$_POST['printType'];
	$cuttingCharge			=	$_POST['cuttingCharge'];
	if($cuttingCharge=='')
	{
		$cuttingCharge		=	0;
	}
	$invType				=	$_POST['invType'];
	$roundOff               =   $_POST['roundOff'];
	$roundAmount              =   $_POST['roundAmount'];
	
	/*---------------------------------Total Calculation unsing PHP Start-----------------------------*/
	$discountInAmount		=	number_format($discountInAmount, 2, '.', '');
	$totalAfterDiscount		=	$totalAmount-$discountInAmount;//$_POST['amountAfterDiscountTotal'];
	$amountAfterDamage		=	$totalAfterDiscount-$damagedGoodsAmount;	
	$amountWithCuttingCharge =	$amountAfterDamage+$cuttingCharge;
	$vatAmount				=	($amountWithCuttingCharge*$vatPercent)/100;
	$netAmount				=	$amountWithCuttingCharge+$vatAmount;
	
	$totalAmount			=	number_format($totalAmount, 2, '.', '');
	$totalAfterDiscount		=	number_format($totalAfterDiscount, 2, '.', '');
	$vatAmount				=	number_format($vatAmount, 2, '.', '');
	$netAmount				=	number_format($netAmount, 2, '.', '');
	/*---------------------------------Total Calculation unsing PHP Ends-----------------------------*/
	$privilageId       	 	=   	$_COOKIE['privillegeId'];
	$branchId        		=   	$_COOKIE['branchId'];
	$userId					=		$_COOKIE['userId'];
	
	if($exRate==''|| $exRate==null || $exRate==0 )
			{
				$exRate	=	1;
			}
	$netAmountWithExRate	=	number_format(($netAmount*$exRate), 2, '.', '');
	
	$invoiceId				=	$objCSalesInvoice->insertToInvoiceTable($invoiceNo,$regularCustomerId,$invoiceDate,
								$poNo,$quotationNo,$currencyId,$vesselId,$totalAmount,$discountInPercent,$discountInAmount
								,$totalAfterDiscount,$vatPercent,$vatAmount,$netAmount,$transactionType,$deliveryNoteId,$exRate,
								$netAmountWithExRate,$userId,$branchId,$discountId,$privilageId,$damagedGoodsReturn,
								$damagedGoodsAmount,$customerPhone,$customerName,$cuttingCharge,$invType,$maxOfinvoiceNumericNo,$roundOff,$roundAmount,$vatNumber,$zakatInvoiceType);

	/*-------------------------------insert To  invoice Table Ends------------------------------------*/
	/*-------------------------------insert To  invoiceDetails Table------------------------------------*/
	 
	 $tableValueArray	= json_decode($_POST['tableValueArray']);
	 for($i=0; $i<count($tableValueArray); $i++)
	 {	 
		if($tableValueArray[$i][1]!=null)
		{
		
		$itemMasterId[]				=	$tableValueArray[$i][1];
		$quantityRow[]				=	$tableValueArray[$i][2];
		$itemUnitRow[]				=	$tableValueArray[$i][3];
		$unitPriceRow[]				=	$tableValueArray[$i][4];
		$discountPercentRow[]		=	$tableValueArray[$i][5];
		$amountAfterDiscountRow[]	=	$tableValueArray[$i][6];
		$itemCodeRow[]				=	$tableValueArray[$i][7];
		$descriptionRow[]			=	$tableValueArray[$i][8];
		$packageSizeRow[]			=	$tableValueArray[$i][9];
		$vatPercentRow[]			=	$tableValueArray[$i][10];
		$vatAmountRow[]				=	$tableValueArray[$i][11];
		$amountWithWithVatRow[]		=	$tableValueArray[$i][12];  
		$amountWithOutDiscountRow[]	=	$tableValueArray[$i][13];
		$purchasePriceRow[]			=	$tableValueArray[$i][14];
		$discountIdRow[]			=	$tableValueArray[$i][15];
		$discountAmountRow[]		=	$tableValueArray[$i][16];
		$stockIdRow[]				=	$tableValueArray[$i][17];
		$netWeightRow[]				=	$tableValueArray[$i][18];
		}
	 }
	
	
	if($invoiceId>0)
	{
		for($i=0;$i<count($itemMasterId);$i++)
		{
			$itemUnitRowArray 		=	explode("-",$itemUnitRow[$i]);
			$itemUnitId				=	$itemUnitRowArray [0];
			$unitFraction			=	$itemUnitRowArray [1];
			$purchasePrice          =   $purchasePriceRow[$i]*$netWeightRow[$i];//$unitFraction*$quantityRow[$i];
			$totalCostValue         =   $totalCostValue+$purchasePrice;
			
			$invoiceDetailsId = $objCSalesInvoice->insertToInvoiceDetails($invoiceId,$itemMasterId[$i],$itemUnitId,$unitFraction,
								$quantityRow[$i],$unitPriceRow[$i],$discountPercentRow[$i],$amountAfterDiscountRow[$i],$itemCodeRow[$i],
								$descriptionRow[$i],$packageSizeRow[$i],$vatPercentRow[$i],$vatAmountRow[$i],$amountWithWithVatRow[$i],
								$amountWithOutDiscountRow[$i],$branchId,$privilageId,$discountIdRow[$i],$discountAmountRow[$i],
								$stockIdRow[$i],$netWeightRow[$i]);
			
			
				 $stock         =  $objCSalesInvoice->getRemainingStock($branchId,$privilageId,$stockIdRow[$i]);	 
		
			$objCSalesInvoice->insertItemTransferDetails($invoiceDate,$invoiceNo,$itemMasterId[$i],$quantityRow[$i],$itemUnitId,$unitFraction,$invoiceDetailsId,$customerName,$branchId,$stock,$privilageId,$userId,$netWeightRow[$i],$stockIdRow[$i]);
		}
		//echo 'coatValue'.$totalCostValue;
			$subAccountHeadId = $objCSalesInvoice->getSubAccountId($regularCustomerId);
			if($transactionType==1)
			{
				$salesPaymentVoucherNo				=	$objCSalesInvoice->getSalesPaymentVoucherNo();
				$customerSalesPaymentId				=	$objCSalesInvoice->insertToCustomerSalesPayment($invoiceId,$invoiceDate,$netAmount,$salesPaymentVoucherNo,$exRate,$userId);
			}
			    
		    
	       $insertNetAmountToAccountJournelDebit	=	$objCSalesInvoice->insertToAccountJournel($invoiceDate,$netAmount,$subAccountHeadId,$invoiceNo,$customerName,$invoiceId,$discountInAmount,$totalAmount,$vatAmount,$transactionType,$salesPaymentVoucherNo,$exRate,$totalCostValue,$damagedGoodsAmount,$cuttingCharge,$regularCustomerId);
	}
	
	/*-------------------------------insert To  invoiceDetails Table Ends------------------------------------*/

	
	if($printType==2)
	{
				header("location:welcome.php?page=salesInvoiceThermalPrint&invoiceId=$invoiceId&referanceNo=1");

	}else if($printType==1){		
		header("location:welcome.php?page=salesInvoicePrint&invoiceId=$invoiceId&referanceNo=1");
	}else if($printType==3){
		header("location:welcome.php?page=dotmertocprint&invoiceId=$invoiceId&referanceNo=1");
	}else{
		header("location:welcome.php?page=salesInvoicePrint&invoiceId=$invoiceId&referanceNo=1");
	}
	
	/*header("Location: http://".$_SERVER['HTTP_HOST'].'/zatca/ZATCA/zakatInvoiceOrginal.php?invoiceId='.$invoiceId.'&referenceval=1');*/
	
	}else{
		$objPath->setHeader('salesInvoice','Invoice Number Duplication!!!','salesInvoice');
	}
}



if(isset($_POST['submitAndPrintconectZakat']))
{
	/*-------------------------------insert To  invoice Table------------------------------------*/
	$invoiceNo				=	$objCSalesInvoice->getMaxInvoiceNo();//$_POST['invoiceNo'];
	$invoiceCount 			= 	$objCSalesInvoice->checkInvoiceNoExistOrNot($invoiceNo);
	$maxOfinvoiceNumericNo	=	$objCSalesInvoice->getMaxOfinvoiceNumericNo();

	
	if($invoiceCount==0)
	{
	$regularCustomerId		=	$_POST['regularCustomerId'];
	$customerName			=	$_POST['customerName'];
	$invoiceDate			=	$_POST['invoiceDate'];
	$invoiceDate			=	date("Y-m-d", strtotime($invoiceDate));
	$poNo					=	$_POST['poNo'];
	$quotationNo			=	$_POST['quotationNo'];
	$currencyData			=	$_POST['currencyId'];
	$currencyDataArray		=	explode('/',$currencyData);
	$currencyId				=	$currencyDataArray[0];
	$vesselId				=	'';
	$totalAmount			=	$_POST['totalAmount'];
	//if($privilageId==11){
	$discountInPercent		=	$_POST['discountInPercent'];
	$discountId				=	'';//$_POST['discountId'];
	$discountInAmount		=	$_POST['discountInAmount'];
	/*}
	else{
		$discountInPercent	=	'';
	$discountId				=	'';
	$discountInAmount		=   '';
	}*/
	$vatNumber              =  $_POST['vatNumber'];
	if($vatNumber!='')
     $zakatInvoiceType = '0100000';
  else
   $zakatInvoiceType='0200000';
	
	$vatPercent				=	$_POST['vatInPercent'];
	$vatAmount				=	$_POST['vatAmount'];
	$netAmount				=	$_POST['netAmount'];
	$transactionType		=	$_POST['transactionType'];
	$perfomaInvoiceId		=	$_POST['perfomaInvoiceId']; // Coded by NarayananG 25-05-2023
	$exRate					=	$_POST['exRate'];
	$damagedGoodsReturn		=	$_POST['damagedGoodsReturn'];
	$damagedGoodsAmount		=	$_POST['damagedGoodsAmount'];
	$customerPhone			=	$_POST['customerPhone'];
	$customerName			=	$_POST['customerName'];
	$cuttingCharge			=	$_POST['cuttingCharge'];
	if($cuttingCharge=='')
	{
		$cuttingCharge		=	0;
	}
	$invType				=	$_POST['invType'];
	$roundOff               =   $_POST['roundOff'];
	$roundAmount              =   $_POST['roundAmount'];
	
	/*---------------------------------Total Calculation unsing PHP Start-----------------------------*/
	$discountInAmount		=	number_format($discountInAmount, 2, '.', '');
	$totalAfterDiscount		=	$totalAmount-$discountInAmount;//$_POST['amountAfterDiscountTotal'];
	$amountAfterDamage		=	$totalAfterDiscount-$damagedGoodsAmount;	
	$amountWithCuttingCharge =	$amountAfterDamage+$cuttingCharge;
	$vatAmount				=	($amountWithCuttingCharge*$vatPercent)/100;
	$netAmount				=	$amountWithCuttingCharge+$vatAmount;
	
	$totalAmount			=	number_format($totalAmount, 2, '.', '');
	$totalAfterDiscount		=	number_format($totalAfterDiscount, 2, '.', '');
	$vatAmount				=	number_format($vatAmount, 2, '.', '');
	$netAmount				=	number_format($netAmount, 2, '.', '');
	/*---------------------------------Total Calculation unsing PHP Ends-----------------------------*/
	$privilageId       	 	=   	$_COOKIE['privillegeId'];
	$branchId        		=   	$_COOKIE['branchId'];
	$userId					=		$_COOKIE['userId'];
	
	if($exRate==''|| $exRate==null || $exRate==0 )
			{
				$exRate	=	1;
			}
	$netAmountWithExRate	=	number_format(($netAmount*$exRate), 2, '.', '');
	
	$invoiceId				=	$objCSalesInvoice->insertToInvoiceTable($invoiceNo,$regularCustomerId,$invoiceDate,
								$poNo,$quotationNo,$currencyId,$vesselId,$totalAmount,$discountInPercent,$discountInAmount
								,$totalAfterDiscount,$vatPercent,$vatAmount,$netAmount,$transactionType,$perfomaInvoiceId,$exRate,
								$netAmountWithExRate,$userId,$branchId,$discountId,$privilageId,$damagedGoodsReturn,$damagedGoodsAmount,
								$customerPhone,$customerName,$cuttingCharge,$invType,$maxOfinvoiceNumericNo,$roundOff,$roundAmount,$vatNumber,$zakatInvoiceType);

	/*-------------------------------insert To  invoice Table Ends------------------------------------*/
	/*-------------------------------insert To  invoiceDetails Table------------------------------------*/
	 
	 $tableValueArray	= json_decode($_POST['tableValueArray']);
	 for($i=0; $i<count($tableValueArray); $i++)
	 {	 
		if($tableValueArray[$i][1]!=null)
		{
		
		$itemMasterId[]				=	$tableValueArray[$i][1];
		$quantityRow[]				=	$tableValueArray[$i][2];
		$itemUnitRow[]				=	$tableValueArray[$i][3];
		$unitPriceRow[]				=	$tableValueArray[$i][4];
		$discountPercentRow[]		=	$tableValueArray[$i][5];
		$amountAfterDiscountRow[]	=	$tableValueArray[$i][6];
		$itemCodeRow[]				=	$tableValueArray[$i][7];
		$descriptionRow[]			=	$tableValueArray[$i][8];
		$packageSizeRow[]			=	$tableValueArray[$i][9];
		$vatPercentRow[]			=	$tableValueArray[$i][10];
		$vatAmountRow[]				=	$tableValueArray[$i][11];
		$amountWithWithVatRow[]		=	$tableValueArray[$i][12];  
		$amountWithOutDiscountRow[]	=	$tableValueArray[$i][13];
		$purchasePriceRow[]			=	$tableValueArray[$i][14];
		$discountIdRow[]			=	$tableValueArray[$i][15];
		$discountAmountRow[]		=	$tableValueArray[$i][16];
		$stockIdRow[]				=	$tableValueArray[$i][17];
		$netWeightRow[]				=	$tableValueArray[$i][18];
		}
	 }
	
	
	if($invoiceId>0)
	{
		for($i=0;$i<count($itemMasterId);$i++)
		{
			$itemUnitRowArray 		=	explode("-",$itemUnitRow[$i]);
			$itemUnitId				=	$itemUnitRowArray [0];
			$unitFraction			=	$itemUnitRowArray [1];
			$purchasePrice          =   $purchasePriceRow[$i]*$netWeightRow[$i];//$unitFraction*$quantityRow[$i];
			$totalCostValue         =   $totalCostValue+$purchasePrice;
			
			$invoiceDetailsId = $objCSalesInvoice->insertToInvoiceDetails($invoiceId,$itemMasterId[$i],$itemUnitId,$unitFraction,
								$quantityRow[$i],$unitPriceRow[$i],$discountPercentRow[$i],$amountAfterDiscountRow[$i],$itemCodeRow[$i],
								$descriptionRow[$i],$packageSizeRow[$i],$vatPercentRow[$i],$vatAmountRow[$i],$amountWithWithVatRow[$i],
								$amountWithOutDiscountRow[$i],$branchId,$privilageId,$discountIdRow[$i],$discountAmountRow[$i],
								$stockIdRow[$i],$netWeightRow[$i]);
			
			
				 $stock         =  $objCSalesInvoice->getRemainingStock($branchId,$privilageId,$stockIdRow[$i]);	 
		
			$objCSalesInvoice->insertItemTransferDetails($invoiceDate,$invoiceNo,$itemMasterId[$i],$quantityRow[$i],$itemUnitId,$unitFraction,$invoiceDetailsId,$customerName,$branchId,$stock,$privilageId,$userId,$netWeightRow[$i],$stockIdRow[$i]);
		}
		//echo 'coatValue'.$totalCostValue;
			$subAccountHeadId = $objCSalesInvoice->getSubAccountId($regularCustomerId);
			if($transactionType==1)
			{
				$salesPaymentVoucherNo				=	$objCSalesInvoice->getSalesPaymentVoucherNo();
				$customerSalesPaymentId				=	$objCSalesInvoice->insertToCustomerSalesPayment($invoiceId,$invoiceDate,$netAmount,$salesPaymentVoucherNo,$exRate,$userId);
			}
			    
		    
	       $insertNetAmountToAccountJournelDebit	=	$objCSalesInvoice->insertToAccountJournel($invoiceDate,$netAmount,$subAccountHeadId,$invoiceNo,$customerName,$invoiceId,$discountInAmount,$totalAmount,$vatAmount,$transactionType,$salesPaymentVoucherNo,$exRate,$totalCostValue,$damagedGoodsAmount,$cuttingCharge,$regularCustomerId);
	}
	
	/*-------------------------------insert To  invoiceDetails Table Ends------------------------------------*/
/*----------------------save invoice hash-------------------------------------*/

header("Location: http://".$_SERVER['HTTP_HOST'].'/zatca/ZATCA/zakatInvoiceOrginal.php?invoiceId='.$invoiceId.'&referenceval=2');
	
//	$objPath->setHeader('salesInvoice','Success!!!','salesInvoice');
	}else{
		$objPath->setHeader('salesInvoice','Invoice Number Duplication!!!','salesInvoice');
	}
}





if(isset($_POST['editInvoice'])){

$id=$_POST['salesInvoiceIdForEdit'];
header("location:welcome.php?page=invoiceEdit&salesInvoiceIdForEdit=$id");
}

if(isset($_POST['updateNeumericNo']))
{
	$allInvoiceDate	=	$objMSalesInvoice->getAllIncoiceForUpdation();
	while($row=mysqli_fetch_array($allInvoiceDate))
	{
		$invoiceId	=	$row['invoiceId'];
		$invoiceNo	=	$row['invoiceNo'];
		$invoiceNoArray	=	explode("/",$invoiceNo);
		if(count($invoiceNoArray)==3)
			{
						$invoiceNoUpdate	=	$invoiceNoArray[2];
						$objMSalesInvoice->updateNeumericNo($invoiceId,$invoiceNoUpdate);
			}
	}
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

</style>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover({ trigger: "hover" });   
});

</script>
</head>
<!--<form method="POST">
	<button type="submit" name="updateNeumericNo" id="updateNeumericNo">Update</button>
</form>-->


<form action="" method="POST" enctype="multipart/form-data" id="invoiceForm"  onsubmit="return confirm('Do you want to continue?')"> 

<div class="row">        
 <div class="col-sm-12 col-md-12 col-lg-12">
	<div class="panel panel-info">
		<div class="panel-heading" >
						
				
						<!--<table width="30%" border="0" style="float: right !important;">
						<tbody style="overflow:auto !important;">
						<tr>
							<td width="40%" style="border:0px !important;padding: 1px 3px !important" >Delivery  Note No:</td>
							<td width="40%" style="border:0px !important;padding: 1px 3px !important" valign="top" >
							<form action="" method="POST" enctype="multipart/form-data" > 
								<input type="text" class="form-control input-sm" id="delNoteNo" value="<?php if(isset($deliveryNoteDetails)) {echo $delNoteNo ;} ?>" name="delNoteNo" required >
								<input type="hidden" name="deliveryNoteId" id="deliveryNoteIdSearch" value="<?php if(isset($deliveryNoteDetails)){echo $deliveryNoteId;}else{echo null;} ?>" />
							</td>
							<td width="20%" style="border:0px !important;padding: 1px 3px !important" valign="top" >
							<button type='submit' name='search' class='btn submitBtn ' style="background-color: #48ef29d1 !important;padding: 4px 12px !important;" ><i style='color:#fff' class="fa fa-search"></i>&nbsp;</button>
							
							</form>	
							</td>
						</tr>
						</tbody>
						</table>-->	
						<table width="100%" border="0">
							<tr>
								<td width="30%"><i class="fa fa-list-ul"></i><strong>&nbsp;SALES INVOICE</strong></td>
								<td width="40%">
									<input type="radio" id="wholesale" name="invType" value="1" <?php echo $wholeSaleSelect; ?> <?php echo $incoiceTypeShow; ?>  />
									<label for="male" <?php echo $incoiceTypeShow; ?> >wholesale</label>
									<input type="radio" id="retail" name="invType" value="2"   <?php echo $incoiceTypeShow; ?> />
									<label for="male" <?php echo $incoiceTypeShow; ?> >Retail</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
								<td width="30%">
									<?php
									if($privilageId==2 || $privilageId==6)
									{
									?>
									<input type="radio" id="normalPrint" name="printType" value="1" <?php echo $normalPrintSelect; ?> />
									<label for="male">Print</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" id="thermalPrint" name="printType" value="2" <?php echo $thernalPrintSelect; ?> />
									<label for="male">Thermal Print</label>
									<input type="radio" id="dotMatrixPrint" name="printType" value="3"  />
									<label for="male">Dot Matrix Print</label>
									<?php
									}
									?>
								</td>
								<!--<td width="25%" align="right">Invoice No&nbsp;&nbsp;&nbsp;</td>
								<td width="30%">
								<form action="" method="POST" enctype="multipart/form-data" > 
									<input type="text" class="form-control input-sm" id="salesInvoiceNoForEdit" name="salesInvoiceNoForEdit" required >
									<input type="hidden" id="salesInvoiceIdForEdit" name="salesInvoiceIdForEdit">
								</td>
								<td width="15%" >
								&nbsp;&nbsp;&nbsp;
								<button type='submit' name='editInvoice' class='btn submitBtn ' style="background-color: #97a795d1 !important;padding: 3px 4px !important;" ><i style='color:#fff' class="fa fa-edit"></i>&nbsp;</button>
								
								</form>	
								</td>-->
							</tr>
						</table>
								
		</div>
				<div class="panel-body" style="">
			<div class="col-sm-12 col-md-12 col-lg-12">
				
			</div>	
			
			<div class="col-sm-12 col-md-12 col-lg-12">
					<input type='hidden' id='tableValueArray' name='tableValueArray'> 
					<div class="row" >
							
							<div class="form-group col-sm-2 col-md-2 col-lg-2">
								<label for="poNumber">PREV. INVOICE NUMBER</label>
								<span style="color:#F00" class="mandatory">*</span>
								<input type="text" class="form-control input-sm" id="invoiceNo" value="<?php echo $prevInvNo; ?>" name="invoiceNo" onkeyup="checkInvNumber(this.id);" readonly >
								<!--<input type="hidden" name="deliveryNoteId" value="<?php if(isset($deliveryNoteDetails)){echo $deliveryNoteId;}else{echo null;} ?>" />-->
							</div>
								<div class="form-group col-sm-2 col-md-2 col-lg-2">
									<label >DATE</label>
									<span style="color:#F00" class="mandatory">*</span>
									<input name="invoiceDate" type="text" required class="input-sm form-control  datepicker" id="invoiceDate" 
									   value="<?php echo $objUtils->getCurrentDate();?>" onclick="displayCalender(this.id)"  autocomplete="off">
							
								</div>
							<!--<div class="form-group col-sm-2 col-md-2 col-lg-2">
								<label for="poNumber">PO.No</label>
								<input type="text" class="form-control input-sm" id="poNo" name="poNo" value=""   />
							</div>
							<div class="form-group col-sm-2 col-md-2 col-lg-2">
								<label for="poNumber">Quotation No</label>
								<input type="text" class="form-control input-sm" id="quotationNo" name="quotationNo" value="<?php //if(isset($deliveryNoteDetails)) { echo $quotation;} ?>">
							</div>-->
							<div class="form-group col-sm-2 col-md-2 col-lg-2" style=" <?php echo $showCustomerCode; ?>" >
									<label for="poNumber">CUSTOMER CODE</label>
									<span style="color:#F00" class="mandatory">*</span>
									<input type="text" class="form-control input-sm" onkeypress="checkEnterKey(event,'',this.id);"  id="customerCode" name="customerCode" value=""   <?php echo $required; ?> >
									<input type="hidden" name="regularCustomerId" id="regularCustomerId" value="" />
								</div>
								<div class="form-group col-sm-4 col-md-4 col-lg-4">
									<label for="poNumber">CUSTOMER NAME</label>
									<span style="color:#F00" class="mandatory">*</span>
									<input type="text" class="form-control input-sm" onkeypress="checkEnterKey(event,'',this.id);" id="customerName" name="customerName" value="<?php //if(isset($deliveryNoteDetails)) { echo $customerName;} ?>" <?php echo $required; ?>   <?php echo $readOnly; ?>>
								</div>
								
								<div class="form-group col-sm-2 col-md-2 col-lg-2" style=" <?php echo $showPhone; ?>">
									<label for="poNumber">PHONE NO</label>
									<span style="color:#F00" class="mandatory">*</span>
									<input type="text" class="form-control input-sm" id="customerPhone" onkeypress="checkEnterKey(event,'',this.id);" name="customerPhone" value="<?php //if(isset($deliveryNoteDetails)) { echo $customerName;} ?>"   >
								</div>
								<div class="form-group col-sm-2 col-md-2 col-lg-2">
									<label>VAT NUMBER</label>
									<span style="color:#F00" class="mandatory">*</span>
									<input type="text" class="form-control input-sm" readonly id="vatNumber" onkeypress="checkEnterKey(event,'',this.id);" name="vatNumber" value="<?php //if(isset($deliveryNoteDetails)) { echo $customerName;} ?>"   >
							
								</div>
								<div class="form-group col-sm-1 col-md-1 col-lg-1">
								&nbsp;
								</div>
								
								
					</div>
					<div class="row">
								
							<div class="form-group col-sm-4 col-md-4 col-lg-4">
								<label for="item" >BARCODE/ITEM</label>
								<input type="text" class="form-control input-sm" onkeypress="checkEnterKey(event,'',this.id);"  id="materialSearch" name="materialSearch"  >
							</div>
							<div class="form-group col-sm-1 col-md-1 col-lg-1">
							</br>
							<button id="searchItemName" type="button" data-toggle="modal" data-target="#myModal" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></button>
							</div>
							<div class="form-group col-sm-1 col-md-1 col-lg-1">
							
							</div>
							<div class="form-group col-sm-2 col-md-2 col-lg-2">
									<label>MODE OF PAY</label>
									<span style="color:#F00" class="mandatory">*</span>
									<select name="transactionType" id="transactionType" style="width: 100%;" class="input-sm form-group" onchange="setAmountPaidByTypeOfTransaction()"  required >  
										<option value="">Select</option>
										<?php echo $paymentModeOptions; ?>
										
									</select>
							
								</div>
								<!--<div class="form-group col-sm-2 col-md-2 col-lg-2">
									<label for="poNumber">Tax ID</label>
									<input type="text" class="form-control input-sm" id="taxId" name="taxId" value="<?php //if(isset($deliveryNoteDetails)) { echo $vatNumber;} ?>" readonly  />
								</div>-->
								<div class="form-group col-sm-2 col-md-2 col-lg-2" >
									<label for="vendorName">CURRENCY</label> <span style="color:#F00" class="mandatory">*</span> <br/>
									<select name="currencyId" class="input-sm form-group" id="currencyId" required="required" onchange="getExchangeRate(this.value);"  style="width: 100%;">
										<option value="">Select</option>
										<?php 
										/*if(isset($deliveryNoteDetails))
										{
										echo $currencyOptionValue;
										}else{*/
										echo $currencyData;
										//}
										?>
									</select>
									
								</div>
								<div class="form-group col-sm-2 col-md-2 col-lg-2">
									<label for="poNumber">EX. RATE</label>
									<span style="color:#F00" class="mandatory">*</span>
									<input type="text" name="exRate" id="exRate" class="form-control input-sm" value="1<?php //if(isset($deliveryNoteDetails)){echo $exRate;}else{echo 1;}?>" onkeyup="checkNumber(this.id);checlExrate(this.value)" required />
								</div>
								<!--<?php $privilageId            =   $_SESSION['privillegeId'];
								if($privilageId==11){ ?>
								<div class="form-group col-sm-2 col-md-2 col-lg-2">
									<label for="poNumber">Discount</label>
									<input type="text" class="form-control input-sm"  id="addDiscPervent" name="addDiscPervent" onKeyUp="getDiscountData(this.value);"  />
								</div>
								<?php } ?>
								<div class="form-group col-sm-2 col-md-2 col-lg-2">
									<label for="poNumber">Vessel</label>
									<select name="vesselId" class="input-sm form-group" id="vesselId" required="required" style="width: 100%;">
										<option value="">Select</option>
										<?php 
										if(isset($deliveryNoteDetails))
										{
											echo $vesselOptionValue;
										}else{
											echo $vesselData	; 
										}
										?>
									</select>		
									
								</div>-->
								
					</div>
									
							
					
			</div>		
				
			
			<!--<div class="col-sm-12 col-md-12 col-lg-12">	
				<div class="row" >
					<div class="form-group col-sm-4 col-md-4 col-lg-4">
						<label for="item" >Barcode/Item</label>
						<input type="text" class="form-control input-sm"  id="materialSearch" name="materialSearch"  >
					</div>
					<div class="form-group col-sm-1 col-md-1 col-lg-1">
					</br>
					<button id="searchItemName" type="button" data-toggle="modal" data-target="#myModal" class="btn btn-success"><i class="fa fa-eye" aria-hidden="true"></i></button>
					</div>
					<div class="form-group col-sm-1 col-md-1 col-lg-1">
						<label for="item" >Disc</label>
						<input type="text" class="form-control input-sm"  id="addDiscPervent" name="addDiscPervent" onKeyUp="getDiscountData(this.value);"  />
					</div>
					<div class="form-group col-sm-2 col-md-2 col-lg-2">
						<label for="item" >Vat%</label>
						<input type="text" class="form-control input-sm"  id="addVatPervent" name="vatPercent"  onKeyUp="checkNumber(this.id);changeAllVat()" />
					</div>
					
				
				</div>
			</div>-->
		<div class='col-sm-12 col-md-12 col-lg-12'>
			<div class="table-responsive">
			  
			
		<table class="table table-bordered example "id="salesItems" style="font-size: 11px !important;">
			<thead style="background-color:#d0e8d2">
			<tr>
				<th width="5%">#</th>
				<th width="20%">Barcode/Item Description</th>
				<!--<th style="width:12% !important" >Description</th>
				<th style="width:8% !important" >Packing Size</th>-->
			
				<th width="10%">Unit</th>
					<th width="10%">Qty</th>
				<th width="10%">Weight</th>
				<th width="10%">Price</th>
				<th width="10%">Amount</th>
					<th width="10%">vat %</th>

				<th width="10%">Amnt.With Vat</th>
				<!--<th style="width:9% !important" >Dis %</th>-->
				<!--<th style="width:9% !important" >Am.Aft.Dis</th>
				<th width="7%">vat %</th>	
				
				<th width="13%">Amnt. With Vat </th>
				<th width="10%">Pr. Pri </th>-->
				<th width="3%">&nbsp;</th>
			</tr>
			</thead>
			<tbody id="materialDetailsTbody" >
			
				<?php
				/*if(isset($deliveryNoteDetails))
				{
				echo $tbody ;
				}*/
				?> 
			</tbody>
			<tfoot>
			<tr>
					<td colspan="3" align="right">Total</td>
					<td>
						<input type="text" name="quantityTotal" id="quantityTotal" class="form-control input-sm" style="text-align: right;" autocomplete="off" readonly="">
					</td>
				
					<td>
						<input type="text" name="netWeightTotal" id="netWeightTotal" class="form-control input-sm" style="text-align: right;" autocomplete="off" readonly="">										
					</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
						<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th colspan='8' style="text-align: right;" ><span class='footerOfTable'>TOTAL</span></th>
					<td colspan='2' >
						<input type="text" name="totalAmount" id="totalAmount" class="input-sm" value="<?php //if(isset($deliveryNoteDetails)){ echo number_format($totalWithOutvat,2,'.','') ;}else {echo '0.00';} ?>" readonly  style="text-align: right;width: 100%" />
					</td>
					
				</tr>
				<tr>
					<th colspan='8' style="text-align: right;"><span class='footerOfTable'>DISCOUNT</span></th>
					<td colspan='2'  >
					<!--<input type="hidden" name="discountId" id="discountId" class="discountId" />-->
					<input type="text" style="width: 30%;float:left;direction: rtl;" name="discountInPercent" id="discountInPercent" class="input-sm" onkeyup="getDiscountAmount();checkNumber(this.id);clearRound()" onchange="getDiscountAmount();checkNumber(this.id);clearRound()"  value=""   />
					<input type="text"  style="width:10%;padding: 0%;border: 0px !important;" class="input-sm" value="%" />
					<input type="text" style="text-align: right;width: 60%;float: right;" name="discountInAmount" id="discountInAmount" class="input-sm" onkeyup="getDiscountPercent();clearRound()" onchange="getDiscountPercent();clearRound()" value=""  />
					<input type="hidden" id="discountInAmountHidden" value="discountInAmountHidden" />
					</td>
					

				</tr>
				<tr>
				<th colspan='8' style="text-align: right;"><span class='footerOfTable'>AMOUNT AFTER DISCOUNT</span></th>
				<td colspan='2'><input type="text" name="amountAfterDiscountTotal" id="amountAfterDiscountTotal" class="input-sm" value="<?php //if(isset($deliveryNoteDetails)){ echo number_format($totalWithOutvat,2,'.','') ;}else {echo '0.00';} ?>" readonly  style="text-align: right;width: 100%"  style="text-align: right;" /></td>
				
				
				</tr>
				<tr>
				<th   colspan="5" rowspan="<?php echo $rowspan; ?>" >
					<span class='footerOfTable'>DAMAGED GOODS RETURN</span>
					<textarea name="damagedGoodsReturn" id="damagedGoodsReturn" style="width: 100%;" rows="6">
					</textarea>
				</th>
				
				
				
				<th  style="text-align: right;" colspan="3"><span class='footerOfTable'>DAMAGED GOODS AMOUNT</span></th>
				<td colspan="2"><input type="text" name="damagedGoodsAmount" id="damagedGoodsAmount" class="input-sm" onkeyup="checkNumber(this.id);getDiscountAmount();clearRound();calculateSum();" onchange="checkNumber(this.id);"    style="text-align: right;width: 100%"  style="text-align: right;" /></td>
				
				
				</tr>
				<tr <?php echo $cuttingChargeShow;?>>
				<th  style="text-align: right;" colspan="3"><span class='footerOfTable'>CUTTING CHARGE</span></th>
				<td colspan="2"><input type="text" name="cuttingCharge" id="cuttingCharge" class="input-sm" onkeyup="checkNumber(this.id);clearRound();calculateSum();" onchange="checkNumber(this.id);"    style="text-align: right;width: 100%"  style="text-align: right;" /></td>
				
				
				</tr>
				<tr>
					<th  style="text-align: right;"  colspan="3"><span class='footerOfTable'>VAT AMOUNT</span></th>
					<td colspan='2' >
						<input type="text" style="width: 25%;float:left;direction: rtl;" name="vatInPercent" id="vatInPercent" class="input-sm" onkeyup="getDiscountAmount();clearRound();calculateSum();checkNumber(this.id);" onchange="getDiscountAmount();clearRound();calculateSum();checkNumber(this.id);" value="15"   />
						<input type="text"  style="width:10%;padding: 0%;border: 0px !important;" class="input-sm" value="%" />
						<input type="text" name="vatAmount" id="vatAmount"  value=""  class="input-sm" readonly  style="text-align: right;width: 65%;float:right" />
					</td>
					
					
				</tr>
				<!--<tr>
					<td colspan='6' style="width:87%" ><span class='footerOfTable'>Total With VAT</span></td>
					<td colspan='3' style="width:13%" ><input type="text"  name="totalWithVatAmount" id="totalWithVatAmount"  value="<?php if(isset($deliveryNoteDetails)){ echo number_format($totalWithOutvat,2,'.','') ;}else {echo '0.00';} ?>"  />
					</td>
					
				</tr>
				
				
				
				<!--<tr>
					<td colspan='6' style="width:87%" ><span class='footerOfTable'>Vat%</span></td>
					<td colspan='3' style="width:13%" ><input type="text" name="vatPercent" id="vatPercent" value="5" onkeyup="calculateSum();" /></td>
					
				</tr>-->
				
				<tr>
					<th  style="text-align: right;"  colspan="3"><span class='footerOfTable'>NET AMOUNT</span></th>
					<td colspan='2'><input type="text" name="netAmount" id="netAmount" class="input-sm"  value="" readonly  style="text-align: right;width: 100%" /></td>
					
					
				</tr>
				<tr>
					<th colspan='8' style="text-align: right;"><span class='footerOfTable'>ROUND</span></th>
					<td colspan='2'  >
					<!--<input type="hidden" name="discountId" id="discountId" class="discountId" />-->
					<input type="text" style="width: 30%;float:left;direction: rtl;" name="roundOff" id="roundOff" class="input-sm" onkeyup="checkNumber(this.id);calculateRound();" onchange="checkNumber(this.id);calculateRound();"  value=""   />
					
					<input type="text" style="text-align: right;width: 60%;float: right;" name="roundAmount" id="roundAmount" class="input-sm" readonly value=""  />
					</td>
					

				</tr>
				
			</tfoot>
		</table>
		</div>
	</div>	
			
			
            <div class="form-row" >
				<div class="form-group col-md-5"> 
				<button type='submit' name='submit' onclick='addArray();' class='btn btn-info btn-sm' style="float:right;"><i style='color:#fff' class="fa fa-save"></i>&nbsp;<span style='color:#fff'>Save</span></button>
				</div>
				<div class="form-group col-md-2"> 
				<button type='submit' name='submitAndPrint' onclick='addArray();' class='btn btn-danger btn-sm' ><i style='color:#fff' class="fa fa-print"></i>&nbsp;<span style='color:#fff'>Save And Print</span></button>
				</div>
					<!--<div class="form-group col-md-2"> 
				<button type='submit' name='submitAndPrintconectZakat' onclick='addArray();' class='btn btn-danger btn-sm' id="printItems"><i style='color:#fff' class="fa fa-print"></i>&nbsp;<span style='color:#fff'>Connect With Zakat</span></button>
				</div>-->
			</div>
					
				
               
            </div>
	</div>


 </div>
 </div>
  </form>
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



<!------------------------------- PopUp To Item Details Start---------------------->
<div id="myTable" class="modal fade" role="dialog" style="padding-right:275px;">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content" style="width:915px">
      <div class="modal-header" id="tableHead">
	  
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" >
		<table class="table table-bordered">
			
				
				<tr>
				<th>Invoice No</th>
					<th>Date</th>
					
					<th>Quantity</th>
					<th>Unit</th>
					<th>Price</th>
					<th>Amount</th>
					<th>Amount With Vat</th>
				</tr>
			
			<tbody id="itemDetails">
	        
			</tbody>
		</table>	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
	</form>
  </div>
</div>
<!------------------------------- PopUp To Item Details Ends---------------------->

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">

 window.onload = function () {
      var privilageId = <?php echo $privilageid = $_COOKIE['privillegeId']; ?>;
      if(privilageId==2 || privilageId==6)
            document.getElementById("customerName").focus();
            else
             document.getElementById("customerCode").focus();
        };
</script>
<script type="text/javascript">
var count = $('#materialDetailsTbody tr').length;
 var i=count+1;

$(function(){
	
$("#materialSearch").autocomplete({
   source: function(request, response) {
     $.getJSON("../../../../modules/salesInvoice/admin/ajax/searchMaterials.php", {
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
		getPurchasePrice(ui.item.key,ui.item.itemName,ui.item.itemCode,ui.item.vat,ui.item.sellingPrice,regularCustomerId,ui.item.stockId,ui.item.importLocalStatus,ui.item.stockValue,ui.item.minimumRate);
		$('#materialSearch').val(null);
		 return false;
      } 
   });
});

$(function(){
$("#delNoteNo").autocomplete({
   source: function(request, response) {
     $.getJSON("../../../../modules/salesInvoice/admin/ajax/searchdelNoteNo.php", {
		 term  : $('#delNoteNo').val()}, 
              response);
  },
      minLength: 0,
    
      select: function( event, ui ) {
		 $('#deliveryNoteIdSearch').val( ui.item.key);
		 $('#delNoteNo').val(ui.item.value);
		 return false;
      }  ,
	  change: function (event, ui) {
             if (ui.item == null) 
			 {
           $('#deliveryNoteIdSearch').val('');
		   $('#delNoteNo').val('');
		    $('#poNo').val(''); 
			$('#quotationNo').val('');
			$('#transactionType').val(''); 
			$('#customerCode').val('');
			$('#regularCustomerId').val(''); 
			$('#customerName').val(''); 
			$('#taxId').val(''); 
			$('#taxId').val('');
			$('#currencyId').val('');
			$('#vesselId').val(''); 
			$('#materialDetailsTbody').empty();
			$('#totalAmount').val(0);
			$('#discountInPercent').val(0);
			$('#discountInAmount').val(0);
			//$('#totalAfterDiscount').val(0);
			$('#totalWithVatAmount').val(0);
			$('#vatPercent').val(0);
			$('#vatAmount').val(0);
			$('#netAmount').val(0);
			 }
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
		   $("#vatNumber").val( ui.item.vatNumber );
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
 
// customerName
/* starts  */
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
/*end */
 
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
                type: "POST",
                url: "../../../../modules/salesInvoice/admin/ajax/getMaterialUnitSalesInvoice.php",
				data: {itemMasterId:itemMasterId,invType:$('input[name="invType"]:checked').val()},
                success: function(data)
                {
                    	var vatValue = sellingPrice*15/100;
				if(vatValue=='' || isNaN(vatValue)){
					vatValue=0;
				}
				
	 <?php if($branchId==5){ ?>
	   var selectBoxForUnit	=	'<select  class="input-sm form-group itemUnitRow" name="itemUnitRow[]" id="itemUnitRow'+i+'" onchange="checkUnitreverse('+i+');" onkeypress="checkEnterKey(event,'+i+',this.id);" required >'+JSON.parse(data)+'</select>'	;
				    materialTableRow	+=	'<tr><td style="text-align:center"><span class="indexNo">'+i+'</span><button  type="button" class="btn btn-xs" data-toggle="popover" data-trigger="hover" title="Stock" data-content="'+stockValue+'"><i class="fa fa-plus"></i></button></td>'; 
					  //<button type="button" data-toggle="modal" data-target="#myTable" onclick="getDetails(this)" class="btn  btnSubmit btn-xs"  ><i class="fa fa-plus"></i></button>
					  materialTableRow	+=	'<td><input type="hidden" value="'+i+'" id="sNo'+i+'" class="sNo"><input type="hidden" value="'+stockId+'" id="stockIdRow'+i+'" class="stockIdRow"><input type="hidden" id="itemCodeRow'+i+'" style="width:100% !important" class="form-control input-sm itemCodeRow" value="'+itemCode+'" readonly /><input type="hidden"  id="itemMasterId'+i+'" class="form-control input-sm itemMasterId" value="'+itemMasterId+'" /><input type="hidden"  id="stockValue'+i+'" class="form-control input-sm stockValue" value="'+stockValue+'" />'+itemCode+'/'+itemName+'</td>';
					 // materialTableRow	+=	'<td style="width:12% !important"><input style="width:100% !important" type="hidden"  id="descriptionRow'+i+'" value="'+itemName+'" class=" input-sm descriptionRow"  readonly/>'+itemName+'</td>';
					 // materialTableRow	+=	'<td style="width:8% !important"><input type="hidden" id="packageSizeRow'+i+'" value="'+packing+'" class="packageSizeRow" />'+packing+'</td>';
				    	 materialTableRow	+=	'<td>'+selectBoxForUnit+'</td>';
					  materialTableRow	+=	'<td><input style="width:100% !important;direction: rtl;float: left;" type="text"  id="quantityRow'+i+'" onkeyup="checkNumber(this.id); calculateRowTotalReverse('+i+');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'+i+',this.id);" onchange="checkNumber(this.id); calculateRowTotalReverse('+i+');clearDiscount();clearRound();" value=""  class=" input-sm quantityRow" /></td>';
					  
					  materialTableRow	+=	'<td><input name="netWeightRow" value="" id="netWeightRow'+i+'" style="width: 100%;direction: rtl;" type="text" onkeyup="checkNumber(this.id);calculateRowTotalReverse('+i+');clearDiscount();clearRound();" onchange="checkNumber(this.id); calculateRowTotalReverse('+i+');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'+i+',this.id);" class=" input-sm netWeightRow"  readonly=""></td>';
					  materialTableRow	+=	'<td><input style="width:100% !important;direction: rtl;" readonly value="" id="unitPriceRow'+i+'" onkeyup="checkNumber(this.id);calculateRowTotalReverse('+i+');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'+i+',this.id);"  onchange="checkNumber(this.id);checkminimumRate('+i+'); calculateRowTotalReverse('+i+');clearDiscount();clearRound();"   type="text" class=" input-sm amountRowTotal"  /></td>';
					  materialTableRow	+=	'<td><input type="hidden" id="purchasePrice'+i+'" class="purchasePrice" value="'+purchasePrice+'" /><input type="hidden" id="sellingPriceHiddenVal'+i+'" class="sellingPriceHiddenVal" value="" /><input style="width:100% !important;direction: rtl;" type="text" name="amountWithOutDiscount" id="amountWithOutDiscount'+i+'" value=""  class="input-sm amountRowWithOutDiscount" readonly/><input type="hidden" id="minimumRate'+i+'" value="'+minimumRate+'" class="minimumRate" /></td>';	
					   //materialTableRow	+=	'<td style="width:9% !important"><input type="hidden" name="discountId" id="discountId'+i+'" class="discountId" /><input style="width:39% !important;float:left;" type="text" name="discountName" id="discountName'+i+'" class=" input-sm discountNameRow" onkeyup="getDiscountData(this.value,'+i+');" /><input style="width:60% !important;float:right" type="text"  id="discountPercentRow'+i+'" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');" onchange="checkNumber(this.id); calculateRowTotal('+i+');" value=" "  class=" input-sm discountRowTotal" /><input style="width:100% !important" type="hidden"  id="dis'+i+'"  value="0"  class=" input-sm discountRowTotals" /></td>';
					   materialTableRow	+= '<td><input style="width:40% !important"  value="15" id="vatPercentRow'+i+'" onkeypress="checkEnterKey(event,'+i+',this.id);" onkeyup="checkNumber(this.id); calculateRowTotal('+i+'); checkEnterKey(event,'+i+',this.id);" onblur="tabPressFocus()" type="text" class="input-sm vatPercentRow left"  /><input style="width:60% !important;float:right;"  value="" type="text" id="vatAmountRow'+i+'"  class=" input-sm vatAmountRowTotal" readonly/</td>';
                     materialTableRow	+=	'<td><input style="width:100% !important;direction: rtl;"  value="'+sellingPrice+'" id="amountWithWithVatRow'+i+'" type="text" class=" input-sm amountWithWithVatRowTotal" onkeyup="calWithOutVats('+i+');  onblur="tabPressFocus()" /></td>';

					 // materialTableRow	+=	'<td style="width:9% !important"> <input style="width:100% !important"  value="0" id="amountAfterDiscountRow'+i+'"   type="text" class=" input-sm amountAfterDiscountRowTotal" readonly  /></td>';
 					  
					  //materialTableRow	+=	'<td><input style="width:100% !important"  value="'+vat+'" id="vatPercentRow'+i+'" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');"  type="text" class="input-sm vatPercentRow"  />';
					 // materialTableRow	+=	'<input style="width:100% !important"  value="0" type="hidden" id="vatAmountRow'+i+'"  class=" input-sm vatAmountRowTotal" readonly/></td>';
                     // materialTableRow	+=	'<td><input style="width:100% !important"  value="0" id="amountWithWithVatRow'+i+'" type="text" class=" input-sm amountWithWithVatRowTotal" readonly="" onblur="tabPressFocus()" /></td>';
 					 // materialTableRow	+=	'<td>'+purchasePrice+'</td>';						  
					  materialTableRow	+=	'<td><button type="button" onclick="deleteRow(this)"  class="btn btn-danger btnSubmit btn-xs" ><i class="fa fa-times"></i></button></td>';
					  materialTableRow	+=	'</tr>';
					  $('#materialDetailsTbody').append(materialTableRow);
					//$("#materialDetailsTbody").prepend(materialTableRow);
					//changeAllVat();
					//changeAllDisc();
					$('#itemUnitRow'+i).focus();
					calWithOutVats(i);
					idChange();
				  i++;
				  clearDiscount();
				  clearRound();
				  
		 <?php }else{ ?>
		   var selectBoxForUnit	=	'<select  class="input-sm form-group itemUnitRow" name="itemUnitRow[]" id="itemUnitRow'+i+'" onchange="checkUnit('+i+');" onkeypress="checkEnterKey(event,'+i+',this.id);" required >'+JSON.parse(data)+'</select>'	;
					  materialTableRow	+=	'<tr><td style="text-align:center"><span class="indexNo">'+i+'</span><button  type="button" class="btn btn-xs" data-toggle="popover" data-trigger="hover" title="Stock" data-content="'+stockValue+'"><i class="fa fa-plus"></i></button></td>'; 
					  //<button type="button" data-toggle="modal" data-target="#myTable" onclick="getDetails(this)" class="btn  btnSubmit btn-xs"  ><i class="fa fa-plus"></i></button>
					  materialTableRow	+=	'<td><input type="hidden" value="'+i+'" id="sNo'+i+'" class="sNo"><input type="hidden" value="'+stockId+'" id="stockIdRow'+i+'" class="stockIdRow"><input type="hidden" id="itemCodeRow'+i+'" style="width:100% !important" class="form-control input-sm itemCodeRow" value="'+itemCode+'" readonly /><input type="hidden"  id="itemMasterId'+i+'" class="form-control input-sm itemMasterId" value="'+itemMasterId+'" /><input type="hidden"  id="stockValue'+i+'" class="form-control input-sm stockValue" value="'+stockValue+'" />'+itemCode+'/'+itemName+'</td>';
					 // materialTableRow	+=	'<td style="width:12% !important"><input style="width:100% !important" type="hidden"  id="descriptionRow'+i+'" value="'+itemName+'" class=" input-sm descriptionRow"  readonly/>'+itemName+'</td>';
					 // materialTableRow	+=	'<td style="width:8% !important"><input type="hidden" id="packageSizeRow'+i+'" value="'+packing+'" class="packageSizeRow" />'+packing+'</td>';
				    	 materialTableRow	+=	'<td>'+selectBoxForUnit+'</td>';
					  materialTableRow	+=	'<td><input style="width:100% !important;direction: rtl;float: left;" type="text"  id="quantityRow'+i+'" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'+i+',this.id);" onchange="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();" value=""  class=" input-sm quantityRow" /></td>';
					  
					  materialTableRow	+=	'<td><input name="netWeightRow" value="" id="netWeightRow'+i+'" style="width: 100%;direction: rtl;" type="text" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();" onchange="checkNumber(this.id); calculateRowTotal('+i+');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'+i+',this.id);" class=" input-sm netWeightRow"  readonly=""></td>';
					  materialTableRow	+=	'<td><input style="width:100% !important;direction: rtl;"  value="'+sellingPrice+'" id="unitPriceRow'+i+'" onkeyup="checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound();" onkeypress="checkEnterKey(event,'+i+',this.id);"  onchange="checkNumber(this.id);checkminimumRate('+i+'); calculateRowTotal('+i+');clearDiscount();clearRound();"   type="text" class=" input-sm amountRowTotal"  /></td>';
					  materialTableRow	+=	'<td><input type="hidden" id="purchasePrice'+i+'" class="purchasePrice" value="'+purchasePrice+'" /><input type="hidden" id="sellingPriceHiddenVal'+i+'" class="sellingPriceHiddenVal" value="'+sellingPrice+'" /><input style="width:100% !important;direction: rtl;" type="text" name="amountWithOutDiscount" id="amountWithOutDiscount'+i+'" value=""  class="input-sm amountRowWithOutDiscount" readonly/><input type="hidden" id="minimumRate'+i+'" value="'+minimumRate+'" class="minimumRate" /></td>';	
					   //materialTableRow	+=	'<td style="width:9% !important"><input type="hidden" name="discountId" id="discountId'+i+'" class="discountId" /><input style="width:39% !important;float:left;" type="text" name="discountName" id="discountName'+i+'" class=" input-sm discountNameRow" onkeyup="getDiscountData(this.value,'+i+');" /><input style="width:60% !important;float:right" type="text"  id="discountPercentRow'+i+'" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');" onchange="checkNumber(this.id); calculateRowTotal('+i+');" value=" "  class=" input-sm discountRowTotal" /><input style="width:100% !important" type="hidden"  id="dis'+i+'"  value="0"  class=" input-sm discountRowTotals" /></td>';
					   materialTableRow	+= '<td><input style="width:40% !important"  value="15" id="vatPercentRow'+i+'" onkeypress="checkEnterKey(event,'+i+',this.id);" onkeyup="checkNumber(this.id); calculateRowTotal('+i+'); checkEnterKey(event,'+i+',this.id);" onblur="tabPressFocus()" type="text" class="input-sm vatPercentRow left"  /><input style="width:60% !important;float:right;"  value="'+vatValue+'" type="text" id="vatAmountRow'+i+'"  class=" input-sm vatAmountRowTotal" readonly/</td>';
                     materialTableRow	+=	'<td><input style="width:100% !important;direction: rtl;"  value="0" id="amountWithWithVatRow'+i+'" type="text" class=" input-sm amountWithWithVatRowTotal" readonly="" onblur="tabPressFocus()" /></td>';

					 // materialTableRow	+=	'<td style="width:9% !important"> <input style="width:100% !important"  value="0" id="amountAfterDiscountRow'+i+'"   type="text" class=" input-sm amountAfterDiscountRowTotal" readonly  /></td>';
 					  
					  //materialTableRow	+=	'<td><input style="width:100% !important"  value="'+vat+'" id="vatPercentRow'+i+'" onkeyup="checkNumber(this.id); calculateRowTotal('+i+');"  type="text" class="input-sm vatPercentRow"  />';
					 // materialTableRow	+=	'<input style="width:100% !important"  value="0" type="hidden" id="vatAmountRow'+i+'"  class=" input-sm vatAmountRowTotal" readonly/></td>';
                     // materialTableRow	+=	'<td><input style="width:100% !important"  value="0" id="amountWithWithVatRow'+i+'" type="text" class=" input-sm amountWithWithVatRowTotal" readonly="" onblur="tabPressFocus()" /></td>';
 					 // materialTableRow	+=	'<td>'+purchasePrice+'</td>';						  
					  materialTableRow	+=	'<td><button type="button" onclick="deleteRow(this)"  class="btn btn-danger btnSubmit btn-xs" ><i class="fa fa-times"></i></button></td>';
					  materialTableRow	+=	'</tr>';
					  $('#materialDetailsTbody').append(materialTableRow);
					//$("#materialDetailsTbody").prepend(materialTableRow);
					//changeAllVat();
					//changeAllDisc();
					$('#itemUnitRow'+i).focus();
					checkUnit(i);
					idChange();
				  i++;
				  clearDiscount();
				  clearRound();
		 <?php } ?>
				   //$('#materialDetailsTbody').find('tr').find('td:first').each(function(index){    
					//$(this).text(index+1);
					//$(this).html('<button type="button" data-toggle="modal" data-target="#myTable" onclick="getDetails(this)" class="btn  btnSubmit btn-xs"  ><i class="fa fa-plus"></i></button>'+(index+1));
					//});
					
					
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
 function idChange()
{
	$('[data-toggle="popover"]').popover({ trigger: "hover" });   

	
	var i=1;
	$('.descriptionRow').each(function(){
		
		var descriptionRow= 'descriptionRow'+i;
		//alert(quantityRow);
        $(this).attr('id',""+descriptionRow+"");
		
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
	$('.packageSizeRow').each(function(){
		
		var packageSizeRow= 'packageSizeRow'+i;
		$(this).attr('id',""+packageSizeRow+"");
		i++;
	    
	});
	
	var i=1;
	$('.stockValue').each(function(){
		
		var stockValue= 'stockValue'+i;
		$(this).attr('id',""+stockValue+"");
		i++;
	    
	});
	
	
	var i=1;
	$('.amountRowWithOutDiscount').each(function(){
		
		var amountWithOutDiscount= 'amountWithOutDiscount'+i;
		$(this).attr('id',""+amountWithOutDiscount+"");
		 
		i++;
	    
	});
		var i=1;
	$('.vatAmountRowTotal').each(function(){
		
		var vatAmountRow= 'vatAmountRow'+i;
		$(this).attr('id',""+vatAmountRow+"");
		  //$(this).attr('onKeyUp','checkNumber("'+vatAmountRow+'");calculateRowTotal('+i+')');
		i++;
	    
	}); 

	


	
	/*var i=1;
	$('.discountRowTotal').each(function(){
		
		var discountPercentRow= 'discountPercentRow'+i;
		$(this).attr('id',""+discountPercentRow+"");
		 $(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotal('+i+')');
		i++;
	    
	}); 
	var i=1;
	$('.discountRowTotals').each(function(){
		
		var dis= 'dis'+i;
		$(this).attr('id',""+dis+"");
		// $(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotal('+i+')');
		i++;
	    
	}); 
	var i=1;
	$('.amountAfterDiscountRowTotal').each(function(){
		
		var amountAfterDiscountRow= 'amountAfterDiscountRow'+i;
		$(this).attr('id',""+amountAfterDiscountRow+"");
		 
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
	$('.invoiceDetailsId').each(function(){
		
		var invoiceDetailsId= 'invoiceDetailsId'+i;
		$(this).attr('id',""+invoiceDetailsId+"");
		
		i++;
	    
	});  */ 


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
/*var i=1;
	$('.invoiceId').each(function(){
		
		var invoiceId= 'invoiceId'+i;
		$(this).attr('id',""+invoiceId+"");
		
		i++;
	    
	});
var i=1;
	$('.quantity_old').each(function(){
		
		var quantity_old= 'quantity_old'+i;
		$(this).attr('id',""+quantity_old+"");
		
		i++;
	    
	});*/
var i=1;
	$('.purchasePrice').each(function(){
		
		var purchasePrice= 'purchasePrice'+i;
		$(this).attr('id',""+purchasePrice+"");
		
		i++;
	    
	});		
	 <?php if($branchId==5){ ?>
	 
	 	
var i=1;
	$('.itemUnitRow').each(function(){
		
		var itemUnitRow= 'itemUnitRow'+i;
		$(this).attr('id',""+itemUnitRow+"");
		$(this).attr('onChange','checkUnitreverse('+i+')');
		$(this).attr('onkeypress','checkEnterKey(event,'+i+',this.id);');
		i++;
	    
	});
	
	var i=1;
	$('.amountWithWithVatRowTotal').each(function(){
		
		var amountWithWithVatRow= 'amountWithWithVatRow'+i;
		$(this).attr('id',""+amountWithWithVatRow+"");
		  $(this).attr('onKeyUp','checkNumber("'+amountWithWithVatRow+'");calWithOutVats('+i+')');
		i++;
	    
	}); 
	var i=1;
	$('.netWeightRow').each(function(){
		
		var netWeightRow= 'netWeightRow'+i;
		$(this).attr('id',""+netWeightRow+"");
		 $(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotalReverse('+i+');clearDiscount();clearRound()');
		 $(this).attr('onChange','checkNumber(this.id);calculateRowTotalReverse('+i+');clearDiscount();clearRound()');
		 $(this).attr('onkeypress','checkEnterKey(event,'+i+',this.id);');
		i++;
	    
	});	
		var i=1;
	$('.vatPercentRow').each(function(){
		
		var vatPercentRow= 'vatPercentRow'+i;
		$(this).attr('id',""+vatPercentRow+"");
		  $(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotalReverse('+i+')');
		i++;
	    
	}); 
	var i=1;
	$('.amountRowTotal').each(function(){
		
		var unitPriceRow= 'unitPriceRow'+i;
		$(this).attr('id',""+unitPriceRow+"");
		 $(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotalReverse('+i+');clearDiscount();clearRound()');
		 $(this).attr('onChange','checkNumber(this.id);checkminimumRate('+i+');calculateRowTotalReverse('+i+');clearDiscount();clearRound()');
		 $(this).attr('onkeypress','checkEnterKey(event,'+i+',this.id);');
		i++;
	    
	});
	var i=1;
	
	$('.quantityRow').each(function(){
		
		var quantityRow= 'quantityRow'+i;
		//alert(quantityRow);
        $(this).attr('id',""+quantityRow+"");
		  $(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotalReverse('+i+');clearDiscount();clearRound()');
		  $(this).attr('onChange','checkNumber(this.id);calculateRowTotalReverse('+i+');clearDiscount();clearRound()');
		  $(this).attr('onkeypress','checkEnterKey(event,'+i+',this.id);');
		i++;
	    
	});  
	 <?php }else{ ?>
	
var i=1;
	$('.itemUnitRow').each(function(){
		
		var itemUnitRow= 'itemUnitRow'+i;
		$(this).attr('id',""+itemUnitRow+"");
		$(this).attr('onChange','checkUnit('+i+')');
		$(this).attr('onkeypress','checkEnterKey(event,'+i+',this.id);');
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
	$('.netWeightRow').each(function(){
		
		var netWeightRow= 'netWeightRow'+i;
		$(this).attr('id',""+netWeightRow+"");
		 $(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound()');
		 $(this).attr('onChange','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound()');
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
	$('.amountRowTotal').each(function(){
		
		var unitPriceRow= 'unitPriceRow'+i;
		$(this).attr('id',""+unitPriceRow+"");
		 $(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound()');
		 $(this).attr('onChange','checkNumber(this.id);checkminimumRate('+i+');calculateRowTotal('+i+');clearDiscount();clearRound()');
		 $(this).attr('onkeypress','checkEnterKey(event,'+i+',this.id);');
		i++;
	    
	});
	var i=1;
	
	$('.quantityRow').each(function(){
		
		var quantityRow= 'quantityRow'+i;
		//alert(quantityRow);
        $(this).attr('id',""+quantityRow+"");
		  $(this).attr('onKeyUp','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound()');
		  $(this).attr('onChange','checkNumber(this.id);calculateRowTotal('+i+');clearDiscount();clearRound()');
		  $(this).attr('onkeypress','checkEnterKey(event,'+i+',this.id);');
		i++;
	    
	});  
	 <?php } ?>

var i=1;
	$('.itemCodeRow').each(function(){
		
		var itemCodeRow= 'itemCodeRow'+i;
		$(this).attr('id',""+itemCodeRow+"");
		//var val=$(this).val();
		  //$(this).attr("onKeyUp","getCustomerItemCode("+i+",this.value)");
		i++;
	    
	});   	

	var i=1;
	$('.stockIdRow').each(function(){
		
		var stockIdRow= 'stockIdRow'+i;
		$(this).attr('id',""+stockIdRow+"");
		
		i++;
	    
	});	
	
	
	/* Sno */
	var i=1;
	$('.indexNo').each(function(){
		$(this).html(i);
		i++;
	});
	/*var i=1;
	$('.discountNameRow').each(function(){
		
		var discountName= 'discountNameRow'+i;
		$(this).attr('id',""+discountName+"");
		
		i++;
	    
	});	
	
	var i=1;
	$('.discountId').each(function(){
		
		var discountId= 'discountId'+i;
		$(this).attr('id',""+discountId+"");
		
		i++;
	    
	});	*/
	
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


function checkUnit(i)
{
	var unitName = $("#itemUnitRow"+i+" option:selected").text();
	//console.log(unitId);
	if(unitName =='OTHER')
	{
		console.log(unitName);
		$('#netWeightRow'+i).prop('readonly', false);	
		calculateRowTotal(i);
		calculateRowVat(i);	
	}/*else if(unitName =='CARTON')
	{
		var itemMasterId	=	parseFloat($('#itemMasterId'+i).val());
			$.ajax({
						type: "POST",
						url: '../../../../modules/salesInvoice/admin/ajax/getCartonSellingPrice.php',
						data: {itemMasterId:itemMasterId},
						success: function(data){
							
							$('#unitPriceRow'+i).val(data);
							$('#netWeightRow'+i).prop('readonly', true);
							calculateRowTotal(i);
							calculateRowVat(i);	
						}
					});
		
	}*/
		else{
		
			var itemMasterId	=	parseFloat($('#itemMasterId'+i).val());
				var unitId = $("#itemUnitRow"+i).val();
				console.log(unitId);
			$.ajax({
						type: "get",
						url: '../../../../modules/salesInvoice/admin/ajax/getUnitPriceFromCartonFraction.php',
						data: {itemMasterId:itemMasterId,unitId:unitId},
						success: function(data){
							console.log(data);
							$('#unitPriceRow'+i).val(data);
							$('#netWeightRow'+i).prop('readonly', true);
							calculateRowTotal(i);	
							calculateRowVat(i);	
						}
					});
		
	}
}
function calculateRowTotal(i)
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
			
		if(unitName =='CARTON')
		{
			var rowTotal		=	quantityRow*unitPriceRow;
		}else{
			var rowTotal		=	newNeightWeight*unitPriceRow;
		}
		
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
							  $('#unitPriceRow'+i).val(null);
							  $('#amountWithOutDiscount'+i).val(null);
							  calculateRowVat(i);	
							calculateSum();	  
						  }	
						  console.log('1');
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
								console.log('2');
		 }			 
						
		 /*$.ajax({
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
									$('#amountWithOutDiscount'+i).val(null);
								}else{
									$('#amountWithOutDiscount'+i).val(rowTotal.toFixed(2)); 
								}
						  }else{
								alert("Only "+stockValue+" is Available ln Stock");
							  $('#quantityRow'+i).val(null);
							  $('#netWeightRow'+i).val(null);
							  $('#itemUnitRow'+i).val(null);
							  $('#unitPriceRow'+i).val(null);
							  $('#amountWithOutDiscount'+i).val(null);
						  }							  
						}
					});
					
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
	   
		calculateSum();	  */ 
	   //calculateRowVat(i);
	   
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
							  $('#itemUnitRow'+i).val(null);
							  $('#unitPriceRow'+i).val(null);
							  $('#amountWithOutDiscount'+i).val(null);
						  }							  
						}
					});
		
	   //$('#amountRow'+i).val(rowTotal.toFixed(2));
	   //$('#totalWithVatAmountRow'+i).val(rowTotal.toFixed(2));
	   
	   calculateSum();
	   //calculateRowVatAmount(i);
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
									$('#amountWithOutDiscount'+i).val(null);
								}else{
									 
									$('#amountWithOutDiscount'+i).val(rowTotal.toFixed(2));
								}
						  }else{
								alert("Only "+stockValue+" is Available ln Stock");
							  $('#quantityRow'+i).val(null);
							  $('#netWeightRow'+i).val(null);
							  $('#itemUnitRow'+i).val(null);
							  $('#unitPriceRow'+i).val(null);
							  $('#amountWithOutDiscount'+i).val(null);
						  }							  
						}
					});
		
	   //$('#amountRow'+i).val(rowTotal.toFixed(2));
	   //$('#totalWithVatAmountRow'+i).val(rowTotal.toFixed(2));
	   
	   calculateSum();
	   //calculateRowVatAmount(i);
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
		var vatAmount		=	(amountRow*vatPercentRow)/100;
		
			$('#vatAmountRow'+i).val(round2Fixed(vatAmount));
			var VatAmt = $('#vatAmountRow'+i).val();
		var AmountWithVat	= parseFloat(amountRow)+parseFloat(VatAmt);	
		$('#amountWithWithVatRow'+i).val(AmountWithVat.toFixed(2));
	
		
	}else{
			$('#amountWithWithVatRow'+i).val(parseFloat(amountRow).toFixed(2));
			$('#vatAmountRow'+i).val(0);
		
	}
	calculateSum();
}


function calculateSum()
   { 
	var amountRowWithOutDiscount	=	0;
	$('.amountRowWithOutDiscount').each(function(){
		var rowValue	=	parseFloat(this.value);
		if(rowValue==''||isNaN(rowValue))
			{
				rowValue=0;
			}
    amountRowWithOutDiscount = amountRowWithOutDiscount+rowValue;
	});
   
  var totalQuantity = 0;
	$('.quantityRow').each(function(){
		var qtyRow =	parseFloat(this.value);
		if(isNaN(qtyRow))
		{
			qtyRow	=	0;
		}
    totalQuantity +=qtyRow;
	});
	
	var netWeightTotal = 0;
	$('.netWeightRow').each(function(){
		var nerWeightRow =	parseFloat(this.value);
		if(isNaN(nerWeightRow))
		{
			nerWeightRow	=	0;
		}
    netWeightTotal +=nerWeightRow;
	});
	
   var discountInAmount		=	parseFloat($('#discountInAmount').val());
   if(discountInAmount==''||isNaN(discountInAmount))
			{
				discountInAmount=0;
			}
   
   
   	var totalAmountWithDiscount		=	amountRowWithOutDiscount-discountInAmount;
	
	var damagedGoodsAmount		=	parseFloat($('#damagedGoodsAmount').val());
   if(damagedGoodsAmount==''||isNaN(damagedGoodsAmount))
			{
				damagedGoodsAmount=0;
			}
	var amountAfterDamage	=	totalAmountWithDiscount-damagedGoodsAmount;		

  var cuttingCharge		=	parseFloat($('#cuttingCharge').val());
   if(cuttingCharge==''||isNaN(cuttingCharge))
			{
				cuttingCharge=0;
			}
	var amountWithCuttingCharge	=	amountAfterDamage+cuttingCharge;
	
  var vatInPercent			=	parseFloat($('#vatInPercent').val());
   if(vatInPercent==''||isNaN(vatInPercent))
			{
				vatInPercent=0;
			}
   var vatAmountTotal		=	(amountWithCuttingCharge*vatInPercent)/100;
	
	
	var netAmount					=	amountWithCuttingCharge+vatAmountTotal;
		
	
	/*if(parseFloat(vatAmountTotal)>0)
	{
	if(amountRowWithOutDiscount==0||isNaN(amountRowWithOutDiscount))
		{
			$('#totalAmount').val(null);
		}else{
		$('#totalAmount').val(amountRowWithOutDiscount.toFixed(2));
		}
	
	if(totalAmountWithDiscount==0||isNaN(totalAmountWithDiscount))
		{
			$('#amountAfterDiscountTotal').val(null);	 
		}else{
			$('#amountAfterDiscountTotal').val(totalAmountWithDiscount.toFixed(2));	 
		}
		if(vatAmountTotal==0||isNaN(vatAmountTotal))
		{
			$('#vatAmount').val(null);	 
		}else{
			$('#vatAmount').val(vatAmountTotal.toFixed(2));	 
		}
		if(netAmount==0||isNaN(netAmount))
		{
			$('#netAmount').val(null);	 
		}else{
			 $('#netAmount').val(netAmount.toFixed(2)); 	 
		}
	  
		 
	}else{*/
		if(amountRowWithOutDiscount==0||isNaN(amountRowWithOutDiscount)||amountRowWithOutDiscount=='')
		{
			$('#totalAmount').val(null);
		}else{
		$('#totalAmount').val(round2Fixed(amountRowWithOutDiscount));
		}
		/*if(discountInAmount==0||isNaN(discountInAmount||discountInAmount==''))
		{
			$('#discountInAmount').val(null);
		}else{
			$('#discountInAmount').val(discountInAmount.toFixed(2));	
		}*/
		if(totalAmountWithDiscount==0||isNaN(totalAmountWithDiscount)||totalAmountWithDiscount=='')
		{
			$('#amountAfterDiscountTotal').val(null);	 
		}else{
			$('#amountAfterDiscountTotal').val(round2Fixed(totalAmountWithDiscount));	 
		}
		
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
			 
			$('#netWeightTotal').val(round2Fixed(netWeightTotal));
		} 		
	//}
		 
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
		$('#discountInAmountHidden').val(null);
	   
	 }else{
		  var discountPercent	=	(discountInAmount*100)/totalAmount;
		  $('#discountInPercent').val(discountPercent.toFixed(2));
		$('#discountInAmountHidden').val(discountInAmount.toFixed(2));
	 }
	  calculateSum();
	    
   }
   
   function deleteRow(r)
{
   var i = r.parentNode.parentNode.rowIndex;
   document.getElementById("salesItems").deleteRow(i);
 // $('#materialDetailsTbody').find('tr').find('td:first').each(function(index){    
					//$(this).text(index+1);
					//$(this).html('<button type="button" data-toggle="modal" data-target="#myTable" onclick="getDetails(this)" class="btn  btnSubmit btn-xs"  ><i class="fa fa-plus"></i></button>'+(index+1));
					//});
   calculateSum();
   idChange();
   clearDiscount();
   clearRound();
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
	        var sNo 					= document.getElementById("sNo"+i).value;
	        var itemMasterId 			= document.getElementById("itemMasterId"+i).value;
	        var quantityRow 			= document.getElementById("quantityRow"+i).value;
			var itemUnitRow 			=  $("#itemUnitRow"+i+" option:selected").val();
	        var unitPriceRow 			= document.getElementById("unitPriceRow"+i).value;
	       // var discountPercentRow 		= document.getElementById("discountPercentRow"+i).value;
	        //var discountAmountRow 		= document.getElementById("dis"+i).value;
			var amountWithOutDiscount 	= document.getElementById("amountWithOutDiscount"+i).value;
	        //var amountAfterDiscountRow 	= document.getElementById("amountAfterDiscountRow"+i).value;
			var itemCodeRow				= document.getElementById("itemCodeRow"+i).value;	
			//var descriptionRow			= document.getElementById("descriptionRow"+i).value;
			//var packageSizeRow			= document.getElementById("packageSizeRow"+i).value;
			var vatPercentRow			= document.getElementById("vatPercentRow"+i).value;
			var vatAmountRow			= document.getElementById("vatAmountRow"+i).value;
			var amountWithWithVatRow	= document.getElementById("amountWithWithVatRow"+i).value;
	    	var purchasePriceRow		= document.getElementById("purchasePrice"+i).value;
	    	var stockIdRow				= document.getElementById("stockIdRow"+i).value;
	    	var netWeightRow			= document.getElementById("netWeightRow"+i).value;
	    	//var discountIdRow			= document.getElementById("discountId"+i).value;
			//alert(itemUnitRow);
			invoiceData[k][0]	= sNo;
	    	invoiceData[k][1]   = itemMasterId;
	    	invoiceData[k][2]   = quantityRow;
	    	invoiceData[k][3]   = itemUnitRow;
	        invoiceData[k][4]   = unitPriceRow;
	    	invoiceData[k][5]   = '';
	    	invoiceData[k][6]   = '';
			invoiceData[k][7]   = itemCodeRow;
			invoiceData[k][8]   = '';
			invoiceData[k][9]   = '';
			invoiceData[k][10]  = vatPercentRow;
	    	invoiceData[k][11]  = vatAmountRow;
	    	invoiceData[k][12]  = amountWithWithVatRow;
			invoiceData[k][13]  = amountWithOutDiscount;
			invoiceData[k][14]  = purchasePriceRow;
			invoiceData[k][15]  = '';
			invoiceData[k][16]  = '';
			invoiceData[k][17]  = stockIdRow;
			invoiceData[k][18]  = netWeightRow;
			k++;

    }

var json_text = JSON.stringify(invoiceData);
document.getElementById("tableValueArray").value = json_text;
}

/*$( document ).ready(function() {
	var regularCustomerId =	$('#regularCustomerId').val();
  if(parseInt(regularCustomerId)>0)
  {
	   $("#materialSearch").attr("readonly", false); 
	   $('#searchItemName').prop("disabled",false);
  }
});*/
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
            //$(this).val(disc);
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

function getDetails(r){
	
	var i = r.parentNode.parentNode.rowIndex;
	//alert(i);
	   var itemMasterId 			= document.getElementById("itemMasterId"+i).value;
	 
	   var regularCustomerId	    = document.getElementById("regularCustomerId").value;
	   //alert(regularCustomerId);
	   var customerName            = document.getElementById("customerName").value;
	   var itemCodeRow             = document.getElementById("itemCodeRow"+i).value;
	    $.ajax({
	type: "POST",
    url: '../../../../modules/salesInvoice/admin/ajax/getDetails.php',
    data: {itemMasterId:itemMasterId,regularCustomerId:regularCustomerId,customerName:customerName,itemCodeRow:itemCodeRow},
    success: function(data){
	
      $('#itemDetails').html(data); 
	  // $('#tableHead').html(data.$table1); 
    }
});
}


$(function(){
$("#salesInvoiceNoForEdit").autocomplete({
   source: function(request, response) {
     $.getJSON("../../../../modules/invoiceSearchByInvoiceNo/admin/ajax/ajaxForInvoiceNo.php", {
		 term  : $('#salesInvoiceNoForEdit').val()}, 
              response);
  },
      minLength: 0,
	  select: function( event, ui ) {
		 $('#salesInvoiceIdForEdit').val( ui.item.key);
		 $('#salesInvoiceNoForEdit').val(ui.item.value);
		 return false;
      }  ,
	  change: function (event, ui) {
             if (ui.item == null) 
			 {
			   $('#salesInvoiceIdForEdit').val('');
			   $('#salesInvoiceNoForEdit').val('');
		    
			 }
		}
   });
});

</script>
<script>
function getDiscountData(discountName)
{
	 $.ajax({
	type: "POST",
    url: '../../../../modules/salesInvoice/admin/ajax/getDiscountData.php',
    data: {discountName:discountName},
    success: function(data){
		var res				=	JSON.parse(data);
		var discountId		=	res.discountId;
		var discountPercent	=	res.discountPercent;
		$('#discountId').val(discountId); 
		$('#discountInPercent').val(discountPercent);
		calculateSum();	
    }
});
}
</script>
<script type="text/javascript">
function tabPressFocus()
{
document.getElementById("materialSearch").focus();
	
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
</script>-->
<!--<script>

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
})
</script>-->
<script>
$('#invoiceForm').on('keyup keypress', function(e) {
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
		 if(id=='itemUnitRow'+i)
		{
			$('#quantityRow'+i).focus();
			
		}else if(id=='quantityRow'+i)
		{
			$('#netWeightRow'+i).focus();
		}else if(id=='netWeightRow'+i)
		{
			$('#unitPriceRow'+i).focus();
		}else if(id=='customerName')
		{
			$('#customerPhone').focus();
		}else if(id=='customerPhone')
		{
			$('#vatNumber').focus();
		}else if(id=='vatNumber')
		{
			$('#materialSearch').focus();
		}else if(id=='customerCode')
		{
			$('#vatNumber').focus();
		}else{
			$('#materialSearch').focus();
		}
	
	}
}
</script>
