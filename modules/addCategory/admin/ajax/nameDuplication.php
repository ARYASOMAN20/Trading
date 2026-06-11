<?php
	$categoryName = $_GET['categoryName'];	
require_once('../../../../modules/addCategory/admin/models/addCategoryModel.php');
		$objaddCategoryModel=new addCategoryModel();
	   $noOfRows=$objaddCategoryModel->nameDuplication($categoryName);
	   if($noOfRows>0)
		 echo '1';
	   
	   else
		   echo '0';
	   
	 
?>
