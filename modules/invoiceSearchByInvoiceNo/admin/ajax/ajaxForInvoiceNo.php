<?php
require_once("../../../../modules/invoiceSearchByInvoiceNo/admin/models/Invoicesearchbyinvoiceno_model.php");
	$objhModel= new Invoicesearchbyinvoiceno_model();
	$j_array = array();
	$array   = array();
    if(isset($_GET['term'])){
    $q	   = $_GET['term'];
	$my_data      = $q;
	$branchId = $_GET['branchId'];
	$rowInvoiceNo = $objhModel->invoiceNoAutocomplete($my_data,$branchId);
	if($rowInvoiceNo){
		while($row = mysqli_fetch_array($rowInvoiceNo)){
			$array['value'] = $row['invoiceNo'];
			$array['key']   = $row['invoiceId'];
			array_push($j_array,$array);
		}
	}
	echo json_encode($j_array);
}

?>