<?php   
	/* DEVELOPED BY AK 12/12/2019 */
	
/*require_once("../../../../modules/invoiceSearchByInvoiceNo/admin/controllers/InvoiceSearchByInvoiceNo.php");
	$objInvoiceSearchByInvoiceNo = new InvoiceSearchByInvoiceNo();
	
	if(isset($_POST['Search'])){
		$invoiceId=$_POST['invoiceId'];
		$details		=	$objInvoiceSearchByInvoiceNo->getDetailsInvoiceNo($invoiceId);
		$tbody			=	$details['tbody'];
		$thead			=	$details['thead'];
		$tableForExcel	=	$details['tableForExcel'];
	}
	*/

	/* Get branches GG(28-06-2024)*/

	$branches=$branchesSelectBox='';
	require_once('../../../../modules/itemMaster/admin/controller/ItemMasterController.php');
	$objItemMasterController=new ItemMasterController();
	$branchIdSelected       	 	=   	$_COOKIE['branchId'];
	$branches 				= $objItemMasterController->getBranch();	
	if($_COOKIE['privillegeId']==1 || $_COOKIE['privillegeId']==12){
	$branchesSelectBox = "<select class='input-sm' name='branchId' id='branchId' >
						<option>
							-BRANCH-
						</option>
						'".$branches."'
					</select>";
	}
	else{
		$branchesSelectBox="<select class='input-sm' name='branchId' id='branchId' style='display:none'>
						<option value='".$branchIdSelected."'>'".$branchIdSelected."'
						</option>
					</select>";
	}
	/* end */

	if(ISSET($_GET['qrCodeInvoiceId'])){
	$filepath='../../../../modules/salesInvoice/admin/includes/qrCodeGenerator/temp/'.$_GET['qrCodeInvoiceId'].'.png';
	$exits = file_exists($filepath);
	if($exits==1){
			unlink($filepath);
	}
}


require_once("../../../../modules/counterSalesInvoice/admin/controllers/c_salesInvoice.php");
$objCSalesInvoice		= 	new C_salesInvoice();
require_once("../../../../modules/invoiceSearchByInvoiceNo/admin/controllers/InvoiceSearchByInvoiceNo.php");
	$objInvoiceSearchByInvoiceNo = new InvoiceSearchByInvoiceNo();
$tbody=$thead=null;
$privilageId       	 	=   	$_COOKIE['privillegeId'];
if(isset($_POST['Search'])){
	//echo 'invoiceId:'.$_POST['invoiceId'];
		$invoiceId		=	$_POST['invoiceId'];
		$invoiceData	=	$objCSalesInvoice->getInvoiceDetails($invoiceId);
		//$invoiceData	=	$objInvoiceSearchByInvoiceNo->getInvoiceDetails($invoiceId);
		$tbody			=	$invoiceData['tbody'];
		$thead			=	$invoiceData['thead'];
		$detailsForExcel		=	$objInvoiceSearchByInvoiceNo->getDetailsInvoiceNo($invoiceId);
		$tbodyExcel		=	$detailsForExcel['tbodyExcel'];
		$theadExcel		=	$detailsForExcel['theadExcel'];
	}
	
?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="../../../../modules/deliveryNode/admin/ajax/sweetAlert.js"></script>
<script type="text/javascript">
function printdata(){
	var invoiceId=$('#invoiceIdToSend').val();
	if(invoiceId!=''){
	document.location.href = 'welcome.php?page=countersalesInvoicePrint&invoiceId='+invoiceId+'&referanceNo=2';
	}else{
			swal({text:"please Search And than Try",icon: "error",timer: 2500});
	}
}

function printdatas(){
	var invoiceId=$('#invoiceIdToSend').val();
	var normalPrint = document.querySelector('input[name = printType]:checked').value;
	
	if(invoiceId!=''){
		if(normalPrint==1){
			document.location.href = 'welcome.php?page=countersalesInvoicePrint&invoiceId='+invoiceId+'&referanceNo=2';
		}
	
else if(normalPrint==2){
	document.location.href = 'welcome.php?page=counterSalesInvoiceThermalPrint&invoiceId='+invoiceId+'&referanceNo=2';
}else if(normalPrint==3){
	document.location.href = 'welcome.php?page=dotmertocprint&invoiceId='+invoiceId+'&referanceNo=2';
}
	
	}else{
			swal({text:"please Search And than Try",icon: "error",timer: 2500});
	}
}
$(function(){
$("#invoiceNo").autocomplete({
   source: function(request, response) {
     $.getJSON("../../../../modules/invoiceSearchByInvoiceNo/admin/ajax/ajaxForInvoiceNo.php", {
		 term  : $('#invoiceNo').val(),
		 branchId :$('#branchId').val()}, 
              response);
  },
      minLength: 0,
	  select: function( event, ui ) {
		 $('#invoiceId').val( ui.item.key);
		 $('#invoiceNo').val(ui.item.value);
		 return false;
      }  ,
	  change: function (event, ui) {
             if (ui.item == null) 
			 {
			   $('#invoiceId').val('');
			   $('#invoiceNo').val('');
		    
			 }
		}
   });
});
</script>
<script>

function fnExcelReport()
{	
    var tab_text="<table border='0'><meta charset='UTF-8'><tr bgcolor=''>";
    var textRange; var j=0;
    tab1 = document.getElementById('headerContent'); // id of table
	
    for(j = 0 ; j < tab1.rows.length ; j++) 
    {     
        tab_text=tab_text+tab1.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table><table border='0'><meta charset='UTF-8'><tr bgcolor=''>";
	   var k=0;
		tab2 = document.getElementById('theadContent'); // id of table
		
		for(i= 0 ; k< tab2.rows.length ; k++) 
		{     
			tab_text=tab_text+tab2.rows[k].innerHTML+"</tr>";
			//tab_text=tab_text+"</tr>";
		}
   tab_text=tab_text+"</table><table border='2px'><meta charset='UTF-8'><tr bgcolor=''>";
	
	
	var i=0;
    tab = document.getElementById('resultTable'); // id of table
	
    for(i= 0 ; i< tab.rows.length ; i++) 
    {     
        tab_text=tab_text+tab.rows[i].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }
	
	tab_text=tab_text+"</table><table border='0'><meta charset='UTF-8'><tr bgcolor=''>";
	
	
	var m=0;
    tab4 = document.getElementById('sdContent'); // id of table
	
    for(m= 0 ; m< tab4.rows.length ; m++) 
    {     
        tab_text=tab_text+tab4.rows[m].innerHTML+"</tr>";
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
.hideDiv
{
	display:none !important ;
}
</style>
<style >.ui-autocomplete { height: 200px; overflow-y: scroll; overflow-x: hidden;}</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<!--<div class='col-sm-12 col-md-12 col-lg-12'>
<div class='row'>
<div class="col-sm-5 col-md-5 col-lg-5">
	
		<div class="box box-solid box-primary" style="background-color:#FFF">
				<div class="box-header"><h4 class="box-title">Search Invoice</h4></div>
				<div class="box-body">
				<form action="" method="POST"> 
					<div class="form-inline">
						<label>Invoice No</label><strong class="forMandatory" style="color:red">*</strong>
						<input type='text' name='invoiceNo' id='invoiceNo' 
						class='input-sm' required>
						<input type='hidden' name='invoiceId' id='invoiceId' required />
						<button type="submit" id="Search"  name="Search"  class="btn btn-primary" title="search">
							<i class="fa fa-search"></i> 
						</button>
						<button type="button" id="printPageButton"
						onClick="printdata();"
							class="btn btn-success" title="print">
							<i class="fa fa-print" aria-hidden="true"></i>
						</button>
						 <button type="button" id="btnExport" class="btn btn-danger" onclick="fnExcelReport();"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
					</div>
					</form>  
				</div>
			</div>
		</div>
	</div>
</div>-->
<div class="all">
<div class="col-sm-12 col-md-12 col-lg-12">
<div class="panel ">
<div class="panel-body" style="padding-top:0px !important;">
<div class="row">
	<div class="col-sm-3 col-md-3 col-lg-3" style="background: #0293bf;">
			<b style="font-size: 18px;color: #fff;">SEARCH INVOICES</b>
	</div>	



<div class="col-sm-9 col-md-9 col-lg-9">
	<form action="" method="POST"> 
		<table width="100%" id="tableSearch">
			<tbody><form action="" method="POST" > 
			<tr>
			<td width="25%">&nbsp;</td>
				<td width="5%">&nbsp;</td>

				<td width="13%">
				<?php echo $branchesSelectBox; ?>

				</td>
				<td width="2%">&nbsp;</td>
				<td width="15%">
				
				<input type='text' name='invoiceNo' id='invoiceNo' 
						class='input-sm' placeholder="INVOICE NO" required>
						<input type='hidden' name='invoiceId' id='invoiceId' required />
				</td>
				
				<td width="4%">
						<button type="submit" id="Search" name="Search" class="btn btn-primary btn-sm" title="search">
							<i class="fa fa-search"></i> 
						</button>
						
				</td>
				
				<?php if($privilageId!=2 && $privilageId!=6 ){ ?> 
				<td width="4%">
					<button type="button" id="printPDF" name="printPDF" onclick="printdata();" class="btn btn-info btn-sm"><i class="fa fa-print"></i></button>
					
				</td>
				<?php } ?>
				<td width="4%">
						 <button type="button" id="btnExport" class="btn btn-danger btn-sm" onclick="fnExcelReport('','');"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button>
				</td>
				
			</tr>
			<br/> <?php
									if($privilageId==2 || $privilageId==6)
									{
									?>
			<tr><td width="25%">&nbsp;</td>
				<td  width="15%">&nbsp;</td>
				<td  width="15%">&nbsp;</td>
				<td  width="45%">
						
									<input type="radio"  id="normalPrint" name="printType" value="1"  >
									<label for="male">Print</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio" id="normalPrints" name="printType" value="2" checked>
									<label for="male">Thermal Print</label>&nbsp;&nbsp;&nbsp;&nbsp;
									<!-- <input type="radio" id="dotMatrix" name="printType" value="3">
									<label for="male">Dot Matrix Print</label> -->
									
				</td>
				<td width="4%">
					<button type="button" id="printPDF" name="printPDF" style="margin-top: 5px;" onclick="printdatas();" class="btn btn-info btn-sm"><i class="fa fa-print"></i></button>
					
				</td>
				</tr><?php
									}
									?></form> 
		</tbody></table>
			</form></div>
		</div>
		<br>
		
			<div class="col-lg-12 col-md-12 col-sm-12" id="printDiv" style="overflow-y: auto;height: 405px;">
				<input type="hidden" name="invoiceIdToSend" id="invoiceIdToSend" value="<?php echo $invoiceId; ?>"  />
				<?php echo $thead; ?>
				<?php echo $tbody; ?>
			</div>
				

	
</div>
</div>	
</div>
</div>


<?php
if(isset($thead)){ ?>
<!--<div class='row'>
<div class='col-sm-12 col-md-12 col-lg-12' style="background: white;">
	<input type="hidden" name="invoiceIdToSend" id="invoiceIdToSend" value="<?php echo $invoiceId; ?>"  />
	<?php //echo $thead; ?>
	<?php //echo $tbody; ?>
</div>		
</div>-->
<div style="display:none;">
<?php echo $theadExcel; ?>
	<?php echo $tbodyExcel; ?>
</div>		
<?php } ?>
