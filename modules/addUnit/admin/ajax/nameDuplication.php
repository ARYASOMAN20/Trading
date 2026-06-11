<?php
	$unitName = $_GET['unitName'];	
require_once('../../../../modules/addUnit/admin/models/addUnitModel.php');
	$objaddUnitModel=new addUnitModel();
	   $noOfRows=$objaddUnitModel->nameDuplication($unitName);
	   if($noOfRows>0)
		 echo '1';
	   
	   else
		   echo '0';
	   
	 
?>
