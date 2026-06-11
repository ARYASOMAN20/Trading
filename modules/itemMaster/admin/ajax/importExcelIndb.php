<?php
    require_once ('../../../../modules/deliveryNode/admin/ajax/SimpleXLSX.php');
	require_once('../../../../modules/itemMaster/admin/models/Itemmastermodel.php');
	$objItemmastermodel=new Itemmastermodel();
	
	$itemCode=$itemNameArabic=$packigSize=$unit=$baseUnit=$fraction=$quantity='';
	
	$filesop=$selectBoxUnit=''; 

 if ( $xlsx = SimpleXLSX::parse($_FILES['file']['tmp_name']) ) {
    
    	$filesop=$xlsx->rows();
    	$section = '';
		for($i=1;$i<count($filesop);$i++){
		    $itemCode       = $filesop[$i][0];
		    $itemName       = $filesop[$i][1];
		    $catogory       = $filesop[$i][2];
		    $costPrice      = $filesop[$i][3]; 
		    $maxretailPrice = $filesop[$i][4];
            $baseunit       = $filesop[$i][5];
		
			$checkCompanyItemCodeDuplication=$objItemmastermodel->checkDuplication($itemCode);
			if($checkCompanyItemCodeDuplication==0){
				$catogoryId  = $objItemmastermodel->getCategoryId($catogory);
			$currencyData  =	$objItemmastermodel->insertExcelDatas($itemCode,$itemName,
			$catogoryId,$costPrice,$maxretailPrice);
			if($baseunit!=''){ 
				$unitId  = $objItemmastermodel->getUnitId($baseunit);
				if($unitId!=''){
					$insertItemUnit = $objItemmastermodel->instItemUnit($unitId,$currencyData);
			
				}
			}
			/*if($unit!=''){
				$unitId1  = $objItemmastermodel->getUnitId($unit);
				if($unitId1!=''){
					$insertItemUnit = $objItemmastermodel->instotherItemUnit($unitId1,$currencyData,$multiple);
			
				}
			}*/
			$unitId2=10;
			$insertItemUnit = $objItemmastermodel->instotherItemUnit($unitId2,$currencyData,0);
		}
		}
	echo 1;
		
	}
	
?>