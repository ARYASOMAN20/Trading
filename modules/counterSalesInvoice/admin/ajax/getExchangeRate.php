<?php
	require_once("../../../../modules/salesInvoice/admin/models/m_salesInvoice.php");
	$objsalesInvoice = new M_salesInvoice();
	if(isset($_POST['currencyId']))
	{
		$currencyData		=	$_POST['currencyId'];
		$currencyArray		=	explode('/',$currencyData);
		$currencyId			=	$currencyArray[0];
		$exRate				=	$objsalesInvoice->getExchangeRate($currencyId);
		
		echo $exRate;
		
	}
?>		
		
		