<?php
require_once("../../../../settings/connect_db.php");
class M_dispSyncData
{
	public function  getItemMasterDetailsTable($branchId)
	{
		global $con;
		$privilageId        =   	$_COOKIE['privillegeId'];
		if($privilageId==1 || $privilageId==12 || $branchId==2 || $branchId==3)
		{
					$query ="SELECT IM.itemMasterId,IM.itemCode,IM.itemName,IM.stock,IM.costPrice,IM.minretailsPrice,categoryName,subCategoryName,IM.branchId,U.unitName,S.stock_".$privilageId."_".$branchId." as stockBranch,S.expiryDate
					FROM  itemMaster IM
					LEFT JOIN category ON category.categoryId=IM.categoryId
					LEFT JOIN subCategory ON subCategory.subCategoryId=IM.SubcategoryId	
					LEFT JOIN itemunit IU ON IM.itemMasterId=IU.itemMasterId AND IU.multiple='1'
					LEFT JOIN unit U ON IU.unitId=U.unitId 
					LEFT JOIN stock S ON IM.itemMasterId = S.itemMasterId
					WHERE IM.status='1' AND S.activeStatus='1'
					ORDER BY IM.itemMasterId DESC
					";
		} else {
			
				$query ="SELECT IM.itemMasterId,IM.itemCode,IM.itemName,IM.stock,IM.costPrice,IM.minretailsPrice,categoryName,subCategoryName,IM.branchId,U.unitName,S.stock_".$privilageId."_".$branchId." as stockBranch,S.expiryDate
					FROM  itemMaster IM
					LEFT JOIN category ON category.categoryId=IM.categoryId
					LEFT JOIN subCategory ON subCategory.subCategoryId=IM.SubcategoryId	
					LEFT JOIN itemunit IU ON IM.itemMasterId=IU.itemMasterId AND IU.multiple='1'
					LEFT JOIN unit U ON IU.unitId=U.unitId 
					LEFT JOIN stock S ON IM.itemMasterId = S.itemMasterId
					WHERE IM.branchId=".$branchId." 
					AND IM.status='1' AND S.activeStatus='1'
					ORDER BY IM.itemMasterId DESC
					";
		}
			$result  = mysqli_query($con,$query);
			return $result;
	}

	function checkInItemTransferDetailsTable($itemMasterId)
	{
		global $con;
		 $query = "SELECT invoiceDetailsId
					FROM itemTransferDetails
					WHERE itemMasterId='$itemMasterId'
					AND status='1'
					";
	
		$result = mysqli_query($con,$query);
		$numRows=	mysqli_num_rows($result);
		return $numRows;
	}
}

?>