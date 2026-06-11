<?php
	
	
		$categoryId 		= $_POST['rowid'];	
		$table='';		
		$j_array = array();

	$array   = array();
		
		require_once('../../../../modules/addSubCategory/admin/models/addSubCategoryModel.php');
		$objaddCategoryModel=new addCategoryModel();
          require_once('../../../../modules/addSubCategory/admin/controllers/addSubCategoryController.php');
	   $addCategoryController=new addCategoryController();

		$updateCategorys=$addCategoryController->updateCategory($categoryId);
		while($updateCategoryResult=mysqli_fetch_array($updateCategorys))
			{
				$categoryId1 =$updateCategoryResult['categoryId'];
				
		
				$array['subCategoryName'] =$updateCategoryResult['subCategoryName'];
				$array['subCategoryId'] =$updateCategoryResult['subCategoryId'];
				$array['subCategoryNameArabic'] =$updateCategoryResult['subCategoryNameArabic'];
			 
	
	}
	$listCategory = $objaddCategoryModel->CategoryList();
				$categoryList  = '<option value="">Select</opion>';
		while($vesselDataRow	=	mysqli_fetch_array($listCategory))
		{
			if($vesselDataRow['categoryId']==$categoryId1)
				$selected = 'selected';
			  else 
				  $selected = '';
			$categoryList	.='<option value="'.$vesselDataRow['categoryId'].'" '.$selected.'>'.$vesselDataRow['categoryName'].'</option>';
		}
		$array['categoryList'] =$categoryList;
		echo json_encode($array);
	   
	
	   
	 
?>
