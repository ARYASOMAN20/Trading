<?php
	
	require_once("../../../../modules/salesReturnCounterSale/admin/models/SalesReturnItemWiseM.php");
	$SalesReturnItemWiseM = new SalesReturnItemWiseM();
	
	if(isset($_GET['term']))
	{
		$my_data	   			= $_GET['term'];
		$regularCustomerId		= $_GET['regularCustomerId'];
		if(isset($_COOKIE['privillegeId'])) {
		$privilageId       	 	=  	$_COOKIE['privillegeId'];
		$branchId        		=  	$_COOKIE['branchId'];
		$userId					= 	$_COOKIE['userId'];
		}
		else{
			$privilageId       	 	=  6;
			$branchId        		=  5;
			$userId					=  '';
		}
		$resMaterialsList 		= 	$SalesReturnItemWiseM->getMaterialsForAutoComplete($my_data,$regularCustomerId,$privilageId,$branchId);
		
		if($resMaterialsList)
		{
		$j_array=array();

		while($row = mysqli_fetch_array($resMaterialsList))
		{
			$expiryDate	 = 	$expiryDateDb=null;
			$expiryDateDb			=	$row['expiryDate'];
			if($expiryDateDb!=null or $expiryDateDb!='0000-00-00'){
			$expiryDate				=	implode("-",array_reverse(explode('-',$expiryDateDb)));
			}else{
				$expiryDate	=null;
			}
			
			$array['value'] 		= 	$row['itemCode'].'('.$row['itemName'].')'.'('.$expiryDate.')';
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
			$array['stockValue']			=	 $row['stockValue'];	
			$array['minimumRate']			=	 $row['minimumRate'];	

			array_push($j_array,$array);
		}

	}

	echo json_encode($j_array);
	}

?>
