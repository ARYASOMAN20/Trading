<?php


require_once('../../../../modules/addUnit/admin/models/addUnitModel.php');
	$objaddUnitModel=new addUnitModel();
	
class addUnitController
{
	
	public function unitList()
	{
	
		$objaddUnitModel=new addUnitModel();
		$UnitInsert  =$objaddUnitModel->unitList();
		return $UnitInsert;
	
	}
	
	public function insertUnitDetails($unitName)
	{
	
		$objaddUnitModel=new addUnitModel();
		$unitInsert  =$objaddUnitModel->insertUnitDetails($unitName);
		return $unitInsert;
	
	}
	public function update_Unit($unitId)
	{
		$objaddUnitModel=new addUnitModel();
		$update_Units=$objaddUnitModel->update_Unit($unitId);
		return $update_Units;
	}
	public function update_UnitList($unitId,$unitName)
	{
		$objaddUnitModel=new addUnitModel();
		$updateUnit=$objaddUnitModel->update_UnitList($unitId,$unitName);
		return $updateUnit;
	}
	
	
	public function deleteUnit($unitId)
	{
		$objaddUnitModel=new addUnitModel();
		$delete_Unit=$objaddUnitModel->deleteUnit($unitId);
		return $delete_Unit;
	}
}

?>
