<?php 
require_once("../../../../settings/connect_db.php");

class StockTransitReportM {
	
	function search($fromDate,$toDate)
	{
		global $con;
		$fromDate=date("Y-m-d", strtotime($fromDate));
		$toDate=date("Y-m-d", strtotime($toDate));
			 $query = "SELECT * FROM importPurchase IP
							INNER JOIN vendor V ON V.vendorId = IP.vendorId 
							INNER JOIN currency C ON C.currencyId = IP.currencyId 
							WHERE IP.invoiceDate BETWEEN'".$fromDate."' AND '".$toDate."'
							AND  IP.status='1' AND IP.storeCompleteStatus='0'
							ORDER BY IP.importPurchaseId";
		$result  = mysqli_query($con,$query);
		return $result; 
	}
	
	function getDetails($importPurchaseId)
	{
		global $con;
		 $query = "SELECT * FROM importPurchase IP
							INNER JOIN importPurchaseDetails IPD ON IPD.importPurchaseId = IP.importPurchaseId 
							INNER JOIN itemMaster IM ON IM.itemMasterId = IPD.itemMasterId 
							INNER JOIN itemUnit IU ON IU.itemUnitId = IPD.itemUnitIdRow
							INNER JOIN unit U ON U.unitId = IU.unitId
							INNER JOIN currency C ON C.currencyId = IP.currencyId 
							INNER JOIN vendor V ON V.vendorId = IP.vendorId 
							WHERE IP.importPurchaseId='$importPurchaseId'
							AND  IP.status='1' AND IP.storeCompleteStatus='0'";
		
		$result  = mysqli_query($con,$query);
		return $result; 
	}
	
	
}

	?>