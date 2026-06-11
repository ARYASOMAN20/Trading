<?php
	$unitId 		= $_POST['unitId'];
	$unitName 	    = $_POST['unitName'];
require_once('../../../../modules/addUnit/admin/models/addUnitModel.php');
	$objaddUnitModel=new addUnitModel();
	$noOfRows=$objaddUnitModel->nameDuplicationCheck($unitId,$unitName);
	if($noOfRows>0)
		 echo '1';
	   
	   else
		   echo '0';
	
?>