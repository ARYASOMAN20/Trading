<?php
 /* ----------Developed By arya 14/04/2020 ---------------- */
require_once('../../../../modules/itemMaster/admin/controller/ItemMasterController.php');
	require_once("../../../../settings/path.php");
	$objPath          = new Path();
	$objItemMasterController=new ItemMasterController();
	
	require_once('../../../../modules/itemMaster/admin/models/Itemmastermodel.php');
	$objItemmastermodel=new Itemmastermodel();
	
	require_once('../../../../modules/itemMasterEdit/admin/controller/c_ItemMasterEdit.php');
	$objCItemMasterEdit				= 	new ItemMasterEditController();
	
	$getAllItemsRoows=$brand =$category =  null;
	
	$i=1;
	
	$getBranch 				= $objItemMasterController->getBranch();
$privilageId        =   	$_COOKIE['privillegeId'];	
if($privilageId==1 || $privilageId==12)
	$branchId=0;
else
	$branchId			=	$_COOKIE['branchId'];
	$itemMasterDetailsTable	= $objItemMasterController->getItemMasterDetailsTable($branchId);	
	$country                = 	$objItemMasterController->getCountry();
	
		$privilageId        =   	$_COOKIE['privillegeId'];

if(isset($_POST['submit'])){
			
		$categoryId=$brandId=$itemCode=$tittle=$vatPer=$location=$packingSize=$packingSizeArabic=$barcode =null;
		$wholeSalePrice=$maxRetailPrice=$agencyPrice=$minRetailPrice=$costPrice=$quantity=0;
		$baseUnitId=$unitId=$multiple=null;
		
		$barcode             =       $_POST['barcode'];
		$checkCompanyItemCodeDuplication=$objItemMasterController->checkDuplication($barcode);
		if($checkCompanyItemCodeDuplication==0){
			
		$privilageId        =   	$_COOKIE['privillegeId'];
		$branchId        	=   	$_COOKIE['branchId'];
		
		if($privilageId==1 || $privilageId==12)
			{
				$branchIdListArray        	=   	$_POST['branchId'];
				$branchIdList = explode("/", $branchIdListArray);
				$branchId    = $branchIdList[0];
				$privilageId = $branchIdList[1];
			}
			/* echo "<br> branchId = ".$branchId."<br>";
			echo "<br> privilageId = ".$privilageId."<br>";die("test"); */
		
		$categoryId			=		$_POST['categoryId'];
		$SubcategoryId      =       $_POST['SubcategoryId'];
		$brandId			=		$_POST['brandId'];
		$barcode            =       $_POST['barcode'];
		$tittle				=		$_POST['tittle'];
		$reorderQty		    =		$_POST['reorderQty'];
		$location			=		$_POST['location'];
		$minimunQty         =       $_POST['minimunQty'];
		$maximunQty			=		$_POST['maximunQty'];
		$profitLevel		=		$_POST['profitLevel'];
		$description        =       $_POST['description'];
		$generateBarcode    =       '';
	    $country            =      $_POST['country'];
		$wholeSalePrice 	=		$_POST['wholeSalePrice'];
		$maxRetailPrice 	=		$_POST['maxRetailPrice'];
		$agencyPrice 		=		'';//$_POST['agencyPrice'];
		$minRetailPrice 	=		$_POST['minRetailPrice'];
		$costPrice 			=		$_POST['costPrice'];
	    $notes			    =		$_POST['note'];
		$vatPer				=		$_POST['vatPer'];
		$tittleArabic       =       $_POST['tittleArabic'];
		$importOrLocal      =       $_POST['importOrLocal'];
		$quantityStock			=		$_POST['quantity'];
		/*if($privilageId==11){
		$expiryDate			=		$_POST['expiryDate'];
		$expiryDate			=		date_format(date_create($expiryDate),"Y-m-d");
		$manufacturingDate	=		$_POST['manufacturingDate'];
		$manufacturingDate	=		date_format(date_create($manufacturingDate),"Y-m-d");
		$batchNo			=		$_POST['batchNo'];
		}
		else{*/
		$expiryDate			=		null;	
		$manufacturingDate	=		null;	
		$batchNo			=	    '';
		//}
		/* if($privilageId==12)
		{ */
		$quantity			=		$_POST['quantity'];
		$expiryDateQty		=		$_POST['expiryDate'];
		$stockDate			=		$_POST['stockDate'];
		/* }else{
		$quantity			=		'';
		$expiryDateQty		=		'';
		$stockDate			=		'';	
		} */
		
		if($expiryDateQty=='' ||$expiryDateQty==null )
		{
			$expiryDateQty	=	null;
		}else{
			$expiryDateQty			=		date_format(date_create($expiryDateQty),"Y-m-d");
		}
		
		
		if($stockDate=='' ||$stockDate==null )
		{
			$stockDate	=	null;
		}else{
			$stockDate			=		date_format(date_create($stockDate),"Y-m-d");
		}
		
		$baseUnitId			=		$_POST['baseUnit'];
		
		$unitId				=		$_POST['unitId'];
		$multiple			=		$_POST['multiple'];
	

	
		
		$objItemMasterController->insertIntoItemMaster($categoryId,$brandId,$barcode,$tittle,$quantity,$reorderQty,$location,
								$wholeSalePrice,$maxRetailPrice,$agencyPrice,$minRetailPrice,$costPrice,$notes,$maximunQty,$minimunQty,$profitLevel,$description,$generateBarcode,$vatPer,
								$expiryDate,$manufacturingDate,$batchNo,
								$baseUnitId,$unitId,$multiple,$branchId,$privilageId,$expiryDateQty,$SubcategoryId,$country,$tittleArabic,$importOrLocal,$stockDate,$quantityStock);
	  
	 
		$objPath->setHeader('itemMaster','Success','itemMaster');
			}
			else{
					$objPath->setHeader('itemMaster',' Error !!! Barcode Duplication','itemMaster');
			}
		
}
 
 if(isset($_POST['deleteBtn']))
 {
	 $itemMasterId	=	$_POST['itemMasterIdDelete'];
	 $objItemmastermodel->deleteFromItemMasterTable($itemMasterId);
	 $objPath->setHeader('itemMaster','Success','itemMaster');
 }
if(isset($_POST['editItem']))
{
		$itemMasterId		=		$_POST['itemMasterIdEdit'];
		$partNo			    =		$_POST['barcodeEdit'];
		$checkCompanyItemCodeDuplication=$objCItemMasterEdit->checkDuplicationItemCode($partNo,$itemMasterId);
		if($checkCompanyItemCodeDuplication==0){
		$categoryId			=		$_POST['categoryIdEdit'];
		$brandId			=		$_POST['brandIdEdit'];
		$tittle				=		$_POST['tittleEdit'];
		
		$reorderQty		    =		$_POST['reorderQtyEdit'];
		$location			=		$_POST['locationEdit'];
		$minimunQty         =       $_POST['minimunQtyEdit'];
		$maximunQty			=		$_POST['maximunQtyEdit'];
		$profitLevel		=		$_POST['profitLevelEdit'];
		$description        =       $_POST['descriptionEdit'];
		$generateBarcode    =       '';
	
		$wholeSalePrice 	=		$_POST['wholeSalePriceEdit'];
		$maxRetailPrice 	=		$_POST['maxRetailPriceEdit'];
		$agencyPrice 		=		'';//$_POST['agencyPrice'];
		$minRetailPrice 	=		$_POST['minRetailPriceEdit'];
		$costPrice 			=		$_POST['costPriceEdit'];
	    $notes			    =		$_POST['noteEdit'];
		$vatPer				=		$_POST['vatPerEdit'];
		$privilageId        =   	$_COOKIE['privillegeId'];
		$branchId        	=   	$_COOKIE['branchId'];
		if($privilageId==1 || $privilageId==12)
			{
				$branchIdListArray        	=   	$_POST['branchIdEdit'];
				$branchIdList = explode("/", $branchIdListArray);
				$branchId    = $branchIdList[0];
				$privilageId = $branchIdList[1];
			}
			$OldBranchIdHidden			    =		$_POST['branchIdHidden'];
			$OldPrivillageIdHidden			=		$_POST['privillageIdHidden'];
			$OldQtyHidden					=		$_POST['openingStockHidden'];

		$SubcategoryIdEdit  =       $_POST['SubcategoryIdEdit'];
		$countryEdit        =       $_POST['countryEdit'];
		$tittleArabicEdit   =       $_POST['tittleArabicEdit'];
		$importOrLocalEdit  =       $_POST['importOrLocalEdit'];
		/*if($privilageId==11){
		$expiryDate			=		$_POST['expiryDateEdit'];
		$expiryDate			=		date_format(date_create($expiryDate),"Y-m-d");
		$manufacturingDate	=		$_POST['manufacturingDateEdit'];
		$manufacturingDate	=		date_format(date_create($manufacturingDate),"Y-m-d");
		$batchNo			=		$_POST['batchNoEdit'];
		}
		else{*/
		if($privilageId==12)
			{
				$quantity			=		'';
				$expiryDate			=		'';	
				$stockDateEdit		=		'';	
			}else{
				$quantity			=		$_POST['quantityEdit'];
				$expiryDate			=		$_POST['expiryDateEdit'];	
				$stockDateEdit		=		$_POST['stockDateEdit'];
			}
		
		if($expiryDate=='' ||$expiryDate==null )
		{
			$expiryDate	=	null;
		}else{
			$expiryDate			=		date_format(date_create($expiryDate),"Y-m-d");
		}
		
		if($stockDateEdit=='' ||$stockDateEdit==null )
		{
			$stockDateEdit		=	null;
		}else{
			$stockDateEdit		=		date_format(date_create($stockDateEdit),"Y-m-d");
		}
		$manufacturingDate	=		null;	
		$batchNo			=	    '';
		//}
		
		$baseUnitId			=		$_POST['baseUnitEdit'];
		
		$unitId				=		$_POST['unitIdEdit'];
		$multiple			=		$_POST['multipleEdit'];
		
		$updateItemMaster	=	$objCItemMasterEdit->updateItemMaster($itemMasterId,$categoryId,$brandId,$partNo,$tittle,$quantity,$reorderQty,$location,
								$wholeSalePrice,$maxRetailPrice,$agencyPrice,$minRetailPrice,$costPrice,$notes,$maximunQty,$minimunQty,$profitLevel,$description,$generateBarcode,$vatPer,
								$baseUnitId,$unitId,$multiple,$expiryDate,$manufacturingDate,$batchNo,$SubcategoryIdEdit,$countryEdit,$tittleArabicEdit,$importOrLocalEdit,$stockDateEdit,$branchId,$privilageId,$OldBranchIdHidden,$OldPrivillageIdHidden,$OldQtyHidden);			

		$objPath->setHeader('itemMaster','Success','itemMaster');
		}
		else{
			$objPath->setHeader('itemMaster','Item Code Duplication','itemMaster');
		}
}


if(isset($_POST['insertStockTbl']))
{
	
	$itemList  = $objItemmastermodel->getAllItemDetails();
	while ($listData = mysqli_fetch_array($itemList))
				{
					$itemMasterId=$itemCode=$importLocalStatus='';
					
					$itemMasterId=$listData['itemMasterId'];
					$itemCode=$listData['itemCode'];
					$importLocalStatus=$listData['importLocalStatus'];
					$objItemmastermodel->insertStockTbl($itemMasterId,$itemCode,$importLocalStatus);
				}
	
}
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Item</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<style>
.modal{
	position: fixed;
	margin-top:10%;
}
.modal-footer {
    padding: 6px;
    text-align: right;
	}

body {padding-right: 0px !important;}

.btn-success {
    background-color: #00c4ff !important;
}

.submitBtn {
	background-color:#0c8473 !important;
}
.col-sm-12 .col-md-12 .col-lg-12
{
	margin-top: 3% !important;
}

.panel-heading {
    color: #31708f !important;
    background-color: #d9edf7 !important;
    border-color: #bce8f1 !important;
}
.panel-heading {
    padding: 10px 15px !important;
    border-bottom: 1px solid transparent !important;
    border-top-left-radius: 3px !important;
    border-top-right-radius: 3px !important;
}
.panel-info {
    border-color: #bce8f1;
}
.paginate_button{
	background: #d9edf7 !important;
	border-radius: 50px !important;
}
</style>
<script>
function editItem(itemMasterId)
{

	$.ajax({
               url: "../../../../modules/itemMaster/admin/ajax/editItem.php",
                type: "post",
                data: {itemMasterId:itemMasterId},
                success: function(data) 
				{
					var obj		=	JSON.parse(data);
					var itemCode						=	obj[0];
					var itemName						=	obj[1];
					var stock							=	obj[2];
					var maximunQty						=	obj[3];
					var location						=	obj[4];	
					var wholsalePrice					=	obj[5];
					var maxretailPrice					=	obj[6];
					var agencyPrice						=	obj[7];			
					var minretailsPrice					=	obj[8];				
					var costPrice						=	obj[9];			
					var minimunQty						=	obj[10];				
					var reorderQty				     	=	obj[11];			
					var brandOptionValues				=	obj[12];
					var categoryNameOptionValues		=	obj[13];
					var itemUnittable					=	obj[14];
					var unitDropdownOption				=	obj[15];
					var baseUnitName					=	obj[16];
					var unitDropdownForBase				=	obj[17];
					var remarks                         =   obj[18];
					var openingStock                   	=   obj[19];
					var profitLevel			        	=	obj[20];
					var description                    	=   obj[21];
					var generateBarcode                	=   obj[22];
					var partNo                         	=   obj[23];
					var itemMasterId                   	=   obj[24];
					var brandFormat                    	=   obj[25];
					var vat                            	=   obj[26];
					var expiryDate                     	=   obj[27];
					var manufacturingDate              	=   obj[28];
					var batchNo                       	=   obj[29]; 
					var expiryDateQty                   =   obj[31]; 
					var totalStock                      =   obj[32]; 
					var brandOptionValues1              =   obj[33]; 
					var SUBCATEGORY                     =   obj[34]; 
					var itemNameArabic                  =   obj[35]; 
					var importLocalStatus               =   obj[36];
					var stockDate               		=   obj[37];
					var branchOptionValues              =   obj[38];
					var branchIdHidden              	=   obj[39];
					var privillageIdHidden              =   obj[40];
					var openingStockHidden              =   obj[41];
					console.log(branchIdHidden);
					console.log(privillageIdHidden);
					console.log(openingStockHidden);
					$('#brandIdEdit').html(brandOptionValues);
					$('#itemMasterIdEdit').val(itemMasterId);
					$('#categoryIdEdit').html(categoryNameOptionValues);
					$('#tittleEdit').val(itemName);
					$('#barcodeEdit').val(partNo);
					$('#quantityEdit').val(totalStock);
					$('#wholeSalePriceEdit').val(wholsalePrice);
					$('#maxRetailPriceEdit').val(maxretailPrice);
					$('#minRetailPriceEdit').val(minretailsPrice);
					$('#costPriceEdit').val(costPrice);
					$('#locationEdit').val(location);
					$('#minimunQtyEdit').val(minimunQty);
					$('#reorderQtyEdit').val(reorderQty);
					$('#maximunQtyEdit').val(maximunQty);
					$('#profitLevelEdit').val(profitLevel);
					$('#descriptionEdit').val(description);
					$('#vatPerEdit').val(vat);
					$('#noteEdit').val(remarks);
					$('#baseUnitEdit').html(unitDropdownForBase);
					$('#unitTableEdit').html(itemUnittable);
					$('#expiryDateEdit').val(expiryDateQty);
					$('#countryEdit').html(brandOptionValues1);
					$('#SubcategoryIdEdit').html(SUBCATEGORY);
					$('#tittleArabicEdit').val(itemNameArabic);
					$('#addLocImp').html(importLocalStatus);
					$('#stockDateEdit').val(stockDate);
					$('#branchIdEdit').html(branchOptionValues);
					$('#branchIdHidden').val(branchIdHidden);
					$('#privillageIdHidden').val(privillageIdHidden);
					$('#openingStockHidden').val(openingStockHidden);

					setQuantityEdit();
					
				}
            });
}
function removeUnitId(itemUnitId){
	if(confirm("Are You Sure !!")){
		$.ajax({
               url: "../../../../modules/itemMasterEdit/admin/ajax/removeUnitId.php",
                type: "post",
				dataType:'JSON',
                data:{itemUnitId:itemUnitId},
				success: function(data) {
					//alert(data);
					alert('SuccessFully Deleted !!');
					location.reload();
				}
            });
		
	 }else{
		alert('Your Unit Is Safe !!');
	}
}

</script>
<script>

    $(document).ready(function() {
        var i = 1;
        $('#addUnit').click(function() {
			i++;
			
			var unitId     	= $('#unit').val();
			var unitName    = $("#unit :selected").text();
			var multiple	= $('#multiple').val();
			if(unitId=='' || multiple==''){
					alert("enter valid data");
			}else{ 

            content = '<tr id="row' + i + '"><td><input type="hidden" class="form-control input-sm" name="unitId[]" value="' + unitId + '" readonly /><input type="text" class="form-control input-sm"  value="' + unitName + '" readonly /></td><td><input type="text" class="form-control input-sm" name="multiple[]" value="' + multiple + '" readonly /></td><td><button type="button" onclick="" class="btn btn-danger btnRemoveTd btn-xs" style="font-size: 16px;" id="'+i+'"><i class="fa fa-times"></i></button></td></tr>"';

            $('#unitTable').append(content);
			$("#unit").val("");
			//document.getElementById("unit").value	= '';
			document.getElementById("multiple").value	= "";
			}
        });
	}); 
	$(document).ready(function() {
        var i = 1;
        $('#addUnitEdit').click(function() {
			i++;
			
			var unitId     	= $('#unitEdit').val();
			var unitName    = $("#unitEdit :selected").text();
			var multiple	= $('#multipleEdit').val();
			if(unitId=='' || multiple==''){
					alert("enter valid data");
			}else{ 

            content = '<tr id="row' + i + '"><td><input type="hidden" class="form-control input-sm" name="unitIdEdit[]" value="' + unitId + '" readonly /><input type="text" class="form-control input-sm"  value="' + unitName + '" readonly /></td><td><input type="text" class="form-control input-sm" name="multipleEdit[]" value="' + multiple + '" readonly /></td><td><button type="button" onclick="" class="btn btn-danger btnRemoveTd btn-xs" style="font-size: 16px;" id="'+i+'"><i class="fa fa-times"></i></button></td></tr>"';

            $('#unitTableEdit').append(content);
			$("#unitEdit").val("");
			//document.getElementById("unit").value	= '';
			document.getElementById("multipleEdit").value	= "";
			}
        });
	});
	
$(document).on('click','.btnRemoveTd',function(){
					var id=$(this).attr('id');
					$('#row'+id).remove();				
				});
				

</script>
<script>
 function checkNumber(a)
{	var x=document.getElementById(a).value;
		if(isNaN(x))
			{
			alert("Enter a Valid Number");
			document.getElementById(a).value =	null;
			a.focus();
	}		
}


/*---- Ajax For Category---- */
 function addNewCategory(){
	 var categoryName     	= $('#categoryName').val();
	 var categoryRemarks    = $('#categoryRemarks').val();
	 //alert(categoryName);
	 if(categoryName!=''){
		 $.ajax({
               url: "../../../../modules/itemMaster/admin/ajax/addCategoryAjax.php",
                type: "post",
                data: {categoryName:categoryName,categoryRemarks:categoryRemarks},
                success: function(data) {
					$('#categoryId').empty();
                   $('#categoryId').html(data);
                }
            });
	}else{
		alert('Enter Valid Category Name !!');
	}
 } 
 
 function addNewBrand(){
	 var brandName     	= $('#brandName').val();
	 var brandRemarks    = $('#brandCode').val();
	 var brandFormat    = null;//$('#brandFormat').val();
	 
	 //alert(brandName);
	 if(brandName!=''){
		 $.ajax({
               url: "../../../../modules/itemMaster/admin/ajax/addBrandAjax.php",
                type: "post",
                data: {brandName:brandName,brandRemarks:brandRemarks,brandFormat:brandFormat},
                success: function(data) {
					$('#brandId').empty();
                   $('#brandId').html(data);
				       //getPartNo();
				   
                } 
            });
	}else{
		alert('Enter Valid Brand Name !!');
	}
 }
 function addNewBrandEdit(){
	 var brandName     	= $('#brandNameEdit').val();
	 var brandRemarks    = $('#brandCodeEdit').val();
	 var brandFormat    = null;//$('#brandFormat').val();
	 
	 //alert(brandName);
	 if(brandName!=''){
		 $.ajax({
               url: "../../../../modules/itemMaster/admin/ajax/addBrandAjax.php",
                type: "post",
                data: {brandName:brandName,brandRemarks:brandRemarks,brandFormat:brandFormat},
                success: function(data) {
					$('#brandIdEdit').empty();
                   $('#brandIdEdit').html(data);
				       //getPartNo();
				   
                } 
            });
	}else{
		alert('Enter Valid Brand Name !!');
	}
 }
 
 function addNewUnit(){
	 var unitName     	= $('#unitName').val();
	 if(unitName!=''){
		 $.ajax({
               url: "../../../../modules/itemMaster/admin/ajax/addUnitAjax.php",
                type: "post",
                data: {unitName:unitName},
                success: function(data) {
					$('#unit').html(data);
					$('#baseUnit').html(data);
				} 
            });
	}else{
		alert('Enter Valid Unit Name !!');
	}
 } 
 function addNewUnitEdit(){
	 var unitName     	= $('#unitNameEdit').val();
	 if(unitName!=''){
		 $.ajax({
               url: "../../../../modules/itemMaster/admin/ajax/addUnitAjax.php",
                type: "post",
                data: {unitName:unitName},
                success: function(data) {
					$('#unitEdit').html(data);
					$('#baseUnitEdit').html(data);
				} 
            });
	}else{
		alert('Enter Valid Unit Name !!');
	}
 }


/* ---- End Ajax For Category ---- */

 $(document).ready(function(){
	  $.ajax({
               url: "../../../../modules/itemMaster/admin/ajax/addCategoryAjax.php",
                type: "post",
                data: {allCategory:1},
                success: function(data) {
                    $('#categoryId').html(data)
				}
            });

			$.ajax({
               url: "../../../../modules/itemMaster/admin/ajax/addBranchAjax.php",
                type: "post",
                data: {allBranch:1},
                success: function(data) {
                  $('#branchId').html(data);
				
				}
            });
	
	 $.ajax({
               url: "../../../../modules/itemMaster/admin/ajax/addBrandAjax.php",
                type: "post",
                data: {allBrand:1},
                success: function(data) {
                  $('#brandId').html(data);
				
				}
            });
			
	$.ajax({
               url: "../../../../modules/itemMaster/admin/ajax/addUnitAjax.php",
                type: "post",
                data: {allUnit:1},
                success: function(data) {
					$('#unit').html(data);
					$('#baseUnit').html(data);
					$('#unitEdit').html(data);
				}
            });
	 
 });
 
 
function itemCodeDuplication()
        {
			
			 var partNo = $('#barcode').val();
            $.ajax({
                type: "GET",
                url: "../../../../modules/itemMaster/admin/ajax/itemCodeDuplication.php?partNo="+partNo,
                success: function(data)
                {
                    if(data == 1)
                    {
						alert("Barcode Duplication....");
							$('#barcode').val(null);
                    }
                    
                }
            })              
        }
 function itemCodeDuplicationEdit()
        {
			
			 var partNo = $('#barcodeEdit').val();
			 var itemMasterIdEdit = $('#itemMasterIdEdit').val();
            $.ajax({
                type: "POST",
				 data: {partNo:partNo,itemMasterIdEdit:itemMasterIdEdit},
                url: "../../../../modules/itemMaster/admin/ajax/itemCodeDuplicationEdit.php",
                success: function(data)
                {
                    if(data == 1)
                    {
						alert("Barcode Duplication....");
							$('#barcodeEdit').val(null);
                    }
                    
                }
            })              
        }
		
		
		function getSubcategory(){
			 var categoryId = $('#categoryId').val();
			 
			 $.ajax({
                type: "POST",
				dataType:'JSON',	
				 data: {categoryId:categoryId},
                url: "../../../../modules/itemMaster/admin/ajax/getSubCategoryData.php",
                success: function(data)
                {
                    $('#SubcategoryId').html(data.subcategoryList);
                    
                }
            })    
			
		}
		function getSubcategorys(){
			 var categoryId = $('#categoryIdEdit').val();
			 
			 $.ajax({
                type: "POST",
				dataType:'JSON',	
				 data: {categoryId:categoryId},
                url: "../../../../modules/itemMaster/admin/ajax/getSubCategoryData.php",
                success: function(data)
                {
                    $('#SubcategoryIdEdit').html(data.subcategoryList);
                    
                }
            })    
			
		}

		/* NGK */
		function setQuantity() {
            var branchId = $('#branchId').val();
            var quantityInput = document.getElementById("quantity");
            
            if (branchId !== "") {
                quantityInput.readOnly = false;
            } else {
                quantityInput.readOnly = true;
            }
        }

		function setQuantityEdit() {
            var branchId = $('#branchIdEdit').val();
            var quantityInput = document.getElementById("quantityEdit");
            
            if (branchId !== "") {
                quantityInput.readOnly = false;
            } else {
                quantityInput.readOnly = true;
				quantityInput.value = 0;
            }
        }
		/* NGK */
 </script>
 <script src="../../../../modules/deliveryNode/admin/ajax/sweetAlert.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
 
 function importExcelData(){
	
	// alert(regularCustomerId);
	var file_data = $("#importExcel").prop("files")[0]; 
	//alert(file_data);
	var form_data = new FormData(); 
	form_data.append("file", file_data);
	
	 $.ajax({
               url: "../../../../modules/itemMaster/admin/ajax/importExcelIndb.php",
                type: "post",
				dataType:'json',
                data:form_data,
				cache: false,
				contentType: false,
				processData: false,
                success: function(data) {
					if(data==1)
						swal({text: "Suucessfully imported !!",icon: "success",timer: 2000,buttons: false});
				}
            });
	}
	
	function getPartNo(){
		var brandId = $('#brandId').val();
		$.ajax({
               url: "../../../../modules/itemMaster/admin/ajax/getPartNo.php",
                type: "post",
                data: {brandId:brandId},
                success: function(data) {
					$('#partNoHidden').val(data);
					var partNoHidden  = $('#partNoHidden').val();
					var count = partNoHidden.length;
					//$('#partNo').maxLength(count);
					  $("#partNo").attr('maxlength',count);
					    $('#partNo').val('');
				}
            });
		
	}
	

function number(value){
	var noOfZero=0;
	var partNoHiddenFetch= $('#partNoHidden').val();
	var partNoHidden=partNoHiddenFetch.replace(/ /g,"-");
	var partNoHiddenRemoveSpace=partNoHiddenFetch.replace(/ /g,"");
	
	var z=Array.from(value);
	var x=Array.from(partNoHidden);
	var y=Array.from(partNoHiddenRemoveSpace);
	
	
	if(z.length<x.length){
		for(var j=1;j<(parseInt(x.length)-parseInt(z.length));j++){
				noOfZero +='0';
		}
	}else{
		noOfZero='';
	}
	
	
	var noOfZeroArray = Array.from(noOfZero);
	
	
	var newValue=$.merge( z,noOfZeroArray);
	//alert(newValue);
	
	var m = [];
	
	k=0;
	if(z.length>x.length){ 
		alert("sory");
	}else{
		for(var i=0;i<(x.length);i++){
			
			if(x[i]=='-'){
				m.push(' ');
			}else{
				
				m.push(newValue[k]);
				k++;
			}
			
		}
	}
	

	$('#partNo').val(m.join(""));
}

function setReuired(){
var quantity = $('#quantity').val();
if(quantity>0){
$('#expiryDate').attr('required', true); 

}else
	$('#expiryDate').attr('required', false); 
	
}
/*
function getBarcode(){
var categoryId = $('#SubcategoryId').val();	
	$.ajax({
               url: "../../../../modules/itemMaster/admin/ajax/getBarcode.php",
                type: "post",
                data: {categoryId:categoryId},
                success: function(data) {
					$('#barcode').val(data);
					
				}
            });
}*/

</script>


</head>
    <body>
<style>
select {
    font-size: 10px !important;
}
.form-control {
    height: 25px !important;
}
td, th {
	font-size: 13px !important;
}
.panel-heading {
    padding: 5px 15px !important;
}
.modal-dialog {
  
    margin: 30px auto;
}
.modal {
    position: fixed;
    margin-top: 0%;
}
table td ,table th {
	border:0.5px solid #e4e4da;
	border-collapse:collapse;
}
 td {
    padding: 0px 10px !important;
}
</style>
        
  <div class="col-sm-12 col-md-12 col-lg-12">
	<div class="panel panel-info">
		<div class="panel-heading" style="" >
			<table width="100%">
				<tr>
					<i class="fa fa-list-ul"></i> ITEM MASTER
					
				
						<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float:right;">Add </button>
<!-- <form action="" method="POST" enctype="multipart/form-data" >  
<button name="insertStockTbl" class='btn btn-success' ><i class="fa fa-save"></i>&nbsp;Submi</button></form>
  <input type="file" class="form-control input-sm" name='importExcel' id="importExcel"  />
<button type="button" onclick='importExcelData()' name='importExcels' class='btn btn-success' ><i class="fa fa-save"></i>&nbsp;Submit</button></form>-->
				</tr>
			</table>
		</div>
		<div class="panel-body" >
			<table width="100%" border="0" cellpadding="0" id="table_id"  class="" >
						<thead style="background-color:#d0e8d2">
							<tr>
								<th width="5%"><b>NO</b></th>							
								<th width="15%"><b>BARCODE</b></th>
								<th width="25%"><b>ITEM NAME</b></th> 
								<th width="10%"><b>CATEGORY</b></th>
								<th width="12%"><b>SUBCATEGORY</b></th>
								<th width="15%"><b>SELLING PRICE</b></th>
								<th width="5%"><b>EDIT</b></th>
								<th width="5%"><b>DELETE</b></th>
							</tr>
						</thead>	
						<tbody>
							<?php echo $itemMasterDetailsTable;?>
						
						</tbody>
			</table>			
			
            </div>
		</div>
	</div>


		

<!-- Modal POP UP to add New Item-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 1266px;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Item</h4>
      </div>
      <div class="modal-body">
		<form method="POST">
				<table width="100%" border="0" cellpadding="5">
					<tr>
						<td width="9%">Item Category</td>
						<td width="13%" colspan="2">
							<select class="form-control input-sm" name='categoryId' onchange="getSubcategory();" 
								id='categoryId'  required>
								<option value='' >Select</option>
							
							</select>
						</td>
						<td width="9%">Sub Category</td>
						<td width="13%" colspan="1">
							<select class="form-control input-sm" name='SubcategoryId'   onchange="" 
								id='SubcategoryId'  >
								
							
							</select>
						</td>
						<td width="7%">Brand(Group)</td>
						<td width="8%" >
							<select class="form-control input-sm" name='brandId' 
								id='brandId'   >
							<option value='' >Select</option>
							
							</select>
						</td>
						<td width="8%">
							<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addBrandModal" ><i class="fa fa-plus"></i></button>						
						</td>
						<td width="8%">Title</td>
						<td width="15%" colspan="2">
							<input type="text" class="form-control" autocomplete="off" id="tittle" name="tittle"  required >
						</td>
						
					</tr>
					<tr>
					<td>Title(Arabic)</td>
						<td colspan="2">
							<input type="text" class="form-control" autocomplete="off" id="tittleArabic" name="tittleArabic"   >
						</td>
					<td>Barcode</td>
					<td >
						 <input type="text" class="form-control" id="barcode" autocomplete="off" name="barcode"  onchange="itemCodeDuplication();"  required >
						<input type="hidden" id="partNoHidden" name="partNoHidden"/>
						<input type="hidden" id="OrginalpartNo" />
						<span id="user"></span>
					</td>
					<td>Import/Local Status</td>
					<td colspan="2">
						<select name="importOrLocal" id="importOrLocal" required class="form-control" >
						<option value="">Select</option>
						<option value="IMP">Import Purchase</option>
						<option value="LOC">Local Purchase</option>
						</select>
					</td>
					<!--<td>Expiry Date</td>-->
					<!--<td>
						<input type="text" autocomplete="off" class="form-control datepicker" onkeyup='checkNumber(this.id)' id="expiryDate" name="expiryDate">
					</td>-->
					<td colspan="2">WholeSale Price</td>
					<td>
						<input type="text" autocomplete="off" class="form-control" onkeyup='checkNumber(this.id)' id="wholeSalePrice" name="wholeSalePrice"  >					
					</td>
					
					
					
				</tr>
				<tr>
				<td width="8%">Max-Retail Price</td>
					<td colspan="2">
						<input type="text" autocomplete="off" class="form-control" onkeyup='checkNumber(this.id)' id="maxRetailPrice" name="maxRetailPrice" >					
					</td>
					<td>Min-Retails Price</td>
					<td >
						<input type="text" autocomplete="off" onkeyup='checkNumber(this.id)' class="form-control" id="minRetailPrice" name="minRetailPrice" >					
					</td>
					<td>Cost Price</td>
					<td>
						<input type="text" autocomplete="off" onkeyup='checkNumber(this.id)' class="form-control" id="costPrice" name="costPrice" >					
					</td>
					<td>Location</td>
					<td>
						<input type="text" autocomplete="off" class="form-control" id="location" name="location">	
					</td>
					<td>Minimum Qty</td>
					<td>
						<input type="text" autocomplete="off" onkeyup='checkNumber(this.id)' class="form-control" id="minimunQty" name="minimunQty" >					
					</td>
					
					
					
				</tr>
				<tr>
				<td>Reorder Qty</td>
					<td colspan="2">
						<input type="text" autocomplete="off" class="form-control" id="reorderQty" onkeyup='checkNumber(this.id)' name="reorderQty">					
					</td>
					<td>Maximum Qty</td>
					<td>
						<input type="text" autocomplete="off" onkeyup='checkNumber(this.id)' class="form-control" id="maximunQty" name="maximunQty" >
					</td>
					<td>Profit Level [%]</td>
					<td>
						<input type="text" autocomplete="off" class="form-control" id="profitLevel" name="profitLevel">
					</td>
					<td>Description(Arabic)</td>
					<td colspan="3">
						 <input type="text" autocomplete="off" class="form-control" name="description" id="description" >
					</td>
					
				</tr>
				<tr>
				<td>Vat%</td>
					<td colspan="2">
						<input type="text" autocomplete="off" onkeyup='checkNumber(this.id)' class="form-control" id="vatPer" name="vatPer" >
					</td>
					<td>Country</td>
					<td >
						<select name="country" id="country"  class="form-control">
						  <?php echo $country;?>
						</select>
					</td>
					<td>Note</td>
					<td colspan="5">
						  <input type="text" class="form-control" name="note" id="note" >
					</td>

				</tr>
				<tr>
				<?php
					if($privilageId==1 || $privilageId==12){ ?>
					<td><!--Quantity-->
						<!-- NGK -->
						Branch
						<!-- NGK -->
					</td>
					<td colspan="2">
						<!--<input type="text" autocomplete="off" class="form-control" onkeyup='checkNumber(this.id);' id="quantity" name="quantity" onchange="">	-->
						<!-- NGK -->
						<select class="form-control input-sm" name='branchId' onchange="setQuantity();" 
								id='branchId'>
								<option value='' >Select</option>
							
							</select> </td>
						<!-- NGK -->
						<?php } else{ ?>
							<td></td><td></td>
						<?php } ?>
					<?php
				/* if($privilageId!=12)
				{	 */
				?>
					<td>Quantity</td>
					<td>
						<input type="text" autocomplete="off" class="form-control" onkeyup='checkNumber(this.id);' id="quantity" name="quantity" onchange="" readonly value="0">	
					</td>
					<td>Expiry Date</td>
					<td>
						<input type="text" autocomplete="off" class="form-control datepicker" onkeyup='checkNumber(this.id)' id="expiryDate" name="expiryDate">
					</td>
					<td>Stock Date</td>
					<td>
						<input type="text" autocomplete="off" class="form-control datepicker" onkeyup='checkNumber(this.id)' id="stockDate" name="stockDate">
					</td>
				<?php
				//}
				?>
					</tr>
				<!--<?php $privilageId        =   $_SESSION['privillegeId'];
				      if($privilageId ==11){ ?>
				<tr>
					<td>Expiry Date</td>
					<td colspan="2">
						<input type="text" autocomplete="off" class="form-control datepicker" name="expiryDate" id="expiryDate" >
					</td>
					<td >Manufac. Date</td>
					<td colspan="2" >
						  <input type="text" autocomplete="off" class="form-control datepicker" name="manufacturingDate" id="manufacturingDate" style="width: 65%;">
					</td>
					<td >Batch No.</td>
					<td>
						  <input type="text" autocomplete="off" class="form-control" name="batchNo" id="batchNos" >
					</td>

				</tr>
					  <?php } ?>-->
				</table>
				<div class="row">
				<br/>
				<table width="30%" border="1" cellpadding="5" style="float:left;margin-left: 2%;">
							<tr>
								<th colspan="2">Base Unit</th>
							</tr>
							<tr>
								<th width="90%">
									<select class="form-control"  id='baseUnit' name='baseUnit' required>
										<option value=''>Select</option>
										<?php echo $unitSelectBox; ?>
									</select>
								</th>
								<th width="10%">
									<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addUnitModal"><i class="fa fa-plus"></i></button>	
								</th>
							</tr>
							
				</table>
				<table width="40%" border="1" cellpadding="5" style="float:right;margin-right: 2%;">
							<thead class="thead-dark" >
								<tr >
									<th width="50%">Other Units</th>
									<th  width="35%">Multiple</th>
									<th  width="10%"></th>
								</tr>
							</thead>
							<tbody id='unitTable'></tbody>
							<tfoot>
								<td>
									<select  class="form-control" id='unit'>
									</select>
								</td>
								<td>
									<input type="text" class="form-control" onkeyup='checkNumber(this.id)' id="multiple" placeholder="Multiple" >
								</td>
								<td>
									<button type='button' id='addUnit' class='btn btn-success btn-sm' ><i class="fa fa-plus"></i></button>
								</td>
							</tfoot>
				</table>
				</div>
				<center><button type='submit' name='submit' class='btn submitBtn' ><i style='color:#fff' class="fa fa-save"></i>&nbsp;<span style='color:#fff'>Save</span></button></center>
		</form>
      </div>
      
    </div>

  </div>
</div>
<!-- Modal POP UP to Edit Item -->
<div id="editItemMaster" class="modal fade" role="dialog">
  <div class="modal-dialog" style="  width: 1266px;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Item</h4>
      </div>
      <div class="modal-body">
		<form method="POST">
				<table width="100%" border="0" cellpadding="5">
					<tr>
						
						<td width="9%">Item Category</td>
						<td width="13%" colspan="2">
							<select class="form-control input-sm" name='categoryIdEdit' onchange="getSubcategorys();" 
								id='categoryIdEdit'  required>
								<option value='' >Select</option>
							
							</select>
						</td>
						<td width="9%">Sub Category</td>
						<td width="13%" colspan="1">
							<select class="form-control input-sm" name='SubcategoryIdEdit' 
								id='SubcategoryIdEdit'  >
								
							
							</select>
						</td>
						<td width="7%">Brand(Group)</td>
						<td width="8%" >
							<input type="hidden" name="itemMasterIdEdit" id="itemMasterIdEdit" />
							<select class="form-control input-sm" name='brandIdEdit' 
								id='brandIdEdit'   >
							<option value='' >Select</option>
							
							</select>
						</td>
						<td width="8%">
							<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addBrandModalEdit" ><i class="fa fa-plus"></i></button>						
						</td>
						<td width="8%">Title</td>
						<td width="15%" colspan="2">
							<input type="text" class="form-control" autocomplete="off" id="tittleEdit" name="tittleEdit"  required >
						</td>
						
					</tr>
					<tr>
					<td >Title(Arabic)</td>
						<td  colspan="2">
							<input type="text" class="form-control" autocomplete="off" id="tittleArabicEdit" name="tittleArabicEdit"   >
						</td>
					<td>Barcode</td>
					<td >
						 <input type="text" class="form-control" id="barcodeEdit" autocomplete="off" name="barcodeEdit"  onchange="itemCodeDuplicationEdit();"  readonly >
						<input type="hidden" id="partNoHiddenEdit" name="partNoHiddenEdit"/>
						<input type="hidden" id="OrginalpartNoEdit" />
						<span id="user"></span>
					</td>
					<td>Import/Local Status</td>
					<td colspan="2" id="addLocImp">
						<select name="importOrLocalEdit" id="importOrLocalEdit" required class="form-control" >
						<option value="">Select</option>
						<option value="IMP">Import Purchase</option>
						<option value="LOC">Local Purchase</option>
						</select>
					</td>
					<td><!--Expiry Date-->
					<td>
					<input type="hidden" style="width:100%" class="input-sm" id="branchIdHidden" name="branchIdHidden" value="" >
					<input type="hidden" style="width:100%" class="input-sm" id="privillageIdHidden" name="privillageIdHidden" value="" >
					<input type="hidden" style="width:100%" class="input-sm" id="openingStockHidden" name="openingStockHidden" value="" >
					</td>
					</td>
					<!--<td>
						<input type="text" autocomplete="off" class="form-control datepicker"  id="expiryDateEdit" name="expiryDateEdit" >
					</td>-->
					<td colspan="2">WholeSale Price</td>
					<td>
						<input type="text" autocomplete="off" class="form-control" onkeyup='checkNumber(this.id)' id="wholeSalePriceEdit" name="wholeSalePriceEdit"  >					
					</td>
					
					
					
				</tr>
				<tr>
				<td >Max-Retail Price</td>
					<td colspan="2">
						<input type="text" autocomplete="off" class="form-control" onkeyup='checkNumber(this.id)' id="maxRetailPriceEdit" name="maxRetailPriceEdit" >					
					</td>
					<td>Min-Retails Price</td>
					<td >
						<input type="text" autocomplete="off" onkeyup='checkNumber(this.id)' class="form-control" id="minRetailPriceEdit" name="minRetailPriceEdit" >					
					</td>
					<td>Cost Price</td>
					<td>
						<input type="text" autocomplete="off" onkeyup='checkNumber(this.id)' class="form-control" id="costPriceEdit" name="costPriceEdit" >					
					</td>
					<td>Location</td>
					<td>
						<input type="text" autocomplete="off" class="form-control" id="locationEdit" name="locationEdit">	
					</td>
					<td>Minimum Qty</td>
					<td>
						<input type="text" autocomplete="off" onkeyup='checkNumber(this.id)' class="form-control" id="minimunQtyEdit" name="minimunQtyEdit" >					
					</td>
					
					
					
				</tr>
				<tr>
				<td>Reorder Qty</td>
					<td colspan="2">
						<input type="text" autocomplete="off" class="form-control" id="reorderQtyEdit" onkeyup='checkNumber(this.id)' name="reorderQtyEdit">					
					</td>
					<td>Maximum Qty</td>
					<td >
						<input type="text" autocomplete="off" onkeyup='checkNumber(this.id)' class="form-control" id="maximunQtyEdit" name="maximunQtyEdit" >
					</td>
					<td>Profit Level [%]</td>
					<td>
						<input type="text" autocomplete="off" class="form-control" id="profitLevelEdit" name="profitLevelEdit">
					</td>
					<td>Description(Arabic)</td>
					<td colspan="3">
						 <input type="text" autocomplete="off" class="form-control" name="descriptionEdit" id="descriptionEdit" >
					</td>
					
				</tr>
				<tr>
				<td>Vat%</td>
					<td colspan="2">
						<input type="text" autocomplete="off" onkeyup='checkNumber(this.id)' class="form-control" id="vatPerEdit" name="vatPerEdit" >
					</td>
					<td>Country</td>
					<td >
						<select name="countryEdit" id="countryEdit"  class="form-control">
						  <?php echo $country;?>
						</select>
					</td>
					<td>Note</td>
					<td colspan="5">
						  <input type="text" class="form-control" name="noteEdit" id="noteEdit" >
					</td>

				</tr>
				<tr>
				<?php
					if($privilageId==1 || $privilageId==12){ ?>
					<td><!--Quantity-->
						<!-- NGK -->
						Branch
						<!-- NGK --></td>
					<td colspan="2">
						<!-- <input type="text" autocomplete="off" class="form-control" onkeyup='checkNumber(this.id)' id="quantityEdit" name="quantityEdit" >	 -->
						<select class="form-control input-sm" name='branchIdEdit' 
								id='branchIdEdit' onchange="setQuantityEdit();">
							<option value='' >Select</option>
							
							</select>
					</td>
						<?php } else{ ?>
							<td></td><td></td>
						<?php } ?>
					<?php
				/* if($privilageId!=12)
				{ */	
				?>
					<td>Quantity</td>
					<td>
						<input type="text" autocomplete="off" class="form-control" onkeyup='checkNumber(this.id)' id="quantityEdit" name="quantityEdit">	
					</td>
					<td>Expiry Date</td>
					<td>
						<input type="text" autocomplete="off" class="form-control datepicker"  id="expiryDateEdit" name="expiryDateEdit" >
					</td>
					<td>Stock Date</td>
					<td>
						<input type="text" autocomplete="off" class="form-control datepicker" onkeyup="checkNumber(this.id)" id="stockDateEdit" name="stockDateEdit">
					</td>
					</tr>
			<?php
				// }
				?>
				<!--<?php $privilageId        =   $_SESSION['privillegeId'];
				      if($privilageId ==11){ ?>
				<tr>
					<td>Expiry Date</td>
					<td colspan="2">
						<input type="text" autocomplete="off" class="form-control datepicker" name="expiryDateEdit" id="expiryDateEdit" >
					</td>
					<td >Manufac. Date</td>
					<td colspan="2" >
						  <input type="text" autocomplete="off" class="form-control datepicker" name="manufacturingDateEdit" id="manufacturingDateEdit" style="width: 65%;">
					</td>
					<td >Batch No.</td>
					<td>
						  <input type="text" autocomplete="off" class="form-control" name="batchNoEdit" id="batchNoEdit" >
					</td>

				</tr>
					  <?php } ?>-->
				</table>
				<div class="row">
				<br/>
				<table width="30%" border="1" cellpadding="5" style="float:left;margin-left: 2%;">
							<tr>
								<th colspan="2">Base Unit</th>
							</tr>
							<tr>
								<th width="90%">
									<select class="form-control"  id='baseUnitEdit' name='baseUnitEdit' required>
										<option value=''>Select</option>
									</select>
								</th>
								<th width="10%">
									<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addUnitModalEdit"><i class="fa fa-plus"></i></button>	
								</th>
							</tr>
							
				</table>
				<table width="40%" border="1" cellpadding="5" style="float:right;margin-right: 2%;">
							<thead class="thead-dark" >
								<tr>
									<th width="50%">Other Units</th>
									<th  width="35%">Multiple</th>
									<th  width="10%"></th>
								</tr>
							</thead>
							<tbody id='unitTableEdit'></tbody>
							<tfoot>
								<td>
									<select  class="form-control" id='unitEdit'>
									</select>
								</td>
								<td>
									<input type="text" class="form-control" onkeyup='checkNumber(this.id)' id="multipleEdit" placeholder="Multiple" >
								</td>
								<td>
									<button type='button' id='addUnitEdit' class='btn btn-success btn-sm' ><i class="fa fa-plus"></i></button>
								</td>
							</tfoot>
				</table>
				</div>
				<center><button type='submit' name='editItem' class='btn submitBtn' ><i style='color:#fff' class="fa fa-save"></i>&nbsp;<span style='color:#fff'>Save</span></button></center>
				</form>
      </div>
     
    </div>

  </div>
</div>
<!------------------- Modal For Add Brand ---------------->
		
<!--<div id="addBrandModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style='background-color:#086356;color:#fff'>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Brand</h4>
			</div>
			<div class="modal-body" style='background-color:#d5e1f7'>
				<p>
					<div class="form-group">
                	<label for="brandCode">Brand Code :</label>
                   <input type="text" name="brandCode" id="brandCode" required  class="form-control input-sm"  autocomplete="off"/>
                </div>
			
				<div class="form-group">
                	<label for="brandName">Brand Name :</label><span style="color:red;" class="mandatory">*</span>
                   <input type="text" name="brandName" id="brandName" required="" class="form-control input-sm" onChange="nameDuplication();"  autocomplete="off"/>
                </div>
            	<div class="form-group">
                	<label for="brandFormat">Format</label>
                    <input type="text" name="brandFormat" id="brandFormat" required class="form-control input-sm" />
                </div>
				</p>
			</div>
			
			<div class="modal-footer" style='background-color:#520101'>
			<center>
				<button type="button" onclick='addNewBrand()' class="btn btn-success" data-dismiss="modal">Add</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</center>
			</div>
		</div>
	</div>
</div>-->
<div id="addBrandModal" class="modal fade in" role="dialog" >
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add Brand</h4>
      </div>
      <div class="modal-body">
	  <form name="form1" method="post" action="">
			
			    <div class="form-group">
                	<label for="brandCode">Brand Code :</label>
                   <input type="text" name="brandCode" id="brandCode" onchange="nameDuplication();" required="" class="form-control input-sm" autocomplete="off">
                </div>
			
				<div class="form-group">
                	<label for="brandName">Brand Name :</label><span style="color:red;" class="mandatory">*</span>
                   <input type="text" name="brandName" id="brandName" required="" class="form-control input-sm" autocomplete="off">
                </div>
            	
                <div class="form-group">
                	<center>
               							<button type="button" onclick='addNewBrand()' class="btn btn-success" data-dismiss="modal">Add</button>

           		 	</center>
             	</div>
			</form> 	
			 </div>
      
    </div>

  </div>
</div>
<div id="addBrandModalEdit" class="modal fade in" role="dialog" >
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add Brand</h4>
      </div>
      <div class="modal-body">
	  <form name="form1" method="post" action="">
			
			    <div class="form-group">
                	<label for="brandCode">Brand Code :</label>
                   <input type="text" name="brandCodeEdit" id="brandCodeEdit" onchange="nameDuplication();" required="" class="form-control input-sm" autocomplete="off">
                </div>
			
				<div class="form-group">
                	<label for="brandName">Brand Name :</label><span style="color:red;" class="mandatory">*</span>
                   <input type="text" name="brandNameEdit" id="brandNameEdit" required="" class="form-control input-sm" autocomplete="off">
                </div>
            	
                <div class="form-group">
                	<center>
               							<button type="button" onclick='addNewBrandEdit()' class="btn btn-success" data-dismiss="modal">Add</button>

           		 	</center>
             	</div>
			</form> 	
			 </div>
      
    </div>

  </div>
</div>
		
<!------------------- End Modal For Add Brand ---------------->

<!------------------- Modal For Add Unit ---------------->
		
<div id="addUnitModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" >
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Unit</h4>
			</div>
			
			<div class="modal-body" >
				<p>
					<div class="form-group">
						<label for="brandName">Unit Name :</label><span style="color:red;" class="mandatory">*</span>
						<input type="text"   id="unitName" required="" class="form-control input-sm" onChange="nameDuplication();" autocomplete="off"/>
					</div>
					
				</p>
			</div>
			
			<div class="modal-footer" >
			<center>
				<button type="button" onclick='addNewUnit()' class="btn btn-danger" data-dismiss="modal" >Add</button>
			</center>
			</div>
			
		</div>
	</div>
</div>
<div id="addUnitModalEdit" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" >
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Unit</h4>
			</div>
			
			<div class="modal-body" >
				<p>
					<div class="form-group">
						<label for="brandName">Unit Name :</label><span style="color:red;" class="mandatory">*</span>
						<input type="text"   id="unitNameEdit" required="" class="form-control input-sm" onChange="nameDuplication();" autocomplete="off"/>
					</div>
					
				</p>
			</div>
			
			<div class="modal-footer" >
			<center>
				<button type="button" onclick='addNewUnitEdit()' class="btn btn-danger" data-dismiss="modal" >Add</button>
			</center>
			</div>
			
		</div>
	</div>
</div>
		
<!------------------- End Modal For Add unit ---------------->
		
	</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>

<script>

$(document).ready( function () {
	$.noConflict();
    $('#table_id').DataTable();
} );

</script>