<?php

	$partNo = $_POST['partNo'];	
	$itemMasterId = $_POST['itemMasterIdEdit'];	

 require_once('../../../../modules/itemMaster/admin/models/Itemmastermodel.php');
$objItemmastermodel=new Itemmastermodel();

	  $checkCompanyItemCodeDuplication=$objItemmastermodel->checkDuplicationEdit($partNo,$itemMasterId);

	   if($checkCompanyItemCodeDuplication>0)

	   {

		   echo 1;

	   }

	   else{

		   echo 0;

	   }

	

?>