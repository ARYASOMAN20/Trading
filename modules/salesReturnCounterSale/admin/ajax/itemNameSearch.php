<?php
require_once("../../../../modules/salesInvoice/admin/models/m_salesInvoice.php");
	$objsalesInvoice 	= new M_salesInvoice();
	$itemDetails		=	'';
	$itemDetails		.=	'<table>
							 <thead>
							<tr>
								<th width="30%">Item Code</th>
								<th width="50%">Item Name</th>
								<th width="10%">Price</th>
								<th width="10%">&nbsp;</th>
							</tr>
							</thead>
							';
if(isset($_GET['itemName']))
{
	$regularCustomerId	=	0;//$_GET['regularCustomerId'];
	$itemName			=	$_GET['itemName'];
	$itemDetailsData	=	$objsalesInvoice->getItemNameDetails($regularCustomerId,$itemName);
	if(mysqli_num_rows($itemDetailsData)>0)
	{
		while($itemDetailsDataRow	=	mysqli_fetch_array($itemDetailsData))
		{
			$itemMasterId			=	$itemDetailsDataRow['itemMasterId'];
			$itemName			 	=	$itemDetailsDataRow['itemName'];
			$array1 				= 	array($itemName);
			$itemName 				= '"' . implode ( "', '", $array1 ) . '"';
			
			$itemCode			 	=	$itemDetailsDataRow['itemCode'];
			$array2 = array($itemCode);
			$itemCode = '"' . implode ( "', '", $array2 ) . '"';


			$packing			 =	$itemDetailsDataRow['packing'];
			$array3 			 = array($packing);
			$packing 			 = '"' . implode ( "', '", $array3) . '"';
			
			$sellingPrice		 =	$itemDetailsDataRow['maxretailPrice'];
			
			$itemDetails		.=	"<tr >
										 <td width='30%' >".$itemDetailsDataRow['itemCode']."</td>
										 <td width='50%' >".$itemDetailsDataRow['itemName']."</td>
										 <td>".$sellingPrice."</td>
										 <th width='10%'>
											 <button type='button' onclick='getPurchasePrice($itemMasterId,$itemName,$itemCode,$packing,$sellingPrice,$regularCustomerId)' data-dismiss='modal' class='btn btn-danger btnSubmit btn-xs'>
											 <i class='fa fa-plus'></i>
											 </button>
										 </th>
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