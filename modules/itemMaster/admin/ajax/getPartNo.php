<?php
	
	
		$brandId 		= $_POST['brandId'];	
				
		
		$brandInsertId='';
		require_once('../../../../modules/itemMaster/admin/models/Itemmastermodel.php');
		$Itemmastermodel=new Itemmastermodel();
		
		$partNoList  =$Itemmastermodel->getBrandFormat($brandId);
	  
		 $brandFormat='';
		
		while($fetch_rowsOfBrands= mysqli_fetch_array($partNoList)){
			$brandFormat = $fetch_rowsOfBrands['brandFormat'];
		}
		echo $brandFormat;
	
	
	   
	
	   
	 
?>
