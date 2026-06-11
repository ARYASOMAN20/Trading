<?php
ini_set('display_errors', 1);
error_reporting(~0);

	require_once("../../../../modules/regularCustomer/admin/controller/c_customer.php");
	$objC_customer     = new C_customer();
	require('../../../../libraries/class/utils.php');
	$objUtils       = new Utils();
	$customerNo     = $customerName    = $fromDate      = '';
	$total          = $table           = $toDate        ='';
if(isset($_POST['search'])){
	$fromDate          = $_POST['fromDate'];
	$toDate            = $_POST['toDate']; 
	$objUtils->strDate = $fromDate;
	$fromDateNew       = $objUtils->formatDate();
	$objUtils->strDate = $toDate;
	$toDateNew         = $objUtils->formatDate();
	$customerId	= $_POST['customerId'];
	$listCurrentBalanceDetails = $objC_customer->currentBalanceList($fromDateNew,$toDateNew,$customerId); 
	$customerNo                = $listCurrentBalanceDetails['customerNo'];
	$customerName              = $listCurrentBalanceDetails['customerName'];
	$total           		     = $listCurrentBalanceDetails['total'];
	$table                     = $listCurrentBalanceDetails['table'];

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

window.onload = function(){
  displayCalender("fromDate");
  displayCalender("toDate");
}
</script>
<style type="text/css">
.colorWhite{color: white !important;}
.forMandatory{color: red !important;}
</style>
<div class="forHeading1"><h3><?php $objPath->getLabel('CUSTOMER VOUCHER REPORT', $lang)?></h3></div>
<form name="customerNoDetailsForm" action="<?=$objPath->setAction('currentBalanceForCustomer');?>" method="post" >
<div class="col-sm-8 col-md-8 col-lg-8">
<div class="box box-solid box-info">
	<div class="box-body">
		<div class="row">

			<div class="col-sm-3 col-md-3 col-lg-3">
                <label for="fromdate"><?php $objPath->getLabel('FROM DATE', $lang);?></label> 
                <strong class="forMandatory">*</strong>
                <input type="text" name="fromDate" id="fromDate" class="form-control input-sm datepicker" placeholder="From Date" 
                autocomplete="off" required="required">
            	<input type="hidden" name="branchId" value="0" id="branchId" >
			</div>
			<div class="col-sm-3 col-md-3 col-lg-3">
				<label for="todate"><?php $objPath->getLabel('TO DATE', $lang);?></label>
                <strong class="forMandatory">*</strong>
    			<input type="text" name="toDate" id="toDate" class="form-control input-sm datepicker"  autocomplete="off" 
                 placeholder="To Date" required="required">
			</div>
            <div class="col-sm-4 col-md-4 col-lg-4">
                <label for="customerNo"><?php $objPath->getLabel('CUSTOMER NO', $lang);?></label>
                <strong class="forMandatory">*</strong>
                <input type="text" name="customerNo" id="customerNo"  class="form-control input-sm"  placeholder="Customer No" 
                   maxlength="30"autocomplete="off" required>
                <input type="hidden" name="customerId" id="customerId" >
            </div>
			<div class="col-sm-2 col-md-2 col-lg-2">
            	<div class="form-group" style="margin-top: 15px;">
					<button name="search" id="search" type="submit" class="btn btn-primary" 
                 	value="<?php $objPath->getLabel('SEARCH', $lang);?>">
                    <i class="fa fa-search"></i>
                    </button>
         			<button type="button" name="printBtn" class="btn btn-success" 
                             value="<?php $objPath->getLabel('PRINT', $lang);?>"
                                onclick="printReportByContent( [ ['ID', 'printDiv'] ] )">  
                        <i class="fa fa-print"></i>
                    </button>
                </div>
			</div>
		</div>
	</div>
</div>
</div>
</form>
<?php if(isset($_POST['search'])){?>
<div class="row" id="printDiv">
	<div class="col-sm-8 col-md-8 col-lg-8">
	<div class="box box-solid box-success">
    	<div class="box-header"><strong><?php $objPath->getLabel('CUSTOMER NO', $lang);?>: &nbsp;&nbsp; <?php echo $customerNo;?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php $objPath->getLabel('CUSTOMER NAME', $lang);?> : &nbsp;&nbsp; <?= $customerName;?>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; <?php $objPath->getLabel('FROM DATE', $lang);?> :&nbsp;&nbsp;<?=$fromDate;?>&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<?php $objPath->getLabel('TO DATE', $lang);?> :&nbsp;&nbsp;<?=$toDate;?></strong>
    	</div>
	<div class="box-body">
  		 <table width="100%" border="1" class="table table-responsive table-bordered table-striped" 
          cellpadding="0" cellspacing="0"><!--footable data-page-navigation=".pagination" data-page-size="10"-->
          <thead style="background-color:rgb(236, 240, 245);">
         		<tr>
                    <th width='10%' align="center"><?php $objPath->getLabel('SL NO', $lang);?></th>
                    <th width='30%'align="center"><?php $objPath->getLabel('DATE', $lang);?></th>
                    <th width='60%'align="right"><?php $objPath->getLabel('AMOUNT', $lang);?></th>
                </tr>
          </thead>
          <tbody>
         	 <?php echo $table;?>
             <!--<tr>
                <td colspan="2" align="right" style="font-weight:bold;">Total</td>
                <td align="right" style="font-weight:bold;"><?php //echo number_format($total,2,'.','');?></td>
             </tr>-->
         </tbody>
         <tfoot>
         	<tr>
                <td colspan="2" align="left" style="font-weight:bold;">Total</td>
                <td align="left" style="font-weight:bold;"><?php echo number_format($total,2,'.','');?></td>
             </tr>
             <tr>  
                  <td colspan="3">
                      <div class="pagination pagination-centered hide-if-no-paging"></div>
                  </td>
             </tr>
		</tfoot>
   </table>      
</div>
</div>
</div>
</div>  
<?php }?> 
 	
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>   
<script type="text/javascript">
	$(function () {
		$('.footable').footable();
	});
</script>-->

<!--<div class="row">
<div class="col-sm-7">
   <div class="box box-info">
 
  <div class="box-body">
<form name="customerNoDetailsForm" action="" method="post" >

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="">
	  <div class="row">
            <div class="col-sm-2"><label for="fromdate">From Date</label></td>
       </div>
       <div class="col-sm-4">
       		<input type="text" name="fromDate" id="fromDate" class="input-sm width80 datepicker" placeholder="fromDate" required>
  			<strong  class="forMandatory">*</strong>
            <input type="hidden" name="branchId" value="0" id="branchId" >
   		</div>
        </div>
        </br>
     <div class="row">
            <div class="col-sm-2"><label for="todate">To Date</label></td>
      </div>
        <div class="col-sm-4">
       		<input type="text" name="toDate" id="toDate" class="input-sm width80 datepicker" placeholder="toDate" required>
  			<strong class="forMandatory">*</strong>
   	</div>
    </div>
    </br>
       <div class="row">
            <div class="col-sm-2"><label for="branch">CustomerNo</label></td>
       </div>
        <div class="col-sm-4">
       		 <input name="customerNo" type="text" id="customerNo" value=""
              onkeyup="checkValidCustomerNo(this.value);" style="width:175px;" maxlength="30" autocomplete="off" />
        <input name="customerId" type="hidden" id="customerId" value=""/> 
   	 </div>
     </div>   
    <div class="row">
  <div class="col-sm-8">
        <button name="search" id="search" type="submit" class="btn btn-primary" value="Search"><i class="fa fa-search"></i>Search</button>
        <button name="print" id="print" type="submit"
         onclick=" printReportByContent( [ ['ID', 'printDiv'] ] );" 
          class="btn btn-primary" ><i class ="fa fa-print"></i>Print</button>
      </div>
      </div>
</table>
</form>

</div>
</div>
</div>
</div>
<div id="printDiv">
<td>&nbsp;</td>

 <div class="col-sm-9">  
   <div class="panel panel-info" >
	<div class="panel-heading"><strong><table width="100%" border="0" cellpadding="0" cellspacing="0" class="table-altVw">
    <tr height="30">
    	<td width="225"><label for="customerNo">Customer No:</label><?php //echo $customerNo; ?></td>
        <td width="264"><label for="customerName">Customer Name:</label><?php //echo $customerName; ?></td>
        <td width="354"><label for="fromDate">From Date:</label><?php //echo $fromDate; ?></td>
        <td width="265"><label for="toDate">To Date:</label><?php //echo $toDate; ?></td>
        <td width="234"><label for="toDate">Current Balance:</label><?php //echo $listCurrentBalanceDetails['currentBalance'];?></td>
  </tr>
</table></strong></div>

	<div class="row">
 <div class="col-sm-6 col-md-6 col-lg-6">
    <div class="box">
        <div class="box-body">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="outerTable">
                <tr><td>
                    <div class="tableTitleDiv">
                    <table width="50%" border="1" cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
                        <tr class="tableRow1">
                            <td width="17%" height="35" >#</td>
                            <td width="50%">Date</td>
                            <td width="33%">Amount</td>
                            <td width="0%"></td>
                        </tr>
                    </table>
                    </div>
                </td></tr>
                <tr><td>
                    <div class="listTableDivScroll">
                    <table width="90%" border="1" cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
                        <?php //echo $table; ?>  
                    </table>
                    </div>
                </td></tr>
            </table>
        </div>
      </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>     		</section>
</div>-->