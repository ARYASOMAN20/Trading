<?php
	require_once('../../../../modules/customerReport/admin/controller/c_customerBalancePayment.php');
	include_once("../../../../system/soft/php/admin/gateway.php");
	require_once('../../../../modules/customerReport/admin/class/m_customerBalancePayment.php');
	require_once("../../../../libraries/class/utils.php");
	require_once("../../../../settings/path.php");
	$objCustomerBalancePayment = new M_customerBalancePayment();
	$objCustBalancePayment     = new C_custBalancePayment();
	$objUtils		          = new Utils();
	$objPath                   = new Path();
	$branchId                  = $_SESSION['sessionBranchId'];
	$arrayConstants       		= array();
	$arrayValues               = array();
	$branchReceiptId	       = 0;
	$resVoucherNo              = $objCustomerBalancePayment->getVoucherNumberForReceipt($sesBranchId);
   	$rowVoucherNo              = mysqli_fetch_array($resVoucherNo);
  	$voucherNo                 = $rowVoucherNo['voucherNo'];
	if(isset($_POST['search'])){
		$customerId 	   = $_POST['customerId'];
		$resReceiptDetails= $objCustBalancePayment->checkBillAndPaidAmount($customerId,$branchId);
		$receiptDetailsTable = $resReceiptDetails['receiptDetailsTable'];
		$customerNo          = $resReceiptDetails['customerNo'];
		$customerName		= $resReceiptDetails['customerName'];
	}
	if(isset($_POST['submitBalancePayment'])){
		$rowCount 		   = $_POST['rowCount'];
		$paidDate 		   = $_POST['inDate']; 
		$objUtils->strDate  = $paidDate;
		$paidDate		   = $objUtils->formatDate();
		$totalAmount		= $_POST['totalAmount'];
		$receiptVoucherNo    = $_POST['voucherNoForReceipt'];
		$voucherNoForReceipt = $receiptVoucherNo;
		$resVoucherNo        = $objCustomerBalancePayment->checkVoucherNoDuplication($voucherNoForReceipt,$branchId);
		if($resVoucherNo=='0'){
			for($i=1; $i<=($rowCount-1); $i++){
				$branchReceiptId   	= $_POST['branchReceiptId'.$i.''];
				$cashAmount         = str_replace(',', '', $_POST['cashAmount'.$i.'']);
				$spanAmount		 = str_replace(',', '', $_POST['spanAmount'.$i.'']);
				if($cashAmount!=0||$spanAmount!=0){
					$paymentModeId      = 1;
					$receiptAmountId  = $objCustomerBalancePayment->insertBalancePayment($branchReceiptId,$paymentModeId,$cashAmount,
																							$paidDate,$receiptVoucherNo,$branchId);
					$paymentModeId	  = 4;
					$receiptAmountId  = $objCustomerBalancePayment->insertBalancePayment($branchReceiptId,$paymentModeId,$spanAmount,
																							$paidDate,$receiptVoucherNo,$branchId);
				}
			}
			$arrayValues= array($customerNo,$branchReceiptId,$totalAmount,$receiptVoucherNo,$paidDate);
			$arrayConstants=array("customerNo","branchReceiptId","totalAmount","receiptVoucherNo","paidDate");
			$objPath->setHeaderPassingValues("printCustomerBalancePayment","",$arrayConstants,$arrayValues);
	    }
		else{
			echo '<script>alert("Voucher Number Duplicate...");</script>';
		}
	}
	
?>
<script src="../../../../modules/receipt/admin/js/forArrow.js"  type="text/javascript" ></script>
<script>
window.onload = function(){
	//displayCalender("invoiceDate")
	displayCalender("inDate");
	
}
</script>

<script src="../../../../modules/customerReport/admin/js/custBalPayment.js" type="text/javascript" ></script>
<!--<script type="text/javascript" src="../../../../modules/customerReport/admin/js/jquery.js"></script>-->
<link rel="stylesheet" href="../../../../modules/customerReport/admin/css/style.css" />
<script src="../../../../libraries/js/validationsScript.js"></script>
<script>
function customerNoAutocomplet() {
 	var min_length      = 0; 
	var customerNo      = $('#customerNo').val();
	var branchId        = $('#branchId').val();
	//var branchId        = sessionBranchId;
	if (customerNo.length > min_length) {
		$.ajax({
			url: "../../../../modules/customerReport/admin/ajax/custNoAutoComplete.php",
			type: 'POST',
			data: {customerNo:customerNo,branchId:branchId},
			success:function(data){
				$('#customer_No_Id').show();
				$('#customer_No_Id').html(data);
				//$('#customer_No').html(data);
				
			}
		 });
			
	} 
	else {
		$('#customer_No_Id').hide();
	}
}

// set_item : this function will be executed when we select an item
function set_item1(item, key) {
	// change input value
	$('#customerNo').val(item);
	$('#customerId').val(key);
	//alert(a);
	// hide proposition list
	$('#customer_No_Id').hide();
}
function voucherNoDuplication(){
	var voucherNoForReceipt = $('#voucherNoForReceipt').val();
		$.ajax({
			url: "../../../../modules/customerReport/admin/ajax/voucherNoDuplicate.php",
			type: 'POST',
			data: {voucherNoForReceipt:voucherNoForReceipt},
			success:function(data){
				if(data==0){
					alert('voucher Nmber Duplicate...');
					$('#voucherNoForReceipt').val('');
					}
				
			}
		 });
}
function calculateTotal() {
	var table = document.getElementById("resultFirstTable");
	var rowCount= table.rows.length;
	var estTotal=0;
    for(var i=1; i<=rowCount-1; i++) {  
	var cashAmount  = 'cashAmount'+i;
	var spanAmount  = 'spanAmount'+i;
		estTotal = parseFloat(document.getElementById(cashAmount).value.replace(/,/g, ''))
					+ parseFloat(document.getElementById(spanAmount).value.replace(/,/g, ''))+ 
					estTotal;
	}
    document.getElementById('totalAmount').value=estTotal.toFixed(2); 
	 document.getElementById('rowCount').value = rowCount;
}
</script>
<style type="text/css">
.resultTableForReceiptRow1{background: #F9C; font-weight:bold;}
</style>
<script src="../../../../libraries/js/validationsScript.js"></script>



<strong class="setFnts17U"><?php $objPath->getLabel('BALANCE PAYMENT', $lang);?></strong> <BR/><BR/>

<div class="row">
<form name="searchReceiptByInvoice" action="../admin/welcome.php?page=branchReceiptForCancel" method="post">
<div class="col-md-5">
   <div class="panel panel-primary">
    <!-- <div class="panel-heading"><strong><?php $objPath->getLabel('SEARCH', $lang);?></strong></div>   -->
   <div class="panel-body">

<div class="col-md-3" style="width:26%!important; ">
<label for="customerNo"><?php $objPath->getLabel('CUSTOMER NO', $lang);?></label>
<strong class="forMandatory" >*</strong>
</div>

<div class="col-md-6"  style="width:49%!important; ">
<input type="hidden" name="branchId" value="<?php echo $branchId?>" id="branchId" >
        	<input type="text" name="customerNo" id="customerNo" class="form-control input-sm" 
            style="color: #000 !important;" maxlength="30" onkeyup="customerNoAutocomplet();"autocomplete="off" >
  			<strong class="forMandatory">*</strong>
             <ul id="customer_No_Id" class="listDD">
            <input type="hidden" name="rowCount" id="rowCount" >
</div>

<div class="col-md-3">
 <input type="hidden" name="customerId" id="customerId">
 
<button type="submit" name="Search" id="search" value="" class="btn btn-primary" />
<i class="fa fa-search"></i><?php $objPath->getLabel('SEARCH', $lang);?></button>
</div>
</div>
</div>
</div>
</form>
</div>










<div style="width: 990px; float: left; background-color: #CCC; border: 1px solid #999; padding:10px;">
<form name="customerBalancePayment" action="" method="post" >
<div class="divFullW">
<table width="965" border="0" cellpadding="0" cellspacing="0" class="">
    <tr height="30">
		<td width="110"><label for="customerNo"><?php $objPath->getLabel('CUSTOMER NO', $lang);?>:</label></td>
       	<td width="500">
        <input type="hidden" name="branchId" value="<?php echo $branchId?>" id="branchId" >
        	<input type="text" name="customerNo" id="customerNo" class="txtFldW200" placeholder="customerNo"
            style="color: #000 !important;" maxlength="30" onkeyup="customerNoAutocomplet();"autocomplete="off" >
  			<strong class="forMandatory">*</strong>
             <ul id="customer_No_Id" class="listDD">
            <input type="hidden" name="rowCount" id="rowCount" >  
        </td>
	</tr>
	<tr height="30">
	  	<td>&nbsp;</td>
        <input type="hidden" name="customerId" id="customerId">
	  	<td><input type="submit" name="search" id="search" value="<?php $objPath->getLabel('SEARCH', $lang);?>" class="btnW80H26"/></td>
	  	<td width="389">&nbsp;</td>
	  	<td width="106">&nbsp;</td>
	  	<td width="107">&nbsp;</td>
	</tr>
</table>
<?php if($receiptDetailsTable!=''){?> 
<table width="950" border="0" cellpadding="0" cellspacing="0">
    <tr height="30">
		<td width="578"><label for="customerNo"><?php $objPath->getLabel('CUSTOMER NO', $lang);?>:<?php echo  $customerNo;?></label></td>
        <td width="372"><label for="customerNo"><?php $objPath->getLabel('CUSTOMER NAME', $lang);?>:<?php echo  $customerName;?></label></td>
  </tr>
</table>
<div id="printDiv">
<?php }?>
<table width="965" border="0" cellpadding="0" cellspacing="0" class="">
    <tr height="30">
       	<td width="129"><label for="inDate" ><?php $objPath->getLabel('VOUCHER DATE', $lang);?> :</label></td> 
       	<td width="221" style="font-weight:bold;"><input type="text" name="inDate" id="inDate" value="<?php echo $objUtils->getCurrentDate();?>" 
        style="font-weight:bold;"required >
        </td>
		<td width="93"><label for="voucherNoForReceipt"><?php $objPath->getLabel('VOUCHER NO', $lang);?>:</label></td>
		<td width="257"><input type="text" name="voucherNoForReceipt" id="voucherNoForReceipt" value="" 
        onKeyUp="checkNumeric(this.id)" onchange ="voucherNoDuplication();" autocomplete="off" style="font-weight:bold;">		
        	<strong class="forMandatory" >*</strong>
		</td>
        <td width="78"><label for="amount"><?php $objPath->getLabel('AMOUNT', $lang);?>:</label></td>
		<td width="187"><input type="text" name="amount" id="amount" value="0" 
        onKeyUp="calculateAmount(this.value);checkNumeric(this.id)" style="font-weight:bold;" autocomplete="off">		
		</td>
     </tr>
</table>
</div>
<div id="printDiv">
<?php //if($receiptDetailsTable!=''){?> 
<div class="divFullW">
<table width="950" id="resultFirstTable" border="1" cellspacing="0" cellpadding="0">
	<tr height="30" id="rowResultTable" tr bgcolor="#B7E9F9" >
		<th width='51'align="center"><?php $objPath->getLabel('SL.NO.', $lang);?></th>
		<th width='96'align="center"><?php $objPath->getLabel('INVOICE NO', $lang);?></th>
		<th width='148'align="center"><?php $objPath->getLabel('INVOICE DATE', $lang);?></th>
		<th width='113'align="center"><?php $objPath->getLabel('BILL AMOUNT', $lang);?></th>
		<th width='125'align="center"><?php $objPath->getLabel('PAID AMOUNT', $lang);?></th>
		<th width='108'align="center"><?php $objPath->getLabel('BALANCE', $lang);?></th>
        <th width='94'align="center"><?php $objPath->getLabel('CASH AMOUNT', $lang);?></th>
        <th width='91'align="center"><?php $objPath->getLabel('SPAN AMOUNT', $lang);?></th>
        <th width='104'align="center"><input type='checkbox' id='select_all' onclick="listAmount(this.id)"/>Select</th>
	</tr>
	<?php echo $receiptDetailsTable;?>
	<!--<tr>
		<td colspan="5" align="right">Total Balance</td>
		<td width='171'align="center"><?php //echo $totalAmount;?></td>
	</tr>-->
   <!-- <input name="cash1" type="text" id="cash1" value="0" />-->
<?php //}?>
</table>
 </div> 
<div class="divFullW" style="margin-top:10px;">
<table width="950" border="0" cellspacing="0" cellpadding="0" >
	<tr>
    	<td width="345"><label for="totalAmount"><b><?php $objPath->getLabel('TOTAL AMOUNT', $lang);?></b></label>
      		<input name="totalAmount" type="text" id="totalAmount" autocomplete="off" 
            		 style="height:40px;width:150px;font-size:32px;font-weight:bold;"value="0"/readonly>  
      	</td>
	</tr>
</table>
</div> 
<div class="divFullW" style="margin-top:10px;">
<table width="950" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="309">&nbsp;</td>
		<td width="681">
        	<input type="submit" name="submitBalancePayment" id="submitBalancePayment" value="<?php $objPath->getLabel('SUBMIT', $lang);?>" class="btnW95H30">
       	</td>
	</tr>
  <?php //}?>
</table>
</div>
</div>
</form>
<?php 
/*if(isset($_POST['submitBalancePayment'])){
	if(isset($_POST['branchReceiptId'])){
		//echo $resVoucherNo;
			$arrayValues= array($customerNo,$branchReceiptId,$totalAmount,$receiptVoucherNo,$paidDate);
			$arrayConstants=array("customerNo","branchReceiptId","totalAmount","receiptVoucherNo","paidDate");
			$objPath->setHeaderPassingValues("printCustomerBalancePayment","",$arrayConstants,$arrayValues);
		
	}
    else{
		 echo '<script>alert("Add One Item Atleast");</script>';
	}
}*/
?>





