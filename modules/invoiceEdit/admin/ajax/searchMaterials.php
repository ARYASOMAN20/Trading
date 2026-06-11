<?php
require_once('../../../../modules/invoiceEdit/admin/models/invoiceEditmodel.php');
	$objsalesInvoice = new invoiceEditmodel();
	if(isset($_GET['term']))
	{
		$my_data	   			= $_GET['term'];
		$regularCustomerId		= $_GET['regularCustomerId'];
		$invoiceId				= $_GET['invoiceId'];
		if($invoiceId>0)
		{
			
		$branchDetails     		=	$objsalesInvoice->getBranchDetailsOfIncoice($invoiceId);
		while($row=mysqli_fetch_array($branchDetails))
		{
			$privilageId       	 	=   	$row['privilageId'];
			$branchId        		=   	$row['branchId'];
			$userId					=		$row['userId'];
			$mainBranch        		= 		$row['mainBranch'];
		}
		
		$resMaterialsList 		= $objsalesInvoice->getMaterialsForAutoComplete($my_data,$regularCustomerId,$privilageId,$branchId);
		if($resMaterialsList)
		{
			$j_array=array();

			while($row = mysqli_fetch_array($resMaterialsList))
			{
				$expiryDateDb			=	$row['expiryDate'];
				if($expiryDateDb=='' || $expiryDateDb==null || $expiryDateDb=='0000-00-00')
				{
					$expiryDate			= null;
				}else{
					$expiryDate				=	date_format(date_create($expiryDateDb),"d-m-Y");
				}
				$array['value'] 		= 	$row['itemCode'].'('.$row['itemName'].')'.'('.$expiryDate.')('.$row['stockValue'].')';
				$array['itemCode']  	= 	$row['itemCode'];
				$array['itemName']   	= 	$row['itemName'];
				$array['key']  		 	= 	$row['itemMasterId'];
				$array['packing']	 	=	$row['packing'];
				$array['sellingPrice']	=	$row['maxretailPrice'];
				$array['vat']	        =	$row['vat'];
				$array['stockId']	    =	$row['stockId'];
				$array['importLocalStatus']	    =	$row['importLocalStatus'];
				$array['customerItemId']	=	0; 	
				$array['expiryDateDb']	=   $row['expiryDate'];		
				$array['stockValue']	=   $row['stockValue'];	
				$array['minimumRate']	=   $row['minimumRate'];
				array_push($j_array,$array);
			}

		 }
		}

	echo json_encode($j_array);
	}

?>
