<?php
	require_once("../../../../modules/purchase/admin/class/m_purchase.php");
	$objMPurchase = new M_Purchase();
	if(isset($_GET['term']))
	{
		$my_data	   		= $_GET['term'];
		$resMaterialsList 	= $objMPurchase->getMaterialsForAutoComplete($my_data);
		if($resMaterialsList)
	{
		$j_array=array();

		while($row = mysqli_fetch_array($resMaterialsList))
		{
			$array['value'] = 	$row['itemCode'].'('.$row['itemName'].')';
			$array['itemCode']   = 	$row['itemCode'];
			$array['itemName']   = 	$row['itemName'];
			$array['key']  		 = 	$row['itemMasterId'];
			if($row['vat']=='')
			    $row['vat'] = 0;
			$array['vat']		 =	$row['vat'];
			$array['packing']	 =	$row['packing'];
			$array['importLocalStatus']	 =	$row['importLocalStatus'];
			array_push($j_array,$array);
		}

	}

	echo json_encode($j_array);
	}

?>
