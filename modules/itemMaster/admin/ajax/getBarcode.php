<?php
	
	
		$categoryId 		= $_POST['categoryId'];	
				
		
		$brandInsertId='';
		require_once('../../../../modules/itemMaster/admin/models/Itemmastermodel.php');
		$Itemmastermodel=new Itemmastermodel();
		
		$barcode  =$Itemmastermodel->getMaxBarcodeNo($categoryId);
	  
		
		echo $barcode;
	   
	 
?>
