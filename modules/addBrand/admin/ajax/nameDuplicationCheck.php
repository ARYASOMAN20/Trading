<?php
	$brandId 		= $_POST['brandId'];
	$brandName 	    = $_POST['brandName'];
require_once('../../../../modules/addBrand/admin/models/addBrandModel.php');
	$objaddCategoryModel=new addBrandModel();
	$noOfRows=$objaddCategoryModel->nameDuplicationCheck($brandId,$brandName);
	if($noOfRows>0)
		 echo '1';
	   
	   else
		   echo '0';
	
?>