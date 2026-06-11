<?php

	$partNo = $_GET['partNo'];	

 require_once('../../../../modules/itemMaster/admin/models/Itemmastermodel.php');
$objItemmastermodel=new Itemmastermodel();

	  $checkCompanyItemCodeDuplication=$objItemmastermodel->checkDuplication($partNo);

	   if($checkCompanyItemCodeDuplication>0)

	   {

		   echo 1;

	   }

	   else{

		   echo 0;

	   }

	

?>

