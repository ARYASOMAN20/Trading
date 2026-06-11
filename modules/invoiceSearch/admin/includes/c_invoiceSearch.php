


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
							
				$totalLabour	    = $rowsListVoucherDetails['totalLabour'];
				$otherCharge         = $rowsListVoucherDetails['totalOtherCharges'];
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
			echo "count".$countRow;	
			
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
							  <td align="center">'.$quotationVoucherNo.'</td>
							  <td align="center">'.$amountDate.'</td>
							  <td align="center">'.$amountPaid.'</td>
						</tr>';
					$i++;
				$totalPaidAmount +=$amountPaid;
			}
			$arrDetails = array('detailsTable'=>$detailsTable,'totalPaidAmount'=>$totalPaidAmount);
			}
  			return $arrDetails;
	  }
	
	function invoiceSearchForQuotation($invoiceId){
			global $objMInvoiceSearch;
			$detailsTable	      = $customerNo = $customerName =$arrDetails= '';
			$i = 1;
			$resQuotationDetails   = $objMInvoiceSearch->invoiceSearch($invoiceId);
			$countRow = mysqli_num_rows($resQuotationDetails);
			echo "count".$countRow;	
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
				$laborCharge = $rowsListDetails['labourCharges'];
				$amount				= $quantity*$unitPrice*$fraction;
				$detailsTable         .= '<tr height="30">
										   <td align="center">'.$rowsListDetails['materialsName'].'</td>
										   <td align="center">'.$rowsListDetails['unitName'].'</td>
										   <td align="center">'.$rowsListDetails['quantity'].'</td>
										   <td align="right">'.$rowsListDetails['unitPrice'].'</td>
										   <td align="right">'.number_format($amount,2,'.','').'</td>
										</tr>';
					$i++;
					
					//$totalAmount += $amount;
					//echo "l".$laborCharge +=$laborCharge ;
				//echo "o".$otherCharges 	+= $rowsListDetails['otherCharges'] ;
			}
			$arrDetails = array('detailsTable'=>$detailsTable,'customerName'=>$customerName,'contactNo'=>$contactNo,
								'quotationNo'=>$quotationNo,'quotationInvoiceNo'=>$quotationInvoiceNo,
								'otherCharges'=>$otherCharges,'quotationTotalAmount'=>$quotationTotalAmount,'customerNo'=>$customerNo,
								'quotationDate'=>$quotationDate);
			}
			  // print_r($arrDetails );
  			return $arrDetails;
	  }
	
 

 }
	?>