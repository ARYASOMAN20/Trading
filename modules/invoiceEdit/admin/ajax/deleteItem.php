<?php
require_once('../../../../modules/invoiceEdit/admin/models/invoiceEditmodel.php');
$objinvoiceEditmodel	= 	new invoiceEditmodel();
$stockQuantity	    =0;
$subAccountHeadId ='';

$invoiceDetailsId	=	$_POST['invoiceDetailsId'];
$quantityRow    	=	$_POST['quantityRow'];
$itemMasterId   	=	$_POST['itemMasterId'];
$fraction       	=	$_POST['fraction'];

$invoiceIdUpdate  	     =	$_POST['invoiceIdUpdate'];
$discountInAmount    	 =	$_POST['discountInAmount'];
$amountAfterDiscountTotal =	$_POST['amountAfterDiscountTotal'];
$totalAmount       	     =	$_POST['totalAmount'];
$vatAmount    	         =	$_POST['vatAmount'];
$netAmount               =	$_POST['netAmount'];
$regularCustomerId       =	$_POST['regularCustomerId'];

$getSubAccountData = $objinvoiceEditmodel->getSubAccountId($regularCustomerId);
while($getSubAccountDataRow	=	mysqli_fetch_array($getSubAccountData))
				{
					$subAccountHeadId	=	$getSubAccountDataRow['subAccountHeadId'];
				}
			

$stockQuantity	    =	$fraction*$quantityRow;
$objinvoiceEditmodel->setStatus($invoiceDetailsId);
$objinvoiceEditmodel->updateStockInItemMaster($itemMasterId,$stockQuantity);
$objinvoiceEditmodel->updateInvoiceTbl($invoiceIdUpdate,$discountInAmount,$amountAfterDiscountTotal,$totalAmount,$vatAmount,$netAmount);
$objinvoiceEditmodel->updateAccountsTbl($invoiceIdUpdate,$discountInAmount,$totalAmount,$vatAmount,$netAmount,$subAccountHeadId);
echo 1;
?>