<?php
require_once("../../../../modules/counterSalesInvoiceReportByDate/admin/controller/counterSalesInvoiceReportByDateC.php");
$counterSalesInvoiceReportC = new counterSalesInvoiceReportByDateC();


$privilageId             =   	$_COOKIE['privillegeId'];
$mainBranch             =   	$_COOKIE['mainBranch'];

$data=$fromDate  = $toDate = '';


if(isset($_POST['Search'])){
		
    $fromDate			=	$_POST['fromDate'];
    $toDate				=	$_POST['toDate'];
    $privilageId        =   $_COOKIE['privillegeId'];
    $branchId        	=   $_COOKIE['branchId'];

    $data=$counterSalesInvoiceReportC->search($fromDate,$toDate,$privilageId,$branchId);
}


if(isset($_POST['printPDF'])){
		
    $fromDate=$_POST['fromDatePDF'];
    $toDate=$_POST['toDatePDF'];
    $privilageId        =   $_COOKIE['privillegeId'];
    $branchId        	=   $_COOKIE['branchId'];
    $data=$counterSalesInvoiceReportC->search($fromDate,$toDate,$privilageId,$branchId);
    require_once '../../../../modules/stockTransitReport/admin/mpdf/vendor/autoload.php';

    $mpdf = new \Mpdf\Mpdf(['margin_header'=>'0','margin_footer'=>'0','margin_top'=>'55','margin_bottom'=>'25',
    'mode' => 'utf-8','format' => 'A4','orientation' => 'L','margin_left'=>'8','margin_right'=>'8',
    'default_font' =>'Myriad Pro','default_font_size' =>9 ]);  

    $mpdf->SetTitle('SALES REPORT');
    $mpdf->SetSubject('SALES REPORT');

    $mpdf->SetDefaultBodyCSS('background', "url('../../../../modules/salesInvoice/admin/includes/letterHead.jpeg')");
    $mpdf->SetDefaultBodyCSS('background-image-resize',6);
    
    
                 
$htmlcontent = ' <h2 align="center"><u>COUNTER SALES REPORT</u></h2>
                    <h4 align="center">
                        FROM : '.$fromDate.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TO: '.$toDate.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    							
                        
        $htmlcontent .= '</h4><table style="border-collapse:collapse" width="100%" border="1">
                    <thead>';
                    if($privilageId==6)
                    {
                    $htmlcontent .= '
                     <tr>
                        <th align="center" width="5%" style="text-align: center !important;">#</th>
                        <th align="center" width="10%" style="text-align: center !important;">INVOICE NO</th>
                        <th align="center" width="10%" style="text-align: center !important;">INVOICE DATE</th>                       
                        <th align="center" width="15%" style="text-align: center !important;">CUSTOMER NAME</th>
                        <th align="center" width="10%" style="text-align: center !important;">AMOUNT</th>
                        <th align="center" width="10%" style="text-align: center !important;">DISCOUNT</th>
                        <th align="center" width="10%" style="text-align: center !important;">AMT.WITH DISC</th>
                        <th align="center" width="10%" style="text-align: center !important;">VAT AMT</th>
                        <th align="center" width="10%" style="text-align: center !important;">NET AMOUNT</th>
                        </tr>';
                    }
                    $htmlcontent .= '</thead>
                    <tbody>'.$data.'</tbody>
                    </table>';
    
    
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
    var tab_text="<table border='2px'><meta charset='UTF-8'><tr ><th colspan='9' align='center'>COUNTER SALES REPORT</th></tr><tr bgcolor=''>";
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


</script>

<style>
    .all   {
        font-size:12px !important;
    }
</style>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<div class="all">
<div class='col-sm-12 col-md-12 col-lg-12'>
<div class="panel ">
<div class="panel-body" style="padding-top:0px !important;">
<div class="row">
	<div class='col-sm-4 col-md-4 col-lg-4' style="background: #0293bf;">
			<B STYLE="font-size: 20px;color: #fff;">COUNTER SALES REPORT</B>
	</div>	
<div class='col-sm-2 col-md-2 col-lg-2'>&nbsp;</div>

<div class='col-sm-6 col-md-6 col-lg-6'>
	<form action="" method="POST"> 
		<table width="100%" id="tableSearch">
			<tr>
			<form action="" method="POST" target="_blank" style="float: right;"> 						
						  
				<td width="17%">
						<input type='text' name='fromDate' id='fromDate' placeholder="FROMDATE" 
						class='input-sm datepicker' required style="width:95%" autocomplete="OFF">
				</td>
				<td width="17%">
						<input type='text' name='toDate' id='toDate' placeholder="TO DATE" 
						class='input-sm datepicker' required style="width:95%" autocomplete="OFF">
				</td>
				
				<td width="2%">
						<button type="submit" id="Search" style="width: 70%;"  name="Search"  class="btn btn-primary btn-sm" title="search">
							<i class="fa fa-search"></i> 
						</button>
						
				</td>
				</form>
				
				<form action="" method="POST" target="_blank"> 
				<td width="2%">
					<input type='hidden' name='fromDatePDF' value="<?php if(isset($_POST['Search'])){ echo $_POST['fromDate'];}?>">
					<input type='hidden' name='toDatePDF' value="<?php if(isset($_POST['Search'])){ echo $_POST['toDate'];}?>">
					<input type='hidden' name='wholesaleOrRetailPdf' value="<?php //if(isset($_POST['Search'])){ echo $_POST['wholesaleOrRetail'];}?>">
					<button type="submit" style="width: 70%;" id="printPDF" name="printPDF" class="btn btn-info btn-sm"><i class="fa fa-print"></i></button>
					
				</td>
				<td width="2%">
						 <button type="button" style="width: 70%;" id="btnExport" class="btn btn-danger btn-sm" onclick="fnExcelReport();"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
				</td>
				</form> 
			</tr>
		</table>
			</div>
		</div>
		<br>
		
        <table border="1" style="border-collapse:collapse;width: 99%;
        margin-left: 7px;margin-right: 7px;" id="resultTable2">
                <thead style="background-color:#d0e8d2">
                
                <?php $privilageId       	 	=   	$_COOKIE['privillegeId'];
                if($privilageId==6)
                    {
                        ?>							
                        
                        <td width="30%" colspan="9">
                            <center><b> FROM :&nbsp;&nbsp;<?php echo $fromDate;?>&nbsp;&nbsp; TO :&nbsp;&nbsp;&nbsp;<?php echo $toDate;?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php //if($wholesaleOrRetail==1 || $wholesaleOrRetail==2){ echo 'Type : '.$wholesaleOrRetailName;}?>
                            </b></center><span id="invoiceNoModal"></span></td>
                        
                    </tr>
                        <tr>
                        <th width="5%" style="text-align: center !important;">#</th>
                        <th width="10%" style="text-align: center !important;">INVOICE NO</th>
                        <th width="10%" style="text-align: center !important;">INVOICE DATE</th>                       
                        <th width="15%" style="text-align: center !important;">CUSTOMER NAME</th>
                        <th width="10%" style="text-align: center !important;">AMOUNT</th>
                        <th width="10%" style="text-align: center !important;">DISCOUNT</th>
                        <th width="10%" style="text-align: center !important;">AMT.WITH DISC</th>
                        <!-- <th width="10%" style="text-align: center !important;">VAT%</th> -->
                        <th width="10%" style="text-align: center !important;">VAT AMT</th>
                        <th width="10%" style="text-align: center !important;">NET AMOUNT</th>
                    <?php } ?>
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



