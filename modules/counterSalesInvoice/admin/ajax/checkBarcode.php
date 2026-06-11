<?php
require_once("../../../../modules/counterSalesInvoice/admin/models/m_salesInvoice.php");
$objsalesInvoice = new M_salesInvoice();
	
	
	
	$privilageId    =   $_COOKIE['privillegeId'];
	$branchId       =   $_COOKIE['branchId'];
if(isset($_POST['barcode']))
{
	$barcode			=	$_POST['barcode'];	
	
	$result	=	$objsalesInvoice->checkBarcodeAvailable($barcode);
	if($result==0){
		$data			=	'1';
    }
	else{
		$data			=	'0';
    }
	echo $data;
}
?>