
<?php
require_once("../../../../settings/connect_db.php");
class addUnitModel
{
	public function unitList()
	{
		global $con;
		$query="SELECT *
				FROM unit WHERE status=1";
				
				
	 	$unitList=mysqli_query($con,$query);
	 	return $unitList;
	}
	
	
	public function insertUnitDetails($unitName)
	{
		global $con;
		$query="INSERT INTO  unit(unitName) VALUES('$unitName')";
		$set=mysqli_query($con,$query);
		return mysqli_insert_id($con);
	}
	
	public function update_Unit($unitId)
	{
		global $con;
		$query='SELECT * FROM unit WHERE unitId="'.$unitId.'"';
	 	$update_Unit=mysqli_query($con,$query);
	 	return $update_Unit;
	}
	
	public function update_UnitList($unitId,$unitName)
	{
	 	global $con;
		$query='update unit set unitName="'.$unitName.'" where unitId="'.$unitId.'"';
		$set=mysqli_query($con,$query);
	}
	
	
	
	public function deleteUnit($unitId)
	{
	 	global $con;
		$query='update unit set status=0 where unitId="'.$unitId.'"';
		$set=mysqli_query($con,$query);
	}
	
	
	public function nameDuplication($unitName)
	{
		global $con;
		$query ='SELECT unitName
			FROM  unit
			WHERE unitName="'.$unitName.'" AND status=1';
			
	    $result  = mysqli_query($con,$query);
		return mysqli_num_rows($result);
		
	}
	
	public function nameDuplicationCheck($unitId,$unitName)

	{

		global $con;

		$query  = "SELECT unitName FROM unit WHERE unitName='".$unitName."' AND unitId!='".$unitId."' AND status=1 "  ;

		 $result  = mysqli_query($con,$query);
		return mysqli_num_rows($result);
		
	}
	
}
?>