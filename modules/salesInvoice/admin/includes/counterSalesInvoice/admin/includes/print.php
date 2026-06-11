<?php
header('Content-Type: text/html; charset=utf-8');
require_once("../../../../modules/salesInvoice/admin/controllers/c_salesInvoice.php");
$objCSalesInvoice		= 	new C_salesInvoice();

	
if(isset($_GET['invoiceId']))
{
	
	$invoiceId		=	$_GET['invoiceId'];
	$referanceNo	=	$_GET['referanceNo'];
	$invoiceData	=	$objCSalesInvoice->getInvoiceDetails($invoiceId);	
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
if($salemanName!=''){
$salesman='<tr>
						<td width="50%" align="left"><b>SALESMAN : '.$salemanName.' </b></td>
						<td width="50%" align="right"><b>'.$salemanName.' :بائع </b></td>
					</tr>';
}

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
		$invoiceTypeHeading = "SIMPLIFIED TAX INVOICE / فاتورة ضريبية مبسطة";
	}
	if($zakatInvoiceType == "0100000")
	{
		$invoiceTypeHeading = "TAX INVOICE / الفاتورة الضريبة ";
	}
}

require_once '../../../../modules/stockTransitReport/admin/mpdf/vendor/autoload.php';


$mpdf = new \Mpdf\Mpdf(['margin_header'=>'0','margin_footer'=>'32','margin_top'=>'61','format' => 'A4-P',
'default_font' =>'Myriad Pro','margin_left'=>'6','margin_right'=>'6','margin_bottom'=>'45','default_font_size'=>9]);

		 $mpdf->SetDefaultBodyCSS('background', "url('../../../../modules/salesInvoice/admin/includes/letterHead.jpeg')");
		$mpdf->SetDefaultBodyCSS('background-image-resize',6);
   
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
	$mpdf->DefHTMLFooterByName('Footer','
						<table width="100%">
							<tr>
							<th width="50%" style="text-align:left">SALESMAN(مندوب مبيعات)</th>
						
							<th width="50%" style="text-align:right">CUSTOMER(الزبون)</tk>
							</tr>
						</table>
					<table width="100%"><tr><td align="center">PageNo - {PAGENO}</td></tr></table>');
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
			</style>

			<table width="100%"  border="0" cellpadding="3" style="border-collapse:collapse">
								<tr>
									<td  align="center" width="25%"></td>
									<td  align="center" width="40%"><b><span style="font-size:15px;border-bottom:1px solid black;">'.$invoiceTypeHeading.'</span><b></td>
									<td  align="center" width="25%"></td>
								</tr>
							</table>
			
			<div width="97%" style="margin-left:auto;margin-right:auto;">
				<table width="100%" border="0" cellpadding="3px" style="border-collapse:collapse;font-size:11px;"  >
					<tr>
						<td width="50%" align="left"><b>INVOICE NO : '.$invoiceNo.' </b></td>
						<td width="50%" align="right"><b>'.$invoiceNo.' : رقم الفاتورة </b></td>
					</tr>
					<tr>
						<td width="50%" align="left"><b>DATE : '.date("d-m-Y",strtotime($invoiceDate)).' </b></td>
						<td width="50%" align="right"><b>'.date("d-m-Y",strtotime($invoiceDate)).' : تاريخ </b></td>
					</tr>
						'.$salesman.'
				</table>
				<br>
				<div width="100%" style="border:0px solid black;">		
					<table width="100%" border="0" cellpadding="3px" style="border-collapse:collapse;font-size:10px;"  >
						<tr>
							<td colspan="4"  align="left" style="font-size:10px;border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;"><b>OUR DETAILS</b></td>
							<td colspan="4"  align="right" style="font-size:10px;border-top:1px solid black;border-right:1px solid black;"><b> تفاصيل شركتنا</b></td>
						</tr>
						<tr>
							<td width="10%" align="left" style="border-left:1px solid black;border-top:1px solid black;border-right:0px solid black;">Name:</td>
							<td width="40%" colspan="3" align="left" style="padding-left:1em;border-top:1px solid black;border-right:1px solid black;"><b>Naf Al Abeer Food Trading Est.</b></td>							
							<td width="40%" colspan="3" align="right" style="border-top:1px solid black;border-right:0px solid black;"><b>     </b></td>							
							<td width="10%" align="right" style="border-top:1px solid black;border-right:1px solid black;">االسم</td>
						</tr>
						<tr>
							<td width="" align="left" style="border-left:1px solid black;border-top:1px solid black;border-right:0px solid black;">Street Name:</td>
							<td width="" colspan="3" align="left" style="padding-left:1em;border-top:1px solid black;border-right:1px solid black;">Central Vegetables Market</td>					
							<td width="" colspan="3" align="right" style="border-top:1px solid black;border-right:0px solid black;"></td>					
							<td width="" align="right" style="border-top:1px solid black;border-right:1px solid black;">اسم الشارع</td>
						</tr>
						<tr>
							<td width="10%" align="left" style="border-left:1px solid black;border-top:1px solid black;border-right:0px solid black;">Building No:</td>
							<td width="15%" align="left" style="border-top:1px solid black;border-right:1px solid black;"></td>
							<td width="10%" align="left" style="border-top:1px solid black;border-right:0px solid black;">City:</td>
							<td width="15%" align="left" style="border-top:1px solid black;border-right:1px solid black;">Jeddah</td>
							<td width="15%" align="center" style="border-top:1px solid black;border-right:0px solid black;">جدة</td>
							<td width="10%" align="right" style="border-top:1px solid black;border-right:1px solid black;">المدينة</td>
							<td width="15%" align="right" style="border-top:1px solid black;border-right:0px solid black;"></td>
							<td width="10%" align="right" style="border-top:1px solid black;border-right:1px solid black;">رقم المبنى</td>
						</tr>
						<!--<tr>
							<td  align="left" style="border-top:1px solid black;border-right:0px solid black;">Addl No:</td>
							<td  align="left" style="border-top:1px solid black;border-right:1px solid black;"></td>
							<td  align="left" style="border-top:1px solid black;border-right:0px solid black;">District</td>
							<td align="left" style="border-top:1px solid black;border-right:1px solid black;"></td>
							<td  align="right" style="border-top:1px solid black;border-right:0px solid black;"></td>
							<td align="right" style="border-top:1px solid black;border-right:1px solid black;">الحي</td>
							<td  align="right" style="border-top:1px solid black;border-right:0px solid black;"></td>
							<td  align="right" style="border-top:1px solid black;border-right:1px solid black;">الرقم إالضافي</td>
						</tr>-->	  
						<tr>
							<td  align="left" style="border-left:1px solid black;border-top:1px solid black;border-right:0px solid black;">Postal Code:</td>
							<td  align="left" style="border-top:1px solid black;border-right:1px solid black;">24321</td>
							<td  align="left" style="border-top:1px solid black;border-right:0px solid black;">Country:</td>
							<td align="left" style="border-top:1px solid black;border-right:1px solid black;">Kingdom Saudi Arabia</td>
							<td  align="right" style="border-top:1px solid black;border-right:0px solid black;">مملكة العربية السعودية</td>		 
							<td align="right" style="border-top:1px solid black;border-right:1px solid black;">البلد</td>
							<td  align="right" style="border-top:1px solid black;border-right:0px solid black;"></td>
							<td  align="right" style="border-top:1px solid black;border-right:1px solid black;">الرمز البريدي</td>
						</tr>
						<tr>
							<td  width="" align="left" style="border-bottom:1px solid black;border-left:1px solid black;border-top:1px solid black;border-right:0px solid black;">VAT Number:</td>
							<td  width="" colspan="3" align="left" style="border-bottom:1px solid black;border-top:1px solid black;border-right:1px solid black;"><b></b></td>
							<td  width="" colspan="3" align="right" style="border-bottom:1px solid black;border-top:1px solid black;border-right:0px solid black;"><b></b></td>
							<td  width="" colspan="2" align="right" style="border-bottom:1px solid black;border-top:1px solid black;border-right:1px solid black;"><b>  رقم الضريبة</b></td>
						</tr>		
					</table>
				</div>
			<br>
			<div width="100%" style="border:0px solid black;">
				<table width="100%" border="0" cellpadding="3px" style="border-collapse:collapse;font-size:10px;"  >
					<tr>
						<td colspan="4"  align="left" style="font-size:10px;border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;"><b>CLIENT DETAILS</b></td>
						<td colspan="4"  align="right" style="font-size:10px;border-top:1px solid black;border-right:1px solid black;"><b> تفاصيل شركة العميل</b></td>
					</tr>
					<tr>
						<td width="10%" align="left" style="border-left:1px solid black;border-top:1px solid black;border-right:0px solid black;">Name:</td>
						<td width="40%" colspan="3" align="left" style="border-top:1px solid black;border-right:1px solid black;"><b>'.$customerName.'</b></td>
						
						<td width="40%" colspan="3" align="right" style="border-top:1px solid black;border-right:0px solid black;"><b>'.$nameArabic.' </b></td>
						
						<td width="10%" align="right" style="border-top:1px solid black;border-right:1px solid black;">االسم</td>
					</tr>
					<tr>
						<td width="" align="left" style="border-left:1px solid black;border-top:1px solid black;border-right:0px solid black;">Street Name:</td>
						<td width="" colspan="3" align="left" style="border-top:1px solid black;border-right:1px solid black;">'.$streetName.'</td>
						
						<td width="" colspan="3" align="right" style="border-top:1px solid black;border-right:0px solid black;">'.$streetNameArab.'</td>
						
						<td width="" align="right" style="border-top:1px solid black;border-right:1px solid black;">اسم الشارع</td>
					</tr>
					<tr>
						<td width="10%" align="left" style="border-left:1px solid black;border-top:1px solid black;border-right:0px solid black;">Building No:</td>
						<td width="15%" align="left" style="border-top:1px solid black;border-right:1px solid black;">'.$buildingNo.'</td>
						<td width="10%" align="left" style="border-top:1px solid black;border-right:0px solid black;">City</td>
						<td width="15%" align="left" style="border-top:1px solid black;border-right:1px solid black;">'.$city.'</td>
						<td width="15%" align="right" style="border-top:1px solid black;border-right:0px solid black;">'.$cityArab.'</td>
						<td width="10%" align="right" style="border-top:1px solid black;border-right:1px solid black;">المدينة</td>
						<td width="15%" align="right" style="border-top:1px solid black;border-right:0px solid black;">'.$buildingNoArab.'</td>
						<td width="10%" align="right" style="border-top:1px solid black;border-right:1px solid black;">رقم المبنى</td>
					</tr>
					<tr>
						<td  align="left" style="border-left:1px solid black;border-top:1px solid black;border-right:0px solid black;">Addl No:</td>
						<td  align="left" style="border-top:1px solid black;border-right:1px solid black;">'.$addlNo.'</td>
						<td align="left" style="border-top:1px solid black;border-right:0px solid black;">District</td>
						<td  align="left" style="border-top:1px solid black;border-right:1px solid black;">'.$district.'</td>
						<td  align="right" style="border-top:1px solid black;border-right:0px solid black;">'.$districtArab.'</td>
						<td align="right" style="border-top:1px solid black;border-right:1px solid black;">الحي</td>
						<td  align="right" style="border-top:1px solid black;border-right:0px solid black;">'.$addlNoArab.'</td>
						<td  align="right" style="border-top:1px solid black;border-right:1px solid black;">الرقم إالضافي</td>
					</tr>
					<tr>
						<td  align="left" style="border-left:1px solid black;border-top:1px solid black;border-right:0px solid black;">Postal Code:</td>
						<td  align="left" style="border-top:1px solid black;border-right:1px solid black;">'.$postalCode.'</td>
						<td align="left" style="border-top:1px solid black;border-right:0px solid black;">Country</td>
						<td  align="left" style="border-top:1px solid black;border-right:1px solid black;">'.$country.'</td>
						<td  align="right" style="border-top:1px solid black;border-right:0px solid black;">'.$countryArab.'</td>
						<td align="right" style="border-top:1px solid black;border-right:1px solid black;">البلد</td>
						<td  align="right" style="border-top:1px solid black;border-right:0px solid black;">'.$postalCodeArab.'</td>
						<td  align="right" style="border-top:1px solid black;border-right:1px solid black;">الرمز البريدي</td>
					</tr>
					<tr>
						<td  align="left" style="border-bottom:1px solid black;border-left:1px solid black;border-top:1px solid black;border-right:0px solid black;">VAT Number:</td>
						<td  align="left" colspan="3" style="border-bottom:1px solid black;border-top:1px solid black;border-right:0px solid black;"><b>'.$vatNumber.'</b></td>
						<td  align="right" colspan="3" style="border-bottom:1px solid black;border-top:1px solid black;border-right:0px solid black;"><b>'.$vatNoArabic.'</b></td>
						<td  align="right" colspan="" style="border-bottom:1px solid black;border-top:1px solid black;border-right:1px solid black;">الرقم الضريبي</td>
					</tr>		
				</table>
			</div>
			<br>
			'.$tbody.'
		 </div>';
	$mpdf->autoScriptToLang = true;
	$mpdf->autoLangToFont = true;
	$mpdf->SetHTMLHeaderByName('Header');
	$mpdf->WriteHTML( $htmlContent);
	$mpdf->SetHTMLFooterByName('Footer');
	ob_clean(); 
	$mpdf->Output();

?>

