<?php

require_once("../../../../modules/dailyReportByWarehouseWise/admin/class/dailyReportByWarehouseWiseModel.php");

$objCSReport  = new dailyReportByWarehouseWiseModel();

$salesmanName = $branchName = $fromDate = $toDate = $customerName = '';

$table = $j_account_id = $j_sub_account_id = $SalesAccount ='';
//$_POST['checkAll']='';
if(isset($_POST['Search'])){
	$fromDate 					= 	$_POST['fromDate'];
	$toDate   		  			= 	$_POST['toDate'];
	
	$totalDebit                 = 0;
	$totalCredit                = 0;
	$totalDebitOpeningBalance   = 0;
	$totalCreditOpeningBalance  = 0;
	$closingBalance             = 0;
	$totalDebitSum              =  0;
	
	$branchId        		=   	$_COOKIE['branchId'];
		$subaccountData			=		$objCSReport->getSubAccountDetails($branchId);
			while($row	=	mysqli_fetch_array($subaccountData))
			{
				$j_account_id		=	$row['accountHeadId'];
				$j_sub_account_id	=	$row['subAccountHeadId'];
			    $SalesAccount		=	$row['subAccountHeadName'];
			}
	
	$getDebitOpeningBalance     =$objCSReport->getDebitAmount($fromDate,$j_sub_account_id);
	while($debitAmt=mysqli_fetch_array($getDebitOpeningBalance))
		{
			$totalDebitOpeningBalance = $debitAmt['j_debit'];
		}
	$getCreditOpeningBalance     =$objCSReport->getCreditAmount($fromDate,$j_sub_account_id);
	while($creditAmt=mysqli_fetch_array($getCreditOpeningBalance))
		{
			$totalCreditOpeningBalance = $creditAmt['j_credit'];
		}	
	
	$openingBalance = $totalDebitOpeningBalance - $totalCreditOpeningBalance;
	$description = 'Opening Balance';
	
	$table                  .= '<tr height="30">
							    <td width="100" align="left" style="border:1px solid">'.$fromDate.'</td>
								<td width="100" align="left" style="border:1px solid"></td>
							    <td width="100" align="left" style="border:1px solid">'.$description.'</td>
							    <td width="100" align="right" style="border:1px solid"></td>
							    <td width="100" align="right" style="border:1px solid"></td>
							    <td width="100" align="right" style="border:1px solid">'.number_format($openingBalance,2).'</td>
							 </tr>';
		$totalDebitSum = $totalDebitSum+$openingBalance;	
	$getCustomerStatement = $objCSReport->getCustomerStatement($fromDate, $toDate, $j_sub_account_id);
	while($resultTable=mysqli_fetch_array($getCustomerStatement))
		{
			//echo $resultTable['j_referenceId'].'</br>';
			if($resultTable['j_referenceId']==2)
				$remarks ='CASH RECEIPT';
			else
				$remarks =$resultTable['j_narration'];
			
			if($resultTable['j_voucherNo']=='')
				$invoiceNo = $resultTable['j_remarks'];
			else
				$invoiceNo = $resultTable['j_voucherNo'];
			
			if($resultTable['j_referenceId']==1)
				$invoiceNo =$invoiceNo.' (In No)';
			else if($resultTable['j_referenceId']==2)
				$invoiceNo =$invoiceNo.' (V No)';
			else if($resultTable['j_referenceId']==9)
				$invoiceNo =$invoiceNo.' (Rtn No)';
			else
				$invoiceNo  = $invoiceNo;
			$balance  = 0;
			//$balance  = $resultTable['j_debit']-$resultTable['j_credit'];
			
				
				if($resultTable['j_debit']>0){
					$totalDebitSum = $totalDebitSum+$resultTable['j_debit'];
				}
				if($resultTable['j_credit']>0)
					$totalDebitSum = $totalDebitSum-$resultTable['j_credit'];
				// new
				$resultTable['j_credit']	= 	$resultTable['j_credit'] ?? 0;
				// new ends
	$table       	.=  '<tr>
						  <td align="left" width="8%">'.$resultTable['j_dateOfPayment'].'</td>
						  <td align="left" width="10%"> '.$invoiceNo.'</td>
						  <td align="left" width="10%"> '.$remarks.'  </td>
						  <td align="right" width="10%"> '.number_format($resultTable['j_debit'],2).'</td>
						  <td align="right" width="10%"> '.number_format($resultTable['j_credit'],2).'  </td>
						  <td align="right" width="10%"> '.number_format($totalDebitSum,2).'  </td>
						</tr>';
						
		$totalDebit  = 	$totalDebit+$resultTable['j_debit'];
        $totalCredit = 	$totalCredit+$resultTable['j_credit'];	
}
	$closingBalance = ($openingBalance+$totalDebit)-$totalCredit;
	$closingBalance = number_format($closingBalance,2);
	
	if($closingBalance>0)
		$closingBalance = 'Dr &nbsp;&nbsp;'.$closingBalance;
	else
		$closingBalance = 'Cr  &nbsp;&nbsp; '.$closingBalance;
$table.='<tr>
						<th width="4%" colspan="3" style="text-align: left !important;"><center>Total</center></th>
						<th width="10%" style="text-align: right !important;">'.number_format($totalDebit,2).' </th>
						<th width="8%" style="text-align: right !important;">'.number_format($totalCredit,2).' </th>
						
						
					</tr>
					 <tr class="tableRow1">
                   
                    <td width="8%" align="left" style="border:1px solid"><strong>'.$toDate.'</strong></td>
                    <td width="10%" style="border:1px solid">&nbsp;</td>
					<td width="23%" align="center" style="border:1px solid"><strong>Closing Balance</strong></td>
                    <td width="10%" style="border:1px solid">&nbsp;</td>
                    <td width="10%" style="border:1px solid">&nbsp;</td>
                    <td width="10%"align ="right" style="border:1px solid"><strong>'.$closingBalance.'</strong></td>
                </tr>';

} //END IF btnSearchReport CONDITION

$table1='';
if(isset($_POST['printPDF'])){
		
		$fromDate=$_POST['fromDatePDF'];
		$toDate=$_POST['toDatePDF'];
		
		
		$customerName               =   $_POST['customerNamePDF'];
	$totalDebit                 = 0;
	$totalCredit                = 0;
	$totalDebitOpeningBalance   = 0;
	$totalCreditOpeningBalance  = 0;
	$closingBalance             = 0;
	$totalDebitSum              =  0;
	
	$branchId        		=   	$_COOKIE['branchId'];
		$subaccountData			=		$objCSReport->getSubAccountDetails($branchId);
			while($row	=	mysqli_fetch_array($subaccountData))
			{
				$j_account_id		=	$row['accountHeadId'];
				$j_sub_account_id	=	$row['subAccountHeadId'];
			    $SalesAccount		=	$row['subAccountHeadName'];
			}
	
	
	$getDebitOpeningBalance     =$objCSReport->getDebitAmount($fromDate,$j_sub_account_id);
	while($debitAmt=mysqli_fetch_array($getDebitOpeningBalance))
		{
			$totalDebitOpeningBalance = $debitAmt['j_debit'];
		}
	$getCreditOpeningBalance     =$objCSReport->getCreditAmount($fromDate,$j_sub_account_id);
	while($creditAmt=mysqli_fetch_array($getCreditOpeningBalance))
		{
			$totalCreditOpeningBalance = $creditAmt['j_credit'];
		}	
	
	$openingBalance = $totalDebitOpeningBalance - $totalCreditOpeningBalance;
	$description = 'Opening Balance';
	
	$table1                  .= '<tr height="30">
							    <td width="100" align="left" style="border:1px solid">'.$fromDate.'</td>
								<td width="100" align="left" style="border:1px solid"></td>
							    <td width="100" align="left" style="border:1px solid">'.$description.'</td>
							    <td width="100" align="right" style="border:1px solid"></td>
							    <td width="100" align="right" style="border:1px solid"></td>
							    <td width="100" align="right" style="border:1px solid">'.number_format($openingBalance,2).'</td>
							 </tr>';
		$totalDebitSum = $totalDebitSum+$openingBalance;	
	$getCustomerStatement = $objCSReport->getCustomerStatement($fromDate, $toDate, $j_sub_account_id);
	while($resultTable=mysqli_fetch_array($getCustomerStatement))
		{
			//echo $resultTable['j_referenceId'].'</br>';
			if($resultTable['j_referenceId']==2)
				$remarks ='CASH RECEIPT';
			else
				$remarks =$resultTable['j_narration'];
			
			if($resultTable['j_voucherNo']=='')
				$invoiceNo = $resultTable['j_remarks'];
			else
				$invoiceNo = $resultTable['j_voucherNo'];
			
			if($resultTable['j_referenceId']==1)
				$invoiceNo =$invoiceNo.' (In No)';
			else if($resultTable['j_referenceId']==2)
				$invoiceNo =$invoiceNo.' (V No)';
			else if($resultTable['j_referenceId']==9)
				$invoiceNo =$invoiceNo.' (Rtn No)';
			else
				$invoiceNo  = $invoiceNo;
			$balance  = 0;
			//$balance  = $resultTable['j_debit']-$resultTable['j_credit'];
			
				
				if($resultTable['j_debit']>0){
					$totalDebitSum = $totalDebitSum+$resultTable['j_debit'];
				}
				if($resultTable['j_credit']>0)
					$totalDebitSum = $totalDebitSum-$resultTable['j_credit'];
	
	$table1       	.=  '<tr>
						  <td align="left" width="8%">'.$resultTable['j_dateOfPayment'].'</td>
						  <td align="left" width="10%"> '.$invoiceNo.'</td>
						  <td align="left" width="10%"> '.$remarks.'  </td>
						  <td align="right" width="10%"> '.number_format($resultTable['j_debit'],2).'</td>
						  <td align="right" width="10%"> '.number_format($resultTable['j_credit'],2).'  </td>
						  <td align="right" width="10%"> '.number_format($totalDebitSum,2).'  </td>
						</tr>';
						
		$totalDebit  = 	$totalDebit+$resultTable['j_debit'];
        $totalCredit = 	$totalCredit+$resultTable['j_credit'];	
}
	$closingBalance = ($openingBalance+$totalDebit)-$totalCredit;
	$closingBalance = number_format($closingBalance,2);
	
	if($closingBalance>0)
		$closingBalance = 'Dr &nbsp;&nbsp;'.$closingBalance;
	else
		$closingBalance = 'Cr  &nbsp;&nbsp; '.$closingBalance;
$table1.='<tr>
						<th width="4%" colspan="3" style="text-align: left !important;"><center>Total</center></th>
						<th width="10%" align="right" style="text-align: right !important;">'.number_format($totalDebit,2).' </th>
						<th width="8%" align="right" style="text-align: right !important;">'.number_format($totalCredit,2).' </th>
						
						
					</tr>
					 <tr class="tableRow1">
                   
                    <td width="8%" align="left" style="border:1px solid"><strong>'.$toDate.'</strong></td>
                    <td width="10%" style="border:1px solid">&nbsp;</td>
					<td width="23%" align="center" style="border:1px solid"><strong>Closing Balance</strong></td>
                    <td width="10%" style="border:1px solid">&nbsp;</td>
                    <td width="10%" style="border:1px solid">&nbsp;</td>
                    <td width="10%" align ="right" style="border:1px solid"><strong>'.$closingBalance.'</strong></td>
                </tr>';
				
		require_once '../../../../modules/stockTransitReport/admin/mpdf/vendor/autoload.php';
	$mpdf = new \Mpdf\Mpdf(['margin_header'=>'5','margin_footer'=>'0','margin_top'=>'60','margin_bottom'=>'20',
		'mode' => 'utf-8','format' => 'A4','orientation' => 'P','margin_left'=>'8','margin_right'=>'8',
		'default_font' =>'Myriad Pro','default_font_size' =>8 ]);  
    
    
		$mpdf->SetTitle('DAILY REPORT');
		$mpdf->SetSubject('DAILY REPORT');

		$mpdf->SetDefaultBodyCSS('background', "url('../../../../modules/salesInvoice/admin/includes/letterHead.jpeg')");
		$mpdf->SetDefaultBodyCSS('background-image-resize',6);
		
		// $mpdf->SetHeader('<table border="0" width="100%" cellpadding="1">
		// 		<tr>
		// 			<th width="45%" align="left">ABDULLAH MOHAMMED ALGHAMDI TRD.EST (AL ABEER COLDSTORES)</th>
		// 			<td width="5%">&nbsp;</td>
		// 			<th width="40%" style="text-align: right;">( مؤسسة عبد الله محمد الغامدي التجاریة( ثلاجات العبیر </th>
		// 		</tr>
		// 		<tr>
		// 			<th align="left">PBNO 34558 JEDDAH 21478 TEL:012 2897999</th>
		// 			<th></th>
		// 			<th style="text-align: right;"> ص ب 34558 جدة 21478 ت:2897999 012</th>
		// 		</tr>
		// 		<tr>
		// 			<th align="left">CR NO 4030142624</th>
		// 			<th></th>
		// 			<th style="text-align: right;"> س ت 4030142624</th>
		// 		</tr>
		// 		<tr>
		// 			<th align="left">VAT NO:300099808500003</th>
		// 			<th></th>
		// 			<th style="text-align: right;"> رقم الضريبة 300099808500003</th>
		// 		</tr>
		// 	 </table>');
		// $mpdf->SetFooter('Document Title');
		
		$htmlcontent = '<div width="100%"  align="center"><b>
			DAILY REPORT</b>
			</div><br/><table border="1" style="border-collapse:collapse;width:100%" id="resultTable2">
							<thead style="background-color:#d0e8d2">
								
						
							<tr>
							
							<td  width="30%" colspan="6"><center><b>FROM :&nbsp;&nbsp;&nbsp;'.$fromDate.' &nbsp;&nbsp;&nbsp;TO :&nbsp;&nbsp;&nbsp;'.$toDate.'</b></center><span id="invoiceDateModal"></span></td>
							
						</tr>
								<tr>
										 <th width="8%" style="border:1px solid;text-align: center;">Date</th>
                   
					<th width="10%"  style="text-align: center;">Invoice No</th>
                    <th width="32%"  style="text-align: center;">Description</th>
                    <th width="12%"  style="text-align: center !important;">Debit(SR)</th>
                    <th width="12%" style="text-align: center !important;">Credit(SR)</th>
                    <th width="13%" style="text-align: center !important;">Balance(SR)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
								</tr>
					</thead>
					<tbody>'.$table1.'</tbody>
					</table>
					';
		
		
	$mpdf->autoScriptToLang = true;
	$mpdf->autoLangToFont = true;
	$mpdf->WriteHTML($htmlcontent);
	ob_clean();
	$mpdf->Output();

	
		
	}
	

?>


 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- jQuery UI -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script>
$(function(){
 $("#customerNo").autocomplete({
   source: function(request, response) {
     var item1 = $('#customerNo').val();
     $.getJSON("../../../../modules/customerSalaesPayment/admin/ajax/custNoAutoComplete.php", {
   term  : $('#customerNo').val()}, 
              response
  );
 
  },
      minLength: 0,
      focus: function( event, ui ) {
    //$("#model").autocomplete("search", "");
        $("#customerNo").html( ui.item.value );
        return false;
      },
      select: function( event, ui ) {
        $( "#customerNo" ).val( ui.item.value );
        $("#customerId").val( ui.item.key );
        return false;
      } 

   });
 
});
function fnExcelReport()
{	
  var tab_text="<table border='2px'><meta charset='UTF-8'><tr bgcolor=''>";
    var textRange; var j=0;
    tab = document.getElementById('resultTable1'); // id of table
	
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
</script>

<style>
.ui-autocomplete { height: 200px; overflow-y: scroll; overflow-x: hidden;}
.ui-state-focus{
	background-color:#bff2f5 !important;
}
</style>


<script>
	function printPage(id)
	{
		//$("#pannelhide").css("display", "block");
	//document.getElementById("tbl1").style.display = "block";
		var printContents = document.getElementById(id).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	
	 $('.hideContent').hide();
	window.print();
	$('.hideContent').show();
	document.body.innerHTML = originalContents;
	//$("#pannelhide").css("display", "none");
	location.reload();
		
	}
</script> 
<div class="all">
<div class='col-sm-12 col-md-12 col-lg-12'>
<div class="panel ">
<div class="panel-body" style="padding-top:0px !important;">
<div class="row">
	<div class='col-sm-4 col-md-4 col-lg-4' style="background: #0293bf;">
			<B STYLE="font-size: 20px;color: #fff;">DAILY REPORT</B>
	</div>	

<div class='col-sm-2 col-md-2 col-lg-2'>&nbsp;</div>

<div class='col-sm-5 col-md-5 col-lg-6'>
	<form action="" method="POST"> 
		<table width="100%" id="tableSearch">
			<tr>
			<form action="" method="POST" target="_blank" > 
				
				<td width="25%">
						<input type='text' name='fromDate' id='fromDate' placeholder="FROM DATE" 
						class='input-sm datepicker' required style="width:99%" autocomplete="OFF">
				</td>
				<td width="25%">
						<input type='text' name='toDate' id='toDate' placeholder="TO DATE" 
						class='input-sm datepicker' required style="width:99%" autocomplete="OFF">
				</td>
				
				<td width="2%">
						<button type="submit" id="Search" style="width: 95%;" name="Search"  class="btn btn-primary btn-sm" title="search">
							<i class="fa fa-search"></i> 
						</button>
						
				</td>
				</form>
				
				<form action="" method="POST" target="_blank"> 
				<td width="2%">
					
					
					<input type='hidden' name='fromDatePDF' value="<?php if(isset($_POST['Search'])){ echo $_POST['fromDate'];}?>">
					<input type='hidden' name='toDatePDF' value="<?php if(isset($_POST['Search'])){ echo $_POST['toDate'];}?>">
					<button type="submit" id="printPDF" style="width: 95%;" name="printPDF" class="btn btn-info btn-sm"><i class="fa fa-print"></i></button>
					
				</td>
				<td width="2%">
						 <button type="button" id="btnExport" style="width: 95%;" class="btn btn-danger btn-sm" onclick="fnExcelReport();"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
				</td>
				</form> 
			</tr>
		</table>
			</div>
		</div>
		<br>
		<?php //echo $data2['head'];?>
			<div class="col-lg-12 col-md-12 col-sm-12">
			<table border="1" style="border-collapse:collapse;width:100%" id="resultTable1">
					<thead style="background-color:#d0e8d2">
						<tr>
							<th width="100%" COLSPAN="6" style="text-align: center !important;">DAILY REPORT</th>
						</tr>
						<tr>
							
							<td  width="30%" colspan="6"><center><b>FROM :&nbsp;&nbsp;&nbsp;<?php echo $fromDate;?> &nbsp;&nbsp;&nbsp;TO :&nbsp;&nbsp;&nbsp;<?php echo $toDate;?></b></center><span id="invoiceDateModal"></span></td>
							
						</tr>
						<tr>
							 <th width="8%" style="border:1px solid;text-align: center;">Date</th>
                   
					<th width="10%"  style="text-align: center;">Invoice No</th>
                    <th width="28%"  style="text-align: center;">Description</th>
                    <th width="10%"  style="text-align: center !important;">Debit(SR)</th>
                    <th width="10%" style="text-align: center !important;">Credit(SR)</th>
                    <th width="10%" style="text-align: center !important;">Balance(SR)</th>
						</tr>
					</thead>
					<tbody>
						<?php echo $table; ?>
					</tbody>
					</table>
				</div>
				
	
</div>
</div>	
</div>
</div>




