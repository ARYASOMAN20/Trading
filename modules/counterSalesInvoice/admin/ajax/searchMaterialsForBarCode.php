<?php	

require_once("../../../../modules/counterSalesInvoice/admin/models/m_salesInvoice.php");
$objsalesInvoice = new M_salesInvoice();


	if(isset($_POST['barcode']))
	{
		$my_data	   			= $_POST['barcode'];
		$regularCustomerId		= '';
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$branchId        		=   	$_COOKIE['branchId'];
		$userId					=		$_COOKIE['userId'];
		$resMaterialsList 		= $objsalesInvoice->getMaterialsForBarcode($my_data,$regularCustomerId,$privilageId,$branchId);
		if($resMaterialsList)
	{
		$j_array=array();

		$value=$itemCode=$itemName=$key=$packing=$sellingPrice=$vat=$stockId=$importLocalStatus=$customerItemId=$stockValue=$minimumRate=$expiryDateDb=null;

		while($row = mysqli_fetch_array($resMaterialsList))
		{
			$stock					=   $row['stockValue'];	
			$expiryDateDb			=	$row['expiryDate'];
			if($expiryDateDb=='' || $expiryDateDb==null || $expiryDateDb=='0000-00-00')
			{
				$expiryDate			= null;
			}else{
				$expiryDate				=	date_format(date_create($expiryDateDb),"d-m-Y");
			}
			

			$value				= 	$row['itemCode'].'('.$row['itemName'].')'.'('.$expiryDate.')'.'('.$stock.')';
			$itemCode  			= 	$row['itemCode'];
			$itemName  			= 	$row['itemName'];
			$key 		 		= 	$row['itemMasterId'];
			$packing 			=	$row['packing'];
			$sellingPrice		=	$row['maxretailPrice'];
			$vat       			=	$row['vat'];
			$stockId	    	=	$row['stockId'];
			$importLocalStatus	    =	$row['importLocalStatus'];
            $customerItemId		=	0; 	
            $expiryDateDb		=   $row['expiryDate'];		
            $stockValue			=   $row['stockValue'];		
            $minimumRate		=   $row['minimumRate'];
			



			
		}

	}

	$currencyArray = array('value' =>$value,'itemCode'=>$itemCode,'itemName'=>$itemName,'key'=>$key,'packing'=>$packing,
	'sellingPrice'=>$sellingPrice,'vat'=>$vat,'customerItemId'=>$customerItemId,'stockId'=>$stockId,'importLocalStatus'=>$importLocalStatus,'expiryDateDb'=>$expiryDateDb,'stockValue'=>$stockValue,'minimumRate'=>$minimumRate);

	echo json_encode($currencyArray);


	
	
	}

?>
