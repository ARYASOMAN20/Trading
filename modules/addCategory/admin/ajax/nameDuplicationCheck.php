<?php
	$categoryId 		= $_POST['categoryId'];
	$categoryName 	    = $_POST['categoryName'];
require_once('../../../../modules/addCategory/admin/models/addCategoryModel.php');
	$objaddCategoryModel=new addCategoryModel();
	$noOfRows=$objaddCategoryModel->nameDuplicationCheck($categoryId,$categoryName);
	if($noOfRows>0)
		 echo '1';
	   
	   else
		   echo '0';
	
?>