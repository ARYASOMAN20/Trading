<?php
require_once('../../../../modules/deliveryNode/admin/models/Deliverynodemodel.php');
$objDeliverynodemodel	= 	new Deliverynodemodel();
if(isset($_GET['term']))
{
		
$searchTerm	   		= $_GET['term'];
$regularCustomerId	= $_GET['regularCustomerId'];
$resItemCode= $objDeliverynodemodel->getItemCode($searchTerm,$regularCustomerId);
if($resItemCode)
	{
		$j_array=array();

		while($row = mysqli_fetch_array($resItemCode))
		{
				$selectBox=null;
				$array['value'] 		= 	$row['customerItemCode'];
				$array['itemMasterId']  = 	$row['companyItemCodeId'];
				$array['itemName']		= 	$row['description'];
				$array['companyItemCode'] = 	$row['companyItemCode'];
				$array['customerItemId']  = 	$row['customerItemId'];
				$array['customerItemCode']= 	$row['customerItemCode'];
				$array['packingSize']	=	$row['packingSize'];	
				$array['sellingPrice']	=	$row['sellingPrice'];
$allUnit=$objDeliverynodemodel->getMaterialsUnitAutoComplete($row['companyItemCodeId']);

while($units = mysqli_fetch_array($allUnit)){
	$selectBox .='<option value="'.$units['itemUnitId'].'/'.$units['multiple'].'">'.$units['unitName'].'</option>';
}	
			$array['allUnits']	=	$selectBox;
			
			array_push($j_array,$array);
		}

	}

	echo json_encode($j_array);
}

?>