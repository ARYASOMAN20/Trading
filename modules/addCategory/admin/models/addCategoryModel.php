
<?php
require_once("../../../../settings/connect_db.php");
class addCategoryModel
{
	public function CategoryList()
	{
		global $con;
		$query="SELECT *
				FROM category WHERE status=1";
				
				
	 	$CategoryList=mysqli_query($con,$query);
	 	return $CategoryList;
	}
	
	
	public function insertCategoryDetails($categoryName,$remarks,$categoryNameArabic)
	{
		global $con;
		$query="INSERT INTO  category(categoryName,remarks,categoryNameArabic) VALUES('$categoryName','$remarks','$categoryNameArabic')";
		$set=mysqli_query($con,$query);
		return mysqli_insert_id($con);
		
	}
	
	public function update_Category($categoryId)
	{
		global $con;
		$query='SELECT * FROM category WHERE categoryId="'.$categoryId.'"';
	 	$update_Category=mysqli_query($con,$query);
	 	return $update_Category;
	}
	
	public function update_CategoryList($categoryId,$categoryName,$remarks,$categoryNameArabicEdit)
	{
	 	global $con;
		$query='update category set categoryName="'.$categoryName.'",remarks="'.$remarks.'",categoryNameArabic="'.$categoryNameArabicEdit.'" where categoryId="'.$categoryId.'"';
		$set=mysqli_query($con,$query);
	}
	
	
	
	public function deleteCategory($categoryId)
	{
	 	global $con;
		$query='update category set status=0 where categoryId="'.$categoryId.'"';
		$set=mysqli_query($con,$query);
	}
	
	
	public function nameDuplication($categoryName)
	{
		global $con;
		$query ='SELECT categoryName
			FROM  category
			WHERE categoryName="'.$categoryName.'" AND status=1';
			
	    $result  = mysqli_query($con,$query);
		return mysqli_num_rows($result);
		
	}
	
	public function nameDuplicationCheck($categoryId,$categoryName)

	{

		global $con;

		$query  = "SELECT categoryName FROM category WHERE categoryName='".$categoryName."'AND NOT(categoryId='".$categoryId."') AND status=1 "  ;

		 $result  = mysqli_query($con,$query);
		return mysqli_num_rows($result);
		
	}
	
}
?>