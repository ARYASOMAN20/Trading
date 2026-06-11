<?php 

	require_once("../../../../modules/stockTransitReport/admin/class/StockTransitReportM.php");
	$StockTransitReportM = new  StockTransitReportM();
    
class StockTransitReportC {
	
	function getDetails($importPurchaseId){
		
		global $StockTransitReportM;
		$data = $StockTransitReportM->getDetails($importPurchaseId);
		return $data;
	}
	
	function search($fromDate,$toDate)
	{ 
			global $StockTransitReportM;
			
			$resOfSearch = $StockTransitReportM->search($fromDate,$toDate);
			$tbody =null;
			$i=1;
			if($resOfSearch!=null){
			while ($dataFetchDetails = mysqli_fetch_array($resOfSearch))
				{
					
				$tbody.='<tr>
						<td width="10%" align="center" >'.implode("-",array_reverse(explode("-",$dataFetchDetails['invoiceDate']))).'</th>
						<td width="10%" align="center">'.$dataFetchDetails['invoiceNo'].'</th>
						<td width="45%">'.$dataFetchDetails['vendorName'].'</th>
						<td width="10%" align="center">'.$dataFetchDetails['currencyName'].'</th>
						<td width="10%" align="center">'.$dataFetchDetails['containerNo'].' </th>
						<td width="10%" align="center">'.$dataFetchDetails['supplierInvoiceNo'].' </th>
						<td width="5%" align="center" style="padding:3px">
							<button class="btn btn-info btn-xs" onclick="getDetails('.$dataFetchDetails['importPurchaseId'].')"><i class="fa fa-eye"></i></button>
						</th>
					</tr>';
					}
					
			return	$tbody;
			}else{
				return	$tbody=null;
			}
			
	}
	
	function searchPDF($fromDate,$toDate)
	{ 
			global $StockTransitReportM;
			
			$resOfSearch = $StockTransitReportM->search($fromDate,$toDate);
			$tbody =null;
			$i=1;
			if($resOfSearch!=null){
			while ($dataFetchDetails = mysqli_fetch_array($resOfSearch))
				{
					
				$tbody.='<tr>
						<td width="10%" align="center" >'.implode("-",array_reverse(explode("-",$dataFetchDetails['invoiceDate']))).'</td>
						<td width="10%" align="center">'.$dataFetchDetails['invoiceNo'].'</td>
						<td width="45%">'.$dataFetchDetails['vendorName'].'</td>
						<td width="10%" align="center">'.$dataFetchDetails['currencyName'].'</td>
						<td width="10%" align="center">'.$dataFetchDetails['containerNo'].' </td>
						<td width="10%" align="center">'.$dataFetchDetails['supplierInvoiceNo'].' </td>
						
					</tr>';
					}
					
			return	$tbody;
			}else{
				return	$tbody=null;
			}
			
	}
}
	?>