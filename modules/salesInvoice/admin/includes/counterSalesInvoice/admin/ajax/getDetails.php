<?php 

require_once("../../../../modules/salesInvoice/admin/models/m_salesInvoice.php");

$objMSalesInvoice	= 	new M_salesInvoice();
$table=null;
$itemCodeRow      = $_POST['itemCodeRow'];
$customerName     = $_POST['customerName'];


if(isset($_POST['regularCustomerId'])){
		$regularCustomerId=$_POST['regularCustomerId'];
		$itemMasterId     = $_POST['itemMasterId'];
		
		
		$getData=$objMSalesInvoice->getDetailsOfItem($regularCustomerId,$itemMasterId);
		
			while($data=mysqli_fetch_array($getData)){
				$table     	.=  '<tr>
						  <td align="center">'.$data['invoiceNo'].'</td>
						  <td align="center"> '.$data['invoiceDate'].'</td>
						  <td align="center"> '.$data['quantity'].'  </td>
						  <td align="center"> '.$data['unitName'].'  </td>
						  <td align="center">'.$data['unitPrice'].'</td>
						  <td align="center"> '.$data['amount'].'</td>
						  <td align="center"> '.$data['amountWithVat'].'  </td>
						   
						</tr>';
				
			}
		
		echo $table;

}

?>