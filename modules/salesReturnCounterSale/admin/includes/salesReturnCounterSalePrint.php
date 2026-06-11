<?php
require_once("../../../../modules/salesReturnCounterSale/admin/controllers/SalesReturnItemWiseC.php");
$SalesReturnItemWiseC		= 	new SalesReturnItemWiseC();
$tbody=$thead=null;

if(isset($_GET['salesReturnId'])){
	
$salesReturnId		=	$_GET['salesReturnId'];
$referanceNo	=	$_GET['referanceNo'];
$invoiceData	=	$SalesReturnItemWiseC->getInvoicereturnDetails($salesReturnId);	
$tbody			=	$invoiceData['tbody'];
$thead			=	$invoiceData['thead'];

}


if(isset($_POST['print'])){
	$salesReturnId   = $_POST['salesReturnId'];
	
$invoiceData	=	$SalesReturnItemWiseC->getInvoicereturnDetails($salesReturnId);	
$tbody			=	$invoiceData['tbody'];
$thead			=	$invoiceData['thead'];

require_once '../../../../modules/stockTransitReport/admin/mpdf/vendor/autoload.php';

		$mpdf = new \Mpdf\Mpdf(['margin_header'=>'0','margin_footer'=>'0','margin_top'=>'45','margin_bottom'=>'20',
		'mode' => 'utf-8','format' => 'A4','orientation' => 'P','margin_left'=>'4','margin_right'=>'8',
		'default_font' =>'Myriad Pro','default_font_size' =>9 ]);  
    
		$mpdf->SetTitle('SALES RETURN');
		$mpdf->SetSubject('SALES RETURN');
		$mpdf->SetDefaultBodyCSS('background', "url('../../../../modules/salesInvoice/admin/includes/letterHead.jpeg')");
		$mpdf->SetDefaultBodyCSS('background-image-resize',6);
		
		// $htmlcontent = '<table border="0" width="100%" cellpadding="1" class="hideDiv">
		// 		<tr>
		// 			<td align="center" colspan="3">
		// 				<img src="../../../../modules/salesInvoice/admin/includes/logo.jpg"  width="250" height="60">
		// 			</td>
		// 		</tr>
		// 		<tr>
		// 			<th width="45%" align="left">ABDULLAH MOHAMMED ALGHAMDI TRD.EST <br/>(AL ABEER COLDSTORES)</th>
		// 			<td width="5%">&nbsp;</td>
		// 			<th width="40%" style="text-align: right;"><b>( مؤسسة عبد الله محمد الغامدي التجاریة( ثلاجات العبیر </b></th>
		// 		</tr>
		// 		<tr>
		// 			<th align="left">PBNO 34558 JEDDAH 21478 TEL:012 2897999</th>
		// 			<th></th>
		// 			<th style="text-align: right;"> <b>ص  ب: ٣٤٥٥٨     جدة:  ٢١٤٧٨   تليفون  :٢٨٩٧٩٩٩   ٠١٢</b></th>
		// 		</tr>
				
		// 		<tr>
		// 			<th align="left">CR NO 4030142624</th>
		// 			<th></th>
		// 			<th style="text-align: right;"> <b>س  ت  : ١٤٢٦٢٤ ٤٠٣٠</b></th>
		// 		</tr>
		// 		<tr>
		// 			<th align="left">VAT NO:300099808500003</th>
		// 			<th></th>
		// 			<th style="text-align: right;"><b> رقم الضريبة:    ٣٠٠٠٩٩٨٠٨٥٠٠٠٠٣</b></th>
		// 		</tr>
		// 	 </table>';
	$htmlcontent = '<br/><br/>'.$thead.$tbody;
	
	$mpdf->autoScriptToLang = true;
	$mpdf->autoLangToFont = true;
	$mpdf->WriteHTML($htmlcontent);
	ob_clean();
	$mpdf->Output();
}
/* if(isset($_POST['print'])){
	header("Location:welcome.php?page=salesReturnCounterSalePrint");
} */
?>



<meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
<body>
<div class="divWrapperFull" id='divPrint' style="width:100%">

<?php echo $thead; ?>
<?php echo $tbody; ?>
</div>

<center>
<form action="" method="POST" target="_blank">
		<input type="hidden" value="<?php echo $salesReturnId; ?>" name="salesReturnId">

		<button name="print" class="btn btn-success btn-md"><i class="fa fa-print"></i>Print</button>
		<a href="welcome.php?page=salesReturnCounterSale" class="btn btn-danger btn-md"><i class="fa fa-print"></i>Cancel</a>
	</form>
</center>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.5.0/print.js"></script>






<script>
$( document ).ready(function() {
 //window.print();
  setTimeout("closePrintView()", 5000);
});
function closePrintView() {
	var referanceNo=$('#referanceNo').val();
	if(referanceNo==1){
      //  document.location.href = 'welcome.php?page=salesInvoice';
	}else if(referanceNo==2){
		// document.location.href = 'welcome.php?page=invoiceSearchByInvoiceNo';
	}else if(referanceNo==4){
		// document.location.href = 'welcome.php?page=salesInvoice';
	}
	else
		//document.location.href = 'welcome.php?page=invoiceEdit';
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