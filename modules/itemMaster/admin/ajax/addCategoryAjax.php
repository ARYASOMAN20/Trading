<?php
	
	if(isset($_POST['categoryName'])){
		$categoryName = $_POST['categoryName'];	
		$categoryRemarks = $_POST['categoryRemarks'];	
		require_once('../../../../modules/addCategory/admin/models/addCategoryModel.php');	
	
		$objaddCategoryModel=new addCategoryModel();
		$categoryInsert  =$objaddCategoryModel->insertCategoryDetails($categoryName,$categoryRemarks);
		 
		 require_once('../../../../modules/itemMaster/admin/controller/ItemMasterController.php');
		$objItemMasterController=new ItemMasterController();
		$allCategory=$objItemMasterController->getAllCategory();
		$categorySelectBox=null;
		$selected=null;
		$categorySelectBox .= '<option value="">Select</option>';
		while($fetch_rowsOfCategory= mysqli_fetch_array($allCategory)){
			if($categoryInsert==$fetch_rowsOfCategory['categoryId']){
				$selected='selected';
			}else{
				$selected=null;
			}
		$categorySelectBox .= '<option value="'.$fetch_rowsOfCategory['categoryId'].'" '.$selected.'>'.$fetch_rowsOfCategory['categoryName'].'</option>';
			}
			
			echo $categorySelectBox;
	}
	
	if(isset($_POST['allCategory'])){
		 require_once('../../../../modules/itemMaster/admin/controller/ItemMasterController.php');
		$objItemMasterController=new ItemMasterController();
		$allCategory=$objItemMasterController->getAllCategory();
		$categorySelectBox=null;
		
		$categorySelectBox .= '<option value="">Select</option>';
		while($fetch_rowsOfCategory= mysqli_fetch_array($allCategory)){
		$categorySelectBox .= '<option value="'.$fetch_rowsOfCategory['categoryId'].'" >'.$fetch_rowsOfCategory['categoryName'].'</option>';
			}
			
			echo $categorySelectBox;
	}
	   
	 function getAllCategory($value){
		 require_once('../../../../modules/itemMaster/admin/controller/ItemMasterController.php');
		$objItemMasterController=new ItemMasterController();
		$allCategory=$objItemMasterController->getAllCategory();
		$categorySelectBox=null;
		$selected=null;
		
		while($fetch_rowsOfCategory= mysqli_fetch_array($allCategory)){
		$categorySelectBox .= '<option value="'.$fetch_rowsOfCategory['categoryId'].'" '.$selected.'>'.$fetch_rowsOfCategory['categoryName'].'</option>';
			}
			
			return $categorySelectBox;
	 }
	   
	 
?>
