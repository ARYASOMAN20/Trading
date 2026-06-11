<?php
	require_once("../../../../modules/settings/admin/class/users.php");
    $objUsers  = new Users();
	$userType       = $_POST['userType'];
	$branch1       = $_POST['branch1'];
	$salesAresList='';
	$salesAress = $objUsers->getSalesArea($branch1,$userType);
	$salesAresList .='<option value="">Select</option>';
	if($salesAress){
	while($listName = mysqli_fetch_array($salesAress)){
	    $salesAresList .='<option value="'.$listName['branchId'].'">
								'.$listName['branchName'].'
							</option>';	
	}
	echo $salesAresList;
	}
?>