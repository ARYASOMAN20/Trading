<?php
	require_once('../../../../modules/preInputs/admin/class/branch.php');
	$objBranch       = new Branch();
	require_once("../../../../modules/regularCustomer/admin/class/m_customer.php");
	$objM_addCustomer  = new M_customer();
	require_once("../../../../settings/path.php");
	$objPath  		   = new Path();
	$objBranch->branchStatus  = '1';
	$resBranch       = $objBranch->resListBranch(BRANCH_ACRONYM);
	while($rowItem=mysqli_fetch_array($resBranch)){
      	$strListBranch  .= '<option value="'.$rowItem['branchId']."/".$rowItem['branchName'].'" > '
       							.$rowItem['branchName'].
       							'</option>';
	}
	if(isset($_POST['search'])){
		$customerId 	   = $_POST['customerId'];
		$resItemDiscount  = $objM_addCustomer->profitItemDiscountPercent($customerId);
		$rowResult 	    = mysqli_fetch_array($resItemDiscount);
	}
	if(isset($_POST['save'])){
		$customerId 	   = $_POST['customerId'];
		$profitItemDiscountPercent 	   = $_POST['profitItemDiscountPercent'];
		$updateCustomerItemDiscount      = $objM_addCustomer->updateCustomerItemDiscount($customerId,$profitItemDiscountPercent);
		echo $message ="Sucess";
		$objPath->setHeader('editProfitItemDiscountPercent', $message);
		}
	
?>
<script src="../../../../modules/customerReport/admin/js/custBalPayment.js" type="text/javascript" ></script>
<script src="../../../../libraries/js/validationsScript.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
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
function getBranchId(){
	var branchArray      = $('#branch').val();
	var branch 	       = branchArray.split("/");
    var branchId         = branch[0];
	$('#branchId').val(branchId);
}
</script>
<script src="../../../../libraries/js/validationsScript.js"></script>
 <h4 class="modal-title" id="myModalLabel"><?php $objPath->getLabel('CUSTOMER ITEM DISCOUNT', $lang);?> </h4>
  <div class="row">
   <div class="col-sm-6 col-md-6 col-lg-6">
    <div class="box">
            <form name="customerItemDiscount" method= "post" action = "" autocomplete= "off">
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
                   <tr>
                	<td width="23%"><label for="branch"><?php $objPath->getLabel('BRANCH', $lang);?></label></td>
                        <td width="77%">
                    		<select name="branch" id="branch" class="input-sm width40" onchange="getBranchId();">
              				<option value="">select</option>
        					<?php echo $strListBranch; ?>
      						</select>
                     		<span class="mandatory">*</span>
                        </td>
                     </tr> 
                    <tr>
                    <td width="23%"><label for="customerNo"><?php $objPath->getLabel('CUSTOMER NO', $lang);?></label></td>
                     <td width="77%">
                         <input type="text" name="customerNo" id="customerNo" class="input-sm width60" required 
          				 maxlength="30" autocomplete="off">
                            <span class="mandatory">*</span>
                          <ul id="customer_No_Id" class="listDD"></ul>
            			<input type="hidden" name="branchId" value="" id="branchId" >
                        </td>
                    </tr>
                    <tr>
                        <td width="23%">
                            <input type="hidden" name="customerId" id="customerId">
                            <button type="submit" name="search" id="search" class="btn btn-success">
                            	<i class="fa fa-save"></i><?php $objPath->getLabel('SEARCH', $lang);?>
                            </button>
                        </td>
                    </tr>
                </table>
                </form>	
  
          </div>
          </div>
          </div>
          <div class="row">
   <div class="col-sm-6 col-md-6 col-lg-6">
    <div class="box">
            <form name="customerItemDiscountResult" method= "post" action = "" autocomplete= "off">
            			<?php if($rowResult!=''){?>
				<input type="hidden" name="customerId" id="customerId" value="<?php echo $customerId;?>">
			 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="table">
                   <tr>
                	<td width="27%"><label for="customerNo"><?php $objPath->getLabel('CUSTOMER NO', $lang);?></label></td>
                        <td width="73%">
                    		<?php echo  $rowResult['customerNo'] ;?>
                        </td>
                     </tr> 
                    <tr>
                    <td width="27%"><label for="customerName"><?php $objPath->getLabel('CUSTOMER NAME', $lang);?></label></td>
                     <td width="73%">
                         <?php echo  $rowResult['customerName'];?>
                        </td>
                    </tr>
                    <tr>
                    <td width="27%"><label for="itemDiscount"><?php $objPath->getLabel('ITEM DISCOUNT', $lang);?></label></td>
                     <td width="73%">
                         <input type="text" name="profitItemDiscountPercent" 
                    id="profitItemDiscountPercent" value="<?php echo  $rowResult['profitItemDiscountPercent'] ;?>" onKeyUp="checkNumeric(this.id)">
                        </td>
                    </tr>
                    <tr>
                        <td width="27%">
                            <button type="submit" name="save" id="save" class="btn btn-success">
                            	<i class="fa fa-save"></i><?php $objPath->getLabel('SAVE', $lang);?>
                            </button>
                        </td>
                    </tr>
                </table>
                		<?php }?>

                </form>	
  
          </div>
          </div>
          </div>

<script src="../../../../js/jquery-1.9.1.js"></script>
<script type="text/javascript">
        $(function() {
                $('.footable').footable();
        });
</script>





