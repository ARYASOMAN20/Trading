<?php  
	/* DEVELOPED BY AK 09/01/2021 */
	
	require_once("../../../../modules/stockTransitReport/admin/controller/StockTransitReportC.php");
	$StockTransitReportC = new StockTransitReportC();
	$data='';
	if(isset($_POST['Search'])){
		
		$fromDate=$_POST['fromDate'];
		$toDate=$_POST['toDate'];
		
		
		$data=$StockTransitReportC->search($fromDate,$toDate);
		
	}
	
	
	if(isset($_POST['printPDF'])){
		
		$fromDate=$_POST['fromDatePDF'];
		$toDate=$_POST['toDatePDF'];
		
		$data=$StockTransitReportC->searchPDF($fromDate,$toDate);
		
		require_once '../../../../modules/stockTransitReport/admin/mpdf/vendor/autoload.php';

		$mpdf = new \Mpdf\Mpdf(['margin_header'=>'0','margin_footer'=>'0','margin_top'=>'15','margin_bottom'=>'20',
		'mode' => 'utf-8','format' => 'A4','orientation' => 'L','margin_left'=>'4','margin_right'=>'8',
		'default_font' =>'Myriad Pro','default_font_size' =>9 ]);  
    
		$mpdf->SetTitle('STOCK TRANSIT REPORT');
		$mpdf->SetSubject('STOCK TRANSIT REPORT');
		
		$htmlcontent = '<h2 align="center"><u>STORE RECEIPT IMPORT</u></h2>
						<h4 align="center">From : '.$fromDate.' &nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; To  : '.$toDate.'</h4>
						<table style="border-collapse:collapse" width="100%" border="1">
						<thead>
							<tr>
							<th width="10%" align="center">Invoice Date</th>
							<th width="10%" align="center">Inv No</th>
							<th width="50%" align="center">Vendor Name</th>
							<th width="5%" align="center">Currency</th>
							<th width="10%" align="center">Container No</th>
							<th width="10%" align="center">Supplier Inv No</th>
						</tr>
						</thead>
						<tbody>'.$data.'</tbody>
						</table>';
		
		
	$mpdf->autoScriptToLang = true;
	$mpdf->autoLangToFont = true;
	$mpdf->WriteHTML($htmlcontent);
	ob_clean();
	$mpdf->Output();

	
		
	}
	
	if(isset($_POST['printPDFForDetails'])){
		
		$invoiceNo =$invoiceDate=$vendorName=$currencyName=$containerNo=$supplierInvoiceNo=$tbody=$tbody2=$tbody3=null;

		$importPurchaseId = $_POST['importPurchaseIdPDF'];
		
		$getDetails = $StockTransitReportC->getDetails($importPurchaseId);
		
		while($row = mysqli_fetch_array($getDetails)){
			
			$invoiceNo = $row['invoiceNo'];
			$invoiceDate = implode("-",array_reverse(explode("-",$row['invoiceDate'])));
			$vendorName = $row['vendorName'];
			$currencyName = $row['currencyName'];
			$containerNo = $row['containerNo'];
			$supplierInvoiceNo = $row['supplierInvoiceNo'];
			
			$totalQty = $row['totalQty'];
			$totalNetWeight = $row['totalNetWeight'];
			$totalAmount = $row['totalAmt'];
			$totalAmtInSr = $row['totalAmtInSR'];
			$totalExpenseCost = $row['totalExpenseCost'];
			
			$customeDuty = $row['customDuty'];
			$other = $row['other'];
			$transportation = $row['transportation'];
			$clearingCharge = $row['clearingCharge'];
			$oceanFreight = $row['oceanFreight'];
			$deliveryOrderFee = $row['deliveryOrderFee'];
			$totalExpense = $row['totalExpense'];
			$totalExpensePerKg = $row['totalExpensePerKg'];
			
			
			$lastTotalAmt = $row['lastTotalAmount'];
			$discount = $row['discount'];
			$lastTotalAmountAfterDis = $row['lastTotalAmountAfterDis'];
			$lastTotalAmountAfterDisInRiyal = $row['lastTotalAmountAfterDisInRiyal'];
			$lastVatPer = $row['lastVatPer'];
			$lastVatAmount = $row['lastVatAmount'];
			$lastTotalAmountWithVat = $row['lastTotalAmountWithVat'];
			
			
			$tbody .='<tr>
							<td>'.$row['itemCode'].'/'.$row['itemName'].'</td>
							<td align="right">'.$row['quantityRow'].'</td>
							<td>'.$row['unitName'].'</td>
							<td align="right">'.$row['netWeightRow'].'</td>
							<td align="right">'.number_format($row['unitPriceRow'],2).'</td>
							<td align="right">'.number_format($row['amountRow'],2).'</td>
							<td align="right">'.number_format($row['amountInSrRow'],2).'</td>
							<td>'.implode("-",array_reverse(explode("-",$row['expiryDateRow']))).'</td>
							<td align="right">'.number_format($row['expesePerKgRow'],2).'</td>
							<td align="right">'.number_format($row['totalExpRow'],2).'</td>
							<td align="right">'.number_format($row['costPlusExpRow'],2).'</td>
							<td align="right">'.number_format($row['costPerCtnRow'],2).'</td>
						</tr>';
			
		}
	
		$tbody .='<tr>
							<td>Total</td>
							<td align="right">'.$totalQty.'</td>
							<td></td>
							<td align="right">'.number_format($totalNetWeight,2).'</td>
							<td></td>
							<td align="right">'.number_format($totalAmount,2).'</td>
							<td align="right">'.number_format($totalAmtInSr,2).'</td>
							<td></td>
							<td></td>
							
							<td align="right">'.number_format($totalExpenseCost,2).'</td>
							<td></td>
							<td></td>
					</tr>';
					
		$tbody2 ='<tr>
					<td width="30%">CUSTOM DUTY </td><td width="20%" align="CENTER">'.number_format($customeDuty,2).'</td><td width="30%">OTHERS </td><td width="20%" align="CENTER"> '.number_format($other,2).'</td>
				</tr>
				<tr>
					<td>TRANSPORTATION </td><td align="CENTER"> '.number_format($transportation,2).'</td><td>OCEAN FREIGHT </td><td align="CENTER"> '.number_format($oceanFreight,2).'</td>
				</tr>
				<tr>
					<td>CLEARING CHARGE </td><td align="CENTER"> '.number_format($clearingCharge,2).'</td><td>DELIVERY ORDER FEE </td><td align="CENTER"> '.number_format($deliveryOrderFee,2).'</td>
				</tr>
				<tr>
					<td>TOTAL </td><td align="CENTER"> '.number_format($totalExpense,2).'</td><td>PER KG </td><td align="CENTER"> '.number_format($totalExpensePerKg,2).'</td>
				</tr>';
				
		$tbody3 ='<tr>
						<td width="60%">Total Amount</td><td width="40%" align="right">'.number_format($lastTotalAmt,2).'</td>
					</tr>
					<tr>
						<td >Discount</td><td align="right">'.number_format($discount,2).'</td>
					</tr>
					<tr>
						<td >Amount After Dis </td><td align="right">'.number_format($lastTotalAmountAfterDis,2).'</td>
					</tr>
					<tr>
						<td >Total Amount('.$currencyName.')</td><td align="right">'.number_format($lastTotalAmountAfterDisInRiyal,2).'</td>
					</tr>
					<tr>
						<td>Vat('.number_format($lastVatPer,2).'%)</td><td align="right">'.number_format($lastVatAmount,2).'</td>
					</tr>
					<tr>
						<td >Total With Vat : </td><td align="right">'.number_format($lastTotalAmountWithVat,2).'</td>
					</tr>';
				
		
		require_once '../../../../modules/stockTransitReport/admin/mpdf/vendor/autoload.php';

		$mpdf = new \Mpdf\Mpdf(['margin_header'=>'0','margin_footer'=>'0','margin_top'=>'15','margin_bottom'=>'20',
		'mode' => 'utf-8','format' => 'A4','orientation' => 'L','margin_left'=>'4','margin_right'=>'8',
		'default_font' =>'Myriad Pro','default_font_size' =>9 ]);  
    
		$mpdf->SetTitle('STOCK TRANSIT REPORT');
		$mpdf->SetSubject('STOCK TRANSIT REPORT');
		$htmlcontent = '<h2 align="center"><u>IMPORT PURCHASE</u></h2>
		
						<table width="100%" id="table1">
					<tbody>
						<tr>
							<td width="20%">Invoice No : '.$invoiceNo.'</td>
							<td  width="20%">Invoice Date : '.$invoiceDate.'</td>
							<td  width="60%">Vendor Name : '.$vendorName.'</td>
						</tr>
						<tr>
							<td colspan="3">&nbsp;</td>
						</tr>
					</tbody>
				</table>
				</div>
				<div >
				<table border="1" style="border-collapse:collapse;width:100%" id="table2" >
					<thead style="background-color:#d0e8d2">
						<tr>
							<th width="20%" style="text-align: center !important;">Barcode/Item Name</th>
							<th width="6%" style="text-align: center !important;">Qty</th>
							<th width="7%" style="text-align: center !important;">Unit Name</th>
							<th width="8%" style="text-align: center !important;">Net Weight</th>
							<th width="8%" style="text-align: center !important;">Unit Price</th>
							<th width="8%" style="text-align: center !important;">Amt</th>
							<th width="10%" style="text-align: center !important;">Amt('.$currencyName.')</th>
							<th width="8%" style="text-align: center !important;">Expiry Date</th>
							<th width="7%" style="text-align: center !important;">Exp/Kg</th>
							<th width="8%" style="text-align: center !important;">Total Exp</th>
							<th width="7%" style="text-align: center !important;">Cost+Exp</th>
							<th width="11%" style="text-align: center !important;">Cost/KG</th>
						</tr>
					</thead>
					<tbody >'.$tbody.'</tbody>
				</table>
				</div>
				<div width="40%" style="float:left">
				<table width="100%" style="float:left;border-collapse:collapse" border="1" >
					<tbody >'.$tbody2.'</tbody>
				</table>
				</div>
				<div width="30%" style="float:right">
				<table width="100%" style="float:right;border-collapse:collapse" border="1">
					<tbody>'.$tbody3.'<tbody>
				</table>
				</div>
			</div> ';
		
		
	$mpdf->autoScriptToLang = true;
	$mpdf->autoLangToFont = true;
	$mpdf->WriteHTML($htmlcontent);
	ob_clean();
	$mpdf->Output();

	
		
	}
	
	
	
	
	
	
?>


<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script>
function fnExcelReport()
{	
    var tab_text="<table border='2px'><meta charset='UTF-8'><tr bgcolor=''>";
    var textRange; var j=0;
    tab = document.getElementById('resultTable2'); // id of table
	
    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}


function fnExcelReportDetails()
{	
    var tab_text="<table border='2px'><meta charset='UTF-8'><tr bgcolor=''>";
    var textRange; var j=0;
    tab = document.getElementById('table1'); // id of table
	
    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table><table border='2px'><meta charset='UTF-8'><tr bgcolor=''>";
	
	tab = document.getElementById('table2'); // id of table
	
    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }
	    tab_text=tab_text+"</table><table border='2px'><meta charset='UTF-8'>";

		
	tab = document.getElementById('table3'); 
		var tab1 = document.getElementById('table4');

	
    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
		if(j!=3){
			tab_text=tab_text+tab.rows[j].innerHTML;
			tab_text=tab_text+"<td></td><td></td>"+tab1.rows[j].innerHTML+"</tr>";
		
		}else{
				tab_text=tab_text+tab.rows[j].innerHTML;
				tab_text=tab_text+"<td></td><td></td>"+tab1.rows[j].innerHTML+"</tr>";;
			
			tab_text=tab_text+"<td></td><td></td><td></td><td></td><td></td><td></td>"+tab1.rows[4].innerHTML+"</tr>";
			tab_text=tab_text+"<td></td><td></td><td></td><td></td><td></td><td></td>"+tab1.rows[5].innerHTML+"</tr>";
		}

    }
		  
	tab_text=tab_text+"</table>";
		
 
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}


function getDetails(importPurchaseId){
	
	$.ajax({
		url:'../../../../modules/stockTransitReport/admin/ajax/getDetails.php',
		type:'POST',
		dataType:'JSON',
		data:{importPurchaseId:importPurchaseId},
		
		success:function(data){
			$('#myModal').modal('show');
			$('#importTbody').html(data.tbody);
			$('#importExpense').html(data.tbody2);
			$('#importTotal').html(data.tbody3);
			$('#invoiceNoModal').html(data.invoiceNo);
			$('#invoiceDateModal').html(data.invoiceDate);
			$('#CurrencyNameModal1').html(data.currencyName);
			$('#CurrencyNameModal2').html(data.currencyName);
			$('#vendorNameModal').html(data.vendorName);
			$('#importPurchaseIdPDF').val(importPurchaseId);
			
			
		},
		complete: function(){}
	});
}

</script>

<style>

.all   {font-size:12px !important;}

#tableSearch input:focus {
    background-color: #bff2f5 !important;
}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<div class="all">
<div class='col-sm-12 col-md-12 col-lg-12'>
<div class="panel ">
<div class="panel-body" style="padding-top:0px !important;">
<div class="row">
	<div class='col-sm-4 col-md-4 col-lg-4' style="background: #0293bf;">
			<B STYLE="font-size: 20px;color: #fff;">STOCK TRANSIT REPORT</B>
	</div>	

<div class='col-sm-3 col-md-3 col-lg-3'>&nbsp;</div>

<div class='col-sm-5 col-md-5 col-lg-5'>
	<form action="" method="POST"> 
		<table width="100%" id="tableSearch">
			<tr>
			<form action="" method="POST" target="_blank" > 

			<td width="25%">&nbsp;</td>
				<td width="30%">
						<input type='text' name='fromDate' id='fromDate' placeholder="FROM DATE" 
						class='input-sm datepicker' required style="width:95%" autocomplete="OFF">
				</td>
				<td width="30%">
						<input type='text' name='toDate' id='toDate' placeholder="TO DATE" 
						class='input-sm datepicker' required style="width:95%" autocomplete="OFF">
				</td>
				<td width="4%">
						<button type="submit" id="Search"  name="Search"  class="btn btn-primary btn-sm" title="search">
							<i class="fa fa-search"></i> 
						</button>
						
				</td>
				</form>
				
				<form action="" method="POST" target="_blank"> 
				<td width="4%">
					<input type='hidden' name='fromDatePDF' value="<?php if(isset($_POST['Search'])){ echo $_POST['fromDate'];}?>">
					<input type='hidden' name='toDatePDF' value="<?php if(isset($_POST['Search'])){ echo $_POST['toDate'];}?>">
					<button type="submit" id="printPDF" name="printPDF" class="btn btn-info btn-sm"><i class="fa fa-print"></i></button>
					
				</td>
				<td width="4%">
						 <button type="button" id="btnExport" class="btn btn-danger btn-sm" onclick="fnExcelReport();"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
				</td>
				</form> 
			</tr>
		</table>
			</div>
		</div>
		<br>
			<table border="1" style="border-collapse:collapse;width:100%" id="resultTable2">
					<thead style="background-color:#d0e8d2">
						<tr>
							<th width="10%" style="text-align: center !important;">Invoice Date</th>
							<th width="10%" style="text-align: center !important;">Inv No</th>
							<th width="50%" style="text-align: center !important;">Vendor Name</th>
							<th width="5%" style="text-align: center !important;">Currency</th>
							<th width="10%" style="text-align: center !important;">Container No</th>
							<th width="10%" style="text-align: center !important;">Supplier Inv No</th>
							<th width="5%" style="text-align: center !important;">Details</th>
						</tr>
					</thead>
					<tbody>
						<?php echo $data; ?>
					</tbody>
					</table>
	
</div>
</div>	
</div>
</div>




<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document" style="margin-left:6%">
    <div class="modal-content" style="width:130%">
       <div class="modal-body" style="padding:0px !important;">
				<div class='col-sm-4 col-md-4 col-lg-4' style="background: #0293bf;">
					<B STYLE="font-size: 20px;color: #fff;">STOCK TRANSIT REPORT  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-forward" aria-hidden="true"></i></B>
				</div>	
				<div class='col-sm-3 col-md-3 col-lg-3'>&nbsp;</div>
				<div class='col-sm-5 col-md-5 col-lg-5'>
				<form action="" method="POST" target="_blank" style="float:right"> 
					<input type='hidden' name='importPurchaseIdPDF' id="importPurchaseIdPDF">
					<button type="submit" id="printPDFForDetails" name="printPDFForDetails" class="btn btn-info btn-sm"><i class="fa fa-print"></i></button>
					<button type="button" id="btnExport" class="btn btn-danger btn-sm" onclick="fnExcelReportDetails();"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
				</form> 
				</div>
				
				<div style="padding:15px" >
				<table width="100%" id="table1">
					<tbody>
						<tr>
							<td width="20%">Invoice No : <span id="invoiceNoModal"></span></td>
							<td  width="20%">Invoice Date : <span id="invoiceDateModal"></span></td>
							<td  width="60%">Vendor Name : <span id="vendorNameModal"></span></td>
						</tr>
					</tbody>
				</table>
				</div>
				<div style="padding-left:1.8%;padding-right:1.7%">
				<table border="1" style="border-collapse:collapse;width:100%" id="table2" >
					<thead style="background-color:#d0e8d2">
						<tr>
							<th width="20%" style="text-align: center !important;">Barcode/Item Name</th>
							<th width="6%" style="text-align: center !important;">Qty</th>
							<th width="7%" style="text-align: center !important;">Unit Name</th>
							<th width="8%" style="text-align: center !important;">Net Weight</th>
							<th width="8%" style="text-align: center !important;">Unit Price</th>
							<th width="8%" style="text-align: center !important;">Amt</th>
							<th width="10%" style="text-align: center !important;">Amt(<span id="CurrencyNameModal2"></span>)</th>
							<th width="8%" style="text-align: center !important;">Expiry Date</th>
							<th width="7%" style="text-align: center !important;">Exp/Kg</th>
							<th width="8%" style="text-align: center !important;">Total Exp</th>
							<th width="7%" style="text-align: center !important;">Cost+Exp</th>
							<th width="11%" style="text-align: center !important;">Cost/KG</th>
						</tr>
					</thead>
					<tbody id="importTbody"></tbody>
				</table>
				</div>
				<div width="100%" class="row" style="padding-left:3%;padding-right:3%">
				<table width="50%" style="float:left" border="1" id="table3">
					<tbody id="importExpense"></tbody>
				</table>
				
				<table width="30%" style="float:right" border="1" id="table4">
					<tbody id="importTotal"></tbody>
				</table>
				</div>
			</div> 
<br>			
			<div class="modal-footer"  style="padding:0px !important">
				<div class='col-sm-4 col-md-4 col-lg-4' style="background: #0293bf;float:right;padding:0.1%">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp; Close</button>
				</div>	
			</div>
		</div>
	</div>
</div>
  

