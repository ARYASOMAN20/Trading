<?php


require_once('../../../../modules/addSubCategory/admin/models/addSubCategoryModel.php');

class addCategoryController
{
	
	public function listSubcategory()
	{
	
		$objaddCategoryModel=new addCategoryModel();
		$categoryInsert  =$objaddCategoryModel->listSubcategory();
		return $categoryInsert;
	
	}
	
	public function insertCategoryDetails($categoryName,$subcategoryName,$subcategoryNameArabic)
	{
	
		$objaddCategoryModel=new addCategoryModel();
		$categoryInsert  =$objaddCategoryModel->insertCategoryDetails($categoryName,$subcategoryName,$subcategoryNameArabic);
		return $categoryInsert;
	
	}
	public function updateCategory($subCategoryId)
	{
		$objaddCategoryModel=new addCategoryModel();
		$update_Categorys=$objaddCategoryModel->update_Category($subCategoryId);
		return $update_Categorys;
	}
	public function update_CategoryList($categoryId,$subCategoryId,$subCategoryName,$subcategoryNameArabicEdit)
	{
		$objaddCategoryModel=new addCategoryModel();
		$updateAccountHead=$objaddCategoryModel->update_CategoryList($categoryId,$subCategoryId,$subCategoryName,$subcategoryNameArabicEdit);
		return $updateAccountHead;
	}
	
	
	public function deleteCategory($subCategoryId)
	{
		$objaddCategoryModel=new addCategoryModel();
		$delete_Categorys=$objaddCategoryModel->deleteCategory($subCategoryId);
		return $delete_Categorys;
	}
	
	public function getCategoryName()
	{
		$objaddCategoryModel=new addCategoryModel();
		$listCategory=$objaddCategoryModel->CategoryList();
		$categoryList  = '<option value="">Select</opion>';
		while($vesselDataRow	=	mysqli_fetch_array($listCategory))
		{
			$categoryList	.='<option value="'.$vesselDataRow['categoryId'].'">'.$vesselDataRow['categoryName'].'</option>';
		}
		return $categoryList;
	}
}

?>
