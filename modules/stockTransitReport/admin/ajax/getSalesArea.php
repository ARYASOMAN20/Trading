<?php
	require_once("../../../../modules/salesAreaSalesReport/admin/models/SalesAreaSalesReportM.php");
   $objBranchTransfer 		= 	new SalesAreaSalesReportM();
	$branchId       = $_POST['branchId'];
	$salesAresList='';
	$privilageId             =   	$_COOKIE['privillegeId'];
	$mainBranch  =   	$_COOKIE['mainBranch'];
	
    $salesAress = $objBranchTransfer->getSalesArea($branchId);
	$salesAresList .='<option value="">Select</option>';
	if($salesAress){
	while($listName = mysqli_fetch_array($salesAress)){
		if($listName['salesmanName']!=''){
	    $salesAresList .='<option value="'.$listName['branchId'].'">
								'.$listName['branchName'].'-'.$listName['salesmanName'].'
							</option>';	
		}else{
			 $salesAresList .='<option value="'.$listName['branchId'].'">
								'.$listName['branchName'].'
							</option>';	
		}
	}
	echo $salesAresList;
	}
?>