
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
	
	function listSubcategory(){
		global $con;
		$query="SELECT subCategory.*,category.categoryName
				FROM subCategory
				INNER JOIN category ON category.categoryId=subCategory.categoryId
				WHERE subCategory.status=1";
				
				
	 	$CategoryList=mysqli_query($con,$query);
	 	return $CategoryList;
		
	}
	
	
	public function insertCategoryDetails($categoryName,$subcategoryName,$subcategoryNameArabic)
	{
		global $con;
		$query="INSERT INTO  subCategory(categoryId,subCategoryName,subCategoryNameArabic) VALUES('$categoryName','$subcategoryName','$subcategoryNameArabic')";
		$set=mysqli_query($con,$query);
	    $id =	mysqli_insert_id($con);
	   $itemCode = $id.'00000000';
	    $query = "INSERT INTO itemMaster(SubcategoryId,itemCode,status)VALUES('$id','$itemCode',0)";
        $result  = mysqli_query($con,$query);
	    
		return $id;
		
	}
	
	public function update_Category($subCategoryId)
	{
		global $con;
		$query='SELECT * FROM subCategory WHERE subCategoryId="'.$subCategoryId.'"';
	 	$update_Category=mysqli_query($con,$query);
	 	return $update_Category;
	}
	
	public function update_CategoryList($categoryId,$subCategoryId,$subCategoryName,$subcategoryNameArabicEdit)
	{
	 	global $con;
		$query='update subCategory set categoryId="'.$categoryId.'",subCategoryName="'.$subCategoryName.'",subCategoryNameArabic="'.$subcategoryNameArabicEdit.'" where subCategoryId="'.$subCategoryId.'"';
		$set=mysqli_query($con,$query);
	}
	
	
	
	public function deleteCategory($subCategoryId)
	{
	 	global $con;
		$query='update subCategory set status=0 where subCategoryId="'.$subCategoryId.'"';
		$set=mysqli_query($con,$query);
	}
	
	
	public function nameDuplication($subcategoryName,$categoryId)
	{
		global $con;
		$query ='SELECT subCategoryName
			FROM  subCategory
			WHERE subCategoryName="'.$subcategoryName.'" and categoryId="'.$categoryId.'" AND status=1';
			
	    $result  = mysqli_query($con,$query);
		return mysqli_num_rows($result);
		
	}
	
	public function nameDuplicationCheck($subCategoryName,$categoryId,$subCategoryId)

	{

		global $con;
 
		$query  = "SELECT subCategoryName FROM subCategory WHERE subCategoryName='".$subCategoryName."' AND categoryId='".$categoryId."'  AND NOT(subCategoryId='".$subCategoryId."') AND status=1 "  ;

		 $result  = mysqli_query($con,$query);
		return mysqli_num_rows($result);
		
	}
	
}
?>