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
	
			public function insertIntoItemMaster($categoryId,$brandId,$barcode,$tittle,$quantity,$reorderQty,$location,
								$wholeSalePrice,$maxRetailPrice,$agencyPrice,$minRetailPrice,$costPrice,$notes,$maximunQty,$minimunQty,$profitLevel,$description,$generateBarcode,$vatPer,
								$expiryDate,$manufacturingDate,$batchNo,$SubcategoryId,$country,$tittleArabic,$importOrLocal,$branchId)
				{
				global $con;
				$query="INSERT INTO  itemMaster(categoryId,brandId,itemCode,itemName,wholSalePrice,
												maxRetailPrice,agencyPrice,minretailsPrice,costPrice,
									 location,stock,status,reorderQty,remarks,maximunQty,minimunQty,profitLevel,description,generateBarcode,openingStock,vat,
									 expiryDate,manufacturingDate,batchNo,SubcategoryId,countryId,itemNameArabic,importLocalStatus,branchId)
						VALUES('$categoryId','$brandId','$barcode','$tittle','$wholeSalePrice',
						'$maxRetailPrice','$agencyPrice','$minRetailPrice','$costPrice',
						'$location','$quantity',1,'$reorderQty','$notes','$maximunQty','$minimunQty','$profitLevel','$description','$generateBarcode','$quantity','$vatPer',
						'$expiryDate','$manufacturingDate','$batchNo','$SubcategoryId','$country','$tittleArabic','$importOrLocal','$branchId')";
		
				$set=mysqli_query($con,$query);
				return mysqli_insert_id($con);
		
				}
		
		public function insertIntoItemUnit($lastInsertedId_ItemMaster,$baseUnitId,$unitId,$multiple){
				global $con;
				$query="INSERT INTO  itemUnit(unitId,multiple,itemMasterId,status) 
							VALUES('$baseUnitId',1,'$lastInsertedId_ItemMaster',1)";
				mysqli_query($con,$query);
				if($unitId!=''){
				if(count($unitId)>0){
					for($i=0;$i<count($unitId);$i++){
						if($unitId[$i]!=$baseUnitId){
						$query="INSERT INTO  itemUnit(unitId,multiple,itemMasterId,status) 
								VALUES('$unitId[$i]','$multiple[$i]','$lastInsertedId_ItemMaster',1)";
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

			/* NGK */
			public function getAllBranch(){
				global $con;
				$query ="SELECT branchId,privillageId,branchName FROM branch where status=1";
				return mysqli_query($con,$query);
			}
			/* NGK */
		
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
		
		
		
function insertExcelDatasold($brand,$itemCode,$itemName,
			$itemNameArabic,$location,$costPrice,$wholsalePrice,$maxretailPrice,$agencyPrice,$minretailsPrice,$quantity,$description)
{
$lastid ='';
            global $con;
			//echo $customerNo = $this ->incrementCustomerNo();
		 echo  $query = "INSERT INTO itemMaster (brandId,itemCode,itemName,itemNameArabic,location,costPrice,wholsalePrice,
		                                    maxretailPrice,agencyPrice,minretailsPrice,stock,1_B_stock,description) 
					values(
					'".$brand."',
					'".$itemCode."',
					'".$itemName."',
					'".$itemNameArabic."',
					'".$location."',
					'".$costPrice."',
					'".$wholsalePrice."',
					'".$maxretailPrice."',
					'".$agencyPrice."',
					'".$minretailsPrice."',
					'".$quantity."',
					'".$quantity."',
					'".$description."')";	
		  	 $result   = mysqli_query($con,$query);
			 $lastid = mysqli_insert_id($con);
			 if($lastid!=''){
    			 $getunitId='';
    			 $baseUnit = 'pcs';
    			 $getId="select unitId from unit where unitName='".$baseUnit."'";
    			 $result   = mysqli_query($con,$getId);
        			if($rest=mysqli_fetch_array($result))
        			{
        				$getunitId=$rest['unitId'];
        			}
			
			/*if($getunitId==''){
				
				$setnitIds = "INSERT INTO unit (unitName) 
					values('".trim($baseUnit)."')";	
					
		  	 $result    = mysqli_query($con,$setnitIds);
			 $getunitId = mysqli_insert_id($con);
			}*/
			
			
              $query1 = "INSERT INTO itemUnit (unitId,multiple,itemMasterId) 
					values(
					'".$getunitId."',
					'1',
					'".$lastid."')";	
		  	 $result   = mysqli_query($con,$query1);
			 
			 
			 $unitId='';
			/*$getUnitId="select unitId from unit where unitName='".$unit."'"; 
			$result1   = mysqli_query($con,$getUnitId);
			if($res=mysqli_fetch_array($result1))
			{
				$unitId=$res['unitId'];
			}
			 if($unitId==''){
				 $setnitId = "INSERT INTO unit (unitName) 
					values('".trim($unit)."')";	
					
		  	 $result    = mysqli_query($con,$setnitId);
			 $unitId = mysqli_insert_id($con);
				 
			 }
			 
			 $query2 = "INSERT INTO itemUnit (unitId,multiple,itemMasterId) 
					values(
					'".$unitId."',
					'".$fraction."',
					'".$lastid."')";	
		  	 $result   = mysqli_query($con,$query2);*/
			 //$lastid = mysqli_insert_id($con);
			}		
             



}	

function insertExcelDatas($itemCode,$itemName,
			$catogoryId,$costPrice,$maxretailPrice){
				
				 global $con;
			//echo $customerNo = $this ->incrementCustomerNo();
		   $query = "INSERT INTO itemMaster (itemCode,itemName,categoryId,costPrice,
		                                    maxretailPrice,branchId,minretailsPrice) 
					values(
					
					'".$itemCode."',
					'".$itemName."',
					'".$catogoryId."',
					'".$costPrice."',
					'".$maxretailPrice."',5,'".$maxretailPrice."'
					)";	
		  	 $result   = mysqli_query($con,$query);
			 $lastid = mysqli_insert_id($con);
			 return $lastid;
			 
			}

function getUnitId($unit){
	
	 $unitId='';
	 	global $con;
			$getUnitId="select unitId from unit where unitName='".$unit."'"; 
			$result1   = mysqli_query($con,$getUnitId);
			if($res=mysqli_fetch_array($result1))
			{
				$unitId=$res['unitId'];
			}
			return $unitId;
			
}

function instItemUnit($unitId,$itemMasterId){
			
			global $con;
		 $query = "INSERT INTO itemUnit (unitId,multiple,itemMasterId) 
					values('".$unitId."',
					       '1',
					      '".$itemMasterId."')";	
		  	 $result   = mysqli_query($con,$query);
			 $lastid = mysqli_insert_id($con);
			 return $lastid;
			
		}
		
		function instotherItemUnit($unitId1,$itemMasterId,$multiple){
			global $con;
		 $query = "INSERT INTO itemUnit (unitId,multiple,itemMasterId) 
					values('".$unitId1."',
					       '$multiple',
					      '".$itemMasterId."')";	
		  	 $result   = mysqli_query($con,$query);
			 $lastid = mysqli_insert_id($con);
			 return $lastid;
		}
		
		public function checkDuplication($barcode)
	{
		global $con;
		$query ='SELECT itemCode
			FROM  itemMaster
			WHERE itemCode="'.$barcode.'"';
			
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
		$query ='SELECT branchName,branchId FROM  branch';
		$result  = mysqli_query($con,$query);
		return $result;
			
		}
		function getCountry(){
			global $con;
		$query ='SELECT * FROM  country where status=1';
		$result  = mysqli_query($con,$query);
		return $result;
			
			
		}
		
		function getCategoryId($catogory){
			
			 $unitId='';
	 	global $con;
			$getUnitId="select categoryId from category where categoryName='".$catogory."'"; 
			$result1   = mysqli_query($con,$getUnitId);
			if($res=mysqli_fetch_array($result1))
			{
				$unitId=$res['categoryId'];
			}
			return $unitId;
			
		}
		
		function  insertIntoBranchStock($lastInsertedId_ItemMaster,$branchId,$privilageId,$barcode,$quantity,$expiryDateQty,$openingStockId,$importOrLocal){
			global $con;
			 if($privilageId==12)
			{
				$query ="INSERT INTO stock 
						(itemMasterId,barcode,expiryDate,openingStockId,importLocalStatus)
						VALUES('$lastInsertedId_ItemMaster','$barcode','$expiryDateQty','$openingStockId','$importOrLocal')
					";
			}else{
			  $query ="INSERT INTO stock 
						(itemMasterId,barcode,expiryDate,stock_".$privilageId."_".$branchId.",openingStockId,importLocalStatus)
						VALUES('$lastInsertedId_ItemMaster','$barcode','$expiryDateQty','$quantity','$openingStockId','$importOrLocal')
					";
					// echo "<br> query = ".$query."<br>";die("test");
			}
			
			$result  = mysqli_query($con,$query);
			$stockId = mysqli_insert_id($con);
			return $stockId;
		}
		
		function insertIntoOpeningStock($lastInsertedId_ItemMaster,$branchId,$privilageId,$barcode,$quantity,$expiryDateQty,$stockDate,$stockId)
		{
			global $con;
			$mainBranch        		= 		$_COOKIE['mainBranch'];
			 $query ="INSERT INTO openingStock 
						(itemMasterId,oprningStock,expiryDate,barcode,branchId,privilageId,mainBranch,stockDate,stockId)
						VALUES('$lastInsertedId_ItemMaster','$quantity','$expiryDateQty','$barcode','$branchId','$privilageId',
						'$mainBranch','$stockDate','$stockId')
					";
		
			$result  		 = mysqli_query($con,$query);
			 $openingStockId = mysqli_insert_id($con);
			return $openingStockId;
		}
		
		function getMaxBarcodeNo($SubcategoryId)
	{
		$barcode = '';
		global $con;
		$query = "SELECT MAX(itemCode) AS barcodeNo 
				  FROM   itemMaster 
				  WHERE SubcategoryId='".$SubcategoryId."'
				  ";
		/*$query = "SELECT itemCode AS barcodeNo 
				  FROM   itemMaster 
				  WHERE SubcategoryId='".$SubcategoryId."'
				  ORDER BY itemMasterId DESC LIMIT 1";*/
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		if($listNo = mysqli_fetch_array($result))
		{
			$barcode = $listNo['barcodeNo']+1;
		}
		return $barcode;
	}
/*-------------------------------------Updation Dy Dipin Start For show DataTable start------------------------------------------*/ 
	public function  getItemMasterDetailsTable($branchId)
	{
		global $con;
		$privilageId        =   	$_COOKIE['privillegeId'];
		if($privilageId==1 || $privilageId==12 || $branchId==2 || $branchId==3)
		{
					$query ="SELECT itemMasterId,itemCode,itemName,stock,costPrice,minretailsPrice,categoryName,subCategoryName,branchId
					FROM  itemMaster
					LEFT JOIN category ON category.categoryId=itemMaster.categoryId
					LEFT JOIN subCategory ON subCategory.subCategoryId=itemMaster.SubcategoryId	
					WHERE itemMaster.status='1'
					ORDER BY itemMasterId DESC
					LIMIT 100
					";
		} else {
			
				$query ="SELECT itemMasterId,itemCode,itemName,stock,costPrice,minretailsPrice,categoryName,subCategoryName,branchId
					FROM  itemMaster
					LEFT JOIN category ON category.categoryId=itemMaster.categoryId
					LEFT JOIN subCategory ON subCategory.subCategoryId=itemMaster.SubcategoryId	
					WHERE itemMaster.status='1'
					AND itemMaster.branchId=".$branchId."
					ORDER BY itemMasterId DESC
					LIMIT 100
					";
		}
			$result  = mysqli_query($con,$query);
			return $result;
	}
	public function deleteFromItemMasterTable($itemMasterId)
	{
		global $con;
			 $query ="UPDATE itemMaster SET status='0' 
				where itemMasterId='$itemMasterId'";
			
			$result  = mysqli_query($con,$query);
			return $result;
	}
	public function checkDuplicationEdit($partNo,$itemMasterId)
	{
		global $con;
		 $query ='SELECT itemCode
			FROM  itemMaster
			WHERE itemCode="'.$partNo.'" AND itemMasterId!="'.$itemMasterId.'"';
			
	    $result  = mysqli_query($con,$query);
		return mysqli_num_rows($result);
		
	}
	
	function getSubcategory($categoryId){
		
		global $con;
		 $query ="SELECT subCategoryName,subCategoryId
			FROM  subCategory
			WHERE categoryId='".$categoryId."'
			AND status='1'
			ORDER BY subCategoryName ASC";
			
	    $result  = mysqli_query($con,$query);
		return $result;
	}
	function insertItemTransferDetails($stockDate,$expiryDateQty,$openingStockId,$lastInsertedId_ItemMaster,$quantity,$branchId,$stockId,$baseUnitId)
	{
		$privilageId     =   	$_COOKIE['privillegeId'];
		$transactionType = 'Opening Stock';
		$stockStatus 	= 'IN';
		$type			=	6;
		$mainBranch     = 	$_COOKIE['mainBranch'];	
		$userId			=	$_COOKIE['userId'];
		
		global $con;
		 $query = "INSERT INTO itemTransferDetails(invoiceDetailsId,date,expiryDate,transactionNo,itemMasterId,quantity,itemUnitId,totalQuanity,transactionType,stockStatus,remainingStock,branchId,userId,privilageId,stockId,type,mainBranch) 
				  VALUES('".$openingStockId."','".$stockDate."','".$expiryDateQty."','','".$lastInsertedId_ItemMaster."','".$quantity."','".$baseUnitId."','".$quantity."',
				  '".$transactionType."','".$stockStatus."','','".$branchId."','".$userId."','".$privilageId."','".$stockId."','".$type."','".$mainBranch."')";
		
		$result = mysqli_query($con,$query);
		//return mysqli_insert_id($con);
		
	}
/*-------------------------------------Updation Dy Dipin Start For show DataTable Ends------------------------------------------*/ 
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
	
	function insertStockTbl($lastInsertedId_ItemMaster,$barcode,$importOrLocal){
		global $con;
		$expiryDateQty='0000-00-00';
		$openingStockId='';
			
				$query ="INSERT INTO stock 
						(itemMasterId,barcode,expiryDate,openingStockId,importLocalStatus)
						VALUES('$lastInsertedId_ItemMaster','$barcode','$expiryDateQty','$openingStockId','$importOrLocal')
					";
			
			
			$result  = mysqli_query($con,$query);
			$stockId = mysqli_insert_id($con);
			return $stockId;
	}
	}
?>