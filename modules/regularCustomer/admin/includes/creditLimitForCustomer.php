<?php
	require_once("../../../../modules/regularCustomer/admin/controller/c_creditLimitForCustomer.php");
	$objCreditLimitForCustomer = new C_allCustomer();
	include_once("../../../../system/soft/php/admin/gateway.php");
	$branchId   	          = $_SESSION['sessionBranchId'];
	if(isset($_POST['search'])){
		$regularCustomerId 	    = $_POST['customerId'];
		$allCustomer              = $_POST['allCustomer'];
			if($allCustomer==1)
				$creditBalance = $objCreditLimitForCustomer->creditBalalnceForAllCustomer($branchId); 
			else
				$creditBalance = $objCreditLimitForCustomer->creditBalalnceForSingleCustomer($regularCustomerId,$branchId); 
	}
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="../../../../libraries/js/validationsScript.js"></script>
<script>
$(function(){
 $("#customerNo").autocomplete({
   source: function(request, response) {
     var item1 = $('#customerNo').val();
     $.getJSON("../../../../modules/receipt/admin/ajax/custNoAutoComplete1.php", {
		 term  : $('#customerNo').val()}, 
              response
	 );
	
  },
      minLength: 0,
      focus: function( event, ui ) {
    //$("#model").autocomplete("search", "");
        $("#customerNo").html( ui.item.value );
        return false;
      },
      select: function( event, ui ) {
        $( "#customerNo" ).val( ui.item.value );
        $("#customerId").val( ui.item.key );
        return false;
      } 

   });
 
});

$(document).ready(function()
{
 $('#searchByKeyWord').keyup(function()
 {
  searchTable($(this).val());
 });
});

function searchTable(inputVal)
{
 var table = $('#example1');
 //alert('tableId:'+table);
 table.find('tr').each(function(index, row)
 {
  var allCells = $(row).find('td');
  if(allCells.length > 0)
  {
   var found = false;
   allCells.each(function(index, td)
   {
    var regExp = new RegExp(inputVal, 'i');
    if(regExp.test($(td).text()))
    {
     found = true;
     return false;
    }
   });
   if(found == true)$(row).show();else $(row).hide();
  }
 });
} 
</script>
<style type="text/css">
.resultTableForReceiptRow1{background: #F9C; font-weight:bold;}
</style>
<script src="../../../../libraries/js/validationsScript.js"></script>
<strong class="setFnts17U"><?php $objPath->getLabel('CUSTOMER CREDIT LIMIT', $lang); ?></strong> <BR/><BR/>
<div style="width: 427px; float: left; background-color: #CCC; border: 1px solid #999; padding:10px;">
<form name="customerBalancePayment" action="" method="post" >
<div class="divFullW">
<table width="427" border="0" cellpadding="0" cellspacing="0" >
    <tr>
      <td width="110" height="26"><label for="customerNo"><?php $objPath->getLabel('CUSTOMER NO', $lang); ?></label></td>
      <td width="192"><input name="customerNo" type="text" id="customerNo" value=""
              onkeyup="checkValidCustomerNo(this.value);" style="width:175px;" maxlength="30" autocomplete="off" />
        <input name="customerId" type="hidden" id="customerId" value=""/></td> 
        <td width="98">
        	<label for="allCustomer"><?php $objPath->getLabel('ALL', $lang); ?></label>
            <input name="allCustomer" type="checkbox" id="allCustomer" value="1" />
        </td>
	</tr>
	<tr height="30">
	  	<td>&nbsp;</td>
	  	<td><input type="submit" name="search" id="search" value="<?php $objPath->getLabel('SEARCH', $lang); ?>" class="btnW80H26"/></td>
	</tr>
    
</table>
</div>
</form>
<?php if(isset($_POST['search'])){?>
<?php if($allCustomer==1){?>
<table  width="427" class="table-responsive table-condensed">
        <tr>
          <td width="32%"></td>
          <td width="8%"><label for="searchByKeyWord"> <?php $objPath->getLabel('SEARCH', $lang);?> </label></td>
          <td width="8%">:</td>
          <td width="52%"> 
              <input type="text" class="input-sm" name="searchByKeyWord" id="searchByKeyWord" 
              placeholder="Search" width="50">
          </td>
        </tr>
</table>
<?php }?>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<div class="divFullW">
    <table width='480' border='0' cellpadding='0' cellspacing='0'>
	 <tr><td>
        <table width='450' border='1' cellpadding='0' cellspacing='0' class='table-altVw'  >
         	<tr class='tableRow1' >
		 		 <td width='105'><?php $objPath->getLabel('CUSTOMER NO', $lang); ?></td>
            	<td width='121'><?php $objPath->getLabel('CUSTOMER NAME', $lang); ?></td>
                <td width='94'><?php $objPath->getLabel('CREDIT LIMIT', $lang); ?></td>
            	 <td width='120'><?php $objPath->getLabel('CURRENT CREDIT LIMIT', $lang); ?></td>
		 	</tr>
	  	</table>
	 </td></tr>
     <tr><td>
     		<div  style='overflow:auto; width:500px; height:330px;' >
            <table width='450' border='1' cellpadding='0' cellspacing='0' class='table-altVw' id='example1'>
            	<?php echo $creditBalance; ?>
			</table>
			</div>
	</td></tr>
</table>
</div>
<?php }?>




