
<?php
require_once("../../../../settings/connect_db.php");
class addBrandModel
{
	public function brandList()
	{
		global $con;
		$query="SELECT *
				FROM brand WHERE status=1";
				
				
	 	$brandList=mysqli_query($con,$query);
	 	return $brandList;
	}
	 
	
	public function insertBrandDetails($brandCode,$brandName,$brandFormat)
	{
		global $con;
		$query="INSERT INTO  brand(brandCode,brandName,brandFormat) VALUES('$brandCode','$brandName','$brandFormat')";
		$set=mysqli_query($con,$query);
		return mysqli_insert_id($con);
	}
	
	public function updateBrand($brandId)
	{
		global $con;
		$query='SELECT * FROM brand WHERE brandId="'.$brandId.'"';
	 	$update_Category=mysqli_query($con,$query);
	 	return $update_Category;
	}
	
	public function update_BrandList($brandId,$brandCode,$brandName,$brandFormat)
	{
	 	global $con;
		$query='update brand set brandCode="'.$brandCode.'",brandName="'.$brandName.'",brandFormat="'.$brandFormat.'" where brandId="'.$brandId.'"';
		$set=mysqli_query($con,$query);
	}
	
	
	
	public function deleteBrand($brandId)
	{
	 	global $con;
		$query='update brand set status=0 where brandId="'.$brandId.'"';
		$set=mysqli_query($con,$query);
	}
	
	public function nameDuplication($brandCode)
	{
		global $con;
		$query ='SELECT brandCode
			FROM  brand
			WHERE brandCode="'.$brandCode.'"';
			
	    $result  = mysqli_query($con,$query);
		return mysqli_num_rows($result);
		
	}
	
	public function nameDuplicationCheck($brandId,$brandCode)

	{

		global $con;

		$query  = "SELECT brandCode FROM brand WHERE brandCode='".$brandCode."' AND brandId!='".$brandId."' AND status=1 "  ;

		 $result  = mysqli_query($con,$query);
		return mysqli_num_rows($result);
		
	}
	
}
?>