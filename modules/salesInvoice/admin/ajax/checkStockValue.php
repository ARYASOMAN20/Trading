<?php
require_once("../../../../modules/salesInvoice/admin/models/m_salesInvoice.php");
	$objMSalesInvoice	= 	new M_salesInvoice();
	
	$stockId		=	'';
	$neightWeight	=	'';
	$stock			=	'';
	$privilageId    =   $_COOKIE['privillegeId'];
	$branchId       =   $_COOKIE['branchId'];
if(isset($_POST['stockId']))
{
	$stockId			=	$_POST['stockId'];
	$neightWeight		=	$_POST['neightWeight'];
	
	$currentStockValue	=	$objMSalesInvoice->getCurrentStockValue($stockId);
	while($row=mysqli_fetch_array($currentStockValue))
	{
		$stockValue	=	$row['stockValue'];
	}
	//echo $neightWeight.'-'.$stockValue;
	if($neightWeight>$stockValue)
	{
		$stock			=	0;	
	}else{
		$stock			=	1;	
	}
	echo $stock.'-'.$stockValue;
}
?>