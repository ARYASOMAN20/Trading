<?php
//echo "veen";
require_once("../../../../modules/invoiceSearch/admin/class/m_invoiceSearch.php");
	$objMInvoiceSearch = new  M_InvoiceSearch();
	$j_array = array();
	$array   = array();
    if(isset($_GET['term'])){
    $q	   = $_GET['term'];
	$my_data      = $q;
	//$jobTypeId = $_GET['jobType'];
	$rowListEstimateNo = $objMInvoiceSearch->listInvoiceNo($my_data);
	if($rowListEstimateNo){
		while($row = mysqli_fetch_array($rowListEstimateNo)){
			$array['value'] = $row['quotationInvoiceNo'];
			$array['key']   = $row['quotationInvoiceId'];
			array_push($j_array,$array);
		}
	}
	echo json_encode($j_array);
}

?>