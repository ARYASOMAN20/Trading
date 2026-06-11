<?php
require_once("../../../../modules/purchase/admin/class/m_purchase.php");
$objMPurchase = new M_Purchase();

	$itemDetails		=	'';
	$itemDetails		.=	'<table class="table table-bordered">
							 <thead>
							<tr>
								<th width="20%">Item Code</th>
								<th width="40%">Item Name</th>
								<th width="15%">Cost Price</th>
								<th width="10%">Pr.Pri</th>
								<th>&nbsp;</th>
							</tr>
							</thead>
							';
if(isset($_GET['itemName']))
{	
	$itemName			=	$_GET['itemName'];
	$itemDetailsData	=	$objMPurchase->getItemNameDetails($itemName);
	if(mysqli_num_rows($itemDetailsData)>0)
	{
		while($itemDetailsDataRow	=	mysqli_fetch_array($itemDetailsData))
		{
			$itemMasterId		=	$itemDetailsDataRow['itemMasterId'];
			
			$itemName			=	$itemDetailsDataRow['itemName'];
			$costPrice			=	$itemDetailsDataRow['costPrice'];
			$resCustomerList 	= 	$objMPurchase->getPurchasePrice($itemMasterId);
					
					$unitPurchasePrice              =  0;
					$sumOfPurchasePrice             =  0; 
                   $count=mysqli_num_rows($resCustomerList);
				 
					while($row = mysqli_fetch_array($resCustomerList))
					{
						//$unitPurchasePrice              =   $row['purchasePrice'];
                        $sumOfPurchasePrice             =   $sumOfPurchasePrice+$row['purchasePrice'];
                        					
					}
				$resCustomerList1 	= 	$objMPurchase->getCostPrice($itemMasterId);	
			
			if($resCustomerList1>0 || $count==0){
				$count=$count+1;
			}
			$PurchasePriceOfItem =($sumOfPurchasePrice+$resCustomerList1)/$count;
			$PurchasePriceOfItem = number_format($PurchasePriceOfItem, 2, '.', '');
			
			$array1 			= 	array($itemName);
			$itemName 			=   '"' . implode ( "', '", $array1 ) . '"';
			
			$itemCode			=	$itemDetailsDataRow['itemCode'];
			$array2 			= 	array($itemCode);
			$itemCode 			= 	'"' . implode ( "', '", $array2 ) . '"';
			
			$vat				=	$itemDetailsDataRow['vat'];
			if($vat==null || $vat=='')
			{
				$vat			=	0;
			}
			$array3 			= 	array($vat);
			$vat 				= 	'"' . implode ( "', '", $array3) . '"';
	
			$itemDetails		.=	"<tr>
										 <td width='20%'>".$itemDetailsDataRow['itemCode']."</td>
										 <td width='40%'>".$itemDetailsDataRow['itemName']."</td>
										 <td width='15%'>".$costPrice."</td>
										 <td width='10%'>".$PurchasePriceOfItem."</td>
										 <td width='10%'> <button type='button' onclick='getMaterialRow($itemMasterId,$itemName,$itemCode,$vat)'  data-dismiss='modal' class='btn btn-danger btnSubmit btn-xs'>
											 <i class='fa fa-plus'></i>
											 </button></td>
									</tr>";
		}
	}else{
		$itemDetails		.=	'<tr>
										 <td colspan="2" width="100%" >No Data Found !!!</td>
										 
									</tr>';
	}
	
}
$itemDetails			.=	'</table>';

echo $itemDetails;

?>