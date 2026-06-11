<?php
require_once("../../../../modules/invoiceSearchByDate/admin/models/Invoicesearchbydate_model.php");
$objhModel = new Invoicesearchbydate_model();
require_once("../../../../settings/path.php");
$objPath  = new Path();
class Invoicesearchbydate {
	function getInvoiceDetails($fromDate,$toDate){
		$objhModel = new Invoicesearchbydate_model();
		$objPath  = new Path();
	   $resInvoiceDetails =$objhModel->getInvoiceDetails($fromDate,$toDate);
		$i          =1;
		$totalAmountWithoutVat =0;
		$vatAmount  =0;
		$discount=0;
		$advanceAmount=0;
		$totalAmountWithVat  =0;
		$invoiceTables ='';
		$resInvoiceDetailsList = '';
		while ($resInvoiceDetailsList = mysqli_fetch_array($resInvoiceDetails)) { 
			$invoiceTables 	.='<tr>
									<td><center> '.$i.'</center> </td>
									<td><center> '.$resInvoiceDetailsList['invoiceNo'].'</center> </td>
									<td><center>'.$resInvoiceDetailsList['invoiceDate'].'</center></td>
									<td><center>'.$resInvoiceDetailsList['customerName'].'</center></td>
									<td align="right"> '.number_format($resInvoiceDetailsList['totalAmountWithoutVat'],2,'.','').'</td>
									<td align="right">  '.number_format($resInvoiceDetailsList['vatAmount'],2,'.','').' </td>
									<td align="right">  '.number_format($resInvoiceDetailsList['discount'],2,'.','').' </td>
									<td align="right">  '.number_format($resInvoiceDetailsList['advanceAmount'],2,'.','').' </td>
									<td align="right">  '.number_format($resInvoiceDetailsList['totalAmountWithVat'],2,'.','').'</td>
									<td id="details"><form method="POST" action="'.$objPath->setAction('invoiceSearchByDate_print','invoiceSearchByDate').'" target="_blank">
				                        <input type="hidden" name="invoiceId" value="'.$resInvoiceDetailsList['invoiceId'].'"/>
		   			                    <button type="submit" class="btn btn-info btn-xs" name="details" value="details" id="details" title="details"><i class="fa fa-eye"></i></button>
					                    </form>
										
								    </td>
								</tr>';
			$totalAmountWithoutVat +=$resInvoiceDetailsList['totalAmountWithoutVat'];
			$vatAmount	         +=$resInvoiceDetailsList['vatAmount'];	
			$discount	          +=$resInvoiceDetailsList['discount'];	
			$advanceAmount	     +=$resInvoiceDetailsList['advanceAmount'];	
			$totalAmountWithVat	+=$resInvoiceDetailsList['totalAmountWithVat'];
		$i++;
		}
		$invoiceTables    	.='<tr>
										<td colspan="4">Total</td>
										<td align="right"> '.number_format($totalAmountWithoutVat,2,'.','').' </td>
										<td align="right"> '.number_format($vatAmount,2,'.','').' </td>
										<td align="right"> '.number_format($discount,2,'.','').' </td>
										<td align="right"> '.number_format($advanceAmount,2,'.','').' </td>
										<td align="right"> '.number_format($totalAmountWithVat,2,'.','').' </td>
										<td id="td"></td>
									</tr>';
		
	
		return $invoiceTables;  
	}
	
	
	function getInvoiceDetailsView($invoiceId){
		$objhModel = new Invoicesearchbydate_model();
		$objPath  = new Path();
		$vatAmount  =0;
		$discount=0;
		$advanceAmount=0;
		$totalAmountWithVat  =0;
	   $resInvoiceDetailsView =$objhModel->getInvoiceDetailsView($invoiceId);
	   /* $getInvoiceAmount =$objhModel->getInvoiceAmount($invoiceId);
		while ($getInvoiceAmountList = mysqli_fetch_array($getInvoiceAmount)) {
		$vatAmount=$getInvoiceAmountList['vatAmount'];
		$totalAmountWithVat=$getInvoiceAmountList['totalAmountWithVat'];	
		$discount=$getInvoiceAmountList['discount'];
		$advanceAmount=$getInvoiceAmountList['advanceAmount'];
		}*/
		
		$i          =1;
		$quantity   =0;
		$unitPrice  =0;
		$amount     =0;
		$resInvoiceDetailsList ='';
		$count='';
		$invoiceDetailsTables = '';
		$count=mysqli_num_rows($resInvoiceDetailsView);
		if($count!='')
		{	 
		while ($resInvoiceDetailsList = mysqli_fetch_array($resInvoiceDetailsView)) { 
		$invoiceNo=$resInvoiceDetailsList['invoiceNo'];
		$invoiceDate=$resInvoiceDetailsList['invoiceDate'];
		$customerName=$resInvoiceDetailsList['customerName'];
		$transactionType=$resInvoiceDetailsList['transactionType'];
		//print_r($resInvoiceDetailsList);
			$invoiceDetailsTables 	.=' <tr>
									<td><center> '.$i.'</center> </td>
									<td><center> '.$resInvoiceDetailsList['modelCode'].'</center> </td>
									<td><center>'.$resInvoiceDetailsList['unitName'].'</center></td>
									<td><center>'.$resInvoiceDetailsList['quantity'].'</center></td>
									<td align="right">'.number_format($resInvoiceDetailsList['unitPrice'],2,'.','').'</td>
									<td align="right">'.number_format($resInvoiceDetailsList['amount'],2,'.','').'</td>
									
								</tr>';
				
			$amount	            +=$resInvoiceDetailsList['amount'];
			
			$vatAmount=$resInvoiceDetailsList['vatAmount'];
		$totalAmountWithVat=$resInvoiceDetailsList['totalAmountWithVat'];	
		$discount=$resInvoiceDetailsList['discount'];
		$advanceAmount=$resInvoiceDetailsList['advanceAmount'];
		$i++;
		}
		
		$invoiceDetailsTables    	.='<tr>
										<td colspan="5">Total Without Vat</td>
										<td align="right">  '.number_format($amount,2,'.','').' </td>
										</tr><tr>
										<td colspan="5">Vat Amount</td>
										<td align="right">  '.number_format($vatAmount,2,'.','').' </td>
										</tr><tr>
										<td colspan="5">Discount</td>
										<td align="right">  '.number_format($discount,2,'.','').' </td>
										</tr><tr>
										<td colspan="5">Advance Amount</td>
										<td align="right">  '.number_format($advanceAmount,2,'.','').' </td>
										</tr><tr>
										<td colspan="5">Total With Vat</td>
										<td align="right">  '.number_format($totalAmountWithVat,2,'.','').' </td>
										
									  </tr>';
		
	$arrDetails = array('invoiceDetailsTables'=>$invoiceDetailsTables,'customerName'=>$customerName,'invoiceDate'=>$invoiceDate,'invoiceNo'=>$invoiceNo,'transactionType'=>$transactionType);
			
			   //print_r($arrDetails );
  			   return $arrDetails;
		//return $invoiceDetailsTables;  
	}
	else
	{
	return 1;	
	}
	}
	
}
?>
