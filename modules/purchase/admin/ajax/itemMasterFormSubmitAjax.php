<?php
require_once('../../../../modules/itemMaster/admin/controller/ItemMasterController.php');
$objItemMasterController=new ItemMasterController();
	
		$categoryId=$brandId=$itemCode=$tittle=$vatPer=$location=$packingSize=$packingSizeArabic=$barcode =null;
		$wholeSalePrice=$maxRetailPrice=$agencyPrice=$minRetailPrice=$costPrice=$quantity=0;
		$baseUnitId=$unitId=$multiple=null;
		
		$barcode             =       $_POST['barcode'];
		$checkCompanyItemCodeDuplication=$objItemMasterController->checkDuplication($barcode);
		if($checkCompanyItemCodeDuplication==0){
			
		$privilageId        =   	$_COOKIE['privillegeId'];
		$branchId        	=   	$_COOKIE['branchId'];
		
		$categoryId			=		$_POST['categoryId'];
		$SubcategoryId      =       $_POST['SubcategoryId'];
		$brandId			=		$_POST['brandId'];
		$barcode            =       $_POST['barcode'];
		$tittle				=		$_POST['tittle'];
		$quantity			=		$_POST['quantity'];
		$reorderQty		    =		$_POST['reorderQty'];
		$location			=		$_POST['location'];
		$minimunQty         =       $_POST['minimunQty'];
		$maximunQty			=		$_POST['maximunQty'];
		$profitLevel		=		$_POST['profitLevel'];
		$description        =       $_POST['description'];
		$generateBarcode    =       '';
	    $country            =      $_POST['country'];
		$wholeSalePrice 	=		$_POST['wholeSalePrice'];
		$maxRetailPrice 	=		$_POST['maxRetailPrice'];
		$agencyPrice 		=		'';//$_POST['agencyPrice'];
		$minRetailPrice 	=		$_POST['minRetailPrice'];
		$costPrice 			=		$_POST['costPrice'];
	    $notes			    =		$_POST['note'];
		$vatPer				=		$_POST['vatPer'];
		$tittleArabic       =       $_POST['tittleArabic'];
		$importOrLocal      =       $_POST['importOrLocal'];
		/*if($privilageId==11){
		$expiryDate			=		$_POST['expiryDate'];
		$expiryDate			=		date_format(date_create($expiryDate),"Y-m-d");
		$manufacturingDate	=		$_POST['manufacturingDate'];
		$manufacturingDate	=		date_format(date_create($manufacturingDate),"Y-m-d");
		$batchNo			=		$_POST['batchNo'];
		}
		else{*/
		$expiryDate			=		null;	
		$manufacturingDate	=		null;	
		$batchNo			=	    '';
		//}
		
		$expiryDateQty			=		$_POST['expiryDate'];
		if($expiryDateQty=='' ||$expiryDateQty==null )
		{
			$expiryDateQty	=	null;
		}else{
			$expiryDateQty			=		date_format(date_create($expiryDateQty),"Y-m-d");
		}
		
		$stockDate			=		$_POST['stockDate'];
		if($stockDate=='' ||$stockDate==null )
		{
			$stockDate	=	null;
		}else{
			$stockDate			=		date_format(date_create($stockDate),"Y-m-d");
		}
		
		$baseUnitId			=		$_POST['baseUnit'];
		
		$unitId				=		$_POST['unitId'];
		$multiple			=		$_POST['multiple'];
	

	
		
		$itemMasterId		=	$objItemMasterController->insertIntoItemMaster($categoryId,$brandId,$barcode,$tittle,$quantity,$reorderQty,$location,
								$wholeSalePrice,$maxRetailPrice,$agencyPrice,$minRetailPrice,$costPrice,$notes,$maximunQty,$minimunQty,$profitLevel,$description,$generateBarcode,$vatPer,
								$expiryDate,$manufacturingDate,$batchNo,
								$baseUnitId,$unitId,$multiple,$branchId,$privilageId,$expiryDateQty,$SubcategoryId,$country,$tittleArabic,$importOrLocal,$stockDate);
	  
	 if($itemMasterId>0)
	 {
		 echo $itemMasterId;
	 }else{
		 echo 0;
	 }
	}else{
		echo 0;
	}
		

?>