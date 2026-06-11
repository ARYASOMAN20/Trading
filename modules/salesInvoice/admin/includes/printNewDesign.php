<?php
header('Content-Type: text/html; charset=utf-8');
require_once("../../../../modules/salesInvoice/admin/controllers/c_salesInvoice.php");
$objCSalesInvoice		= 	new C_salesInvoice();

	
if(isset($_GET['invoiceId']))
{
	
	$invoiceId		=	$_GET['invoiceId'];
	$referanceNo	=	$_GET['referanceNo'];
	$invoiceData	=	$objCSalesInvoice->getInvoiceDetailsNewDesign($invoiceId);	
	$tbody			=	$invoiceData['tbody'];
	$thead			=	$invoiceData['thead'];
	$img			=	$invoiceData['img'];
	$customerName		=	$invoiceData['customerName'];
	$address			=	$invoiceData['address'];
	$invoiceNo			=	$invoiceData['invoiceNo'];
	$customerName			=	$invoiceData['customerName'];
	$nameArabic			=	$invoiceData['nameArabic'];
	$vatNumber			=	$invoiceData['vatNumber'];
	$transaction         = $invoiceData['transaction'];
	$quotationNo         =  $invoiceData['quotationNo'];
	$poNo         =  $invoiceData['poNo'];
	$address         =  $invoiceData['address'];

	$streetName      = $invoiceData['streetName'];
	$buildingNo      = $invoiceData['buildingNo'];
	$addlNo     	 = $invoiceData['addlNo'];
	$postalCode      = $invoiceData['postalCode'];
	$city      		 = $invoiceData['city'];
	$district      	 = $invoiceData['district'];
	$country     	 = $invoiceData['country'];
$salemanName                    =   $invoiceData['salesman'];

$salesman='';

/* if($salemanName!=''){
$salesman='<tr>
						<td width="50%" align="left"><b>SALESMAN : '.$salemanName.' </b></td>
						<td width="50%" align="right"><b>'.$salemanName.' :بائع </b></td>
					</tr>';
} */

	$vatNoArabic					=   $invoiceData['vatNoArabic'];
	$streetNameArab					=   $invoiceData['streetArabic'];
	$buildingNoArab					=   $invoiceData['buildingArabic'];
	$addlNoArab						=   $invoiceData['addlNoArabic'];
	$postalCodeArab					=   $invoiceData['postalArabic'];
	$cityArab						=   $invoiceData['cityArabic'];
	$districtArab					=   $invoiceData['districtArabic'];
	$countryArab					=   $invoiceData['countryArabic'];	
	$exRate							=   $invoiceData['exRate'];
	$invoiceDate					=	$invoiceData['invoiceDate'];
	$zakatInvoiceType				=	$invoiceData['zakatInvoiceType'];
	$invoiceTypeHeading = "";
	if($zakatInvoiceType == "0200000")
	{
		// $invoiceTypeHeading = "SIMPLIFIED TAX INVOICE / فاتورة ضريبية مبسطة";
	}
	if($zakatInvoiceType == "0100000")
	{
		// $invoiceTypeHeading = "TAX INVOICE / الفاتورة الضريبة ";
	}
}

if($nameArabic!="") { $nameArabic=' / '.$nameArabic; }
if($streetNameArab!="") { $streetNameArab=' / '.$streetNameArab; }
if($vatNoArabic!="") { $vatNoArabic=' / '.$vatNoArabic; }

require_once '../../../../modules/stockTransitReport/admin/mpdf/vendor/autoload.php';


$mpdf = new \Mpdf\Mpdf(['margin_header'=>'0','margin_footer'=>'32','margin_top'=>'54','format' => 'A4-P',
'default_font' =>'Myriad Pro','margin_left'=>'10','margin_right'=>'10','margin_bottom'=>'40','default_font_size'=>9]);

		/*  $mpdf->SetDefaultBodyCSS('background', "url('../../../../modules/salesInvoice/admin/includes/letterHead.jpeg')");
		$mpdf->SetDefaultBodyCSS('background-image-resize',6); */
   
/*------------- Header And Footer-------------------------------------------------------------------START-------------*/

	// $mpdf->DefHTMLHeaderByName('Header',
	// 						'<table border="0" width="100%" cellpadding="1" style="" class="hideDiv">
	// 							<tr>
	// 								<td align="center" colspan="3">
	// 									<img src="../../../../modules/salesInvoice/admin/includes/logo.jpg"  width="250" height="60">
	// 								</td>
	// 							</tr>
	// 							<tr>
	// 								<th width="45%" align="left">ABDULLAH MOHAMMED ALGHAMDI TRD.EST <br/>(AL ABEER COLDSTORES)</th>
	// 								<td width="5%" rowspan="4" align="center"><img src="'.$img.'" width="90px" height="90px"></td>
	// 								<th width="40%" style="text-align: right;"><b>( مؤسسة عبد الله محمد الغامدي التجاریة( ثلاجات العبیر </b></th>
	// 							</tr>
	// 							<tr>
	// 								<th align="left">PBNO 34558 JEDDAH 21478 TEL:012 2897999</th>
	// 								<th style="text-align: right;"> <b>ص  ب: ٣٤٥٥٨     جدة:  ٢١٤٧٨   تليفون  :٢٨٩٧٩٩٩   ٠١٢</b></th>
	// 							</tr>
								
	// 							<tr>
	// 								<th align="left">CR NO 4030142624</th>
	// 								<th style="text-align: right;"><b> س  ت  : ١٤٢٦٢٤ ٤٠٣٠</b></th>
	// 							</tr>
	// 							<tr>
	// 								<th align="left">VAT NO:300099808500003</th>
	// 								<th style="text-align: right;"> <b>رقم الضريبة:    ٣٠٠٠٩٩٨٠٨٥٠٠٠٠٣</b></th>
	// 							</tr>
	// 						</table>
	// 						<table width="100%"  border="0" cellpadding="3" style="border-collapse:collapse">
	// 							<tr>
	// 								<td  align="center" width="25%"></td>
	// 								<td  align="center" width="40%"><b><span style="font-size:15px;border-bottom:1px solid black;">'.$invoiceTypeHeading.'</span><b></td>
	// 								<td  align="center" width="25%"></td>
	// 							</tr>
	// 						</table>');

	 $mpdf->SetHTMLHeaderByName('Header');	
	/* $mpdf->DefHTMLFooterByName('Footer','
						<table width="100%">
							<tr>
							<th width="50%" style="text-align:left">SALESMAN(مندوب مبيعات)</th>
						
							<th width="50%" style="text-align:right">CUSTOMER(الزبون)</tk>
							</tr>
						</table>
					<table width="100%"><tr><td align="center">PageNo - {PAGENO}</td></tr></table>'); */
	$mpdf->SetHTMLFooterByName('Footer');
/*------------- Header And Footer------------------------------------------------------------------STOP--------------	
              
/*------------- Title Setting-----------------------------------------------------------------------START---------*/
	$mpdf->SetTitle('INVOICE');
	$mpdf->SetSubject('INVOICE');
/*------------- Title Setting------------------------------------------------------------------------STOP---------*/


/*-----------------------*** Content Start ****-------------------------------------------------------------------*/





if($transaction == 1){
	$type = "Cash/نقدًا";
	$arabic = "الفاتورة النقدية ";
	$display = '';
}else if($transaction==2){
	$type = " Credit/موجل ";
	$arabic = "فاتورة ضريب";
}

$htmlContent ='<style>
			#printPage thead th{
				border-left: 1px solid #000;
				border-right: 1px solid #000;
				
			}
			#printPage thead tr:nth-child(2) th{
				border-bottom:1px solid black;
			}
			#printPage{
				border-top:1px solid black;
				border-bottom:1px solid black;
			}
			#printPage tbody td{
				border-left: 1px solid #000;
				border-right: 1px solid #000;
				
			}
			.marginSet {
				margin-left: 10% !important;
			}
			</style>
<br>
			<table width="100%"  border="0" cellpadding="3" style="border-collapse:collapse" class="marginSet">
								<tr>
									<td  align="center" width="25%"></td>
									<td  align="center" width="40%"><b><span style="font-size:15px;border-bottom:1px solid black;">'.$invoiceTypeHeading.'</span><b></td>
									<td  align="center" width="25%"></td>
								</tr>
							</table>
			
			<div width="97%" style="margin-left:auto;margin-right:auto;">
				<table width="100%" border="0" cellpadding="3px" style="border-collapse:collapse;font-size:11px;"  class="marginSet" >
					<tr>
						<td width="50%"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.date("d-m-Y",strtotime($invoiceDate)).' </b></td>
						<td width="50%" align="center"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$invoiceNo.' </b></td>
					</tr>
					<tr>
					</tr>
						'.$salesman.'
				</table>
				<br>
			<div width="100%" style="border:0px solid black;">
				<table width="100%" border="0" cellpadding="3px" style="border-collapse:collapse;font-size:10px;" class="marginSet"  >
					<tr>
						<td width="10%" align="left">&nbsp;</td>
						<td width="40%" colspan="3" align="left"><b>'.$customerName.$nameArabic.'</b></td>
					</tr>
					<br><br>
					<tr>
						<td width="" align="left">&nbsp;</td>
						<td width="" colspan="3" align="left">'.$streetName.$streetNameArab.'</td>
					</tr>
					<br><br>
					 <tr>
						<td  align="left">&nbsp;</td>
						<td  align="left" colspan="3"><b>'.$vatNumber.$vatNoArabic.'</b></td>
					</tr> */		
				</table>
			</div>
			<br><br>
			'.$tbody.'</div>
		 </div>';
	$mpdf->autoScriptToLang = true;
	$mpdf->autoLangToFont = true;
	$mpdf->SetHTMLHeaderByName('Header');
	$mpdf->WriteHTML( $htmlContent);
	$mpdf->SetHTMLFooterByName('Footer');
	ob_clean(); 
	$mpdf->Output();

?>

