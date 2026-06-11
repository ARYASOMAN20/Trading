
<?php 

require_once("../../../../modules/invoiceSearchByDate/admin/controllers/Invoicesearchbydate.php");
$objInvoiceSearch = new Invoicesearchbydate();
//require_once("../../../../modules/JournelSearch/admin/models/Journel_search_model.php");
//$objhModel = new Journalvoucher_model();
$resInvoiceDetails = "";
 $fromDate='';
 $toDate='';
if(isset($_POST['invoiceSearchBTN'])){
	
	    $fromDate=$_POST['fromDate'];
		$fromDateConv = strtr($fromDate, '/', '-');
		$fromDate     = date('Y-m-d', strtotime($fromDateConv));

		$toDate=$_POST['toDate'];
		$fromDateConv = strtr($toDate, '/', '-');
		$toDate     = date('Y-m-d', strtotime($fromDateConv));

	    $resInvoiceDetails =$objInvoiceSearch->getInvoiceDetails($fromDate,$toDate);
	
	}
	
?>
 

<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">           <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script><script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.5.1/jQuery.print.js"></script> <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script><link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>   

<script>
	function printPage(id)
	{
		
		var printContents = document.getElementById(id).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	
	 $('#th').hide();
	
	 $("#my_table td:nth-child(10)").hide();
	 $('#td').hide();
	  //$('#details').hide();
	window.print();
	document.body.innerHTML = originalContents;
		
	}
	
	function fnExcelReport(fromdate,todate)
{  
document.getElementById('th').innerHTML = ''; 

    var tab_text="<table border='2px'><tr><td align='center' colspan='10'>INVOICE DETAILS</td></tr><tr><td align='center' colspan='10'>From Date:"+fromdate+"</td></tr><tr><td align='center' colspan='10'>To Date:"+todate+"</td></tr><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('my_table'); // id of table

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
	document.getElementById('th').innerHTML = 'Details'; 
	
    return (sa);
}
</script>
 
<style type="text/css">

    @media print {
		 #details { display:none; }
		 table td:last-child {display:none}
		 table th:last-child {display:none}
		table tr.highlighted td {
			background-color: rgba(247, 202, 24, 0.3) !important;
		}
	}
</style>
<script>
$('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
	autoclose: true
});
</script>
<style type="text/css">

form{margin-bottom: 5px !important;}
form-group{margin-bottom: 5px !important;}
.invoiceWrapper{width: 100%; float: left;
	/*background:url(<?php //echo asset_url();?>img/mab_invoice3a.jpg) left top no-repeat; background-size: auto !important;*/}
.section0Print {width: 100%; height: 60px; float: left; padding: 10px 0;}

.section0 {width: 100%; height: 92px; float: left;}
.section1 {width: 100%; height: 20px; float: left;}
.section2 {width: 100%; height: 50px; float: left;}
.section3 {width: 100%; height: 26px; float: left; margin-top: 5px; border: 1px solid #003;}
.section4 {width: 100%; height: 165px; float: left; margin-top: 7px;}
.section5 {width: 100%; height: auto; min-height:400px; float: left;}
.section6 {width: 100%; height: 125px; float: left;}
.section7 {width: 100%; height: 20px; float: left;}
.section8 {width: 100%; height: 45px; float: left;}
.section9 {width: 100%; height: 65px; float: left; margin-top: 10px;}
.section10{width: 100%; height: 120px; float: left;}
table tr td{font-family:Arial, Helvetica, sans-serif; font-size: 12px !important;}
table tr.listItemTr {font-size: 10px !important;}
table tr.listItemTr td {font-size: 10px !important;}
table tr.listItemTr td strong{font-size: 10px !important;}
</style>   
<div class="panel-heading" style="background: #efefef; border-bottom: 1px dashed #00F;">
                            <h3 class="panel-title" style="text-align-left; font-size:20px" >INVOICE SEARCH BY DATE</h3>
                        </div>
<div class="row">
	<form action="" method="POST"> 
	<div class="col-sm-3 col-md-3 col-lg-3">
        <div class="box box-solid box-primary" style="background-color:#FFF">
            <div class="box-header"><h4 class="box-title"></h4></div>
            <div class="box-body">
                <div class="form-group">
                
			 <label>From Date</label><strong class="forMandatory">*</strong>:
        	<input type="text" name="fromDate" id="fromDate" required="required" autocomplete="off" class="form-control input-sm datepicker" placeholder="From Date">
       </div>
        <div class="form-group">
        	<label>To Date</label> <strong class="forMandatory">*</strong>:
            <input type="text" name="toDate" id="toDate" required="required" autocomplete="off" class="form-control input-sm datepicker" placeholder="To Date">
       </div>
                <div class="form-group" style="margin-top: 18px;">
                    <button type="submit" id="invoiceSearchBTN"  name="invoiceSearchBTN"  class="btn btn-primary" title="search">
                        <i class="fa fa-search"></i> 
                    </button>
                    <button type="button" id="printPageButton" name="printPageButton" onClick="printPage('block1');"
                         class="btn btn-success" title="print">
                        <i class="fa fa-print" aria-hidden="true"></i>
                    </button>	
					<button type="button" id="excelPageButton" name="excelPageButton" onClick="fnExcelReport('<?php  echo $fromDate;?>','<?php  echo $fromDate;?>');"		
					class="btn btn-danger" title="excel">		
					<i class="fa fa-file-excel-o" aria-hidden="true"></i>
					</button>
                </div>
            </div>
        </div>
	</div>
	</form>



	<?php if(isset($_POST['invoiceSearchBTN'])){
		// if($journelTables->num_rows()>0){
 	?>

    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="invoiceWrapper" id="block1">

            <div class="box box-solid box-success" >
            <div class="panel panel-info filterable">
                <div class="panel-heading">
             <strong>   <h3 class="panel-title" style="font-size:18px">INVOICE DETAILS   &nbsp;&nbsp;&nbsp; &nbsp; Date : <?php  echo $_POST['fromDate']." to ".$_POST['toDate'];?></h3></strong>
               
                    <!--<h4 class="box-title">
                        Date : <?php // echo $_POST['fromDate']." to ".$_POST['toDate'];?>
                    </h4>-->
                </div>
               
                
                    <table id="my_table"  width="100%" border="1" cellpadding="0" cellspacing="0"
                                class="table table-condensed table-responsive table-bordered" >
                        <thead>
                            <tr>
                               <th width="4%" style="text-align: left !important;">Sl.No</th>
                               <th width="12%" style="text-align: left !important;">Invoice No</th>
                               <th width="14%" style="text-align: left !important;">Invoice Date</th>
                               <th width="13%" style="text-align: left !important;">Customer Name</th>
                               <th width="15%" style="text-align: left !important;">Total Without Vat</th>
                               <th width="10%" style="text-align: left !important;">Vat Amount</th>
                               <th width="8%" style="text-align: left !important;">Discount</th>
                               <th width="14%" style="text-align: left !important;">Advance Amount</th>
                               <th width="24%" style="text-align: left !important;">Total With Vat</th>
                                <th id="th" width="3%">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $resInvoiceDetails; ?>
                        </tbody>
                        
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
	<?php /*?><?php }else { ?> <span style="color:red">No Data!!!!</span><?php } ?><?php */?>
	<?php }?>
</div>

<!--
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script type="text/javascript">
	$(function() {
		$('.footable').footable();
	});
</script>
-->

    
