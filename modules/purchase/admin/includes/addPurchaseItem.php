<?php
/*------------------------------------Coding And Design By DIPIN D----------------------------------------*/
require_once("../../../../modules/purchase/admin/controllers/c_purchase.php");
require_once("../../../../modules/purchase/admin/class/m_purchase.php");
require_once("../../../../libraries/class/utils.php");
require_once("../../../../settings/path.php");
require_once("../../../../modules/salesInvoice/admin/controllers/c_salesInvoice.php");
	require_once('../../../../modules/itemMaster/admin/controller/ItemMasterController.php');
	$objItemMasterController=new ItemMasterController();
	$country                = 	$objItemMasterController->getCountry();
	
$objPath          		= 	new Path(); 
$objCPurchase 			= 	new C_Purchase();
$objMPurchase           =   new M_Purchase();
$objUtils 	 			= 	new Utils();
$objCSalesInvoice		= 	new C_salesInvoice();

$maxInvoiceNo 			=	''; 
$dropDownForVendor  	=	'';
$purchasePaymentId      =   '';
$maxInvoiceNo 			= 	$objCPurchase->getMaxInvoiceNo(); 
$dropDownForVendor 	 	=	$objCPurchase->dropDownForvendorName();
$currencyData			=	$objCPurchase->getCurrencyData();

$privilageId       	 	=   	$_COOKIE['privillegeId'];
$branchId        		=   	$_COOKIE['branchId'];
$userId					=		$_COOKIE['userId'];
$mainBranch        		= 		$_COOKIE['mainBranch'];

if(isset($_POST['submitBtn']))
{
	
	$invoiceNo					=	$_POST['invoiceNo'];
	$vendorId					=	$_POST['vendorId'];
	$invoiceCount 				= 	$objCPurchase->checkInvoiceNoExistOrNot($invoiceNo,$vendorId,$privilageId,$branchId);
	
	if($invoiceCount==0)
	{ 
	/*---------------------------------Insert To Purchase Item Bill----------------------------------------------*/
	$venderName                 =   $_POST['venderName'];
	$invoiceDate				=	$objUtils->formatDate($_POST['invoiceDate']) ; 
	$vendorId					=	$_POST['vendorId'];
	$discount   				=	$_POST['billDiscount'];
	$billTotalWithOutDiscount	=	$_POST['totalAmount'];
	$amountWithDiscountTotal	=	$_POST['amountWithDiscountTotal'];
	$totalVatAmount				=	$_POST['vatAmountTotal'];
	$vatPercentTotal			=	$_POST['vatPercentTotal'];
	$billTotalWithVat			=	$_POST['amountWithVat'];
	$typeOfTransactionId		=	$_POST['typeOfTransactionId'];
	$currencyDetails			=	$_POST['currency'];
	$customerPoNo				=	$_POST['customerPoNo'];
	$deliveryOrderNo			=	$_POST['deliveryOrderNo'];
	$currencyDetailsArray		=	explode("/",$currencyDetails);
	$currencyId					=	$currencyDetailsArray[0];	
	//$exRate						=	$currencyDetailsArray[1];
    $exRate	                    =  $_POST['exRate'];
	$amountAfterDiscount        =   $billTotalWithOutDiscount;
	$netAmountWithExRate1       = $billTotalWithVat*$exRate;
	$netAmountWithExRate       = number_format($netAmountWithExRate1,2,'.','');

	
	$purchaseItemBillId			=	$objCPurchase->insertToPurchaseItemBill($invoiceNo,$invoiceDate,$vendorId,$discount,$billTotalWithOutDiscount,
										$amountWithDiscountTotal,$totalVatAmount,$billTotalWithVat,$typeOfTransactionId,$userId,$currencyId,$exRate,
										$netAmountWithExRate,$customerPoNo,$deliveryOrderNo,$vatPercentTotal,$privilageId,$branchId,$mainBranch);
	/*---------------------------------Insert To Purchase Item Bill Ends----------------------------------------------*/
	
	/*---------------------------------Insert To Purchase Item ----------------------------------------------*/
	$itemUnitRow				=	$_POST['itemUnitRow'];
	$itemMasterId				=	$_POST['itemMasterId'];
	$quantityRow				=	$_POST['quantityRow'];
	$netWeightRow				=	$_POST['netWeightRow'];
	$unitPriceRow				=	$_POST['unitPriceRow'];
	$amountRow					=	$_POST['amountRow'];
	$discountRow				=	'';//$_POST['discountRow'];
	$amountAfterDiscountRow		=	'';//$_POST['amountAfterDiscountRow'];
	$vatPercentRow				=	$_POST['vatRow'];
	$vatAmountRow				=	$_POST['vatAmountRow'];
	$totalWithVatAmountRow		=	$_POST['totalWithVatAmountRow'];
	$expiryDate                 =   $_POST['expiryDate'];
	
	if($purchaseItemBillId>0) 
	{
		for($i=0;$i<count($itemMasterId);$i++)
		{
		$expiryDateItem			=	$objUtils->formatDate($expiryDate[$i]) ; 
		$itemUnitRowArray 		=	explode("-",$itemUnitRow[$i]);
		$itemUnitId				=	$itemUnitRowArray [0];
		$unitFraction			=	$itemUnitRowArray [1];
			$purchaseItemId = $objCPurchase->insertToPurchaseItem($purchaseItemBillId,$itemMasterId[$i],$quantityRow[$i],$unitPriceRow[$i],$amountRow[$i],$discountRow[$i],$amountAfterDiscountRow[$i],$vatPercentRow[$i],$vatAmountRow[$i],$totalWithVatAmountRow[$i],$itemUnitId,$unitFraction,$expiryDateItem,$netWeightRow[$i]); 	
			$stock         =  $objCPurchase->getRemainingStock($itemMasterId[$i],$expiryDateItem,$privilageId,$branchId);
			$objCPurchase->insertItemTransferDetails($invoiceDate,$invoiceNo,$itemMasterId[$i],$quantityRow[$i],$netWeightRow[$i],$expiryDateItem,$itemUnitId,
							$purchaseItemId,$venderName,$stock,$privilageId,$branchId,$userId);
		}
	}
	
	
	header("location:welcome.php?page=purchasePrint&purchaseItemBillId=$purchaseItemBillId&referanceNo=1");
	
	}else{
		$objPath->setHeader('addPurchaseItem','Invoice Number Duplication!!!','purchase');
	}
} 
 if(isset($_POST['addamdSaveBtn']))
{
	
			
	$invoiceNo					=	$_POST['invoiceNo'];
	$vendorId					=	$_POST['vendorId'];
	$invoiceCount 				= 	$objCPurchase->checkInvoiceNoExistOrNot($invoiceNo,$vendorId,$privilageId,$branchId);
	if($invoiceCount==0)
	{
	  
	/*---------------------------------Insert To Purchase Item Bill----------------------------------------------*/
	$venderName                 =   $_POST['venderName'];
	$invoiceDate				=	$objUtils->formatDate($_POST['invoiceDate']) ; 
	$vendorId					=	$_POST['vendorId'];
	$discount   				=	$_POST['billDiscount'];
	$billTotalWithOutDiscount	=	$_POST['totalAmount'];
	$amountWithDiscountTotal	=	$_POST['amountWithDiscountTotal'];
	$totalVatAmount				=	$_POST['vatAmountTotal'];
	$vatPercentTotal			=	$_POST['vatPercentTotal'];
	$billTotalWithVat			=	$_POST['amountWithVat'];
	$typeOfTransactionId		=	$_POST['typeOfTransactionId'];
	$customerPoNo				=	$_POST['customerPoNo'];
	$deliveryOrderNo			=	$_POST['deliveryOrderNo'];
	$currencyDetails			=	$_POST['currency'];
	$currencyDetailsArray		=	explode("/",$currencyDetails);
	$currencyId					=	$currencyDetailsArray[0];	
	//$exRate						=	$currencyDetailsArray[1];
    $exRate	                    =  $_POST['exRate'];
    $barcodeRow	                =  $_POST['barcodeRow'];
	$amountAfterDiscount        =   $billTotalWithOutDiscount;
	$netAmountWithExRate1       = $billTotalWithVat*$exRate;
	$netAmountWithExRate       = number_format($netAmountWithExRate1,2,'.','');

	$purchaseItemBillId			=	$objCPurchase->insertToPurchaseItemBill($invoiceNo,$invoiceDate,$vendorId,$discount,$billTotalWithOutDiscount,
									$amountWithDiscountTotal,$totalVatAmount,$billTotalWithVat,$typeOfTransactionId,$userId,$currencyId,$exRate,
									$netAmountWithExRate,$customerPoNo,$deliveryOrderNo,$vatPercentTotal,$privilageId,$branchId,$mainBranch);
	/*---------------------------------Insert To Purchase Item Bill Ends----------------------------------------------*/
	
	/*---------------------------------Insert To Purchase Item ----------------------------------------------*/
	$itemUnitRow				=	$_POST['itemUnitRow'];
	$itemMasterId				=	$_POST['itemMasterId'];
	$quantityRow				=	$_POST['quantityRow'];
	$netWeightRow				=	$_POST['netWeightRow'];
	$unitPriceRow				=	$_POST['unitPriceRow'];
	$amountRow					=	$_POST['amountRow'];
	$discountRow				=	'';//$_POST['discountRow'];
	$amountAfterDiscountRow		=	'';//$_POST['amountAfterDiscountRow'];
	$vatPercentRow				=	'';//$_POST['vatRow'];
	$vatAmountRow				=	'';//$_POST['vatAmountRow'];
	$totalWithVatAmountRow		=	'';//$_POST['totalWithVatAmountRow'];
	$expiryDate                 =   $_POST['expiryDate'];
		$importLocalStatus                 =   $_POST['importLocalStatus'];
	
	if($purchaseItemBillId>0) 
	{
		for($i=0;$i<count($itemMasterId);$i++)
		{
		$expiryDateItem			=	$objUtils->formatDate($expiryDate[$i]) ; 
		$itemUnitRowArray 		=	explode("-",$itemUnitRow[$i]);
		$itemUnitId				=	$itemUnitRowArray [0];
		$unitFraction			=	$itemUnitRowArray [1];
		$checkBarcodeExitsOrNot = 	$objMPurchase->checkBarcodeExitsOrNot($itemMasterId[$i],$expiryDateItem,$importLocalStatus[$i]);
		if($checkBarcodeExitsOrNot==0){
				$barcodeId 		= 	$objMPurchase->insertIntoBarcode($barcodeRow[$i],$itemMasterId[$i],$expiryDateItem,$importLocalStatus[$i]);
		}else{
				$barcodeId 		= 	$objMPurchase->getBarcode($itemMasterId[$i],$expiryDateItem,$importLocalStatus[$i]);
		}

			$purchaseItemId = $objCPurchase->insertToPurchaseItem($purchaseItemBillId,$itemMasterId[$i],$quantityRow[$i],$unitPriceRow[$i],$amountRow[$i],$discountRow[$i],$amountAfterDiscountRow[$i],$vatPercentRow[$i],$vatAmountRow[$i],$totalWithVatAmountRow[$i],$itemUnitId,$unitFraction,$expiryDateItem,$netWeightRow[$i],$barcodeId);

				if($purchaseItemId>0)
				{
					$stockQuantity			=	$netWeightRow[$i];//$quantityRow[$i]*$unitFraction;
					$existInStockTable 		=	$objMPurchase->checkExistInStockTable($itemMasterId[$i],$expiryDateItem,$importLocalStatus[$i]);
					if($existInStockTable>0)
					{
						$updateStock			=	$objMPurchase->updateStockInItemMaster($itemMasterId[$i],$stockQuantity,$expiryDateItem,$privilageId,$branchId);
					}else{
						/*$checkNullStock			=	$objMPurchase->checkStockWithNull($itemMasterId[$i]);
						if($checkNullStock>0)
						{	
							$updateStock			=	$objMPurchase->updateStockInStockTable($itemMasterId[$i],$stockQuantity,$expiryDateItem,$privilageId,$branchId);	
						}else{*/
							$insertStock	=	$objMPurchase->insertStockInStockTable($itemMasterId[$i],$stockQuantity,$expiryDateItem,$barcodeRow[$i],$privilageId,$branchId);
						//}
					}
				}
				
				
			$stock         =  $objCPurchase->getRemainingStock($itemMasterId[$i],$expiryDateItem,$privilageId,$branchId);
			$objCPurchase->insertItemTransferDetails($invoiceDate,$invoiceNo,$itemMasterId[$i],$quantityRow[$i],$netWeightRow[$i],$expiryDateItem,$itemUnitId,
							$purchaseItemId,$venderName,$stock,$privilageId,$branchId,$userId);
		}
	}
	
		if($exRate=='' || $exRate==0)
			$exRate=1;
		$amountAfterDiscount1 = $amountAfterDiscount * $exRate;
		$amountAfterDiscount  = number_format($amountAfterDiscount1,2,'.','');
		$discount1            = $discount * $exRate;
		$discount             = number_format($discount1,2,'.','');
		$totalVatAmount1      = $totalVatAmount * $exRate;
		$totalVatAmount       = number_format($totalVatAmount1,2,'.','');
		$billTotalWithVat1    = $billTotalWithVat * $exRate;
		$billTotalWithVat     = number_format($billTotalWithVat1,2,'.','');
		
		$objMPurchase->insertAccountjournal($purchaseItemBillId, $invoiceDate,$vendorId,$amountAfterDiscount,$discount,$totalVatAmount,$billTotalWithVat,$invoiceNo,$userId,$privilageId,$branchId);
		if($typeOfTransactionId=='1'){
			$PurcahsePaymentVoucherNo		=	$objCPurchase->getPurcahsePaymentVoucherNo();
			$purchasePaymentId				=	$objMPurchase->insertTopuchaseAmountPayment($purchaseItemBillId,$invoiceDate,$billTotalWithVat,$PurcahsePaymentVoucherNo,$userId,$privilageId,$branchId);
		   $objMPurchase->insertAccountjournalForPayment($purchaseItemBillId, $invoiceDate,$vendorId,$billTotalWithVat,$invoiceNo,$userId,$privilageId,$branchId,$mainBranch);
		}
	/*---------------------------------Insert To Purchase Item Ends----------------------------------------------*/

	header("location:welcome.php?page=purchasePrint&purchaseItemBillId=$purchaseItemBillId&referanceNo=1");
	}else{
		$objPath->setHeader('addPurchaseItem','Invoice Number Duplication!!!','purchase');
	}
}  


?>
<!--Autocomplete-Link-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style >.ui-autocomplete { height: 200px; overflow-y: scroll; overflow-x: hidden;}</style>
<script>
$( document ).ready(function() {
   document.getElementById("materialSearch").focus();
});
</script>
<script type="text/javascript">


$(document).on('keydown', function(e) {
   if (e.key === "Enter") {
        e.preventDefault();

        var $canfocus = $(':tabbable:visible');
        var index = $canfocus.index(document.activeElement) + 1;

        if (index >= $canfocus.length) index = 0;
        $canfocus.eq(index).focus();
    }


});
</script>


<script type="text/javascript">

$(function(){
$("#materialSearch").autocomplete({
   source: function(request, response) {
     $.getJSON("../../../../modules/purchase/admin/ajax/searchMaterials.php", {
		 term  : $('#materialSearch').val()}, 
              response);
  },
      minLength: 0,
      focus: function( event, ui ) {
        $("#materialSearch").html( ui.item.value );
        return false;
      },
      select: function( event, ui ) {
		getMaterialRow(ui.item.key,ui.item.itemName,ui.item.itemCode,ui.item.vat,ui.item.importLocalStatus);
		$('#materialSearch').val(null);
		 return false;
      } 
   });
});


$(function(){
 $("#venderName").autocomplete({
   source: function(request, response) {
    
     $.getJSON("../../../../modules/purchase/admin/ajax/vendorNameAutoComplete.php", {
   term  : $('#venderName').val()},
              response
  );
 
  },
      minLength: 0,
      focus: function( event, ui ) {
    //$("#model").autocomplete("search", "");
        $("#venderName").html( ui.item.value );
        return false;
      },
      select: function( event, ui ) {
        $( "#venderName" ).val( ui.item.value );
        $("#vendorId").val( ui.item.key );
        return false;
      } ,
        change: function (event, ui) {
             if (ui.item == null) 
           // $("#vendorId").val('');
             $("#venderName").val('');
		}

   });
 
});

 function invoiceNoDuplication()
        {
			
			var invoiceNo=vendorId = '';
			
			var invoiceNo= $('#invoiceNo').val();
			var vendorId= $('#vendorId').val();
			
			$.ajax({

                type: "POST",

                url: "../../../../modules/purchase/admin/ajax/invoiceNoDuplication.php",

				 data:{invoiceNo:invoiceNo,vendorId:vendorId},

				 cache:false,

                success: function(data)

                {
					
					if(data==1)
					{
						alert("Invoice No Duplication");
						$('#invoiceNo').val('');
						$('#venderName').val('');
						$('#vendorId').val('');
					}

                }

            })              
			
            
		}


	
 var i=1;
function getMaterialRow(itemMasterId,itemName,itemCode,vat,importLocalStatus)
{
	$.ajax({
                type: "GET",
                url: "../../../../modules/purchase/admin/ajax/getMaterialUnit.php?itemMasterId="+itemMasterId,
                success: function(data)
                {
				  var selectBoxForUnit	=	'<select class="input-sm form-group" name="itemUnitRow[]" id="itemUnitRow'+i+'" onchange="checkUnit('+i+')" style="width: 100%;height: 30px !important;" required ><option value="">-unit-</option>'+JSON.parse(data)+'</select>'	;
				  var materialTableRow	=	'<tr><td><input type="hidden" name="importLocalStatus[]" value="'+importLocalStatus+'"  /><input type="hidden" name="barcodeRow[]" class="form-control input-sm" value="'+itemCode+'" readonly /><input type="hidden" name="itemMasterId[]" class="form-control input-sm" value="'+itemMasterId+'" /><input name="itemCodeRow[]" id="itemCode'+i+'"  style="width: 100%;direction: rtl" type="text" class=" input-sm" value="'+itemCode+'" readonly /></td>';
					  materialTableRow	+=	'<td><input type="hidden" name="descriptionRow[]" id="descriptionRow'+i+'" value="'+itemName+'" style="width: 100%;" class=" input-sm"  readonly/><input name="itemNameRow[]" id="itemNameRow'+i+'"  style="width: 100%;direction: rtl" type="text" class=" input-sm" value="'+itemName+'" readonly /></td>';
					  materialTableRow	+=	'<td><input type="text"  name="quantityRow[]" required id="quantityRow'+i+'" value="" onkeyup="checkNumber(this.id);checkUnit('+i+');" onchange="checkNumber(this.id);checkUnit('+i+');" style="width: 100%;direction: rtl" class="input-sm quantityRow" /></td>';
					  materialTableRow	+=	'<td>'+selectBoxForUnit+'</td>';
					  materialTableRow	+=	'<td><input name="netWeightRow[]" value="" id="netWeightRow'+i+'" onkeyup="checkNumber(this.id);checkUnit('+i+');" onchange="checkNumber(this.id);checkUnit('+i+');"   style="width: 100%;direction: rtl" type="text" class=" input-sm netWeightRow" readonly /></td>'; 
					  materialTableRow	+=	'<td><input name="unitPriceRow[]" id="unitPriceRow'+i+'" onkeyup="checkNumber(this.id);checkUnit('+i+');" onchange="checkNumber(this.id);checkUnit('+i+');"  style="width: 100%;direction: rtl" type="text" class=" input-sm " /></td>';
					  materialTableRow	+=	'<td><input name="amountRow[]" value="" id="amountRow'+i+'"  style="width: 100%;direction: rtl" type="text" class=" input-sm amountRowTotal" readonly /></td>';
					 // materialTableRow	+=	'<td><input name="discountRow[]" value="0" id="discountRow'+i+'"  style="width: 100%;" type="text" class=" input-sm discountRowTotal" onkeyup="checkNumber(this.id);calculateRowTotal('+i+');" /><input name="amountAfterDiscountRow[]" value="0" id="amountAfterDiscountRow'+i+'"  style="width: 100%;" type="hidden" class=" input-sm amountAfterDiscountRowTotal" readonly  />';
					  //materialTableRow	+=	'<td style="width: 8%;"><input name="amountAfterDiscountRow[]" value="0" id="amountAfterDiscountRow'+i+'"  style="width: 100%;" type="text" class=" input-sm amountAfterDiscountRowTotal" readonly  /></td>';					  
					 // materialTableRow	+=	'<td><input name="vatRow[]"  id="vatRow'+i+'" value="'+vat+'" onkeyup="checkNumber(this.id);calculateRowTotal('+i+');" style="width: 100%;" type="text" class=" input-sm" /></td>';
					 // materialTableRow	+=	'<td><input name="vatAmountRow[]" value="0" id="vatAmountRow'+i+'"  style="width: 100%;"  type="text" class=" input-sm vatAmountRowTotal" readonly /></td>';
					 // materialTableRow	+=	'<td><input name="totalWithVatAmountRow[]" value="0" id="totalWithVatAmountRow'+i+'" style="width: 100%;"  type="text" class=" input-sm totalWithVatAmount" readonly /></td>';
					  materialTableRow	+='<td><input name="expiryDate[]" type="text" style="width: 100%;" class="input-sm datepicker" style="width: 100%;" id="expiryDate'+i+'" autocomplete="off" onblur="tabPressFocus('+i+')" required></td>';
					  
					  materialTableRow	+=	'<td width="3%" style="padding:3px !important"><button type="button" onclick="deleteRow(this)"  class="btn btn-danger btnSubmit btn-xs" ><i class="fa fa-times"></i></button></td></tr>';
				  //$('#materialDetailsTbody').append(materialTableRow);
				   $("#materialDetailsTbody").prepend(materialTableRow);
				   document.getElementById("itemCode"+i).focus();


				 i++;
				}
            })				
}

function deleteRow(r)
{
   var i = r.parentNode.parentNode.rowIndex;
   document.getElementById("addPurchaseItemTable").deleteRow(i);
   calculateSum();
}

  
	function checkNumber(argId){
        //alert('numeric');
        var quantity = (document.getElementById(argId).value);
        if(quantity == "")
                document.getElementById(argId).value = null;
        else{
                if(isNaN(quantity) == true){
                        quantity = quantity.trim();
                        var tempQuantity= quantity.replace(/\D+/, '');
                        if(tempQuantity  == "")
                        document.getElementById(argId).value = null;
                        else
                        document.getElementById(argId).value = tempQuantity;
                }
        }
}
function checkUnit(i)
{
	var unitName = $("#itemUnitRow"+i+" option:selected").text();
	if(unitName =='OTHER')
	{
		$('#netWeightRow'+i).prop('readonly', false);	
		calculateRowTotalOtherUnit(i);
	}else if(unitName =='CARTON')
	{
		$('#netWeightRow'+i).prop('readonly', true);
		calculateRowTotalCartonUnit(i)
	}else{
		$('#netWeightRow'+i).prop('readonly', true);
		calculateRowTotal(i);
	}
}
function calculateRowTotalCartonUnit(i)
{
	var unitPriceRow		=	parseFloat($('#unitPriceRow'+i).val());
	   var quantityRow		=	parseFloat($('#quantityRow'+i).val());
	    var value = $("#itemUnitRow"+i+" option:selected").val();
	   var arry = value.split('-');
		if(isNaN(arry[1])){
			var fraction = 0;
		}else{
			var fraction = parseFloat(arry[1]);
		}
		var newNeightWeight = quantityRow*fraction;
		var rowTotal		= quantityRow*unitPriceRow;
		if(newNeightWeight==0 ||isNaN(newNeightWeight))
		{
			$('#netWeightRow'+i).val(null);
		}else{
			$('#netWeightRow'+i).val(newNeightWeight.toFixed(2));
		}
		if(rowTotal==0||isNaN(rowTotal))
		{
			$('#amountRow'+i).val(null);
		}else{
			 
			$('#amountRow'+i).val(rowTotal.toFixed(2));
		}
	   //$('#amountRow'+i).val(rowTotal.toFixed(2));
	   //$('#totalWithVatAmountRow'+i).val(rowTotal.toFixed(2));
	   
	   calculateSum();
	   //calculateRowVatAmount(i);
}
function calculateRowTotalOtherUnit(i)
{
	
	   var unitPriceRow			=	parseFloat($('#unitPriceRow'+i).val());
	   var netWeightRow			=	parseFloat($('#netWeightRow'+i).val());
		var rowTotal		= netWeightRow*unitPriceRow;
		if(rowTotal==0||isNaN(rowTotal))
		{
			$('#amountRow'+i).val(null);
		}else{
			 
			$('#amountRow'+i).val(rowTotal.toFixed(2));
		}
	   //$('#amountRow'+i).val(rowTotal.toFixed(2));
	   //$('#totalWithVatAmountRow'+i).val(rowTotal.toFixed(2));
	   
	   calculateSum();
	   //calculateRowVatAmount(i);
}
 function calculateRowTotal(i)
   {
	   var quantityRow			=	parseFloat($('#quantityRow'+i).val());
	   var unitPriceRow			=	parseFloat($('#unitPriceRow'+i).val());
	   var value = $("#itemUnitRow"+i+" option:selected").val();
	   var arry = value.split('-');
		if(isNaN(arry[1])){
			var fraction = 0;
		}else{
			var fraction = parseFloat(arry[1]);
		}
		var newNeightWeight = quantityRow*fraction;
		var rowTotal		= newNeightWeight*unitPriceRow;
		if(newNeightWeight==0 ||isNaN(newNeightWeight))
		{
			$('#netWeightRow'+i).val(null);
		}else{
			$('#netWeightRow'+i).val(newNeightWeight.toFixed(2));
		}
		if(rowTotal==0||isNaN(rowTotal))
		{
			$('#amountRow'+i).val(null);
		}else{
			 
			$('#amountRow'+i).val(rowTotal.toFixed(2));
		}
	   //$('#totalWithVatAmountRow'+i).val(rowTotal.toFixed(2));
	   calculateSum();
	   //calculateRowVatAmount(i);
   }
   function calculateRowVatAmount(i)
   {
	   var vatRow		=	$('#vatRow'+i).val();
	   var amountRow	=	$('#amountRow'+i).val();	
	    if(vatRow>0)
	   {
		   var vatAmount	=	(parseFloat(amountRow)*parseFloat(vatRow))/100;
	   }else{
		   var vatAmount	=	0;   
	   }
	    var totalAmountWithVat	=	parseFloat(amountRow)+parseFloat(vatAmount);	
		$('#vatAmountRow'+i).val(vatAmount.toFixed(2));
	    $('#totalWithVatAmountRow'+i).val(totalAmountWithVat.toFixed(2));	
		calculateSum();
   }
   
   function calculateRowDiscount(i)
{
	var amountRow			=	$('#amountRow'+i).val();
	var discountRow			=	$('#discountRow'+i).val();
	if(discountRow=='' || discountRow== null)
	{
		discountRow=0;
		$('#discountRow'+i).val(0);
	}
	
	if(parseFloat(discountRow)>parseFloat(amountRow))
	{
		alert('Discount Amount Greater Than Total Amount');
		$('#amountRow'+i).val(amountRow);
		$('#discountRow'+i).val(0);
	}else{
	var rowDiscountAmount	=	parseFloat(amountRow)-parseFloat(discountRow);
	$('#amountAfterDiscountRow'+i).val(rowDiscountAmount.toFixed(2));
	}
	calculateRowVatAmount(i);	
	calculateSum();	
}
   function calculateSum()
   { 
	var totalAmount = 0;
	$('.amountRowTotal').each(function(){
		var amountRow =	parseFloat(this.value);
		if(isNaN(amountRow))
		{
			amountRow	=	0;
		}
    totalAmount += amountRow;
	});
	var totalQuantity = 0;
	$('.quantityRow').each(function(){
		var qtyRow =	parseFloat(this.value);
		if(isNaN(qtyRow))
		{
			qtyRow	=	0;
		}
    totalQuantity +=qtyRow;
	});
	
	var netWeightTotal = 0;
	$('.netWeightRow').each(function(){
		var nerWeightRow =	parseFloat(this.value);
		if(isNaN(nerWeightRow))
		{
			nerWeightRow	=	0;
		}
    netWeightTotal +=nerWeightRow;
	});
	   	
	
	/*var vatAmountTotal = 0;
	$('.vatAmountRowTotal').each(function(){
    vatAmountTotal += parseFloat(this.value);
	});
	var totalDiscountAmount = 0;
	$('.discountRowTotal').each(function(){
    totalDiscountAmount += parseFloat(this.value);
	});
	
	var totalWithVatAmount = 0;
	$('.totalWithVatAmount').each(function(){
    totalWithVatAmount += parseFloat(this.value);
	});
	
  	
	var amountWithDiscountTotal = 0;
	$('.amountAfterDiscountRowTotal').each(function(){
    amountWithDiscountTotal += parseFloat(this.value);
	}); */
	
	//var afterDiscount  =0;

	//afterDiscount           =   parseFloat(totalAmount)-parseFloat(totalDiscountAmount);
	//totalWithVatAmount		=	parseFloat(totalAmount)+parseFloat(vatAmountTotal);
	if(totalAmount==0||isNaN(totalAmount))
		{
			$('#totalAmount').val(null);
			$('#amountWithVat').val(null);
		}else{
			 
			$('#totalAmount').val(totalAmount.toFixed(2));
			$('#amountWithVat').val(totalAmount.toFixed(2));
		}
		if(totalQuantity==0||isNaN(totalQuantity))
		{
			$('#quantityTotal').val(null);
		}else{
			 
			$('#quantityTotal').val(totalQuantity);
		}
		if(netWeightTotal==0||isNaN(netWeightTotal))
		{
			$('#netWeightTotal').val(null);
		}else{
			 
			$('#netWeightTotal').val(netWeightTotal.toFixed(2));
		}
		
	 //$('#amountWithDiscountTotal').val(totalAmount.toFixed(2));
	 //$('#vatAmountTotal').val(vatAmountTotal.toFixed(2));
	 //$('#billTotal').val(totalWithVatAmount.toFixed(2));
	 //$('#billDiscount').val(totalDiscountAmount.toFixed(2));
	 calculateDiscount();
	}
   
function calculateDiscount()
{

	var totalAmount			=	parseFloat($('#totalAmount').val());
	var billDiscount		=	parseFloat($('#billDiscount').val());
	if(isNaN(totalAmount) || totalAmount==''){
			var totalAmount = 0;
		}
	if(isNaN(billDiscount) || billDiscount==''){
			var billDiscount = 0;
		}
	if(billDiscount>0 && totalAmount>0)
	{
		if(totalAmount>=billDiscount)
		{
			var totalAfterDiscount		=	parseFloat(totalAmount)-parseFloat(billDiscount);
			$('#amountWithDiscountTotal').val(totalAfterDiscount.toFixed(2));
		}else{
			alert('Discount Amount is Greater than TOtal Amount');
			$('#amountWithDiscountTotal').val(totalAmount.toFixed(2));
			$('#billDiscount').val(null);
		}
	
	}else{
		if(totalAmount==0||isNaN(totalAmount))
		{
			$('#amountWithDiscountTotal').val(null);
		}else{
		$('#amountWithDiscountTotal').val(totalAmount.toFixed(2));
		}
		$('#billDiscount').val(null);
	}
	getVatAmount();
}
function getVatAmount()
{
	var vatPercentTotal	=	parseFloat($('#vatPercentTotal').val());
	var amountWithDiscountTotal	=	parseFloat($('#amountWithDiscountTotal').val());
	
	if(isNaN(vatPercentTotal) || vatPercentTotal==''){
			var vatPercentTotal = 0;
		}
	if(isNaN(amountWithDiscountTotal) || amountWithDiscountTotal==''){
			var amountWithDiscountTotal = 0;
		}
		var vatAmount	=	(amountWithDiscountTotal*vatPercentTotal)/100;
		if(vatAmount==0||isNaN(vatAmount))
		{
		$('#vatAmountTotal').val(null);
		}else{
		$('#vatAmountTotal').val(vatAmount.toFixed(2));
		}
	calculateTotalVat();		
}
function calculateTotalVat()
{
	var vatAmountTotal 			=	parseFloat($('#vatAmountTotal').val());
	var amountWithDiscountTotal =	parseFloat($('#amountWithDiscountTotal').val());
	if(isNaN(vatAmountTotal) || vatAmountTotal==''){
			var vatAmountTotal = 0;
		}
	if(isNaN(amountWithDiscountTotal) || amountWithDiscountTotal==''){
			var amountWithDiscountTotal = 0;
		}
		var amountWithVat	=	amountWithDiscountTotal+vatAmountTotal;
		if(amountWithVat==0||isNaN(amountWithVat) )
		{
			$('#amountWithVat').val(null);
		}else{
			$('#amountWithVat').val(amountWithVat.toFixed(2));
		}
	
}
function searchItemData()
{
	var itemName			=	$('#itemNameSearch').val();
	if( itemName==null || itemName=='')
	{
		alert('Add Any Item Name !!!!');
	}else{
		$.ajax({
		type: "GET",
		url: "../../../../modules/purchase/admin/ajax/itemNameSearch.php?",
		data: {itemName:itemName},
		success: function(result)
		{
			$("#modal-body").html(result);
		}
  });
	}
	
}

function getCurrenyExRate(){
	var currency	  =	$('#currency').val();
	var res           = currency.split("/");
	var ExRate        = res[1];
	$('#exRate').val(ExRate);
	
}

function checkAmountZero(){
	var exRate	  =	$('#exRate').val();
	if(exRate==0)
		$('#exRate').val('');
}

</script>
<script type="text/javascript">
function tabPressFocus()
{
document.getElementById("materialSearch").focus();
	
}
</script>

<style>
.btn-success {
    background-color: #848090 !important;
}
#addPurchaseItemTable td {
	padding:0px !important;
}
label {
    font-size: 11px !important;
}
#addPurchaseItemTable input:focus , #addPurchaseItemTable select:focus {
    background-color: #bff2f5 !important;
}
.ui-state-focus{
	background-color:#bff2f5 !important;
}
</style>

	<div class="col-sm-12 col-md-12 col-lg-12" >
  		<div class="panel panel-info">
   			<div class="panel-heading">
            	<i class="fa fa-list-ul"></i> 
     			<strong>LOCAL PURCHASE ITEM </strong>
   			</div>
   			<div class="panel-body">
			  <form name="form1" id="" method="post" action="" onsubmit="return confirm('Do you want to continue?')" >
				<div class="row">
					<div class="col-sm-2 col-md-2 col-lg-2 ">
						<label for="invoiceNo"> INVOICE NO</label> <span style="color:#F00" class="mandatory">*</span>
						<input name="invoiceNo" value="<?php echo $maxInvoiceNo; ?>" autocomplete="off" type="text" required  
							   onChange="invoiceNoDuplication();" class="input-sm form-group" id="invoiceNo" >
					</div>
					<div class="col-sm-2 col-md-2 col-lg-2 form-group ">   
						<label for="invoiceDate">INVOICE DATE</label> <span style="color:#F00" class="mandatory">*</span>
						<input name="invoiceDate" type="text" required class="input-sm form-group datepicker" id="invoiceDate" 
							   value="<?php echo $objUtils->getCurrentDate();?>" onclick="displayCalender(this.id)"  autocomplete="off">
					</div>
					
					<div class="col-sm-2 col-md-2 col-lg-2 form-group"> 
						<label for="vendorName">VENDOR NAME</label> <span style="color:#F00" class="mandatory">*</span><br/>
						
							 <input type="text" name="venderName" id="venderName" required   class="form-control input-sm" autocomplete="off"
                             placeholder="VENDOR NAME"/>
							 <input type="hidden" name="vendorId" id="vendorId" />
					</div>
					
					<div class="col-sm-2 col-md-2 col-lg-2 form-group"> 
						<label for="vendorName">VENDOR INVOICE NO</label> <span style="color:#F00" class="mandatory"></span> <br/>
						
							 <input type="text" name="customerPoNo" id="customerPoNo"    class="form-control input-sm" autocomplete="off"
                             placeholder="VENDOR INVOICE NO."/>
					</div>
				
				<div class="col-sm-2 col-md-2 col-lg-2 form-group"> 
						<label for="vendorName">DELIVERY ORDER NO</label>  <br/>
						
							 <input type="text" name="deliveryOrderNo" id="deliveryOrderNo"    class="form-control input-sm" autocomplete="off"
                             placeholder="DELIVERY ORDER NO."/>
				</div>
				 <div class="col-sm-2 col-md-2 col-lg-2 form-group">
							<label>Mode Of Pay <span style="color:#F00" class="mandatory">*</span></label>
							<select name="typeOfTransactionId" id="typeOfTransactionId" style="width: 100%;" class="input-sm form-group" onchange="setAmountPaidByTypeOfTransaction()" required="">  
								<option value="">Select</option>
								<option value="1">Cash Invoice</option>
								<option value="2">Credit Invoice</option>   
							</select>
					 </div>
				</div>
				<div class="row">
					<div class="col-sm-3 col-md-3 col-lg-3 form-group">
                          	<label for="materialSearch"> Barcode/Item Name </label>
                          	<input type="text" name="materialSearch" id="materialSearch" class="form-control input-sm" 
                                 onchange="addRowForEstimate();"/>
                          	<input type="hidden" name="materialSearchId"  id="materialSearchId" />
                   		</div>
       					<div class="col-sm-2 col-md-2 col-lg-2 form-group">
							</br>
							<button id="addItem" type="button" data-toggle="modal" data-target="#addItemMaster" class="btn btn-success btn-sm" ><i class="fa fa-plus" aria-hidden="true"></i></button>					
							<button id="searchItemName" type="button" data-toggle="modal" data-target="#myModal" class="btn btn-success btn-sm" ><i class="fa fa-eye" aria-hidden="true"></i></button>					
						</div>
						
					<div class="co3-sm-3 col-md-3 col-lg-3 form-group">
					</div>
					 <div class="col-sm-2 col-md-2 col-lg-2 form-group"> 
						<label for="vendorName">CURRENCY</label> <span style="color:#F00" class="mandatory">*</span> <br/>
						<select name="currency" class="input-sm form-group" id="currency" onchange="getCurrenyExRate();" required="required" style="width: 100%;pointer-events: none !important;"  >
							<option value="">Select</option>
							<?php echo $currencyData; ?>
						</select>
					</div>
					<div class="col-sm-2 col-md-2 col-lg-2 form-group"> 
						<label for="vendorName">ExRate</label> <span style="color:#F00" class="mandatory">*</span> <br/>
						
							 <input type="text" name="exRate" id="exRate" required onkeyup="checkNumber(this.id);checkAmountZero();" value="1" class="form-control input-sm" autocomplete="off" readonly />
                            
                     
					</div>
				</div>
				
				<div class="row">
     				<!--<div class=" box box-solid box-warning col-sm-12 col-md-12 col-lg-12">-->
       					
       					<div class="col-sm-12 col-md-12 col-lg-12 form-group">
          					<!--<div class="panel panel-info"> -->  
                               <table width="100%" border="1" cellpadding="0" cellspacing="0" id="addPurchaseItemTable" class="table table-bordered" style="font-size: 11px !important;" >
									<thead style="background-color:#d0e8d2">
                                         <tr height="30">
											<th width="10%" style= "text-align:center">Barcode</th>
											<th width="18%" style= "text-align:center">Item Description</th>
											<th width="7%" style= "text-align:center">Qty</th>
											<th width="7%" style= "text-align:center">Unit</th> 
											<th width="7%" style= "text-align:center">Weight</th> 
											<th width="10%" style= "text-align:center">Unit price</th>
											<th width="10%" style= "text-align:center">Amount</th>
											<!--<th width="5%" style= "text-align:center">VAT(%)</th>
											<th width="8%" style= "text-align:center">VAT Amt</th>
											<th width="10%" style= "text-align:center">Tot.With vat </th>-->
											<th width="8%" style= "text-align:center">Exp. Date </th>
											<th  width="3%">&nbsp;</th>
										</tr>
										
                                  	</thead>
									<tbody id="materialDetailsTbody">
										
									</tbody>
									<tfoot>
									<tr>
										<td colspan="2" align="right">Total</td>
										<td>
											<input type="text" name="quantityTotal" id="quantityTotal" class="form-control input-sm" style="text-align: right;"  autocomplete="off" readonly />
										</td>
										<td>&nbsp;</td>
										<td>
											<input type="text" name="netWeightTotal" id="netWeightTotal" class="form-control input-sm" style="text-align: right;"   autocomplete="off" readonly />										
										</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td colspan="7" style="text-align: right;"><label for="total">TOTAL AMOUNT</label></td>
										<td colspan="2" align="right">
											<input name="totalAmount"  id="totalAmount" class="input-sm" type="text"  value="" style="width:100%;direction: rtl;" readonly>
										</td>
									</tr>
									<tr>
										<td colspan="7" style="text-align: right;"><label for="billDiscount">DISCOUNT</label></td>
										<td colspan="2" align="right">
											<input name="billDiscount" type="text" id="billDiscount" autocomplete="off" class=" input-sm"
																			   onkeyUp="calculateSum();" onchange="calculateSum();" style="width:100%;direction: rtl;" value=""  >									
										</td>
									</tr>
									<tr>
										<td colspan="7" style="text-align: right;"><label for="total">TOTAL AFTER DISCOUNT</label></td>
										<td colspan="2" align="right">
											<input name="amountWithDiscountTotal"  id="amountWithDiscountTotal" class=" input-sm" type="text"  value="" style="width:100%;direction: rtl;" readonly>
										</td>
									</tr>
									<tr>
										<td colspan="7" style="text-align: right;"><label for="totalVatAmount">VAT AMOUNT</label></td>
										<td colspan="2" valign="bottom">
											
											<input name="vatPercentTotal"  id="vatPercentTotal" onkeyUp="getVatAmount();" onchange="getVatAmount();" style="width:30%;float:left;direction: rtl;" class=" input-sm" type="text"  value="15" >
											<input type="text" class=" input-sm" style="width:10%;padding: 0%;border: 0px !important;"  value="%" />
											<input name="vatAmountTotal"  id="vatAmountTotal" onkeyUp="calculateSum();" onchange="calculateSum();" style="width:60%;float:right;direction: rtl;" class=" input-sm" type="text"  value="" readonly >
										</td>
									</tr>
									<tr>
										<td colspan="7" style="text-align: right;"><label for="amountWithVat">TOTAL WITH VAT</label></td>
										<td colspan="2" align="right">
											<input name="amountWithVat" type="text" class=" input-sm" id="amountWithVat" value="" style="width:100%;direction: rtl;"  readonly>
										</td>
									</tr>
									</tfoot>
                                </table>
	 	  					<!--</div>-->
       					</div>						
					<!--</div>-->
				</div>	
				<div class="col-sm-12 col-md-12 col-lg-12 form-group">	
					<div class="row">
						 <!--<div class="col-sm-2 col-md-2 col-lg-2 form-group">
							<label for="total">TOTAL AMOUNT</label>
							<input name="totalAmount"  id="totalAmount" type="text" class="form-control input-sm " value="" readonly>
						 </div>
						  <div class="col-sm-2 col-md-2 col-lg-2 form-group">
							<label for="billDiscount">DISCOUNT</label>
							<input name="billDiscount" type="text" id="billDiscount" autocomplete="off" class="form-control input-sm"
								   onkeyup="calculateDiscount();" value="" readonly >
						 </div>
						 <div class="col-sm-2 col-md-2 col-lg-2 form-group">
							<label for="total">TOTAL WITHOUT VAT</label>
							<input name="amountWithDiscountTotal"  id="amountWithDiscountTotal" type="text" class="form-control input-sm" value="" readonly>
						 </div>
						  <div class="col-sm-2 col-md-2 col-lg-2 form-group">
							<label for="totalVatAmount">VAT AMOUNT</label>
							<input name="vatAmountTotal"  id="vatAmountTotal" type="text" class="form-control input-sm" value="" readonly>
						 </div>
						 <div class="col-sm-2 col-md-2 col-lg-2 form-group" >
							<label for="amountWithVat">BILL TOTAL</label>
							<input name="amountWithVat" type="text" id="amountWithVat" value="" class="form-control input-sm" readonly>
						 </div>
						 
						 <div class="col-sm-2 col-md-2 col-lg-2 form-group" style="display:none">
							<label for="billTotal">BILL TOTAL</label>
							<input name="billTotal" type="text" id="billTotal"   value="" class="form-control input-sm" readonly >
						 </div>
						
					 </div>-->
				
				</div>
				<!--<div class="col-sm-12 col-md-12 col-lg-12 form-group">
					<div class="col-sm-6 col-md-6 col-lg-6">	
						<div class="checkbox" style="float: right;">
						  <label><input type="checkbox" name="addToStockCheckBox" id="addToStockCheckBox"  value="1"><b>Add To Stock</b></label>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-6">	
						<div class="checkbox">
						  <label><input type="checkbox" name="addToAccountsCheckBox" id="addToAccountsCheckBox"  value="1"><b>Add To Accounts</b></label>
						</div>
					</div>	
				</div>-->
				<div class="col-sm-12 col-md-12 col-lg-12 form-group">
					<center>
						<!--<button type="submit" name="submitBtn" class="btn btn-success" > 
								<i class="fa fa-save"></i> Save 
						</button>-->
						<button type="submit" name="addamdSaveBtn" class="btn btn-success" > 
								<i class="fa fa-save"></i> Save 
						</button>
					</center>
				</div>
			 </form>	
			</div>
		</div>	
	</div>	
	
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
				<div class="row">
					<div class="form-group col-sm-4 col-md-4 col-lg-4">
						<label for="item" >Item Name</label>
						<input type="text" class="form-control input-sm"  id="itemNameSearch" name="itemNameSearch" />
					</div>
					<div class="form-group col-sm-2 col-md-2 col-lg-2">
						</br>
						<button type="button"  class="btn btn-success" onclick="searchItemData();" ><i style='color:#fff' class="fa fa-search"></i></button>
					 </div>
				</div>	
	  </div>
      <div class="modal-body" id="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Modal POP UP to add New Item Start-->
<div id="addItemMaster" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 1266px;">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Item</h4>
      </div>
      <div class="modal-body">
		<form method="POST" id="itemMastreForm">
								<table width="100%" border="0" cellpadding="5">
					<tr>
						<td width="9%">Item Category</td>
						<td width="13%" colspan="2">
							<select class="form-control input-sm clearAll" name='categoryId' onchange="getSubcategory();" 
								id='categoryId'  required>
								<option value='' >Select</option>
							
							</select>
						</td>
						<td width="9%">Sub Category</td>
						<td width="13%" colspan="1">
							<select class="form-control input-sm clearAll" name='SubcategoryId'   onchange="getBarcode();" 
								id='SubcategoryId'  required>
								
							
							</select>
						</td>
						<td width="7%">Brand(Group)</td>
						<td width="8%" >
							<select class="form-control input-sm clearAll" name='brandId' 
								id='brandId'   >
							<option value='' >Select</option>
							
							</select>
						</td>
						<td width="8%">
							<!--<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#addBrandModal" ><i class="fa fa-plus"></i></button>		-->				
						</td>
						<td width="8%">Title</td>
						<td width="15%" colspan="2">
							<input type="text" class="form-control clearAll" autocomplete="off" id="tittle" name="tittle"  required >
						</td>
						
					</tr>
					<tr>
					<td>Title(Arabic)</td>
						<td colspan="2">
							<input type="text" class="form-control clearAll" autocomplete="off" id="tittleArabic" name="tittleArabic"   >
						</td>
					<td>Barcode</td>
					<td >
						 <input type="text" class="form-control clearAll" id="barcode" autocomplete="off" name="barcode"  onchange="itemCodeDuplication();"  required >
						<input type="hidden" id="partNoHidden" name="partNoHidden" class="form-control clearAll"/>
						<input type="hidden" id="OrginalpartNo" class="form-control clearAll" />
						<span id="user"></span>
					</td>
					<td><!--Quantity--></td>
					<td>
						<!--<input type="text" autocomplete="off" class="form-control" onkeyup='checkNumber(this.id);' id="quantity" name="quantity" onchange="">	-->
					</td>
					<td><!--Expiry Date--></td>
					<!--<td>
						<input type="text" autocomplete="off" class="form-control datepicker" onkeyup='checkNumber(this.id)' id="expiryDate" name="expiryDate">
					</td>-->
					<td colspan="2">WholeSale Price</td>
					<td>
						<input type="text" autocomplete="off" class="form-control clearAll" onkeyup='checkNumber(this.id)' id="wholeSalePrice" name="wholeSalePrice"  >					
					</td>
					
					
					
				</tr>
				<tr>
				<td width="8%">Max-Retail Price</td>
					<td colspan="2">
						<input type="text" autocomplete="off" class="form-control clearAll" onkeyup='checkNumber(this.id)' id="maxRetailPrice" name="maxRetailPrice" >					
					</td>
					<td>Min-Retails Price</td>
					<td >
						<input type="text" autocomplete="off" onkeyup='checkNumber(this.id)' class="form-control clearAll" id="minRetailPrice" name="minRetailPrice" >					
					</td>
					<td>Cost Price</td>
					<td>
						<input type="text" autocomplete="off" onkeyup='checkNumber(this.id)' class="form-control clearAll" id="costPrice" name="costPrice" >					
					</td>
					<td>Location</td>
					<td>
						<input type="text" autocomplete="off" class="form-control clearAll" id="location" name="location">	
					</td>
					<td>Minimum Qty</td>
					<td>
						<input type="text" autocomplete="off" onkeyup='checkNumber(this.id)' class="form-control clearAll" id="minimunQty" name="minimunQty" >					
					</td>
					
					
					
				</tr>
				<tr>
				<td>Reorder Qty</td>
					<td colspan="2">
						<input type="text" autocomplete="off" class="form-control clearAll" id="reorderQty" onkeyup='checkNumber(this.id)' name="reorderQty">					
					</td>
					<td>Maximum Qty</td>
					<td>
						<input type="text" autocomplete="off" onkeyup='checkNumber(this.id)' class="form-control clearAll" id="maximunQty" name="maximunQty" >
					</td>
					<td>Profit Level [%]</td>
					<td>
						<input type="text" autocomplete="off" class="form-control clearAll" id="profitLevel" name="profitLevel">
					</td>
					<td>Description(Arabic)</td>
					<td colspan="3">
						 <input type="text" autocomplete="off" class="form-control clearAll" name="description" id="description" >
					</td>
					
				</tr>
				<tr>
				<td>Vat%</td>
					<td colspan="2">
						<input type="text" autocomplete="off" onkeyup='checkNumber(this.id)' class="form-control clearAll" id="vatPer" name="vatPer" >
					</td>
					<td>Country</td>
					<td >
						<select name="country" id="country"  class="form-control clearAll">
						  <?php echo $country;?>
						</select>
					</td>
					<td>Note</td>
					<td colspan="5">
						  <input type="text" class="form-control clearAll" name="note" id="note" >
					</td>

				</tr>
				<tr>
				<td>Import/Local Status</td>
					<td colspan="2">
						<select name="importOrLocal" id="importOrLocal" required class="form-control clearAll" >
						<option value="">Select</option>
						<!--<option value="IMP">Import Purchase</option>-->
						<option value="LOC">Local Purchase</option>
						</select>
					</td>
					<td>Quantity</td>
					<td>
						<input type="text" autocomplete="off" class="form-control clearAll" onkeyup='checkNumber(this.id);' id="quantity" name="quantity" onchange="">	
					</td>
					<td>Expiry Date</td>
					<td>
						<input type="text" autocomplete="off" class="form-control clearAll datepicker" onkeyup='checkNumber(this.id)' id="expiryDate" name="expiryDate">
					</td>
					<td>Stock Date</td>
					<td>
						<input type="text" autocomplete="off" class="form-control  clearAll datepicker" onkeyup='checkNumber(this.id)' id="stockDate" name="stockDate">
					</td>
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
									<select class="form-control clearAll"  id='baseUnit' name='baseUnit' required>
										<option value=''>Select</option>
										<?php echo $unitSelectBox; ?>
									</select>
								</th>
								<th width="10%">
									<!--<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addUnitModal"><i class="fa fa-plus"></i></button>	-->
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
							<tbody id='unitTable' class="clearAll1"></tbody>
							<tfoot>
								<td>
									<select  class="form-control clearAll" id='unit'>
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
				<center><button type='submit' name='submit' class='btn submitBtn btn-success' ><i style='color:#fff' class="fa fa-save"></i>&nbsp;<span style='color:#fff'>Save</span></button></center>
		</form>
      </div>
      
    </div>

  </div>
</div>
<!-- Modal POP UP to add New Item Ends-->
<!---------------------------------------Scirpt To to Add in Item Master Start---------------------------------------------->
<script>
 
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
				}
            });
	 
 });
 
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
function getBarcode()
{
var categoryId = $('#SubcategoryId').val();	
	$.ajax({
               url: "../../../../modules/itemMaster/admin/ajax/getBarcode.php",
                type: "post",
                data: {categoryId:categoryId},
                success: function(data) {
					$('#barcode').val(data);
					
				}
            });
}
// this is the id of the form
$("#itemMastreForm").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');
    
    $.ajax({
           type: "POST",
           url: "../../../../modules/purchase/admin/ajax/itemMasterFormSubmitAjax.php",
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
              var itemMasterId	=	data;
			  if(parseInt(itemMasterId)>0)
			  {
				  alert('Success !!!');
				   $('#addItemMaster').modal('toggle');
				  addNewPurchaseItemRow(itemMasterId);
				  $('.clearAll').val(null);
					 $('.clearAll1').html(null);
			  }else{
				  alert('Error !!! or Barcode Duplication !!!');
			  }
           }
         });

    
});
function addNewPurchaseItemRow(itemMasterId)
{
	$.ajax({
           type: "POST",
           url: "../../../../modules/purchase/admin/ajax/getNewItemDedails.php",
           data: {itemMasterId:itemMasterId}, 
           success: function(data)
           {
              var result	=	JSON.parse(data);
			  var itemName	=	result.itemName;
			  var itemCode	=	result.itemCode;
			  var vat		=	result.vat;
			 var importLocalStatus		=	result.importLocalStatus;
			  getMaterialRow(itemMasterId,itemName,itemCode,vat,importLocalStatus);
           }
         });
}
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
	
	$(document).on('click','.btnRemoveTd',function(){
					var id=$(this).attr('id');
					$('#row'+id).remove();				
				});
</script>
<!---------------------------------------Scirpt To to Add in Item Master Ends----------------------------------------------->
<script>
  $('body').on('focus',".datepicker", function(){
  $(this).datepicker({
	   format: 'dd-mm-yyyy',
	    todayHighlight:'TRUE',
		autoclose: true
  });
});
  </script>