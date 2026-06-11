<?php
require_once("../../../../modules/counterSalesInvoice/admin/controllers/c_salesInvoice.php");
$objCSalesInvoice		= 	new C_salesInvoice();
$tbody=$thead=null;

	
if(isset($_GET['invoiceId'])){
	
$invoiceId		=	$_GET['invoiceId'];
$referanceNo	=	$_GET['referanceNo'];
$invoiceData	=	$objCSalesInvoice->getInvoiceDetailsThermalprint($invoiceId);	
$tbody			=	$invoiceData['tbody'];
$thead			=	$invoiceData['thead'];
}
?>

<style type="text/css">
.divWrapperFull{width:240px; float: right;margin-right: 3%;}
.divFullWidth{width: 100%; float: left ;}
table, tr, td{font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 9px;}
table{
	word-wrap: break-word;
	word-break: break-all;
}
.companyHeader th {
    text-align: center !important; 
}
</style>
<meta http-equiv="Content-Type" content="text/html" charset=utf-8"/>
<body>
<div class="divWrapperFull" id='divPrint' >

<?php echo $thead; ?>
<?php echo $tbody; ?>
<input type='hidden' id='referanceNo' value='<?php echo $referanceNo; ?>'>
</div>
</body>
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
        document.location.href = 'welcome.php?page=counterSalesInvoice';
	}else if(referanceNo==2){
		 document.location.href = 'welcome.php?page=invoiceSearchByInvoiceNo';
	}else if(referanceNo==4){
		 document.location.href = 'welcome.php?page=counterSalesInvoice';
	}
	else
		document.location.href = 'welcome.php?page=invoiceEdit';
 }

</script>
<style type="text/css" media="print">

@media print{
 
  @page {
         /* size: A4;   auto is the initial value */
         margin: .2% .2% .2% .2%;
		  /*height:50% !importnat;*/
		}	
	.divWrapperFull{width:240px; float: right;margin-right: 3%;}
	.divFullWidth{width: 100%; float: left !important;}
	.brkPage {page-break-after:always;}
	.main-footer {display:none !important;}
	
	}
	
</style>