<?php
require_once("../../../../modules/purchase/admin/class/m_purchase.php");

class C_Purchase
{
	function getMaxInvoiceNo()
	{
		$objMPurchase = new M_Purchase();
		$maxInvoiceNodata 	= 	$objMPurchase->getMaxInvoiceNo(); 
		$branchCode			=	$objMPurchase->getBranchCode();
		if(mysqli_num_rows($maxInvoiceNodata)>0)
			{
			while($row=mysqli_fetch_array($maxInvoiceNodata))
			{
				
					$lastIncoiceNo	=	$row['invoiceNo'];
					$invoiceNoArray	=	explode("/",$lastIncoiceNo);
					
					if(count($invoiceNoArray)==3)
					{
						$maxInvoiceNo	=	$invoiceNoArray[2];
						$maxInvoiceNo	=	$maxInvoiceNo+1;
					}else{
						$maxInvoiceNo	=	1;
					}
				
				
				
			}
			}else{
				$maxInvoiceNo	=	1;
			}
		
		 $invoiceNo	=	$branchCode.'/LC/'.$maxInvoiceNo;
		return $invoiceNo;
	}
	function dropDownForvendorName()
	{
		$objMPurchase 		= 	new M_Purchase();
		$strVendor			=	'';
		$dropDownForVendor  =	$objMPurchase->dropDownForvendorName();
		while ($rowVendor 	= 	mysqli_fetch_array($dropDownForVendor))
		{
			$strVendor .='<option value = '.$rowVendor['vendorId'].'>'.$rowVendor['vendorName'].'</option>';
		} 
		return 	$strVendor;
	}
	function getCurrencyData()
	{
		$currencyData		=	'';
		$objMPurchase 		= 	new M_Purchase();
		$dropDownForCurrency  =	$objMPurchase->getCurrencyData();
		while ($rowDropDownForCurrency 	= 	mysqli_fetch_array($dropDownForCurrency))
		{
			if($rowDropDownForCurrency['currencyName']=='SAUDI RIYAL')
			{
				$selected="selected";
			}else{
				$selected="";
			}
			$currencyData .='<option value = "'.$rowDropDownForCurrency['currencyId'].'/'.$rowDropDownForCurrency['exRate'].'" '.$selected.'>'.$rowDropDownForCurrency['currencyName'].'</option>';
		} 
		return $currencyData;
	}
	function insertToPurchaseItemBill($invoiceNo,$invoiceDate,$vendorId,$discount,$billTotalWithOutDiscount,$amountWithDiscountTotal,$totalVatAmount,
					$billTotalWithVat,$typeOfTransactionId,$userId,$currencyId,$exRate,$netAmountWithExRate,$customerPoNo,$deliveryOrderNo
					,$vatPercentTotal,$privilageId,$branchId,$mainBranch)
	{
		$objMPurchase 		= 	new M_Purchase();
		$purchaseItemBillId	=	$objMPurchase->insertToPurchaseItemBill($invoiceNo,$invoiceDate,$vendorId,$discount,$billTotalWithOutDiscount,
								$amountWithDiscountTotal,$totalVatAmount,$billTotalWithVat,$typeOfTransactionId,$userId,$currencyId,$exRate,
								$netAmountWithExRate,$customerPoNo,$deliveryOrderNo,$vatPercentTotal,$privilageId,$branchId,$mainBranch);
		return $purchaseItemBillId;
	}
	function insertToPurchaseItem($purchaseItemBillId,$itemMasterId,$quantityRow,$unitPriceRow,$amountRow,$discountRow,$amountAfterDiscountRow,$vatPercentRow,$vatAmountRow,$totalWithVatAmountRow,$itemUnitId,$unitFraction,$expiryDate,$netWeightRow,$barcodeId)
	{
		$objMPurchase 		= 	new M_Purchase();
		$purchaseItemId		=	$objMPurchase->insertToPurchaseItem($purchaseItemBillId,$itemMasterId,$quantityRow,$unitPriceRow,$amountRow,$discountRow,$amountAfterDiscountRow,$vatPercentRow,$vatAmountRow,$totalWithVatAmountRow,$itemUnitId,$expiryDate,$netWeightRow,$barcodeId);
		
		return $purchaseItemId;
	}	


function getRemainingStock($itemMasterId,$expiryDate,$privilageId,$branchId)
	{
		$objMPurchase	= 	new M_Purchase();
		$remainingStock	    =	$objMPurchase->getRemainingStock($itemMasterId,$expiryDate,$privilageId,$branchId);
		return $remainingStock;
		
	}	
	
	function insertItemTransferDetails($invoiceDate,$invoiceNo,$itemMasterId,$quantityRow,$netWeightRow,$expiryDateItem,$itemUnitId,
							$purchaseItemId,$venderName,$stock,$privilageId,$branchId,$userId)
	{		
	$objMPurchase 		= 	new M_Purchase();	
	$objMPurchase-> insertItemTransferDetails($invoiceDate,$invoiceNo,$itemMasterId,$quantityRow,$netWeightRow,$expiryDateItem,$itemUnitId,
							$purchaseItemId,$venderName,$stock,$privilageId,$branchId,$userId);	
	
	}
	
	function checkInvoiceNoExistOrNot($invoiceNo,$vendorId,$privilageId,$branchId)
	{
		$objMPurchase 		= 	new M_Purchase();
		$numOfRows			=	$objMPurchase->checkInvoiceNoExistOrNot($invoiceNo,$vendorId,$privilageId,$branchId);
		return $numOfRows;	
	}
	
	
	function getPurcahsePaymentVoucherNo()
	{
	$objMPurchase 		= 	new M_Purchase();
    $getPurcahsePaymentVoucherNo		=	$objMPurchase->getPurcahsePaymentVoucherNo();
	while($purchasePaymentVoucherNoRow	=	mysqli_fetch_array($getPurcahsePaymentVoucherNo))
				{
					$purchaseVoucherNo	=	$purchasePaymentVoucherNoRow['purchaseVoucherNo'];
				}
	return 	$purchaseVoucherNo;		
	}
	function getBarcode($itemMasterId)
	{
		$objMPurchase 	= 	new M_Purchase();
		$itemCode		=	$objMPurchase->getBarcode($itemMasterId);
		return $itemCode;
	}
	function getPurchasePrintTable($purchaseItemBillId)
	{
		$table				=	'';
		$tbody				=	'';
		$i					=	1;
		$quantityTotal		=	0;
		$netWeightTotal		=	0;
		
		$objMPurchase 		= 	new M_Purchase();
		$resPurchaseItem 	= $objMPurchase->getBasicPurchaseDetails($purchaseItemBillId);
		while($row=mysqli_fetch_array($resPurchaseItem))
		{
			$invoiceNo				=	$row['invoiceNo'];
			$invoiceDateDb			=	$row['invoiceDate'];
			$invoiceDate			=	date_format(date_create($invoiceDateDb),"d-m-Y");
			$billTotal				=	$row['billTotal'];
			$discount				=	$row['discount'];
			$billTotalWithDiscount	=	$row['billTotalWithDiscount'];
			$vatPercentTotal		=	$row['vatPercentTotal'];
			$totalVatAmount			=	$row['totalVatAmount'];
			$billTotalWithVat		=	$row['billTotalWithVat'];
			$customerPoNo			=	$row['customerPoNo'];
			$deliveryOrderNo		=	$row['deliveryOrderNo'];
			$vendorName				=	$row['vendorName'];
		}
		$resPurchaseItemDetails 	= $objMPurchase->getPurchaseItemDetails($purchaseItemBillId);
		while($row=mysqli_fetch_array($resPurchaseItemDetails))
		{
			$tbody					.=	'<tr>
											<td>'.$i.'</td>
											<td>'.$row['itemCode'].'</td>
											<td>'.$row['itemName'].'('.$row['itemNameArabic'].')</td>
											<td align="right">'.$row['quantity'].'</td>
											<td>'.$row['unitName'].'</td>
											<td align="right">'.number_format($row['netWeight'],2,'.','').'</td>
											<td align="right">'.number_format($row['unitPrice'],2,'.','').'</td>
											<td align="right">'.number_format($row['purchasePriceWithOutDiscount'],2,'.','').'</td>
											<td align="center">'.date_format(date_create($row['expiryDate']),"d-m-Y").'</td>
										</tr>';
			$i=$i+1;
			$quantityTotal		=	$quantityTotal+$row['quantity'];
			$netWeightTotal		=	$netWeightTotal+$row['netWeight'];
			
		}
		$tbody					.=	'<tr>
										<td colspan="3" align="right">Total</td>
										<td align="right"> <b>'.$quantityTotal.'</b></td>
										<td>&nbsp;</td>
										<td align="right"> <b>'.number_format($netWeightTotal,2,'.','').'</b></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td colspan="8" style="text-align: right;">TOTAL AMOUNT</td>
										<td  align="right"><b>'.number_format($billTotal,2,'.','').'</b></td>
									</tr>
									<tr>
										<td colspan="8" style="text-align: right;">DISCOUNT</td>
										<td  align="right"><b>'.number_format($discount,2,'.','').'</b></td>
									</tr>
									<tr>
										<td colspan="8" style="text-align: right;">TOTAL AFTER DISCOUNT</td>
										<td  align="right"><b>'.number_format($billTotalWithDiscount,2,'.','').'</b></td>
									</tr>
									<tr>
										<td colspan="8" style="text-align: right;">VAT AMOUNT('.$vatPercentTotal.'%)</td>
										<td  align="right"><b>'.number_format($totalVatAmount,2,'.','').'</b></td>
									</tr>
									<tr>
										<td colspan="8" style="text-align: right;">TOTAL WITH VAT</td>
										<td  align="right"><b>'.number_format($billTotalWithVat,2,'.','').'</b></td>
									</tr>
									';
		
		$table				.=	'<div class="hideDiv" style="display:none;">
									<img src="../../../../modules/salesInvoice/admin/includes/header.jpeg" style="width: 100%; height: 100px;"/>
								</div>
						<br/><br/><br/><br/>
						<table border="0" style="border-collapse:collapse;width:100%;font-size: 13px;"  cellpadding="5">
									<thead>
										<tr>
											<th colspan="6" style="text-align:center;"><u>PURCHASE INVOIVE</u></th>
										</tr>
										<tr>
											<th colspan="6" style="text-align:center;">&nbsp;</th>
										</tr>
										<tr>
											<td width="25%">INVOICE NO: <b>'.$invoiceNo.'</b></td>
											<td width="30%">INVOICE DATE: <b>'.$invoiceDate.'</b></td>
											<td width="15%">VENDOR NAME: </td>
											<td width="30%"><b>'.$vendorName.'</b></td>
										</tr>
						</table><br/>	
						<table border="0" style="border-collapse:collapse;width:100%;font-size: 13px;" cellpadding="5" cellpadding="5">
										<tr>
											
											<td>VENDOR INVOICE NO: <b>'.$customerPoNo.'</b></td>
											<th></th>
											<td>DELIVERY ORDER NO: <b>'.$deliveryOrderNo.'</b></td>
											<th></th>
										</tr>
									</thead>
									
								</table><br/><br/>
								<table border="1" style="border-collapse:collapse;width:100%;font-size: 12px !important;" >
									<thead>
										<tr>
											<th width="3%">Sl</th>
											<th width="10%" style="text-align:center">Barcode</th>
											<th width="18%" style="text-align:center">Item Description</th>
											<th width="7%" style="text-align:center">Qty</th>
											<th width="7%" style="text-align:center">Unit</th> 
											<th width="7%" style="text-align:center">Weight</th> 
											<th width="10%" style="text-align:center">Unit price</th>
											<th width="10%" style="text-align:center">Amount</th>
											<th width="8%" style="text-align:center">Exp. Date </th>
											
										</tr>
									</thead>
									<tbody>
										'.$tbody.'
									</tbody>
								</table>
								';
		return $table;
	}
}
?>