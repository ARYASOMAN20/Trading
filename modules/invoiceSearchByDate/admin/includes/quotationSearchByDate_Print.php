
<?php

require_once("../../../../modules/quotationSearchByDate/admin/controllers/quotationSearchByController.php");
$objquotationSearchByController = new quotationSearchByController();

if(isset($_POST['details'])){
 $quotationId=$_POST['quotationId'];
 $customerName=$_POST['customerName'];
 $quotationNo=$_POST['quotationNo'];
 $quotationDate=$_POST['quotationDate'];
 $resulttQuotaionDetailsView =$objquotationSearchByController->getQuotaionDetailsView($quotationId);
}
?>



<script>
	function printPage(id)
	{
		var html="<html>";
		html+= document.getElementById(id).innerHTML;
		html+="</html>";
		var printWin = window.open();
		printWin.document.write(html);
		printWin.document.close();
		printWin.focus();
		printWin.print();
		printWin.close();
	}
</script> 

<form method="POST" action="">


<div class="invoiceWrapper" id="block1">

<style type="text/css">
.invoiceWrapper{width: 70%; float: left;
	/*background:url(<?php //echo asset_url();?>img/mab_invoice3a.jpg) left top no-repeat; background-size: auto !important;*/}
.section0Print {width: 70%; height: 60px; float: left; padding: 10px 0;}
@media print{
	.section0Print {display:none !important;}
	.invoiceWrapper{width: 100%; float: left;  margin-top: -80px;
	 	/*background:url(<?php //echo asset_url();?>img/mab_invoice3a.jpg) left top no-repeat !important;
	 	background-size: cover !important;*/
	}
}
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

	
	 <div class="col-sm-12 col-md-12 col-lg-12" align="center" >
      <div class="panel panel-info filterable" >
        
    
		<div class="panel-heading"><h3 class="panel-title">QUOTATION DETAILS </br></br>Quotation No : <?php echo  $quotationNo; ?> &nbsp;&nbsp;&nbsp; Quotation Date : <?php echo  $quotationDate; ?> &nbsp;&nbsp;&nbsp; Customer Name : <?php echo  $customerName; ?>&nbsp;&nbsp; </h3> </div>

	 <div class="box-body">
	<table width="100%" border="1" cellpadding="0" cellspacing="0" class="table table-responsive table-bordered table-condensed">
               			<thead>
                            <tr>
                                <th style="text-align: left">SI.No</th>
                                <th style="text-align: left">Description</th>
                                <!--<th style="text-align: left">Model Name</th>-->
                                <th style="text-align: left">Unit</th>
                                <th style="text-align: left">quantity</th>
                                <th style="text-align: left">Unit price</th>
								<th style="text-align: left">Amount</th>
                            </tr>
                        </thead>
                    	<tbody>
						  <?php echo $resulttQuotaionDetailsView; ?>
						  
                     	</tbody>
			
            		</table>
	</div>
    </div>
    </div>
    </div>
    <div class="section0Print">
    <center>
        <button type="button" id="printPageButton" name="printPageButton" onClick="printPage('block1');"
        		class="btn btn-success">
            <i class="fa fa-print" aria-hidden="true"></i> Print
        </button>
    </center>
</div>
    </form>
    
	
	
	
	
	