<?php
	
	
		 $categoryId 		= $_POST['categoryId'];	
		$table='';		
		$j_array = array();

	$array   = array();
		$categoryList  = '<option value="">Select</opion>';
		require_once('../../../../modules/itemMaster/admin/models/Itemmastermodel.php');
	$objItemmastermodel=new Itemmastermodel();

		$updateCategorys=$objItemmastermodel->getSubcategory($categoryId);
		while($updateCategoryResult=mysqli_fetch_array($updateCategorys))
			{
				$categoryList	.='<option value="'.$updateCategoryResult['subCategoryId'].'">'.$updateCategoryResult['subCategoryName'].'</option>';
			 
	
	}
	
		
		$array['subcategoryList'] =$categoryList;
		echo json_encode($array);
	   
	
	   
	 
?>
