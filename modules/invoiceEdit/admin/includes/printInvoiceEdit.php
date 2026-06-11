<?php
  	require_once("../../../../modules/deliveryNode/admin/controller/DeliveryNodeController.php");
	require_once("../../../../settings/path.php");
	$objPath          = new Path();
	$objDeliveryNodeController          = new DeliveryNodeController();
$tbody=$fetch_deliveryNoteHead=$deliveryNoteDate=$delNoteNo=$modeOfPayment=$poNo=null;
$quotation=$customerName=$customerNo=$vatNumber=$vesselName=$currencyName=null;
$fetch_deliveryNoteBody=null;
	 
if(isset($_GET['deliveryNodeId'])){
   	$deliveryNoteId=$_GET['deliveryNodeId'];
	$deliveryNoteHead=$objDeliveryNodeController->printDeliveryNoteHead($deliveryNoteId);
	$deliveryNoteBody=$objDeliveryNodeController->printDeliveryNoteBody($deliveryNoteId);
	$pageRefrrence=1;
	
	
	if($deliveryNoteHead!=null){
	while($fetch_deliveryNoteHead= mysqli_fetch_array($deliveryNoteHead)){
		$deliveryNoteDate	=	$fetch_deliveryNoteHead['deliveryNoteDate'];
		$delNoteNo			=	$fetch_deliveryNoteHead['delNoteNo'];
		$modeOfPayment		=	$fetch_deliveryNoteHead['modeOfPayment'];
		$poNo				=	$fetch_deliveryNoteHead['poNo'];
		$quotation			=	$fetch_deliveryNoteHead['quotation'];
		$customerName		=	$fetch_deliveryNoteHead['customerName'];
		$customerNo			=	$fetch_deliveryNoteHead['customerNo'];
		$vatNumber			=	$fetch_deliveryNoteHead['vatNumber'];
		$vesselName			=	$fetch_deliveryNoteHead['vesselName'];
		$currencyName		=	$fetch_deliveryNoteHead['currencyName'];
		}
	}
	
	
	$tbody .="<div class='brkPage'>
				<table width='100%' border='0' cellpadding='0' cellspacing='0'>
				<thead class='theader'>
					<tr>
						<th colspan='2'><span style='float:left'>Date :". $deliveryNoteDate."</span></th>
						<th colspan='6'><span style='margin-left:32%'>DELIVERY NOTE</span></th>
					</tr>
					<tr>
						<th ></th>
						<th colspan='7'><center>Customer Name- ".$customerName."</center></th>
					</tr>
					<tr>
						<th></th>
						<th colspan='7'><center>Vessel Name- ".$vesselName."</center></th>
					</tr>
					<tr>
						<th></th>
						<th colspan='7'><center>DEL NO:- ".$delNoteNo."<center></th>
					</tr>
				</thead>
				<thead class='theader'>
					<tr><th colspan='8'>&nbsp;</th></tr>
					<tr><th colspan='8'>&nbsp;</th></tr>
				</thead>
				<thead>
				 <tr>
					<th style='text-align:center;' width='5%'>#</th>
					<th style='text-align:center;' width='15%'>Item Code</th>
					<th style='text-align:center;' width='30%'>Item Name</th>
					<th style='text-align:center;' width='10%'>PackingSize</th>
					<th style='text-align:center;' width='5%'>Unit</th>
					<th style='text-align:center;' width='10%'>Qty</th>
					<th style='text-align:center;' class='notDisplay'>Price</th>
					<th style='text-align:center;' width='25%'>Remarks</th>
				 </tr>
				</thead><tbody>";
	
	
	if($deliveryNoteBody!=null){
	$k=1;
	$countOfTbody=mysqli_num_rows($deliveryNoteBody);
	if($countOfTbody%20!=0){
		$totalNoOfPages=(floor($countOfTbody/20))+1;
	}else{
	$totalNoOfPages=(floor($countOfTbody/20));
	}
	
	while($fetch_deliveryNoteBody= mysqli_fetch_array($deliveryNoteBody)){
	
	$tbody .= '<tr>
				<td align="center" width="5%">'.$fetch_deliveryNoteBody['sNo'].'</td>
				<td width="15%">'.$fetch_deliveryNoteBody['customerItemCode'].'</td>
				<td width="30%">'.$fetch_deliveryNoteBody['title'].'</td>
				<td align="center" width="10%">'.$fetch_deliveryNoteBody['packageSize'].'</td>
				<td align="center" width="10%">'.$fetch_deliveryNoteBody['unitName'].'</td>
				<td align="center" width="5%">'.$fetch_deliveryNoteBody['quantity'].'</td>
			<td align="center" class="notDisplay">'.$fetch_deliveryNoteBody['unitPrice'].'</td>
				<td width="25%">'.$fetch_deliveryNoteBody['remarks'].'</td>
				   </tr>';
				 
		if($fetch_deliveryNoteBody['sNo']%20==0){
			if($countOfTbody!=$fetch_deliveryNoteBody['sNo']){
					$tbody .="<tfoot class='tfooter'>
								<tr>
									<td  colspan='8'>&nbsp;</td>
								</tr>
								<tr>
									<td  colspan='8'>&nbsp;</td>
								</tr>
								<tr>
									<td  colspan='8'>&nbsp;</td>
								</tr>
								<tr>
									<td colspan='2'>CHANDLER SIGN</td>
									<td colspan='4'><center><h4>Page ".$k." 
									of ".$totalNoOfPages."</h4></center></td>
									<td colspan='2'>RECEIVER SIGN</td>
								</tr>
							</tfoot>
							</table>
							</div>
							<div class='brkPage'>
								<table width='100%' border='0' cellpadding='0' cellspacing='0'>
							<thead class='theader'>
					<tr>
						<th colspan='2'><span style='float:left'>Date :". $deliveryNoteDate."</span></th>
						<th colspan='6'><span style='margin-left:32%'>DELIVERY NOTE</span></th>
					</tr>
					<tr>
						<th></th>
						<th colspan='7'><center>Customer Name- ".$customerName."</center></th>
					</tr>
					<tr>
						<th></th>
						<th colspan='7'><center>Vessel Name- ".$vesselName."</center></th>
					</tr>
					<tr>
						<th ></th>
						<th colspan='7'><center>DEL NO:- ".$delNoteNo."</center></th>
					</tr>
				</thead>
				<thead class='theader'>
						<tr><th colspan='8'>&nbsp;</th></tr>
						<tr><th colspan='8'>&nbsp;</th></tr>
				</thead>
				<thead>
				 <tr>
					<th style='text-align:center;' width='5%'>#</th>
					<th style='text-align:center;' width='15%'>Item Code</th>
					<th style='text-align:center;' width='30%'>Item Name</th>
					<th style='text-align:center;' width='10%'>PackingSize</th>
					<th style='text-align:center;' width='5%'>Unit</th>
					<th style='text-align:center;' width='10%'>Qty</th>
					<th style='text-align:center;' class='notDisplay' >Price</th>
					<th style='text-align:center;' width='25%'>Remarks</th>
				 </tr>
				</thead><tbody>";
					$k++;
				}
			 }
		} 
	}
	
	$tbody .="<tfoot class='tfooter'>
					<tr>
						<td  colspan='8'>&nbsp;</td>
					</tr>
					<tr>
						<td  colspan='8'>&nbsp;</td>
					</tr>
					<tr>
						<td  colspan='8'>&nbsp;</td>
					</tr>
					<tr>
						<td colspan='2'>CHANDLER SIGN</td>
						<td colspan='4'><center><h4>Page ".$totalNoOfPages." of 
							".$totalNoOfPages."</h4></center></td>
						<td colspan='2'>RECEIVER SIGN</td>
					</tr>
				</tfoot>
			</table>
			</div>";
}



if(isset($_GET['delNoteId'])){
   	$deliveryNoteId=$_GET['delNoteId'];
	$deliveryNoteHead=$objDeliveryNodeController->printDeliveryNoteHead($deliveryNoteId);
	$deliveryNoteBody=$objDeliveryNodeController->printDeliveryNoteBody($deliveryNoteId);
	$pageRefrrence=2;
	
	
	if($deliveryNoteHead!=null){
	while($fetch_deliveryNoteHead= mysqli_fetch_array($deliveryNoteHead)){
		$deliveryNoteDate	=	$fetch_deliveryNoteHead['deliveryNoteDate'];
		$delNoteNo			=	$fetch_deliveryNoteHead['delNoteNo'];
		$modeOfPayment		=	$fetch_deliveryNoteHead['modeOfPayment'];
		$poNo				=	$fetch_deliveryNoteHead['poNo'];
		$quotation			=	$fetch_deliveryNoteHead['quotation'];
		$customerName		=	$fetch_deliveryNoteHead['customerName'];
		$customerNo			=	$fetch_deliveryNoteHead['customerNo'];
		$vatNumber			=	$fetch_deliveryNoteHead['vatNumber'];
		$vesselName			=	$fetch_deliveryNoteHead['vesselName'];
		$currencyName		=	$fetch_deliveryNoteHead['currencyName'];
		}
	}
	
	
	$tbody .="<div class='brkPage'>
				<table width='100%' border='0' cellpadding='0' cellspacing='0'>
				<thead class='theader'>
					<tr>
						<th colspan='2'><span style='float:left'>Date :". $deliveryNoteDate."</span></th>
						<th colspan='6'><span style='margin-left:32%'>DELIVERY NOTE</span></th>
					</tr>
					<tr>
						<th ></th>
						<th colspan='7'><center>Customer Name- ".$customerName."</center></th>
					</tr>
					<tr>
						<th></th>
						<th colspan='7'><center>Vessel Name- ".$vesselName."</center></th>
					</tr>
					<tr>
						<th></th>
						<th colspan='7'><center>DEL NO:- ".$delNoteNo."<center></th>
					</tr>
				</thead>
				<thead class='theader'>
						<tr><th colspan='8'>&nbsp;</th></tr>
						<tr><th colspan='8'>&nbsp;</th></tr>
				</thead>
				<thead>
				 <tr>
					<th style='text-align:center;' width='5%'>#</th>
					<th style='text-align:center;' width='15%'>Item Code</th>
					<th style='text-align:center;' width='30%'>Item Name</th>
					<th style='text-align:center;' width='10%'>PackingSize</th>
					<th style='text-align:center;' width='5%'>Unit</th>
					<th style='text-align:center;' width='10%'>Qty</th>
					<th style='text-align:center;' class='notDisplay'>Price</th>
					<th style='text-align:center;' width='25%'>Remarks</th>
				 </tr>
				</thead><tbody>";
	
	
	if($deliveryNoteBody!=null){
	$k=1;
	$countOfTbody=mysqli_num_rows($deliveryNoteBody);
	if($countOfTbody%20!=0){
		$totalNoOfPages=(floor($countOfTbody/20))+1;
	}else{
	$totalNoOfPages=(floor($countOfTbody/20));
	}
	
	while($fetch_deliveryNoteBody= mysqli_fetch_array($deliveryNoteBody)){
	
	$tbody .='<tr>
			<td align="center" width="5%">'.$fetch_deliveryNoteBody['sNo'].'</td>
			<td width="15%">'.$fetch_deliveryNoteBody['customerItemCode'].'</td>
			<td width="30%">'.$fetch_deliveryNoteBody['title'].'</td>
			<td align="center" width="10%">'.$fetch_deliveryNoteBody['packageSize'].'</td>
			<td align="center" width="10%">'.$fetch_deliveryNoteBody['unitName'].'</td>
			<td align="center" width="5%">'.$fetch_deliveryNoteBody['quantity'].'</td>
			<td align="center" class="notDisplay" >'.$fetch_deliveryNoteBody['unitPrice'].'</td>
			<td align="center" width="25%">'.$fetch_deliveryNoteBody['remarks'].'</td>
			</tr>';
				 
		if($fetch_deliveryNoteBody['sNo']%20==0){
			if($countOfTbody!=$fetch_deliveryNoteBody['sNo']){
					$tbody .="<tfoot class='tfooter'>
								<tr>
									<td  colspan='8'>&nbsp;</td>
								</tr>
								<tr>
									<td  colspan='8'>&nbsp;</td>
								</tr>
								<tr>
									<td  colspan='8'>&nbsp;</td>
								</tr>
								<tr>
									<td colspan='2'>CHANDLER SIGN</td>
									<td colspan='4'><center><h4>Page ".$k." 
									of ".$totalNoOfPages."</h4></center></td>
									<td colspan='2'>RECEIVER SIGN</td>
								</tr>
							</tfoot>
							</table>
							</div>
							<div class='brkPage'>
								<table width='100%' border='0' cellpadding='0' cellspacing='0'>
							<thead class='theader'>
					<tr>
						<th colspan='2'><span style='float:left'>Date :". $deliveryNoteDate."</span></th>
						<th colspan='6'><span style='margin-left:32%'>DELIVERY NOTE</span></th>
					</tr>
					<tr>
						<th></th>
						<th colspan='7'><center>Customer Name- ".$customerName."</center></th>
					</tr>
					<tr>
						<th></th>
						<th colspan='7'><center>Vessel Name- ".$vesselName."</center></th>
					</tr>
					<tr>
						<th ></th>
						<th colspan='7'><center>DEL NO:- ".$delNoteNo."</center></th>
					</tr>
				</thead>
				<thead class='theader'>
						<tr><th colspan='8'>&nbsp;</th></tr>
						<tr><th colspan='8'>&nbsp;</th></tr>
				</thead>
				<thead>
				 <tr>
					<th style='text-align:center;' width='5%'>#</th>
					<th style='text-align:center;' width='15%'>Item Code</th>
					<th style='text-align:center;' width='30%'>Item Name</th>
					<th style='text-align:center;' width='10%'>PackingSize</th>
					<th style='text-align:center;' width='5%'>Unit</th>
					<th style='text-align:center;' width='10%'>Qty</th>
					<th style='text-align:center;'  class='notDisplay' >Price</th>
					<th style='text-align:center;' width='25%'>Remarks</th>
				 </tr>
				</thead><tbody>";
					$k++;
				}
			 }
		} 
	}
	
	$tbody .="<tfoot class='tfooter'>
					<tr>
						<td  colspan='8'>&nbsp;</td>
					</tr>
					<tr>
						<td  colspan='8'>&nbsp;</td>
					</tr>
					<tr>
						<td  colspan='8'>&nbsp;</td>
					</tr>
					<tr>
						<td colspan='2'>CHANDLER SIGN</td>
						<td colspan='4'><center><h4>Page ".$totalNoOfPages." of 
							".$totalNoOfPages."</h4></center></td>
						<td colspan='2'>RECEIVER SIGN</td>
					</tr>
				</tfoot>
			</table>
			</div>";
} 

	

?>


<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
		window.print();
		setTimeout("closePrintView()", 3000);
    });
    function closePrintView() {
		var pageRefrrence=$('#pageRefrrence').val();
		if(pageRefrrence==1){
        document.location.href = 'welcome.php?page=deliveryNodeView';
		}if(pageRefrrence==4){        document.location.href = 'welcome.php?page=salesInvoice';		}else{
			 document.location.href = 'welcome.php?page=deliveryNoteSearch';
		}
    }
	
</script>

<style type="text/css">


@media print{
 
  @page {
         size: A4;   /* auto is the initial value */
         margin: 18% 2% 10% 2%;
		 height:50% !importnat;
		}	
		
	.brkPage {page-break-after:always;}
	
	.notDisplay {display:none !important}
}

	 
		 
.main-footer {
	display:none !important;
	  }
	  

.theader tr,.theader th {
	border:none !important
}

.tfooter td,.tfooter tr {
	border:none !important
}

tbody, tr, td, th {
	border:1px solid black !important;
}

</style>
<body>
<div id="printDiv">
<input type='hidden' id='pageRefrrence' value='<?php echo $pageRefrrence;?>'>
<?php echo $tbody; ?>

</div>
</body>	
	
	
	
	