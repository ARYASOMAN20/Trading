<?php
require_once('../../../../settings/path.php');
require_once('../../../../modules/regularCustomer/admin/controller/customerVoucherController.php');
require('../../../../libraries/class/utils.php');
		

$objUtils       = new Utils();
$objCustomerVoucherController = new customerVoucherController();

if (isset($_POST['search'])) {
    $customerId       = $_POST['customerId'];
	$customerNoAndName = $_POST['customerNo'];
	$customer = explode('|',$customerNoAndName);
	$customersNo=$customer[0];
	$customersName=$customer[1];
    $arrSearchResult   = $objCustomerVoucherController->searchByCustomerId($customerId);
    $currentBalanceReceiverAmount         = $arrSearchResult['currentBalanceReceiverAmount'];
	$regularCustomerId        			= $arrSearchResult['regularCustomerId'];
   
}

if (isset($_POST['save'])) {

    $regularCustomerId          	  = $_POST['regularCustomerId'];
	$customerNo = $_POST['customerNo1'];
	$customers = explode('|',$customerNo);
	$customerNos = $customers[0];
	$customerName = $customers[1];
    $currentBalanceReceiverAmount   = $_POST['currentBalanceReceiverAmount'];
    $amount   						 = $_POST['amount'];
    //$date               				= $_POST['date'];
   	$date          				   = $_POST['date'];
   	$objUtils->strDate = $date;
   	$formatedDate       = $objUtils->formatDate();
	
	   
 	$saveCustomerDetails = $objCustomerVoucherController->saveCustomerDetails($customerName,$regularCustomerId, $currentBalanceReceiverAmount, $amount, $formatedDate);
    //$formatedDate = $objStudent_readmissionController->formatDate($date);
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
		$( "#customerNo1" ).val( ui.item.value );
        $("#customerId").val( ui.item.key );
        return false;
      } 

   });
 
});

window.onload = function()
{ 
 displayCalender("date"); 
}


function CheckCreditBalance(creditBalance)
{
	
	var creditBalance = document.getElementById("currentBalanceReceiverAmount").value;
	var typingAmount  = document.getElementById("amount").value;
	if(parseFloat(creditBalance) >= parseFloat(typingAmount)){
		
		
		//alert("ok");
		return true;
	}
	else
	{
		//return false;
		alert("Possible Amount is "+creditBalance);
		document.getElementById("amount").value =0;
	}
}

</script>
<script type="text/javascript">
    function checkNumeric(argId) {
        //	alert(argId);
        var quantity = (document.getElementById(argId).value);
        //alert(quantity);
        quantity = quantity.replace(/\s/g, '');
        document.getElementById(argId).value = quantity;
        quantity = (document.getElementById(argId).value);
        if (quantity == "")
            document.getElementById(argId).value = '';
        else {
            //alert(quantity);
            if (isNaN(quantity) == true) {
                quantity = quantity.trim();
                var tempQuantity = quantity.replace(/[^0-9$.]/g, '');
                if (tempQuantity == "")
                    document.getElementById(argId).value = '';
                else
                    document.getElementById(argId).value = tempQuantity;
            }
        }
    }
</script>


	
    	<div class="widget-box widget-color-blue">
        	<div class="widget-header">
            	<h5 class="widget-title bigger lighter ui-sortable-handle"><b>
                CUSTOMER VOUCHER
                </b></h5>
            </div>
            <div class="widget-body">
             <form  method="post" action="">
            	<div class="row">
                	
                        <div class="form-group" id="container" style="padding-top: 10px;" >
                            <label class="col-sm-2 control-label no-padding-right" >
                              <?php $objPath->getLabel('CUSTOMER NO', $lang); ?> <span style="color:#F00" class="mandatory">*</span>
                            </label> 
                            <div class="col-sm-3 input-group">
                               <input type="text" name="customerNo" id="customerNo" onkeyup="checkValidCustomerNo(this.value);" class="form-control input-sm" maxlength="30" autocomplete="off"/>
                               <input name="customerId" type="hidden" id="customerId" value=""/>
                                <span class="input-group-btn">
                                    <button type="submit" name="search" id="search" class="btn btn-sm btn-primary" 
                                    		style="padding:5px 8px 5px 8px !important;">
                                        <i class="fa fa-search"></i>  
                                    </button>
                                </span>
                            </div>  
                        </div>
                  
                    </div>
                    
                  
                    </form>



<?php if (isset($_POST['search'])) {?>


<form action="" method="POST">
 <div class="row">
            <div class="col-sm-5 col-md-5 col-lg-5">
            <div class="panel panel-primary" style="width: 104%;">
               <div class="panel-heading">
                    <h3 class="panel-title">Customer No : <?php echo $customersNo;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Customer Name : <?php echo $customersName;?></h3>
                </div>
                <div class="panel-body">
               <input type="hidden" name="regularCustomerId" id="regularCustomerId" value="<?php echo $regularCustomerId;?>"   class="form-control input-sm"> 
                <div class="form-group">
                  <label>Current Balance</label><span class="mandatory"></span>
                  <input type="text" name="currentBalanceReceiverAmount" id="currentBalanceReceiverAmount" value="<?php echo $currentBalanceReceiverAmount;?>"  class="form-control input-sm" readonly>
                  <input name="customerNo1" type="hidden" id="customerNo1" value="<?php echo  $_POST['customerNo']?>"/>
               </div>
                    <div class="form-group">
                        <label for="date">Date</label> <span style="color:#F00" class="mandatory">*</span>
                              <input name="date" type="text" class="form-control input-sm datepicker" id="date" required="required" >
                    </div>
                    <div class="form-group" >
                        <label for="applicationNo">Amount</label>
                        <span style="color:#F00" class="mandatory">*</span>
                        <input type="text"   name="amount" id="amount" class="form-control input-sm"
                autocomplete="off" onkeyup="CheckCreditBalance(this.id); checkNumeric(this.id);" required="required">

                 
                    </div>
                     <div class="form-group">
                    <button type="submit" name="save" id="save" class="btn btn-sm btn-primary" 
                                    		style="padding:5px 8px 5px 8px !important;">
                                       Update  
                                    </button>
                                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                 
                    </div>
                    </div>
   </form>

<?php } ?>
