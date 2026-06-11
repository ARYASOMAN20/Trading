<?php
	
 /* ----------Developed By AK 07/11/2019 ---------------- */

require_once("../../../../settings/connect_db.php");
	
class Itemmastermodel
		{
			public function getAllItemDetails(){
				global $con;
				$query ="SELECT * FROM itemMaster where status=1 ORDER BY itemMasterId";
				return mysqli_query($con,$query);
			}
	
			public function insertIntoItemMaster($categoryId,$brandId,$partNo,$tittle,$quantity,$reorderQty,$location,
								$wholeSalePrice,$maxRetailPrice,$agencyPrice,$minRetailPrice,$costPrice,$notes,$maximunQty,$minimunQty,$profitLevel,$description,$generateBarcode,$vatPer,
								$expiryDate,$manufacturingDate,$batchNo,$WeighedOrPcs)
				{
				global $con;
				 $query="INSERT INTO  itemMaster(categoryId,brandId,itemCode,itemName,wholSalePrice,
												maxRetailPrice,agencyPrice,minretailsPrice,costPrice,
									 location,stock,status,reorderQty,remarks,maximunQty,minimunQty,profitLevel,description,generateBarcode,openingStock,vat,
									 expiryDate,manufacturingDate,batchNo,weighedOrPcs,itemNameArabic)
						VALUES('$categoryId','$brandId','$partNo','$tittle','$wholeSalePrice',
						'$minRetailPrice','$agencyPrice','$minRetailPrice','$costPrice',
						'$location','$quantity',1,'$reorderQty','$notes','$maximunQty','$minimunQty','$profitLevel','$description','$generateBarcode','$quantity','$vatPer',
						'$expiryDate','$manufacturingDate','$batchNo','$WeighedOrPcs','$description')";
		
				$set=mysqli_query($con,$query);
				return mysqli_insert_id($con);
		
				}
		
		public function insertIntoItemUnit($lastInsertedId_ItemMaster,$baseUnitId,$unitId,$multiple,$baseUnitPrice,$basesellingPrice,$oterCostPrice,$otherSellingPrice){
				global $con;
				$query="INSERT INTO  itemUnit(unitId,multiple,itemMasterId,status,costPrice,sellingPrice) 
							VALUES('$baseUnitId',1,'$lastInsertedId_ItemMaster',1,'$baseUnitPrice','$basesellingPrice')";
				mysqli_query($con,$query);
				
				if($unitId!=''){
				if(count($unitId)>0){
					for($i=0;$i<count($unitId);$i++){
						if($unitId[$i]!=$baseUnitId){
						$query="INSERT INTO  itemUnit(unitId,multiple,itemMasterId,status,costPrice,sellingPrice) 
								VALUES('$unitId[$i]','$multiple[$i]','$lastInsertedId_ItemMaster',1,'$oterCostPrice[$i]','$otherSellingPrice[$i]')";
						mysqli_query($con,$query);
						}
					}
				}
				}
			}
		
			public function getAllBrand(){
				global $con;
				$query ="SELECT brandId,brandName FROM brand where status=1";
				return mysqli_query($con,$query);
			}
		
			public function getAllCategory(){
				global $con;
				$query ="SELECT categoryId,categoryName FROM category where status=1";
				return mysqli_query($con,$query);
			}
			
			public function getAllUnit(){ 
				global $con;
				 $query ="SELECT unitId,unitName FROM unit where status=1";
				return mysqli_query($con,$query);
			}
		
			public function getItemsDetailsForUpdate($itemMasterId){
				global $con;
				$query ="SELECT categoryId,brandId,description,packingSize,packingSizeArabic,vat,remarks,
						costPrice,sellingPrice
						FROM itemMaster where itemMasterId=$itemMasterId AND status=1";
				return mysqli_query($con,$query);
			}
		
			public function geUnitsForEdit($itemMasterId){
				global $con;
				$query ="SELECT * FROM itemUnit where itemMasterId='$itemMasterId' AND status=1";
				return mysqli_query($con,$query);
			}
		
			public function  updateIntoItemMaster($categoryId,$brandId,$description,$packingSize,
											$packingSizeArbic,$vatPer,$remarks,$costPrice,$sellingPrice,$itemMasterId){
				global $con;
				$query ="update itemMaster SET categoryId='$categoryId',brandId='$brandId',
						description='$description',packingSize='$packingSize',packingSizeArabic='$packingSizeArbic',
						vat='$vatPer',remarks='$remarks',costPrice='$costPrice',sellingPrice='$sellingPrice'
						where itemMasterId='$itemMasterId' AND status=1";
				return mysqli_query($con,$query);
			}
		
			public function updateIntoUnitItems($itemUnitIdUpdate,$unitName,$fractionValue,$itemMasterId){
				global $con;
				for($i=0;$i<count($unitName);$i++){
					if($itemUnitIdUpdate[$i]=='newUnit'){
						$query="INSERT INTO  itemUnit(unitName,multiple,itemMasterId,status) 
							VALUES('$unitName[$i]','$fractionValue[$i]','$itemMasterId',1)";
						
					}else{
						 $query ="update itemUnit SET unitName='$unitName[$i]',multiple='$fractionValue[$i]' where itemUnitId='$itemUnitIdUpdate[$i]'";
					}
					
					mysqli_query($con,$query);
			}
		}
		
		
		
function insertExcelDatas($barcode,$itemName,$sellingPrice)
{
$lastid ='';
            global $con;
			//echo $customerNo = $this ->incrementCustomerNo();
		   $query = "INSERT INTO itemMaster (itemCode,itemName,maxretailPrice) 
					values(
					'".$barcode."',
					'".$itemName."','".$sellingPrice."')";	
		  	 $result   = mysqli_query($con,$query);
			 $lastid = mysqli_insert_id($con);
			 
			
			
              return $lastid;
             



}	
		function getUnitId($baseUnit)
		{
			$getunitId = '';
			global $con;
			 $getId="select unitId from unit where unitName='".$baseUnit."'";
    			 $result   = mysqli_query($con,$getId);
        			if($rest=mysqli_fetch_array($result))
        			{
        				$getunitId=$rest['unitId'];
        			}
					return $getunitId;
		}
		
		function insertUnit($baseUnit)
		{
			global $con;
			 $setnitId = "INSERT INTO unit (unitName) 
					values('".$baseUnit."')";	
					
		  	 $result    = mysqli_query($con,$setnitId);
			 return $unitId = mysqli_insert_id($con);
		}
		
		function insertUnitId($baseUnitId,$multiple,$lastid,$costBase,$selingBase)
		{
			global $con;
			$query2 = "INSERT INTO itemUnit (unitId,multiple,itemMasterId,costPrice,sellingPrice) 
					values(
					'".$baseUnitId."',
					'".$multiple."',
					'".$lastid."','".$costBase."','".$selingBase."')";	
		  	 $result   = mysqli_query($con,$query2);
		}
		public function checkDuplication($partNo)
	{
		global $con;
		$query ='SELECT itemCode
			FROM  itemMaster
			WHERE itemCode="'.$partNo.'"';
			
	    $result  = mysqli_query($con,$query);
		return mysqli_num_rows($result);
		
	}
		function getBrandFormat($brandId){
			global $con;
		$query ='SELECT brandFormat
			FROM  brand
			WHERE brandId="'.$brandId.'"';
			
	    $result  = mysqli_query($con,$query);
		return $result;
		}
		
		
		function  getBranch(){
			global $con;
		$query ='SELECT branchName,branchId FROM  branch 
		         WHERE status=1';
		$result  = mysqli_query($con,$query);
		return $result;
			
		}
		
		function  insertIntoBranchStock($lastInsertedId_ItemMaster,$branchId,$quantity){
			global $con;
			 $query ="UPDATE itemMaster SET ".$branchId."_B_stock='$quantity' 
				where itemMasterId='$lastInsertedId_ItemMaster'";
			$result  = mysqli_query($con,$query);
			return $result;
		}
	}
?>