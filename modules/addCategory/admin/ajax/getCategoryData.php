<?php
	
	
		$categoryId 		= $_POST['rowid'];	
		$table='';		
		$j_array = array();

	$array   = array();
		
		require_once('../../../../modules/addCategory/admin/controllers/addCategoryController.php');
		$addCategoryController=new addCategoryController();

	

		$updateCategorys=$addCategoryController->updateCategory($categoryId);
		while($updateCategoryResult=mysqli_fetch_array($updateCategorys))
			{
				$array['categoryId'] =$updateCategoryResult['categoryId'];
				$array['categoryName'] =$updateCategoryResult['categoryName'];
				$array['remarks'] =$updateCategoryResult['remarks'];
				$array['categoryNameArabic'] =$updateCategoryResult['categoryNameArabic'];
			 
	
	}
		echo json_encode($array);
	   
	
	   
	 
?>
