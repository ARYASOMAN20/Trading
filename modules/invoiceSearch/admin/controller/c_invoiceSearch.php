

<?php 
require('../../../../libraries/class/utils.php');
require_once("../../../../settings/path.php");
require_once("../../../../modules/invoiceSearch/admin/class/m_invoiceSearch.php");
	$objMInvoiceSearch = new  M_InvoiceSearch();
    $objUtils      	  = new Utils();
    $objUtils          = new Utils();
	
class C_InvoiceSearch {
	
	function otherChargesDetails($invoiceId)
	{
			global $objMInvoiceSearch;
			$totalAmount =$totalLabour=$otherCharge = 0;
			$resCharges = $objMInvoiceSearch->otherChargesDetails($invoiceId);
			if($rowsListVoucherDetails      = mysqli_fetch_array($resCharges)){
							
				$totalLabour	    = $rowsListVoucherDetails['labourCharges'];
				$otherCharge         = $rowsListVoucherDetails['otherCharges'];
				$totalAmount = $rowsListVoucherDetails['total'];
	
						}
			$arrDetails = array('totalLabour'=>$totalLabour,'otherCharge'=>$otherCharge,'totalAmount'=>$totalAmount);
            return $arrDetails;

	}
	
	function voucherSearchForQuotation($invoiceId){
			global $objMInvoiceSearch;
			$i = 1;
			$resVoucherQuotationDetails = $objMInvoiceSearch->quotationVoucherSearch($invoiceId);
			$countRow = mysqli_num_rows($resVoucherQuotationDetails);
			//echo "count".$countRow;	
			
			$arrDetails=$detailsTable='';
			if($countRow > 0)
			{	
			$amountPaid =0;
			$totalPaidAmount = 0;					
			while($rowsListVoucherDetails      = mysqli_fetch_array($resVoucherQuotationDetails)){
				$amountDate	    = $rowsListVoucherDetails['amountDate'];
				$amountPaid         = $rowsListVoucherDetails['amountPaid'];
				$quotationVoucherNo = $rowsListVoucherDetails['quotationVoucherNo'];
				$detailsTable         .= '<tr height="30">
							  <td >'.$quotationVoucherNo.'</td>
							  <td >'.$amountDate.'</td>
							  <td >'.$amountPaid.'</td>
						</tr>';
					$i++;
				$totalPaidAmount +=$amountPaid;
			}
			$arrDetails = array('detailsTable'=>$detailsTable,'totalPaidAmount'=>$totalPaidAmount,'countRow'=>$countRow);
			}
  			return $arrDetails;
	  }
	
	function invoiceSearchForQuotation($invoiceId){
			global $objMInvoiceSearch;
			$detailsTable	      = $customerNo = $customerName =$arrDetails= '';
			$i = 1;
			$resQuotationDetails   = $objMInvoiceSearch->invoiceSearch($invoiceId);
			$countRow = mysqli_num_rows($resQuotationDetails);
			//echo "count".$countRow;	
			$totalAmount =$laborCharge=$amountPaid =0 ;
			if($countRow > 0)
			{					
			while($rowsListDetails = mysqli_fetch_array($resQuotationDetails )){
				$quotationNo		   = $rowsListDetails['quotationNo'];
				$quotationInvoiceNo	= $rowsListDetails['quotationInvoiceNo'];
				$otherCharges	      = $rowsListDetails['otherCharges'];
				$quotationTotalAmount  = $rowsListDetails['quotationTotalAmount'];
				$customerName		  = $rowsListDetails['customerName'];
				$contactNo		     = $rowsListDetails['contactNo_1'];
				$quantity			  = $rowsListDetails['quantity'];
				$unitPrice			 = $rowsListDetails['unitPrice'];
				$fraction			  = $rowsListDetails['fraction'];
				$quotationDate         = $rowsListDetails['quotationDate'];
				$customerNo            = $rowsListDetails['customerNo'];
				$labourCharges         = $rowsListDetails['labourCharges'];
				$vatInPercentage       = $rowsListDetails['vatInPercentage'];
				$vatInAmount           = $rowsListDetails['vatInAmount'];
				$billTotalWithVat      = $rowsListDetails['billTotalWithVat'];
				$billTotal 	       = $rowsListDetails['billTotal'];
				$amount				= $quantity*$unitPrice*$fraction;
				$detailsTable         .= '<tr height="30">
										   <td >'.$rowsListDetails['materialsName'].'</td>
										   <td >'.$rowsListDetails['unitName'].'</td>
										   <td >'.$rowsListDetails['quantity'].'</td>
										   <td align="right">'.$rowsListDetails['unitPrice'].'</td>
										   <td align="right">'.number_format($amount,2,'.','').'</td>
										</tr>';
					$i++;

					$totalAmount += $amount;
			}
			$arrDetails = array('detailsTable'=>$detailsTable,'customerName'=>$customerName,'contactNo'=>$contactNo,
								'quotationNo'=>$quotationNo,'quotationInvoiceNo'=>$quotationInvoiceNo,
								'otherCharges'=>$otherCharges,'quotationTotalAmount'=>$quotationTotalAmount,'customerNo'=>$customerNo,
								'quotationDate'=>$quotationDate,
								'totalLabour'=>$labourCharges,'otherCharge'=>$otherCharges,'totalAmount'=>$totalAmount,
								'vatInPercentage'=>$vatInPercentage,'vatInAmount'=>$vatInAmount ,'billTotalWithVat'=>$billTotalWithVat,
								'billTotal'=>$billTotal 	        	       
								);
			}
			  // print_r($arrDetails );
  			return $arrDetails;
	  }
	
 

 }
	?>