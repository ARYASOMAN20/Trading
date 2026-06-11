<?php

$invoiceNo  =$vendorId =$invoiceCount='';
$invoiceNo  = $_POST['invoiceNo'];
$vendorId = $_POST['vendorId'];

require_once("../../../../modules/purchase/admin/class/m_purchase.php");
$objMPurchase           =   new M_Purchase();
$invoiceCount 			= 	$objMPurchase->checkInvoiceNoExistOrNot($invoiceNo,$vendorId);
if($invoiceCount>0){
    echo '1';
}else{
    echo '0';
}

?>

