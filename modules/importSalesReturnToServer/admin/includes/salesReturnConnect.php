<?php
//new
//session_start();
//new ends

$con = mysqli_connect("localhost", "root", "", "vansale") or die("cannot connect");

	//global $con;
	$salesReturnTable='';
	if(isset($_POST['Search']))
	{
		$fromDate	=	$_POST['fromDate'];
		$toDate		=	$_POST['toDate']; 
		$fromDate	=	date("Y-m-d", strtotime($fromDate));
		$toDate		=	date("Y-m-d", strtotime($toDate));

		/*$searchQuery = "SELECT INV.invoiceId,INV.invoiceNo,INV.invoiceDate,INV.totalAmount,INV.totalAmountAfterDiscount,INV.discountAmount,INV.vatAmount,INV.totalAmountWithVat,INV.transactionType,regularCustomer.customerName,damagedGoodsAmount
							FROM invoice INV 
							INNER JOIN regularCustomer  ON regularCustomer.regularCustomerId=INV.regularCustomerId 
							
							WHERE INV.invoiceDate BETWEEN'".$fromDate."' AND '".$toDate."'
							 AND INV.status='1' AND INV.branchId='5' and connectedStatus=0
                             
							ORDER BY INV.invoiceId";*/

		$searchQuery = "SELECT SR.salesReturnItemWiseId,SR.salesReturnNo,SR.salesReturnDate,SR.totalAmount,SR.totalAfterDiscount,SR.discountInAmount,SR.vatAmount,SR.netAmount,regularCustomer.customerName,SR.damagedGoodsAmount
							FROM salesreturncountersale SR 
							INNER JOIN regularCustomer  ON regularCustomer.regularCustomerId=SR.regularCustomerId 
							
							WHERE SR.salesReturnDate BETWEEN'".$fromDate."' AND '".$toDate."'
							 AND SR.status='1' AND SR.branchId='5' and connectedStatus=0
                             
							ORDER BY SR.salesReturnItemWiseId";
	
	
	$result  = mysqli_query($con,$searchQuery);
	$i=1;
	while ($dataFetchDetails = mysqli_fetch_array($result))
				{
					$salesReturnNo=$dataFetchDetails['salesReturnNo'];
					$salesReturnItemWiseId= $dataFetchDetails['salesReturnItemWiseId'];
					$name=$dataFetchDetails['customerName'];
					$invoiceDate=$dataFetchDetails['salesReturnDate'];
					$invoiceDate=date("d-m-Y", strtotime($invoiceDate));
					$totalAmount=$dataFetchDetails['totalAmount'];
					$totalAmountAfterDiscount=$dataFetchDetails['totalAfterDiscount'];
					$discountAmount=$dataFetchDetails['discountInAmount'];
					$vatAmount=$dataFetchDetails['vatAmount'];
					$totalAmountWithVat=$dataFetchDetails['netAmount'];
					// $type=$dataFetchDetails['transactionType'];
					// if($type==1){
					// 	$typeOfTransaction='CASH';
					// }else if($type==2){
					// 	$typeOfTransaction='CREDIT';
					// }else if($type=='NULL'){
					// 		$typeOfTransaction='ALL';
					// }else{
					// 	$typeOfTransaction='';
					// }
					$damagedGoodsAmount = $dataFetchDetails['damagedGoodsAmount'];
					/*$amountPaid = $objGeneralSalesReportClass->getPaidAmountByInvoiceId($invoiceId);
					//$amountPaid=$dataFetchDetails['amountPaid'];
					$balanceAmount=$billTotalWithVat-$amountPaid;
					if($amountPaid==null or $amountPaid==''){
						$amountPaid=0;
					}
					if($balanceAmount==null or $balanceAmount==''){
						$balanceAmount=0;
					}
					if($billTotalWithVat==null or $billTotalWithVat==''){
						$billTotalWithVat=0;
					}*/
				
				$salesReturnTable.='<tr>
						<td width="3%" style="text-align: left !important;">'.$i.'</td>
						<td width="10%" style="text-align: center !important;">'.$salesReturnNo.'</td>
						<td width="12%" style="text-align: center !important;">'.$name.'</td>
							<td width="10%" style="text-align: center !important;">'.$invoiceDate.'</td>
						
						<td width="8%" style="text-align: right !important;">'.number_format($totalAmount,2,".","").' </td>
						<td width="9%" style="text-align: right !important;">'.number_format($discountAmount,2,".","").' </td>
						<td width="10%" style="text-align: right !important;">'.number_format($totalAmountAfterDiscount,2,".","").' </td>
						 

						<td width="6%" style="text-align: right !important;">'.number_format($vatAmount,2,".","").' </td>
                        <td width="7%" style="text-align: right !important;">'.number_format($totalAmountWithVat,2,".","").' </td>
						<td width="4%" style="text-align: center !important;">   
                                        <input type="checkbox" name="checkbox" value="'.$salesReturnItemWiseId.'" id="checkbox'.$i.'" class="invoiceCheckbox">   
                                    </td>
						
					</tr>';
					$i++;
				
				
				}
					
	}
//$invoiceId = 77;
// $invoiceId = $_POST['invoiceId'];

?>


<style>

.btn-success {
	padding: 2px 7px !important;
    background-color: #848090 !important;
}

.submitBtn {
	background-color: #848090 !important;
    padding: 3px 8px !important;
}

</style>

      
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<div class="all">
<div class='col-sm-12 col-md-12 col-lg-12'>
<div class="panel ">
<div class="panel-body" style="padding-top:0px !important;">
<div class="row">
	

<?php
if (isset($_COOKIE['connectStatus'])) {
    $message = $_COOKIE['connectStatus'];
    echo '
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      <strong>' . htmlspecialchars($message) . '</strong>
    </div>';
    //unset($_SESSION['message']); // Optionally unset the message after displaying it
	setcookie('connectStatus', '', time() - 120, '/'); 
}
?>

<div class='col-sm-3 col-md-3 col-lg-3' style="background: #0293bf;height:6%;">
			<B STYLE="font-size: 18px;color: #fff;">SALES RETURN IMPORT</B>
	</div>	
<div class='col-sm-8 col-md-8 col-lg-8' style="margin-top: 5px;">
	<form action="" method="POST">
		
		
		 <table width="40%" id="tableSearch" style="float:right">
			<tr>
			<form action="" method="POST"  > 
			
				<td width="15%">
						<input type='text' name='fromDate' id='fromDate' placeholder="FROM DATE" 
						class='input-sm datepicker' required style="width:99%" autocomplete="OFF">
				</td>
				<td width="15%">
						<input type='text' name='toDate' id='toDate' placeholder="TO DATE" 
						class='input-sm datepicker' required style="width:97%" autocomplete="OFF">
				</td>
				
				<td width="4%">
						<button type="submit" id="Search"  name="Search"  class=" btn btn-success" title="search">
							<i class="fa fa-search">search</i> 
						</button>
						
				</td>
				
				
			
				</form> 
			</tr>
		</table>
			</div> 
		

		<br><form action="" method="POST"> 

			<div class="col-lg-12 col-md-12 col-sm-12" id="printDiv" style="overflow-y: auto;
    height: 405px;">
			<table border="1" style="border-collapse:collapse;width:100%; margin-top:10px;" id="resultFirstTable"
					<thead style="background-color:#d0e8d2">
					
						<tr>
							<th width="100%" COLSPAN="12" style="text-align: center !important;">SALES RETURN DETAILS</th>
						</tr>
						<tr>
							<th width="3%" style="text-align: left !important;font-size: 13px;">#</th>
							<th width="10%" style="text-align: center !important;font-size: 13px;">Invoice No</th>
							<th width="12%" style="text-align: center !important;font-size: 13px;">CustomerName</th>
							<th width="10%" style="text-align: center !important;font-size: 13px;">Invoice Date</th>
							<!-- <th width="5%" style="text-align: center !important;font-size: 13px;">Type </th> -->
							<th width="8%" style="text-align: center !important;font-size: 13px;">Bill Amt</th>
							<th width="9%" style="text-align: center !important;font-size: 13px;">Discount</th>
							<th width="10%" style="text-align: center !important;font-size: 13px;">Amt With Dis</th>
							
							<th width="6%" style="text-align: center !important;font-size: 13px;">Vat Amt</th>
							
							<th width="7%" style="text-align: center !important;font-size: 13px;">Net Amt</th>
								<th><input type='checkbox' id='select_all' onclick="selectallInvoice()"/>Select
								
							</th>
						</tr>
					</thead>
					<tbody>
						<?php echo $salesReturnTable; ?>
					</tbody>
					</table>
					<br/>
						<button type="button" name="submitBalancePayment1" id="submitBalancePayment"  style="margin-left: 45%;"
                        		 onclick="submitForm();" class="btn btn-success">
							<i class="fa fa-save"></i> IMPORT
                      	</button>
				</div>
				</form>

	
</div>
</div>	
</div>
</div>

      <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"> 
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
	function submitForm() {
		var selectedInvoiceIds	=	[];
		// Get all checkboxes with the class "invoiceCheckbox"
		var checkboxes = document.getElementsByClassName('invoiceCheckbox');

		// Iterate through checkboxes and check if they are selected
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].checked) {
			  
				selectedInvoiceIds.push(checkboxes[i].value);
			}
		}
		// Do something with the selectedInvoiceIds
		//	console.log(selectedInvoiceIds);	
		 var url = "../../../../modules/importSalesReturnToServer/admin/includes/conSalesReturnToServer.php?selectedInvoiceIds=" + selectedInvoiceIds + "&referenceval=2";
			window.location.href = url;
			
		//window.location.href = "welcome.php?page=conectLocalToServer&selectedInvoiceIds=" + selectedInvoiceIds + "&referenceval=2";

			
		
	}
	
	function selectallInvoice(){
	    
	    
	    var checkboxes = document.getElementsByClassName('invoiceCheckbox');
var select_all =  document.getElementById("select_all");

if (select_all.checked) {
    // Iterate through checkboxes and check if they are selected
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = true;
    }
} else {
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
    }
}

//submitForm();
	}
	$(document).ready(function() {
   
      $(".datepicker").datepicker({
        dateFormat: "mm/dd/yy",
        
      });
    });
	
	</script>