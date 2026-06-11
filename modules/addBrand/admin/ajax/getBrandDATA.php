<?php
	
	
		$brandId 		= $_POST['rowid'];	
		$table='';		
		$j_array = array();
 
	$array   = array();
		
		require_once('../../../../modules/addBrand/admin/controllers/addBrandController.php');
		$addBrandController=new addBrandController();

	

		$updateBrands=$addBrandController->updateBrand($brandId);
		while($updateBrandResult=mysqli_fetch_array($updateBrands)) 
			{
				$array['brandId']     =$updateBrandResult['brandId'];
				$array['brandCode']   =$updateBrandResult['brandCode'];
				$array['brandName']   =$updateBrandResult['brandName'];
			 
	
	}
		echo json_encode($array);
	   
	   
	
	   
	 
?>
