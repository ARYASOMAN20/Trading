
<?php 
require_once("../../../../modules/purchase/admin/class/m_purchase.php");
$objMPurchase = new M_Purchase();

require_once("../../../../modules/purchase/admin/controllers/c_purchase.php");
$objCPurchase = new C_Purchase();

$purchaseItemBillId = '';
$table 				= '';
$purchaseItemBillId = $_GET['purchaseItemBillId'];
$referanceNo 		= $_GET['referanceNo'];

$table		=	$objCPurchase->getPurchasePrintTable($purchaseItemBillId);

?>
<div>
	<input type="hidden" name="referanceNo" id="referanceNo" value="<?php echo $referanceNo; ?>"/>
	<?php echo $table; ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.5.0/print.js"></script>






<script>
$( document ).ready(function() {
 window.print();
 setTimeout("closePrintView()", 5000);
});
function closePrintView() {
	var referanceNo=$('#referanceNo').val();
	if(referanceNo==1){
        document.location.href = 'welcome.php?page=addPurchaseItem';
	}else if(referanceNo==2)
	{
		document.location.href = 'welcome.php?page=purchaseLocalinvoiceSearchByInvoiceNo';
	}
	else
		document.location.href = 'welcome.php?page=addPurchaseItem';
 }

</script>
<style type="text/css" media="print">

@media print{
 
  @page {
         /* size: A4;   auto is the initial value */
         margin: 5% 8% 2% 8%;
		  /*height:50% !importnat;*/
		}	
	
	.brkPage {page-break-after:always;}
	.main-footer {display:none !important;}
	
	}
	
</style>
