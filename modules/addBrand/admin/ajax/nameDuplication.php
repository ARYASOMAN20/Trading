<?php
	$brandName = $_GET['brandName'];	
 require_once('../../../../modules/addBrand/admin/models/addBrandModel.php');
				$addBrandModel=new addBrandModel();
	   $noOfRows=$addBrandModel->nameDuplication($brandName);
	   if($noOfRows>0)
	   {
		   echo '1';
	   }
	   else{
		   echo '0';
	   }
	
?>
