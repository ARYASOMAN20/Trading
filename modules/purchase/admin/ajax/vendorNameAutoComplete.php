<?php
require_once("../../../../modules/purchase/admin/class/m_purchase.php");
	$objMPurchase = new M_Purchase();
	$j_array = array();
	$array   = array();
    if(isset($_GET['term'])){
    $q	   = $_GET['term'];
	$my_data      = $q;
	$rowListVendorName = $objMPurchase->vendorNameAutocomplete($my_data);
	if($rowListVendorName){
		while($row = mysqli_fetch_array($rowListVendorName)){
			$array['value'] = $row['vendorName'];
			$array['key']   = $row['vendorId'];
			array_push($j_array,$array);
		}
	}
	echo json_encode($j_array);
}

?>