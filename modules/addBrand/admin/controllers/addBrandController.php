<?php


require_once('../../../../modules/addBrand/admin/models/addBrandModel.php');

class addBrandController
{
	
	public function brandList()
	{
	
		$addBrandModel=new addBrandModel();
		$categoryInsert  =$addBrandModel->brandList();
		return $categoryInsert;
	
	}
	
	public function insertBrandDetails($brandCode,$brandName,$brandFormat)
	{
	
		$addBrandModel=new addBrandModel();
		$categoryInsert  =$addBrandModel->insertBrandDetails($brandCode,$brandName,$brandFormat);
		return $categoryInsert;
	
	}
	public function updateBrand($brandId)
	{
		$addBrandModel=new addBrandModel();
		$updateBrand=$addBrandModel->updateBrand($brandId);
		return $updateBrand;
	}
	public function update_BrandList($brandId,$brandCode,$brandName,$brandFormat)
	{
		$addBrandModel=new addBrandModel();
		$updateAccountHead=$addBrandModel->update_BrandList($brandId,$brandCode,$brandName,$brandFormat);
		return $updateAccountHead;
	}
	
	
	public function deleteBrand($brandId)
	{
		$addBrandModel=new addBrandModel();
		$delete_Categorys=$addBrandModel->deleteBrand($brandId);
		return $delete_Categorys;
	}
}

?>
