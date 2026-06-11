<?php


require_once('../../../../modules/addCategory/admin/models/addCategoryModel.php');

class addCategoryController
{
	
	public function CategoryList()
	{
	
		$objaddCategoryModel=new addCategoryModel();
		$categoryInsert  =$objaddCategoryModel->CategoryList();
		return $categoryInsert;
	
	}
	
	public function insertCategoryDetails($categoryName,$remarks,$categoryNameArabic)
	{
	
		$objaddCategoryModel=new addCategoryModel();
		$categoryInsert  =$objaddCategoryModel->insertCategoryDetails($categoryName,$remarks,$categoryNameArabic);
		return $categoryInsert;
	
	}
	public function updateCategory($categoryId)
	{
		$objaddCategoryModel=new addCategoryModel();
		$update_Categorys=$objaddCategoryModel->update_Category($categoryId);
		return $update_Categorys;
	}
	public function update_CategoryList($categoryId,$categoryName,$remarks,$categoryNameArabicEdit)
	{
		$objaddCategoryModel=new addCategoryModel();
		$updateAccountHead=$objaddCategoryModel->update_CategoryList($categoryId,$categoryName,$remarks,$categoryNameArabicEdit);
		return $updateAccountHead;
	}
	
	
	public function deleteCategory($categoryId)
	{
		$objaddCategoryModel=new addCategoryModel();
		$delete_Categorys=$objaddCategoryModel->deleteCategory($categoryId);
		return $delete_Categorys;
	}
}

?>
