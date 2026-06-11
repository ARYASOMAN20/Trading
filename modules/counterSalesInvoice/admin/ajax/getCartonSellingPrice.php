<?php
	
	require_once("../../../../modules/salesInvoice/admin/models/m_salesInvoice.php");
	$objMSalesInvoice	= 	new M_salesInvoice();
	if(isset($_POST['itemMasterId']))
	{
		$itemMasterId	   		= $_POST['itemMasterId'];
		$cartonPrice			=	'';
	
	$priceDeta	=	$objMSalesInvoice->getItemCartonPrice($itemMasterId);
	while($row1 = mysqli_fetch_array($priceDeta))
		{
			$cartonPrice	=	$row1['maxretailPrice'];
		}
		
		
		if($cartonPrice==null||$cartonPrice==0)
		{
			$unitPrice		=	null;
		}else{
			$unitPrice		=	number_format($cartonPrice, 2, '.', '');
		}
	echo $unitPrice;
	}


?>