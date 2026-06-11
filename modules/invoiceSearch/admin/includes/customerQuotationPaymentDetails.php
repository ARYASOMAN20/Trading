<?php  
	require_once("../../../../modules/estimateQuotationReport/admin/controller/c_EstimateQuotationReport.php");
	require('../../../../libraries/class/utils.php');
	require_once("../../../../settings/path.php");
	require_once("../../../../modules/customerQuotationPaymentReport/admin/controller/c_customerQuotationPaymentReport.php");
    $objCCusQuotationReportCntrl = new C_CustomerQuotationPaymentReport();
	

	
		$objPath       = new Path();
		$objUtils       = new Utils();
		$listTable = $voucherTable='';
		$listTableLPO='';
		$listDetailsTableMaterilasData ='';
		$objCEstimateQuotationReport = new  C_EstimateQuotationReport();

		$quotationId 			= $_POST['quotationId'];
		
		$listDetailsTableQuotation = $objCEstimateQuotationReport->listDetailsByQuotationId($quotationId );
		mysqli_num_rows($listDetailsTableQuotation);
		$listDetailsTableMaterilasData = $objCEstimateQuotationReport->listDetailsByQuotationIds($quotationId );
		$resCalculation = $objCEstimateQuotationReport->listDetailsByQuotationIdChargesCalculation($quotationId );
		
		$resVoucherData          = $objCCusQuotationReportCntrl->voucherSearchForQuotation($quotationId);
		$voucherTable 			= $resVoucherData['detailsTable'];

		$laborCharge = 0;
		$otherCharges =0;
		$total = 0;
		$listTableChargesRow ='';
		
	if($resList = mysqli_fetch_array($resCalculation))
		{
			$laborCharge = $resList['labourCharges'];
			$otherCharges = $resList['otherCharges'];
			$total = $resList['total'];
		}

		if($resList = mysqli_fetch_array($listDetailsTableQuotation))
		{
			$quotationNo = $resList['quotationNo'];
			$jobEstimateNo = $resList['jobEstimateNo'];
			
			$quotationDate = $objUtils->reversFormatDate($resList['quotationDate']);
			$customerName = $resList['customerName'];
			$salesmanName = $resList['name'];
			
			if($resList['quotationStatus'] ==1)
			{$status = "Confirm";}
			if($resList['quotationStatus'] ==0)
			{$status = "Cancelled";}
			if($resList['quotationStatus'] =='')
			{$status = "Not Confirm";}
			
		}


?>



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
<style>
.footable #printDiv {
	font-family: Tahoma, Geneva, sans-serif;
}
.footable #printDiv  td div {
	font-family: Tahoma, Geneva, sans-serif;
}
</style>

<div id="printDiv">
<h3>Quotation Details </h3> 
<div class="row">
	 
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="box box-solid " >
                <div class="box-body">

                <div class="row">
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
                            <label for="jobType"><?php echo 'SalesMan :  '. $salesmanName; ?></label>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label for="jobType"><?php echo 'Quotation Status :  '. $status; ?></label>
                        </div>
                    </div>
                    </div>
                
                
				<table width="100%" border="1" cellpadding="0" cellspacing="0"
                         data-sort="false" 
                            class="table table-condensed table-responsive table-bordered footable ">
	
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
                <?php  echo $listDetailsTableMaterilasData; ?> 
                
                <tr>
                        	<td colspan="4">
                            	<strong>Total</strong>
                            </td>
                            <td><?php echo  number_format((float)$total, 2, '.', '') ?></td>
                      	</tr>
                        <?php //echo $listTableLPO?>  
                        
                        <tr>
                        	<td colspan="4">
                            	<strong> LABOUR CHARGES </strong>
                            </td>
                            <td><?php echo  number_format((float)$laborCharge, 2, '.', '') ?></td>
                      	</tr>
                        <tr>
                        	<td colspan="4">
                            	<strong> OTHER CHARGES </strong>
                            </td>
                            <td><?php echo  number_format((float)$otherCharges, 2, '.', '') ?></td>
                      	</tr>
                        <tr>
                        	<td colspan="4">
                            	<strong> TOTAL</strong>
                            </td>
                            <td><strong><?php echo  number_format((float)$laborCharge+$otherCharges+$total, 2, '.', '') ?></strong></td>
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
           <br />
<br />

           <div class="row pull-left" > 
           <div class="col-sm-5 col-md-5 col-lg-5">
            <table width="100%" border="1" cellpadding="0" cellspacing="0"
                         data-sort="false" 
                            class="table table-condensed table-responsive table-bordered footable ">
                            <thead style="background-color:#999">
            <tr>
            
            <th width="10%">Voucher No</th><th width="10%">Quotation Date</th><th width="15%">Paid Amount</th></tr></thead>
            <tbody>
            <?php echo $voucherTable ?>
            </tbody>
            
            </table>
            </div>
            </div>

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


        
<?php /*?>                   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>   
<script type="text/javascript">
	$(function () {
		$('.footable').footable();
	});
</script>  
          

<?php */?>