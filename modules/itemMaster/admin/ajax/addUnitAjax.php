<?php

	if(isset($_POST['unitName'])){
		$unitName = $_POST['unitName'];	
		
		require_once('../../../../modules/addUnit/admin/models/addUnitModel.php');
	
		$objaddUnitModel=new addUnitModel();
		$noOfRows=$objaddUnitModel->nameDuplication($unitName);
		if($noOfRows==0)
		{
		$unitInsert  =$objaddUnitModel->insertUnitDetails($unitName);
		}
		 
		 require_once('../../../../modules/itemMaster/admin/controller/ItemMasterController.php');
		$objItemMasterController=new ItemMasterController();
		$allUnits=$objItemMasterController->getAllUnit(); 
		
		$unitSelectBox=null;
		$selected=null;
		$unitSelectBox .= '<option value="">Select</option>';
		while($fetch_rowsOfUnits= mysqli_fetch_array($allUnits)){
			if($unitInsert==$fetch_rowsOfUnits['unitId']){
				$selected='selected';
			}else{
				$selected=null;
			}
		$unitSelectBox .= '<option value="'.$fetch_rowsOfUnits['unitId'].'">'.$fetch_rowsOfUnits['unitName'].'</option>';
		}
		echo $unitSelectBox;
	}
	
	if(isset($_POST['allUnit'])){
		 require_once('../../../../modules/itemMaster/admin/controller/ItemMasterController.php');
		$objItemMasterController=new ItemMasterController();
		$allUnits=$objItemMasterController->getAllUnit(); 
		$unitSelectBox=null;
		$unitSelectBox .= '<option value="">Select</option>';
		while($fetch_rowsOfUnits= mysqli_fetch_array($allUnits)){
		$unitSelectBox .= '<option value="'.$fetch_rowsOfUnits['unitId'].'">'.$fetch_rowsOfUnits['unitName'].'</option>';
		}
		echo $unitSelectBox;
	}
	   
	
	   
	 
?>
