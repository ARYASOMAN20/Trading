

<?php
require_once("../../../../modules/purchase/admin/class/m_purchase.php");
require_once("../../../../libraries/class/utils.php");
require_once("../../../../settings/path.php");
$objPath      = new Path();
$objMPurchase = new M_Purchase();
$objUtils 	 = new Utils();
$strVendor	= '';
$message	  = '';
$purchaseItemBillId = '';
$maxInvoiceNo = $objMPurchase->getMaxInvoiceNo(); 
$dropDownForVendor =$objMPurchase->dropDownForvendorName();

$resAffectedRows  = 0;

while ($rowVendor = mysqli_fetch_array($dropDownForVendor)){
	$strVendor .='<option value = '.$rowVendor['vendorId'].'>'.$rowVendor['vendorName'].'</option>';
} 
	
	

if (isset($_POST['btnSavePurchase']) && isset($_POST['newMaterialsId'])) {
	
	$invoiceNo    = $_POST['invoiceNo'] ;	
	$invoiceCount = $objMPurchase->checkInvoiceNoExistOrNot($invoiceNo);
	if($invoiceCount == 0) {  	
		$invoiceDate  = $objUtils->formatDate($_POST['invoiceDate']) ; 
		$vendorId     = $_POST['vendorName'] ;
		$billDiscount = $_POST['billDiscount'] ;
		$totalWithoutVat = $_POST['total'] ;
		$totalVatAmount = $_POST['totalVatAmount'] ;
		$totalWithVatAmount = $_POST['billTotal'] ;
		
		//$amountPaid   = $_POST['amountPaid'] ;
		$userId	   = 1 ;
	 	$paidDate	 = $objUtils->getCurrentDate();
		 $typeOfTransactionId   = $_POST['typeOfTransactionId'] ;
			
		$purchaseItemBillId = $objMPurchase->insertPurchaseItemBill($invoiceNo, $invoiceDate, $vendorId, $billDiscount, 
																    $totalWithoutVat,$totalVatAmount,$totalWithVatAmount,$typeOfTransactionId, $userId);
		$objMPurchase->insertAccountjournal($purchaseItemBillId, $invoiceDate,$vendorId,$totalWithoutVat,$totalVatAmount,$totalWithVatAmount,$billDiscount);
		$rowCount 	   = count($_POST['newMaterialsId']) ;
		$newMaterialsId = $_POST['newMaterialsId'] ;
		$newQuantity 	= $_POST['newQuantity'] ;
		//$newUnit 		= $_POST['newUnit'] ;
		$newUnit 		= '';
		$newUnitPrice   = $_POST['newUnitPrice'] ;
		$newMaterial 	= $_POST['newMaterial'] ;
		//$newAmount 	= $_POST['newAmount'] ;
		$billDiscount 	= $_POST['billDiscount'];
		$vatPercentage 	= $_POST['vatPercentage'];
		$vatAmount 	    = $_POST['vatAmount'];
		//$newAmount 	  = $_POST['newAmount'] ;
		
		if($purchaseItemBillId > 0 ) {
			
			// $objMPurchase->insertPurchaseAmount($purchaseItemBillId, $amountPaid, $paidDate );
			$queryValuesForPI = "";
			for( $i= 0 ;$i<$rowCount ;$i++) {
				$arrData = explode("/",$newUnit[$i]);
				$unit 	= $arrData[0];
				$fraction = '';
				$queryValuesForPI = "('".$purchaseItemBillId."', '".$newMaterialsId[$i]."',  '".$unit."', 
								   '".$newQuantity[$i]."', '".$newUnitPrice[$i]."',  '".$billDiscount."',
									 '".$vatPercentage[$i]."',	'".$vatAmount[$i]."'
														)";
				//$queryValuesForPI = rtrim($queryValuesForPI, ',');
				$purchaseItemId  = $objMPurchase->insertPurchaseItem($queryValuesForPI);
				
				 $materialCount = $objMPurchase->checkMaterialExistOrNot($newMaterial[$i], $newUnitPrice[$i]);
				 
				 
				 
				 if($materialCount == 0) {
				    $quantityMultiple = $newQuantity[$i];
					$newMaterialId = $objMPurchase->insertMaterialsData($newMaterial[$i], $newUnitPrice[$i], $quantityMultiple);
					
					//------------------------Code Updation By Dipin D ----------------------//
					
					
					$updateMaterianidInPurchaseItem	=	$objMPurchase->updateMaterianidInPurchaseItem($newMaterialId,$purchaseItemId);
					
					
					//------------------------Code Updation End By Dipin D ----------------------//
					$resUnit   = $objMPurchase->getMaterialUnits($newMaterialsId[$i]);
					
					
					while($listUnit = mysqli_fetch_array($resUnit)){
						$objMPurchase->insertUnitData($newMaterialId, $listUnit["unitName"], $fraction );
					}
				 } else{
				    $quantityMultiple = $newQuantity[$i];
					
					$updateMaterials=$objMPurchase->updateMaterials($newMaterial[$i], $quantityMultiple, $newUnitPrice[$i]);
					
				 }
				 
			} //END FOR LOOP			
			//$queryValuesForPI = rtrim($queryValuesForPI, ',');
			//$resAffectedRows  = $objMPurchase->insertPurchaseItem($queryValuesForPI);
		
		
			$arrayValues = $arrayConstants = array();
			$arrayValues    = array($purchaseItemBillId);
			$arrayConstants = array('purchaseItemBillId');
			$count = count($arrayConstants);
			$objPath->setHeaderPassingValues('purchasePrint' , 'Save Successfully.', $count, $arrayConstants, $arrayValues);
		}
			//$objPath->setAction('addPurchaseItem', 'Save Successfully...');
	} else // END IF LOOP invoiceCount CONDITION
		$objPath->setHeader('addPurchaseItem', 'Invoice No Already Exist...');
} // END IF LOOP btnSavePurchase & newMaterialsId CONDITION
?>

<!--Autocomplete-Link-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
	 var $j = jQuery.noConflict();
	 var text2 = $("#materialSearch").tautocomplete({
		 // width: "500px",
		  columns: ['Name', 'Unit Price', 'Stock'],
		  ajax: {
			  url: "../../../../modules/purchase/admin/ajax/searchMaterials.php",
			  type: "GET",
			  data: function () {
				  return [{ test: text2.searchdata() }];
			  },
			  success: function (data) {
				  alert();
				  var filterData = [];
				  var searchData = eval("/" + text2.searchdata() + "/gi");
				  $.each(data, function (i, v) {
					  if (v.name.search(new RegExp(searchData)) != -1) {
						  filterData.push(v);
					  }
				  });
				 
				  return filterData;
			  }
		  },
		  onchange: function () {
			  alert();
			  $("#materialSearch").html(text2.text());
			  $("#materialSearchId").val(text2.id());
			   addRowForEstimate();
		  }
	  });
	
	 /* $("#showLpo").hide();
	  //var $j = jQuery.noConflict();
	  $("#LPO").click(function(e) {
		  $("#showLpo").toggle();
	  });
	*/
	
	

	

});

function addRowForEstimate() {
	makeTransactionId();
	var materialsName  = $("#materialSearch").text();
	var newMaterialsId = $("#materialSearchId").val(); 
	
 	if(newMaterialsId > 0 && materialsName !=''){	
	   
		var table	= document.getElementById("resultTable");
		var tableId  = "resultTable";
		var rowCount = table.rows.length;
		var row	  = table.insertRow(rowCount);
		var cell	 = new Array(9);
		for(var i=0; i<8; i++) {
			cell[i]=row.insertCell(i); 
		}		
		var quantity       = 1;
	
		cell[0].innerHTML = materialsName+"<input type='hidden' value='"+materialsName+"' id='newMaterial"+rowCount+"' name='newMaterial[]'/>"+"<input type='hidden' value='"+newMaterialsId+"' id='newMaterialsId"+rowCount+"' name='newMaterialsId[]'/>";
   		cell[1].innerHTML="<input type='text' value='"+quantity+"' name='newQuantity[]' id='newQuantity"+rowCount+"' onkeyup='findRowAmount(this,\""+tableId+"\",\""+rowCount+"\");checkNumeric(this.id); makeTransactionId();' class='input-sm form-control' autocomplete='off' />";
   		/*cell[2].innerHTML="<select  name='newUnit[]' required class='input-sm form-control' id='newUnit"+rowCount+"' onchange='findRowAmount(this,\""+tableId+"\",\""+rowCount+"\"); makeTransactionId();'></select>";*/									
   		cell[2].innerHTML="<input type='text' value='0' name='newUnitPrice[]'  id='newUnitPriceId"+rowCount+"' onkeyup='findRowAmount(this,\""+tableId+"\",\""+rowCount+"\");checkNumeric(this.id); makeTransactionId();' class='input-sm form-control' />";
   		cell[3].innerHTML="<input type='text' value='0' name='amountForView[]' id='amountForView"+rowCount+"' onkeyup='findVatAmount(this,\""+tableId+"\",\""+rowCount+"\");checkNumeric(this.id);' class='input-sm form-control' readonly />";		
		cell[4].innerHTML="<input type='text' value='5' name='vatPercentage[]' id='vatPercentage"+rowCount+"' onkeyup='findVatAmount(this,\""+tableId+"\",\""+rowCount+"\");checkNumeric(this.id); makeTransactionId();' class='input-sm form-control' />";		
		cell[5].innerHTML="<input type='text' value='0' name='vatAmount[]' id='vatAmount"+rowCount+"' class='input-sm form-control' readonly/>";		
		cell[6].innerHTML="<input type='text' value='0' name='newAmount[]' id='newAmount"+rowCount+"' class='input-sm form-control' readonly/>";											
   		<!--cell[7].innerHTML="<button class='btn btn-xs btn-danger' onclick='deleteRows(this,\""+tableId+"\")'><i class='fa fa-times'</i></button>";-->
  		
		//selectUnitByModelId(newMaterialsId,rowCount);
   		//document.getElementsByName("materialSearch").value = '';
		makeFieldsdEmpty();
		
	}
}

function makeFieldsdEmpty() {
	
	$("#searchField").val("");
	$("#materialSearchId").val("");
}
	
function selectUnitByModelId(materialId,rowCount){
	$.ajax({
		  type: "POST",  
		  url: "../../../../modules/purchase/admin/ajax/getAllUnitsByMaterialsId.php",  
		  data: {materialId:materialId},   
		  success:function(resp){
            document.getElementsByName("newUnit[]")[rowCount-1].innerHTML = resp;
			//document.getElementById("newUnit"+rowCount).innerHTML = resp;
			setUnitPrice(materialId,rowCount);
        },
        error : function(resp){}
	 });
}

function setUnitPrice(materialId,rowCount) {
	 
	$.ajax({
		  type: "POST",  
		  url: "../../../../modules/estimate/admin/ajax/getUnitPrice.php",  
		  data: {materialId:materialId},   
		  success:function(resp){ 
            document.getElementsByName("newUnitPrice[]")[rowCount-1].value = parseFloat(resp).toFixed(2);
			//document.getElementById("newUnitPrice"+rowCount).value = resp;
			findRowAmount('', 'resultTable', rowCount);
        },
        error : function(resp){}
	 });
}


function setAmountPaidByTypeOfTransaction() {
	 
	var typeOfTransactionId = $("#typeOfTransactionId").val();
	var billTotal 		   = $("#billTotal").val();
	var discount 		   = $("#billDiscount").val();

	
		   
	if(typeOfTransactionId == 1) {
		var newTxtFieldForAmountPaid = '<input name="amountPaid" required type="text" id="amountPaid" value="'+parseFloat(billTotal).toFixed(2)+'" readonly class="form-control input-sm" style="text-align:right">';
		$("#amountPaid").replaceWith(newTxtFieldForAmountPaid);
	} else {
		var newTxtFieldForAmountPaid = '<input name="amountPaid" required type="text" id="amountPaid" value="0" onkeyup="checkNumeric(this.id); checkBillAmount();" class="form-control input-sm" style="text-align:right" >';
		$("#amountPaid").replaceWith(newTxtFieldForAmountPaid); 
	}
}


function checkBillAmount(){
	
	var typeOfTransactionId = $("#typeOfTransactionId").val();
	var billTotal 		   = $("#billTotal").val();
	var amountPaid 		  = $("#amountPaid").val();
		 
	if(typeOfTransactionId == 2) {
		if(parseFloat(billTotal) < parseFloat(amountPaid)) {
			$("#amountPaid").val(0);
			alert("Check Bill Total");
		}
	}
}

function deleteRows(getObject,tableId){ 
	//var table	= document.getElementById("tableForEstimate");alert(table);
	var deleteRowIndex = getObject.parentNode.parentNode.rowIndex;
	document.getElementById(tableId).deleteRow(deleteRowIndex);
	calculateTotal('resultTable');
	var table	= document.getElementById("resultTable");
	var tableId  = "resultTable";
	var rowCount = table.rows.length;
	makeTransactionId();

}

function findRowAmount(getObject,resultTableId,rowCount){
	//alert(rowCount);
	//var i 		  = $(getObject).parent().parent().index();// find the row index in jquery
	var i 		  = rowCount;
	var quantity   = $("[name='newQuantity[]']")[i-1].value;
	//alert('quantity '+quantity);
	
	/*var id         = 'newUnit'+i;
	var strUnit    = (document.getElementById(id).value);
	var unitArray  = strUnit.split("/");
	//var multiple   = unitArray[1];*/
	var multiple   = 1;
	//alert('multiple '+multiple);
	var unitPrice  = $("[name='newUnitPrice[]']")[i-1].value;
	//alert('unitPrice '+unitPrice);
	
	var vatPercentage=$("[name='vatPercentage[]']")[i-1].value;

	


	if(isNaN(quantity) == true || quantity == ' ')
		quantity = 0;
	if(isNaN(unitPrice) == true || unitPrice == ' ')
		unitPrice = 0;
	if(isNaN(vatPercentage) == true || vatPercentage == ' ')
		vatPercentage = 0;
	

	var vatamount	 = parseFloat(quantity)*parseFloat(unitPrice)*parseFloat(multiple)*parseFloat(vatPercentage)/100;
	
if(isNaN(vatamount) == true || vatamount == ' ')
		vatamount = 0;
	

	$("[name='vatAmount[]']")[i-1].value = vatamount.toFixed(2); 

	var amountWithVat	 = (parseFloat(quantity)*parseFloat(unitPrice)*parseFloat(multiple))+parseFloat(vatamount);

if(isNaN(amountWithVat) == true || amountWithVat == ' ')
		amountWithVat = 0;	
	
		var amountWithoutVat	 = parseFloat(quantity)*parseFloat(unitPrice)*parseFloat(multiple);

if(isNaN(amountWithoutVat) == true || amountWithoutVat == ' ')
		amountWithoutVat = 0;	
	


	
	$("[name='newAmount[]']")[i-1].value = amountWithVat.toFixed(2);
	$("[name='amountForView[]']")[i-1].value = amountWithoutVat.toFixed(2);
	calculateTotal(resultTableId);
	
}


function findVatAmount(getObject,resultTableId,rowCount){
	
	//var i 		  = $(getObject).parent().parent().index();// find the row index in jquery
	var i 		  = rowCount;
	var quantity   = $("[name='newQuantity[]']")[i-1].value;
	var unitPrice  = $("[name='newUnitPrice[]']")[i-1].value;
	var vatPercentage=$("[name='vatPercentage[]']")[i-1].value;
	/*var id         = 'newUnit'+i;
	var strUnit    = (document.getElementById(id).value);
	var unitArray  = strUnit.split("/");
	var multiple   = unitArray[1];*/
	var multiple   = 1;
	//alert('multiple '+multiple);
	
	if(isNaN(quantity) == true || quantity == ' ')
		quantity = 0;
	if(isNaN(unitPrice) == true || unitPrice == ' ')
		unitPrice = 0;
	if(isNaN(vatPercentage) == true || vatPercentage == ' ')
		vatPercentage = 0;
	
		var vatamount	 = parseFloat(quantity)*parseFloat(unitPrice)*parseFloat(multiple)*parseFloat(vatPercentage)/100;
		
		if(isNaN(vatamount) == true || vatamount == ' ') 
		vatamount = 0; 
		
		$("[name='vatAmount[]']")[i-1].value = vatamount.toFixed(2); 
		
		 var amount	 = parseFloat(quantity)*parseFloat(multiple)*parseFloat(unitPrice)+parseFloat(vatamount);
		
		if(isNaN(amount) == true || amount == ' ') 
		amount = 0; 
	
		 $("[name='newAmount[]']")[i-1].value = amount.toFixed(2);
		calculateTotal(resultTableId); 

	
}


function calculateTotal(tableId) {
	
	var rowCount= document.getElementById(tableId).rows.length;
	
	var estTotal = 0;
	var vatTotal=0;
    for(var i=0; i<rowCount-1; i++) {  
		estTotal += parseFloat(document.getElementsByName("newAmount[]")[i].value);
		vatTotal += parseFloat(document.getElementsByName("vatAmount[]")[i].value);

		//alert('estTotal : '+estTotal);
	}
    
	document.getElementById('total').value = (estTotal-parseFloat(vatTotal)).toFixed(2);
	
	var billDiscount = document.getElementById('billDiscount').value; 
	if(isNaN(billDiscount) == true || billDiscount == ' ')
		billDiscount = 0;
	
	
	document.getElementById('totalVatAmount').value = (parseFloat(vatTotal)).toFixed(2);
	document.getElementById('amountWithVat').value = (estTotal).toFixed(2);//).toFixed(2); 
	
	var billAmountAfterDiscount=parseFloat(estTotal)- parseFloat(billDiscount);
	
	if(isNaN(billAmountAfterDiscount) == true || billAmountAfterDiscount == ' ')
		billAmountAfterDiscount = parseFloat(estTotal);
		
	
	document.getElementById('billTotal').value = (billAmountAfterDiscount).toFixed(2);//).toFixed(2); 
	
}

function checkNumeric(argId){
	//alert(argId);
	var quantity = (document.getElementById(argId).value);
	quantity 	 = quantity.replace(/\s/g,'');
	document.getElementById(argId).value = quantity;
	quantity     = (document.getElementById(argId).value);
	if(quantity == "")
		document.getElementById(argId).value = 0;
	else{
		
		//alert(quantity);
		if(isNaN(quantity) == true){
			quantity = quantity.trim();
			var tempQuantity= quantity.replace(/[^0-9$.]/g,'');
			if(tempQuantity  == "")
				document.getElementById(argId).value = 0;
			else
				document.getElementById(argId).value = tempQuantity;	
		}
		
	} 
	
}


function addMaterialData() {

	var materialName = $("#materialName").val();
	/*var unitName     = $("#unitName").val();
	var fraction     = $("#fraction").val();
	var unitPrice    = $("#unitPrice").val();*/
	
	var unitName     = '';
	var fraction     = '';
	var unitPrice    = '';
	
	var isEntryValid = 'FALSE';
	if(materialName != "" && materialName != null ){
		/*if(unitName != "" && unitName != null ){
			if(fraction != "" && fraction != null ){*/
				isEntryValid='TRUE';
			/*} else  $("#errorMessage").html('Please select fraction !!');	
		} else  $("#errorMessage").html('Please select unit Name !!');*/
	} else  $("#errorMessage").html('Please select material Name !!');
	
	
	if(isEntryValid == 'TRUE') {
		
		$("#errorMessage").html('');
		$.ajax({
		  type: "POST",  
		  url: "../../../../modules/purchase/admin/ajax/insertMaterials.php",  
		  data: {materialName:materialName, fraction:fraction, unitName:unitName, unitPrice:unitPrice},  
		  success:function(resp){  
		  		
				var arrCount   = resp.split('|');
				var materialId = arrCount[0];
				$("#materialSearch").html(materialName);
				$("#materialSearchId").val(materialId); 
				addRowForEstimate();
		  },
		  error : function(resp){}
		
	 	});
		
		$("#materialName").val(""); //Clear The text fields
		$("#unitPrice").val("");
		$("#fraction").val("");
		$("#unitName").val("");
		
	} // END IF isEntryValid CONDITION

}


function makeTransactionId() {

$("#typeOfTransactionId").val('');
$("#amountPaid").val(null);


}




</script>

<style type="text/css">
	form{margin-bottom: 5px !important;}
	.form-group{margin-bottom: 5px !important;}
	.box-body{padding: 5px !important;}
	.panel-body{padding: 5px !important;}
</style>

<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12" >
  		<div class="box box-solid box-info">
   			<div class="box-header">
            	<i class="fa fa-list-ul"></i> 
     			<strong> PURCHASE ITEM </strong>
   			</div>
   			<div class="box-body">
    		<form name="form1" id="form1" method="post" action="" onsubmit="return confirm('Do you want to continue?')" >
                <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                    <label for="invoiceNo"> INVOICE NO</label> <span style="color:#F00" class="mandatory">*</span>
                    <input name="invoiceNo" value="<?php echo $maxInvoiceNo; ?>" autocomplete="off" type="text" required  
                           onChange="InvoiceNoDuplication();" class="input-sm" id="invoiceNo" >
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 form-group pull-right">   
                    <label for="invoiceDate">INVOICE DATE</label> <span style="color:#F00" class="mandatory">*</span>
                    <input name="invoiceDate" type="text" required class="input-sm datepicker" id="invoiceDate" 
                           value="<?php echo $objUtils->getCurrentDate();?>" onclick="displayCalender(this.id)"  autocomplete="off">
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3 form-group"> 
                    <label for="vendorName">SUPPLIERS</label> <span style="color:#F00" class="mandatory">*</span> <br/>
                    <select name="vendorName" class="input-sm" id="vendorName" required="required">
                        <option value="">Select</option>
                        <?php echo $strVendor; ?>
                    </select>
                </div>
   				
                <div class="col-sm-12 col-md-12 col-lg-12 form-group">
     				<div class=" box box-solid box-warning col-sm-12 col-md-12 col-lg-12"> 
       					<div class="col-sm-3 col-md-3 col-lg-3 form-group">
                          	<label for="materialSearch">Materials</label>
                          	<input type="text" name="materialSearch" id="materialSearch" class="form-control input-sm" 
                                 onchange="addRowForEstimate();"/>
                          	<input type="hidden" name="materialSearchId"  id="materialSearchId" />
                   		</div>
       					<div class="col-sm-3 col-md-3 col-lg-3"  style="margin-top: 21px;">	
          					<button type="button" name="search" id="button" class="btn btn-success" 
                            		 onclick="displayResult()" data-toggle="modal" data-target="#addMaterials" > 
                                     <i class="fa fa-plus"></i> Material 
                        	</button>
       					</div> 
                        
       					<div class="col-sm-12 col-md-12 col-lg-12 form-group">
          					<div class="panel panel-info">    
                               <table width="100%" border="0" cellpadding="0" cellspacing="0" data-sort="false" id="resultTable"
                                  class="table table-condensed table-responsive table-bordered table-striped footable"  >
									<tbody>
                                         <tr style="background-color: aliceblue;" height="30">
											<th width="" style= "text-align:center">MATERIALS NAME</th>
											<th width="" style= "text-align:center">QUANTITY</th>
											<!--<th width="" style= "text-align:center">UNIT</th>-->
											<th width="" style= "text-align:center">UNIT PRICE</th>
											<th width="" style= "text-align:center">AMOUNT</th>
											<th width="" style= "text-align:center">VAT(%)</th>
											<th width="" style= "text-align:center">VAT AMOUNT</th>
											<th width="" style= "text-align:center">TOTAL WITH VAT </th>
											<!--<th width="" style= "text-align:center"></th>-->
										</tr>
										<?php 
											$totalAmount=0;
											$toatalVatamount=0;
											$totalAmountWithVat=0;
                                            $confrmStockPurchasePageData = "";
                                            $resultTableId = "resultTable";
                                            if(isset($_POST['purchase'])) {
                                                $arrMaterials = array(array());
                                                $arrMaterials = unserialize(base64_decode($_POST['arrayValues']));
                                                //print_r($arrMaterials);
                                                for( $i= 0, $j= 1; $i<count($arrMaterials); $i++, $j++) {
													
													list($multiple0,$multiple1)=explode("/",$arrMaterials[$i]['unitId']);
													//print_r($val2);
													//echo $multiple=$multipleArray['1'];
													$amount=$arrMaterials[$i]['quantity']*$arrMaterials[$i]['unitPrice']*$multiple1;
													
													$vatamount=$amount*5/100;
													
													$amountwithvat=$vatamount+$amount;
													$totalAmount=$totalAmount+$amount;
													$toatalVatamount=$toatalVatamount+$vatamount;
													$totalAmountWithVat=$totalAmountWithVat+$amountwithvat;
                                                    $confrmStockPurchasePageData .= 
                                                    "<tr>
                                                        <td>".$arrMaterials[$i]['materialsName']."
                                        <input type='hidden' value='".$arrMaterials[$i]['materialsName']."' 
                                                                     id='newMaterial".$j."' name='newMaterial[]' class='input-sm form-control'/>
                                                              <input type='hidden' value='".$arrMaterials[$i]['materialsId']."' 
                                                                     id='newMaterialsId".$j."' name='newMaterialsId[]' class='input-sm form-control'/>
                                                        </td>
                                                        <td style='text-align:right'>
                                                            <input type='text' value='".$arrMaterials[$i]['quantity']."' name='newQuantity[]' 
                                                                   id='newQuantity".$j."'class='input-sm form-control'autocomplete='off'
                                                                   onkeyup='findRowAmount(this,\"".$resultTableId."\",".$j.");checkNumeric(this.id);'/>
                                                        </td>
                                                        <!--<td style='text-align:center'>
                                                            <select name='newUnit[]' required class='input-sm form-control' id='newUnit".$j."' 
                                                                    onchange='findRowAmount(this,\"".$resultTableId."\",".$j.");'>
                                                                    <option value='".$arrMaterials[$i]['unitId']."'>".$arrMaterials[$i]['unitName']."</option>
                                                            </select>
                                                        </td>-->
                                                        <td style='text-align:right'> 
                                                            <input type='text' value='".$arrMaterials[$i]['unitPrice']."' name='newUnitPrice[]'  
                                                                    id='newUnitPriceId".$j."' class='input-sm form-control'
                                                                    onkeyup='findRowAmount(this,\"".$resultTableId."\",".$j.");checkNumeric(this.id);' />
                                                            
                                                        </td>
														<td style='text-align:right'> 
														 <input type='text' value='".$amount."' name='amountForView[]'  
                                                                    id='amountForView".$j."' class='input-sm form-control'
                                                                    onkeyup='findRowAmount(this,\"".$resultTableId."\",".$j.");checkNumeric(this.id);'  readonly />
                                                        </td>
														<td style='text-align:right'> 
														 <input type='text' value='5' name='vatPercentage[]'  
                                                                    id='vatPercentage".$j."' class='input-sm form-control'
                                                                    onkeyup='findRowAmount(this,\"".$resultTableId."\",".$j.");checkNumeric(this.id); makeTransactionId();' />
                                                        </td>
														<td style='text-align:right'> 
														 <input type='text'value='".$vatamount."' name='vatAmount[]' 
                                                                    id='vatAmount".$j."' class='input-sm form-control'  readonly/>
														</td>
														<td style='text-align:right'>
                                                            <input type='text' value='".$amountwithvat."' name='newAmount[]' id='newAmount".$j."' class='input-sm form-control' 
                                                                   readonly/>
                                                        </td>
                                                        <!--<td style='text-align:center'>
                                                            <button class='btn btn-xs btn-danger' onclick='deleteRows(this,\"".$resultTableId."\")'>
                                                                    <i class='fa fa-times'></i></button>
                                                        </td>-->";
														
														
														
                                                }
                                                echo $confrmStockPurchasePageData;
												
                                            }
											
                                        ?>
                                  	</tbody>
                                </table>
	 	  					</div>
       					</div>
     				</div>
   				</div>
   
   			 <div class="row col-sm-12 col-md-12 col-lg-12 form-group">
             <?php /* if(isset($_POST['purchase'])) { 
			 $totalAmount=0;
											$toatalVatamount=0;
											$totalAmountWithVat=0;
											 $arrMaterials = array(array());
                                                $arrMaterials = unserialize(base64_decode($_POST['arrayValues']));
                                                //print_r($arrMaterials);
                                                for( $i= 0, $j= 1; $i<count($arrMaterials); $i++, $j++) {
													
													list($multiple0,$multiple1)=explode("/",$arrMaterials[$i]['unitId']);
													//print_r($val2);
													//echo $multiple=$multipleArray['1'];
													$amount=$arrMaterials[$i]['quantity']*$arrMaterials[$i]['unitPrice']*$multiple1;
													
													$vatamount=$amount*5/100;
													
													$amountwithvat=$vatamount+$amount;
													$totalAmount=$totalAmount+$amount;
													$toatalVatamount=$toatalVatamount+$vatamount;
													$totalAmountWithVat=$totalAmountWithVat+$amountwithvat;
												}*/
												
												
			
		/*	echo '<div class="col-sm-2 col-md-2 col-lg-2 form-group">
		<label for="total">TOTAL WITHOUT VAT</label>
    	<input name="total"  id="total" type="text" class="form-control input-sm" value="'. $totalAmount.'" readonly>
     </div>
	  <div class="col-sm-2 col-md-2 col-lg-2 form-group">
		<label for="totalVatAmount">VAT AMOUNT</label>
    	<input name="totalVatAmount"  id="totalVatAmount" type="text" class="form-control input-sm" value="'. $toatalVatamount.'" readonly>
     </div>
	 <div class="col-sm-2 col-md-2 col-lg-2 form-group" style="display:">
     	<label for="amountWithVat">TOTAL WITH VAT</label>
        <input name="amountWithVat" type="text" id="amountWithVat" value="'.$totalAmountWithVat.'"  class="form-control input-sm" readonly>
     </div>
	  <div class="col-sm-2 col-md-2 col-lg-2 form-group">
    	<label for="billDiscount">DISCOUNT</label>
        <input name="billDiscount" type="text" id="billDiscount" autocomplete="off" class="form-control input-sm"
        	   onkeyup="calculateTotal(resultTable); checkNumeric(this.id); makeTransactionId();" value="0">
     </div>
     <div class="col-sm-2 col-md-2 col-lg-2 form-group">
     	<label for="billTotal">BILL TOTAL</label>
        <input name="billTotal" type="text" id="billTotal" value="'. $totalAmountWithVat.'" class="form-control input-sm" readonly >
     </div>';   }
			 */
			
          ?>
             
	 <div class="col-sm-2 col-md-2 col-lg-2 form-group">
		<label for="total">TOTAL WITHOUT VAT</label>
    	<input name="total"  id="total" type="text" class="form-control input-sm" value="<?php echo $totalAmount ?>" readonly>
     </div>
	  <div class="col-sm-2 col-md-2 col-lg-2 form-group">
		<label for="totalVatAmount">VAT AMOUNT</label>
    	<input name="totalVatAmount"  id="totalVatAmount" type="text" class="form-control input-sm" value="<?php echo $toatalVatamount ?>" readonly>
     </div>
	 <div class="col-sm-2 col-md-2 col-lg-2 form-group" style="display:">
     	<label for="amountWithVat">TOTAL WITH VAT</label>
        <input name="amountWithVat" type="text" id="amountWithVat" value="<?php echo $totalAmountWithVat ?>" class="form-control input-sm" readonly>
     </div>
	  <div class="col-sm-2 col-md-2 col-lg-2 form-group">
    	<label for="billDiscount">DISCOUNT</label>
        <input name="billDiscount" type="text" id="billDiscount" autocomplete="off" class="form-control input-sm"
        	   onkeyup="calculateTotal('resultTable'); checkNumeric(this.id); makeTransactionId();" value="0">
     </div>
     <div class="col-sm-2 col-md-2 col-lg-2 form-group">
     	<label for="billTotal">BILL TOTAL</label>
        <input name="billTotal" type="text" id="billTotal"   value="<?php echo $totalAmountWithVat ?>" class="form-control input-sm" readonly >
     </div>
     
  <?php 
			
      $dropDownForPaymentType =$objMPurchase->dropDownForPaymentType();
	   $typeLIst='';
          while($row = mysqli_fetch_array($dropDownForPaymentType)){
        $typeLIst.="<option value ='$row[paymentTypeId]'>$row[paymentTypeName]</option>";
                 }
             ?>
	 
	 <div class="col-sm-2 col-md-2 col-lg-2 form-group">
    <?php ?>                	<label>Transaction Type</label>
                    	<select   name="typeOfTransactionId"   id="typeOfTransactionId" class="input-sm" onchange="setAmountPaidByTypeOfTransaction()"  required >  
                       	 	<option value ="">Select</option>
                        	<?php echo $typeLIst; ?>
                    	</select>
                 	</div>
					
					
	<!--<div class="col-sm-2 col-md-2 col-lg-2 form-group">
     	<label>Amount Paid</label>
        <input name="amountPaid" type="text" id="amountPaid" value="0" class="form-control input-sm" 
        	   onkeyup="checkNumeric(this.id);">
     </div>--><?php ?>
    <!--<tr height="40">
		<td><label for="typeOfTransactionId">TRANSACTION TYPE</label></td>
		<td>
		<select name="typeOfTransactionId" id="typeOfTransactionId" class="input-sm form-control" required>
		<option value="">Select</option>
		<?php /*
		require_once('../../../../modules/preInputs/admin/class/typeOfTransaction.php');
		$objTransaction = new TypeOfTransaction();
		$value = $objTransaction->resList();
		while($row = mysqli_fetch_array($value)){
		echo "<option value = $row[typeOfTransactionId]>$row[transactionName]</option>";
		}
		*/?>
		</select>
		<strong class="forMandatory">*</strong>
		</td>
    </tr> -->
     
     <div class="col-sm-2 col-md-2 col-lg-2 form-group" style="margin-top: 21px;">
        <button type="submit" name="btnSavePurchase" id="btnSavePurchase" class="btn btn-success"  >
                <i class="fa fa-save"></i>SAVE </button>
     </div>
   </div>
    		</form>
            </div>
   		</div>
  	</div>
</div>


<div class="modal modal-md fade" id="addMaterials" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
        		<h4 class="modal-title" id="myModalLabel">Add Materials</h4>
      		</div>
			<div class="modal-body">
				<div class="form-group">
                    <label>Material Name :</label>
                    <input type="text" name="materialName" id="materialName" class="form-control input-sm">
                </div>
                <!--<div class="form-group">
                    <label>Unit Type :</label>
                    <input type="text" name="unitName" id="unitName" class="form-control input-sm">
                </div>
                
                <div class="form-group">
                    <label>Unit Price :</label>
                    <input type="text" name="unitPrice" id="unitPrice" class="form-control input-sm"
                           onkeyup="checkNumeric(this.id);">
                </div>
                <div class="form-group">
                    <label>Fraction :</label>
                    <input type="text" name="fraction" id="fraction" class="form-control input-sm"
                            onkeyup="checkNumeric(this.id);">
                </div>-->
			</div>
            <div class="modal-footer">
            	<center>
                    <button type="button" name="btnSave" class="btn btn-primary" onclick="addMaterialData()"> 
                            <i class="fa fa-save"></i> Save 
                    </button>
              	</center>
            </div>
    	</div>
  	</div>
</div>



<link rel="stylesheet" type="text/css" href="../../../../modules/purchase/admin/css/tautocomplete.css" />
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script src="../../../../modules/purchase/admin/js/tautocomplete.js" type="text/javascript"></script>

