

<?php  
	require_once("../../../../modules/estimateQuotationReport/admin/controller/c_EstimateQuotationReport.php");
	require('../../../../libraries/class/utils.php');
	require_once("../../../../settings/path.php");
    $objPath       = new Path();
    $objUtils       = new Utils();
	$listTable = '';
	$listTableLPO='';
	$objCEstimateQuotationReport = new  C_EstimateQuotationReport();
	$jobEstimateId 			   = $_POST['jobEstimateId'];
		
	$listDetailsTable 			  = $objCEstimateQuotationReport->listDetailsByEstimateId($jobEstimateId );
	$listDetailsTableMaterilasData = $objCEstimateQuotationReport->listDetailsByEstimateIdMaterialData($jobEstimateId );
	$listTableLPO 				  = $objCEstimateQuotationReport->listDetailsByEstimateIdMaterialDataLPO($jobEstimateId );
		
		if($resList = mysqli_fetch_array($listDetailsTable))
		{
			$no = $resList['jobEstimateNo'];
			$date = $objUtils->reversFormatDate($resList['estimateDate']);
			$jobType = $resList['jobTypeName'];
			
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


<h3>Estimate Details</h3>  
<div class="row">
	 
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="box box-solid" >
                <div class="box-body">
                <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label for="jobType"><?php echo 'Job Type :  '. $jobType; ?></label>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label for="jobType"><?php echo 'Estimate No :  ' .$no; ?></label>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label for="jobType"><?php echo 'Estimate Date :  '. $date; ?></label>
                        </div>
                    </div>
                    </div>
                
                
                            <table width="50%" border="0" cellpadding="0" cellspacing="0" 
            data-page-navigation=".pagination" data-page-size="8" data-sort="false" class="table table-responsive table-bordered table-striped  ">

	
                <thead style="background-color:rgb(236, 240, 245);">
                    <tr>
                        
                        
                        <th width="2%">Materials Name</th>
                        <th width="2%">Quantity</th>
                        <th width="2%">Unit Name</th>
                        <th width="2%">Unit Price</th>
                    </tr>
                </thead>
                <tbody>
                <?php  echo $listDetailsTableMaterilasData; ?> 
                <tr>
                        	<td colspan="6">
                            	<strong>LPO :</strong>
                            </td>
                      	</tr>
                        <?php echo $listTableLPO?>  
                </tbody>
                
                <!--<tfoot>
                    <tr>
                        <td colspan="14">
                            <div class="pagination pagination-centered hide-if-no-paging"></div>
                        </td>
                    </tr>
                </tfoot>-->
            </table>

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
