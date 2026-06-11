<?php
	require_once("../../../../modules/regularCustomer/admin/class/m_customer.php");
   $objM_addCustomer  = new M_customer();
	$branchId       = $_POST['branchId'];
	$salesAresList='';
	$salesAress = $objM_addCustomer->getSalesArea($branchId);
	//$salesAresList .='<option value="">Select</option>';
	if($salesAress){
	while($listName = mysqli_fetch_array($salesAress)){
	    $salesAresList .='<option value="'.$listName['branchId'].'" selected>
								'.$listName['branchName'].'
							</option>';	
	}
	echo $salesAresList;
	}
?>