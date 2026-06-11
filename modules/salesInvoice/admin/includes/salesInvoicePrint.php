<style>
.skin-red,.wrapper{
	min-height:100% !important;
	height:100% !important;
}
</style>
<?php
require_once("../../../../modules/salesInvoice/admin/controllers/c_salesInvoice.php");
$objCSalesInvoice		= 	new C_salesInvoice();
$tbody=$thead=null;

	
if(isset($_GET['invoiceId'])){
	
$invoiceId		=	$_GET['invoiceId'];
$referanceNo	=	$_GET['referanceNo'];
$invoiceData	=	$objCSalesInvoice->getInvoiceDetails($invoiceId);	
$tbody			=	$invoiceData['tbody'];
$thead			=	$invoiceData['thead'];
$src= '../../../../modules/salesInvoice/admin/includes/print.php?invoiceId='.$invoiceId.'';
		
}


?>


<div style="overflow: hidden;width:100%;height:550px;float:left"  >
<input type="hidden" id="referanceNo" class="form-control input-sm" value="<?php echo $referanceNo; ?>">
<button type="button" class="btn btn-danger" id="btnCancel" style="float:right;" onclick="closePrintView();" >Cancel</button>
<iframe height="95%" width="100%" src="<?php echo $src; ?>">
</iframe>
</div>
</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.5.0/print.js"></script>




<script>

function closePrintView() {
	var referanceNo=$('#referanceNo').val();
	var invoiceId=$('#invoiceId').val();
	if(referanceNo==1){
		 document.location.href = 'welcome.php?page=salesInvoice';
	}else if(referanceNo==2){
		  document.location.href = 'welcome.php?page=invoiceSearchByInvoiceNo';
	}else if(referanceNo==4){
		  document.location.href = 'welcome.php?page=salesInvoice';
	}else
		 document.location.href = 'welcome.php?page=invoiceEdit';
 }

</script>