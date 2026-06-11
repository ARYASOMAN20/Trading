
<?php

require_once("../../../../modules/invoiceSearchByDate/admin/controllers/Invoicesearchbydate.php");
$objInvoiceSearch = new Invoicesearchbydate();
//require_once("../../../../modules/JournelSearch/admin/models/Journel_search_model.php");
//$objhModel = new Journalvoucher_model();
$resInvoiceDetailsView = "";
if(isset($_POST['details'])){
 $invoiceId=$_POST['invoiceId'];
 $invoiceNo=$_POST['invoiceNo'];
 $invoiceDate=$_POST['invoiceDate'];
 $customerName=$_POST['customerName'];
 $resInvoiceDetailsView =$objInvoiceSearch->getInvoiceDetailsView($invoiceId);


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



	
    <div class="section1">
    	<center><strong style="font-size: 14px;">INVOICE</strong></center>
    </div>
	
	 <div class="col-sm-6 col-md-6 col-lg-6">
		<div class="panel-heading"><h3 class="panel-title">Customer Name : <?php echo  $customerName; ?> &nbsp;&nbsp; Invoice No : <?php echo  $invoiceNo; ?> &nbsp;&nbsp; Invoice Date : <?php echo  $invoiceDate; ?> &nbsp;&nbsp;&nbsp;</h3> </div>

	 <div class="box-body">
	<table width="100%" border="1" cellpadding="0" cellspacing="0" class="table table-responsive table-bordered table-condensed footable">
               			<thead>
                            <tr>
                                <th>SI.N0</th>
                                <th>Model Code</th>
                                <th>Model Name</th>
                                <th>Unit</th>
                                <th>quantity</th>
                                <th>Unit price</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                    	<tbody>
						  <?php echo $resInvoiceDetailsView; ?>
                     	</tbody>
					</table>
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
    
	
	
	
	
	