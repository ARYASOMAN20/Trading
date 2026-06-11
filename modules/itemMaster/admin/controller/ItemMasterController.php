<?php


require_once('../../../../modules/itemMaster/admin/models/Itemmastermodel.php');

class ItemMasterController
{
	
	public function insertIntoItemMaster($categoryId,$brandId,$barcode,$tittle,$quantity,$reorderQty,$location,
								$wholeSalePrice,$maxRetailPrice,$agencyPrice,$minRetailPrice,$costPrice,$notes,$maximunQty,$minimunQty,$profitLevel,$description,$generateBarcode,$vatPer,
								$expiryDate,$manufacturingDate,$batchNo,
								$baseUnitId,$unitId,$multiple,$branchId,$privilageId,$expiryDateQty,$SubcategoryId,$country,$tittleArabic,
								$importOrLocal,$stockDate,$quantityStock)
	{
		$openingStockId		=	'';
		$objItemmastermodel=new Itemmastermodel();
		 $lastInsertedId_ItemMaster = $objItemmastermodel->insertIntoItemMaster($categoryId,$brandId,$barcode,$tittle,$quantity,$reorderQty,$location,
								$wholeSalePrice,$maxRetailPrice,$agencyPrice,$minRetailPrice,$costPrice,$notes,$maximunQty,$minimunQty,$profitLevel,$description,$generateBarcode,$vatPer,
								$expiryDate,$manufacturingDate,$batchNo,$SubcategoryId,$country,$tittleArabic,$importOrLocal,$branchId);
								
	$objItemmastermodel->insertIntoItemUnit($lastInsertedId_ItemMaster,$baseUnitId,$unitId,$multiple);
	
	$stockId	=	$objItemmastermodel->insertIntoBranchStock($lastInsertedId_ItemMaster,$branchId,$privilageId,$barcode,$quantityStock,$expiryDateQty,$openingStockId,$importOrLocal);	

	if($quantity>0)
	{
			$openingStockId	=	$objItemmastermodel->insertIntoOpeningStock($lastInsertedId_ItemMaster,$branchId,$privilageId,$barcode,$quantity,$expiryDateQty,$stockDate,$stockId);
			$objItemmastermodel->insertItemTransferDetails($stockDate,$expiryDateQty,$openingStockId,$lastInsertedId_ItemMaster,$quantity,$branchId,$stockId,$baseUnitId);
	}
	return  $lastInsertedId_ItemMaster;
	}
	
	public function getAllBrand()
	{
		$objItemmastermodel=new Itemmastermodel();
		return $getAllBrand=$objItemmastermodel->getAllBrand();
		
	}

	/* NGK */
	public function getAllBranch()
	{
		$objItemmastermodel=new Itemmastermodel();
		return $getAllBranch=$objItemmastermodel->getAllBranch();
		
	}
	/* NGK */
	
	public function getAllCategory()
	{
		$objItemmastermodel=new Itemmastermodel();
		return $getAllBrand=$objItemmastermodel->getAllCategory();
		
	}
	
	public function getAllUnit()
	{
		$objItemmastermodel=new Itemmastermodel();
		return $getAllUnit=$objItemmastermodel->getAllUnit();
		
	}
	 
	public function getAllItemDetails(){
		$objItemmastermodel=new Itemmastermodel();
		return $getAllBrand=$objItemmastermodel->getAllItemDetails();
	}
	
	
	public function updateBrand($brandId)
	{
		$objItemmastermodel=new Itemmastermodel();
		$updateBrand=$objItemmastermodel->updateBrand($brandId);
		return $updateBrand;
	}
	public function update_BrandList($brandId,$brandName,$remarks)
	{
		$objItemmastermodel=new Itemmastermodel();
		$updateAccountHead=$objItemmastermodel->update_BrandList($brandId,$brandName,$remarks);
		return $updateAccountHead;
	}
	
	
	public function deleteBrand($brandId)
	{
		$objItemmastermodel=new Itemmastermodel();
		$delete_Categorys=$objItemmastermodel->deleteBrand($brandId);
		return $delete_Categorys;
	}  
	
	public function checkDuplication($barcode)
	{
		$objItemmastermodel=new Itemmastermodel();
		$duplication=$objItemmastermodel->checkDuplication($barcode);
		return $duplication;
	}
	
	public function  getBranch(){
		$objItemmastermodel=new Itemmastermodel();
		$getBranch=$objItemmastermodel->getBranch();
		$allBranch=null;
		while($data = mysqli_fetch_array($getBranch)){
			$allBranch .= '<option value="'.$data['branchId'].'">'.$data['branchName'].'</option>';
		}
		return $allBranch;
		 
	
}
function getCountry()
{
	$objItemmastermodel=new Itemmastermodel();
		$getBranch=$objItemmastermodel->getCountry();
		$allBranch='<option value="">Select</option>';
		while($data = mysqli_fetch_array($getBranch)){
			$allBranch .= '<option value="'.$data['countryId'].'">'.$data['countryName'].'</option>';
		}
		return $allBranch;
	
	 
}
/*-------------------------------------Updation Dy Dipin Start For show DataTable start------------------------------------------*/ 
	public function  getItemMasterDetailsTable($branchId)
	{
		$itemMasterDetailsTable	=	'';
		$i 						=	1;
		$objItemmastermodel		=	new Itemmastermodel();
		$itemMasterData			=	$objItemmastermodel->getItemMasterDetailsTable($branchId);
		while($row=mysqli_fetch_array($itemMasterData))
		{	
			$itemMasterId		=	$row['itemMasterId'];
			$nunRows			=	$objItemmastermodel->checkInItemTransferDetailsTable($itemMasterId);
			$itemMasterDetailsTable	.=	'<tr>
											<td>'.$i.'</td>
											<td>'.$row['itemCode'].'</td>
											<td>'.$row['itemName'].'</td>
											<td>'.$row['categoryName'].'</td>
											<td>'.$row['subCategoryName'].'</td>
											<td>'.number_format($row['minretailsPrice'], 2, '.', '').'</td>
											
											<td>
												<button class="btn" style="border-radius: 50%;"  onclick="editItem('.$row['itemMasterId'].','.$row['branchId'].')" data-toggle="modal" data-target="#editItemMaster">
													<i class="fa fa-edit" style="color:#1af516;"></i>
												</button>
											</td>
											<td>';
					if($nunRows==0)
					{						
					$itemMasterDetailsTable	.=	'<form method="POST">
													<input type="hidden" id="itemMasterIdDelete'.$i.'" name="itemMasterIdDelete" value="'.$row['itemMasterId'].'"/>
													<button type="submit" class="btn" name="deleteBtn" style="border-radius: 50%;">
														<i class="fa fa-times" style="color:red;"></i>
													</button>
												</form>';
					}												
						$itemMasterDetailsTable	.=	'</td>
										</tr>';
			$i=$i+1;							
		}
		return $itemMasterDetailsTable;
	}
	
/*-------------------------------------Updation Dy Dipin Start For show DataTable ends------------------------------------------*/ 
}

?>
