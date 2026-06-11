<?php  
require_once("../../../../modules/invoiceSearch/admin/controller/c_invoiceSearch.php");
	//require('../../../../libraries/class/utils.php');
	require_once("../../../../settings/path.php");
	
		$objPath       = new Path();
		//$objUtils       = new Utils();
		$listTable =$customerName=$quotationNo=$quotationInvoiceNo= $quotationDate =$customerNo=$voucherTable='';
		$totalAmount=$laborCharge=$otherCharges=$totalPaidAmount=$totalBillAmount=$balaceAmountToPay=$countRow =0;
		$objCInvoiceSearch = new C_InvoiceSearch();
		
		if(isset($_POST['Search'])){
			
		$invoiceId = $_POST['invoiceId'];
		$resInvoiceDetails       = $objCInvoiceSearch->invoiceSearchForQuotation($invoiceId);
//		$resAmountDetails       = $objCInvoiceSearch->otherChargesDetails($invoiceId);
//		if($resAmountDetails )
//		{
//		$totalAmount          = $resAmountDetails['totalAmount'];
//		$laborCharge          = $resAmountDetails['totalLabour'];
//		$otherCharges         = $resAmountDetails['otherCharge'];
//		//$amountPaid           = $resInvoiceDetails['amountPaid'];
//		$totalBillAmount      = $totalAmount +$laborCharge+$otherCharges;
//
//			
//		}
		$resVoucherData          = $objCInvoiceSearch->voucherSearchForQuotation($invoiceId);
		if($resVoucherData)
		{
		$voucherTable 			= $resVoucherData['detailsTable'];
		$totalPaidAmount         = $resVoucherData['totalPaidAmount'];
		$countRow                = $resVoucherData['countRow'];
		}
		//print_r($resInvoiceDetails);
		if($resInvoiceDetails)
		{
		$listTable 			= $resInvoiceDetails['detailsTable'];
		$customerName 		 = $resInvoiceDetails['customerName'];
		$quotationNo 		  = $resInvoiceDetails['quotationNo'];
		$quotationInvoiceNo   = $resInvoiceDetails['quotationInvoiceNo'];
		$customerName         = $resInvoiceDetails['customerName'];
		$customerNo           = $resInvoiceDetails['customerNo'];
		$quotationDate        = $resInvoiceDetails['quotationDate'];
		//'totalLabour'=>$labourCharges,'otherCharge'=>$otherCharges,'totalAmount'=>$totalAmount
				$totalAmount          = $resInvoiceDetails['totalAmount'];
		$laborCharge          = $resInvoiceDetails['totalLabour'];
		$otherCharges         = $resInvoiceDetails['otherCharge'];
		//$amountPaid           = $resInvoiceDetails['amountPaid'];
		$totalBillAmount      = $totalAmount +$laborCharge+$otherCharges;

		//$balaceAmountToPay    = $totalBillAmount -$amountPaid ;
		
		$totalAmountWithOutVat = $resInvoiceDetails['billTotal'];
		$vatInPercentage       = $resInvoiceDetails['vatInPercentage'];
		$vatInAmount           = $resInvoiceDetails['vatInAmount'];
		$billTotalWithVat      = $resInvoiceDetails['billTotalWithVat'];
		$totalBillAmount      = $totalAmount +$laborCharge+$otherCharges;
		}
	
		if(empty($resInvoiceDetails))
		{
			echo "No data Found !!!";
		}
	}
	//$listTable = 
?>

<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(function(){
        $("#invoiceNo").autocomplete({
            source: function(request, response) {
            var item1 = $('#invoiceNo').val();
            $.getJSON("../../../../modules/invoiceSearch/admin/ajax/invoiceNoAutoComplete.php", {
            term  : $('#invoiceNo').val()},
            response
            );
            },
            minLength: 0,
            focus: function( event, ui ) {
                //$("#model").autocomplete("search", "");
                $("#invoiceNo").html( ui.item.value );
                return false;
            },
            select: function( event, ui ) {
                $( "#invoiceNo" ).val( ui.item.value );
                $("#invoiceId").val( ui.item.key );
                return false;
            } 
    
       });
 
    });
</script>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="../../../../libraries/js/jQuery.print.js"></script>
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>

<style type="text/css">
table tr td{font-family:Arial, Helvetica, sans-serif !important; font-size: 12px !important;}
table tr.listItemTr {font-size: 10px !important;}
table tr.listItemTr td {font-size: 10px !important;}
table tr.listItemTr td strong{font-size: 10px !important;}
#printDiv{font-family:Arial, Helvetica, sans-serif !important; }
</style> 

<h3>Invoice Search </h3> 
<form name="msgForm" method="post"  action=""> 
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
    	<div class="col-sm-7 col-md-7 col-lg-7">
            <div class="box box-solid box-info" >
                <div class="box-body">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label for="invoiceNo">Invoice No</label>
                        </div>
                    </div>
                    <div class="col-sm-4 input-group">
                        <input type="hidden" name="invoiceId" value="0" id="invoiceId">
                        <input name="invoiceNo" type="text" id="invoiceNo" required="required" maxlength="10" 
                                 class="form-control input-sm" />
                     	<span class="input-group-btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="submit" name="Search" id="Search" class="btn  btn-info" 
                                    style="padding:4px 5px 5px 5px !important;">
                                <i class="glyphicon glyphicon-search"></i>  
                            </button>
                        </span>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div>
</form>
        
 <?php if(isset($_POST['Search'])){
 $resInvoiceDetails       = $objCInvoiceSearch->invoiceSearchForQuotation($invoiceId);
 if($resInvoiceDetails){
 ?>
<div id="printDiv">
    <div class="row">
    	<div class="col-sm-12 col-md-12 col-lg-12">
    		<div class="box box-solid " >
    			<div class="box-body">
    				<div class="row">
                     	<div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label for="jobType"><?php echo 'Invoice  No :  '. $quotationInvoiceNo; ?></label>
                            </div>
                        </div>
                    	<div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label for="jobType"><?php echo 'Quotation No :  '. $quotationNo; ?></label>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label for="jobType"><?php echo 'Quotation Date :  '. $quotationDate; ?></label>
                            </div>
                        </div>
                     	<div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label for="jobType"><?php echo 'Customer Name :  '. $customerName; ?></label>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label for="jobType"><?php echo 'Customer No :  '. $customerNo; ?></label>
                            </div>
                        </div>
                  	</div>
    				<br />
    				<br />
    
    				<table width="100%" border="1" cellpadding="0" cellspacing="0"
                             data-sort="false" 
                                class="table table-condensed table-responsive table-bordered  ">
                    	<thead style="background-color:rgb(236, 240, 245);">
                        	<tr>
                                <th width="2%">Materials Name</th>
                                <th width="2%">Quantity</th>
                                <th width="2%">Unit Name</th>
                                <th width="2%">Unit Price</th>
                                <th width="2%">Amount</th>
                            </tr>
                        </thead>
                    	<tbody>
                    		<?php  echo $listTable; ?> 
                    		<tr>
                            	<td colspan="4">
                                	<strong>Total</strong>
                                </td>
                                <td align="right"><?php echo  number_format((float)$totalAmount, 2, '.', '') ?></td>
                          	</tr>
                            <?php //echo $listTableLPO?>  
                            
                            <tr>
                            	<td colspan="4">
                                	<strong> LABOUR CHARGES </strong>
                                </td>
                                <td align="right"><?php echo  number_format((float)$laborCharge, 2, '.', '') ?></td>
                          	</tr>
                            <tr>
                            	<td colspan="4">
                                	<strong> OTHER CHARGES </strong>
                                </td>
                                <td align="right"><?php  echo  number_format((float)$otherCharges, 2, '.', '') ?></td>
                          	</tr>
                            <tr>
                            	<td colspan="4">
                                	<strong> TOTAL Amount Without Vat</strong>
                                </td>
                                <td align="right"><strong><?php echo  number_format((float)$totalAmountWithOutVat, 2, '.', '') ?></strong></td>
                          	</tr>
                          	<tr>
                            	<td colspan="4">
                                	<strong> Vat Percentage</strong>
                                </td>
                                <td align="right"><strong><?php echo $vatInPercentage ; ?>%</strong></td>
                          	</tr>
                          	<tr>
                            	<td colspan="4">
                                	<strong> Vat Amount</strong>
                                </td>
                                <td align="right"><strong><?php echo  number_format((float)$vatInAmount, 2, '.', '') ?></strong></td>
                          	</tr>
                          	<tr>
                            	<td colspan="4">
                                	<strong> Total Amount With Vat</strong>
                                </td>
                                <td align="right"><strong><?php echo  number_format((float)$billTotalWithVat, 2, '.', '') ?></strong></td>
                          	</tr>
                    	</tbody>
                        <!--<tfoot>
                            <tr>
                                <td colspan="14">
                                    <div class="pagination pagination-centered hide-if-no-paging"></div>
                                </td>
                            </tr>
                        </tfoot>-->
                	</table>
                    <div class="row">
                     	<div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label for="totalAmount">
    								<?php echo 'Total Amount :  '.number_format((float)$billTotalWithVat, 2, '.', '')  ?>
                               	</label>
                            </div>
                        </div>
                    	<div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label for="PaidAmount">
									<?php echo 'Paid Amount :  '.number_format((float)$totalPaidAmount, 2, '.', '')  ; ?>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label for="Balance">
									<?php echo 'Balance Amount :  '.number_format((float)($billTotalWithVat-$totalPaidAmount), 2, '.', '') ?>
                              	</label>
                            </div>
                        </div>
    				</div>

                    <br />
                    <br />
                    <?php if($countRow  > 0 ) {?>
                    <div class="row pull-left" > 
                        <div class="col-sm-5 col-md-5 col-lg-5">
                            <table width="100%" border="1" cellpadding="0" cellspacing="0"
                                 data-sort="false" 
                                    class="table table-condensed table-responsive table-bordered footable ">
                                <thead style="background-color:#999">
                                    <tr>
                                        <th width="10%">Voucher No</th>
                                        <th width="10%">Quotation Date</th>
                                        <th width="15%">Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo  $voucherTable; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php }?>
    			</div>
    		</div>
    	</div>
    </div>
</div>

<div class="row">
	<div class="col-sm-10 col-md-10 col-lg-10">
    	<center>
         	<button type="button" id="printBtn" name="printBtn" class="btn btn-warning" onclick="printDiv('printDiv')">
            	<i class="fa fa-print"></i> Print 
            </button>
		</center>
	</div>
</div>
<?php } }?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>   
<script type="text/javascript">
	$(function () {
		$('.footable').footable();
	});
</script>  
          