<?php
	
	if(isset($_POST['brandName'])){
		$brandName 		= $_POST['brandName'];	
		$brandCode 	= $_POST['brandRemarks'];
		$brandFormat 	= $_POST['brandFormat'];			
		
		$brandInsertId='';
		require_once('../../../../modules/addBrand/admin/models/addBrandModel.php');
		$addBrandModel=new addBrandModel();
		require_once('../../../../modules/itemMaster/admin/controller/ItemMasterController.php');
		$objItemMasterController=new ItemMasterController();
      $noOfRows=$addBrandModel->nameDuplication($brandCode);
	   if($noOfRows==0){
		$brandInsertId  =$addBrandModel->insertBrandDetails($brandCode,$brandName,$brandFormat);
	   }
		 
		 $objItemMasterController=new ItemMasterController();
		$allBrands=$objItemMasterController->getAllBrand();
		$brandSelectBox=null;
		$brandSelectBox .= '<option value="">Select</option>';
		while($fetch_rowsOfBrands= mysqli_fetch_array($allBrands)){
			if($brandInsertId==$fetch_rowsOfBrands['brandId']){
				$selected='selected';
			}else{ 
				$selected='';
			}
		$brandSelectBox .= '<option value="'.$fetch_rowsOfBrands['brandId'].'" '.$selected.'>'.$fetch_rowsOfBrands['brandName'].'</option>';
		}
		echo $brandSelectBox;
	}
	
	if(isset($_POST['allBrand'])){
		 require_once('../../../../modules/itemMaster/admin/controller/ItemMasterController.php');
		$objItemMasterController=new ItemMasterController();
		$allBrands=$objItemMasterController->getAllBrand();
		$brandSelectBox=null;
		$brandSelectBox .= '<option value="">Select</option>';
		while($fetch_rowsOfBrands= mysqli_fetch_array($allBrands)){
		$brandSelectBox .= '<option value="'.$fetch_rowsOfBrands['brandId'].'">'.$fetch_rowsOfBrands['brandName'].'</option>';
		}
		echo $brandSelectBox;
	}
	   
	
	   
	 
?>
