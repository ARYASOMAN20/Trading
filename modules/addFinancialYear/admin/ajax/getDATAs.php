<?php
	
	require_once('../../../../modules/addFinancialYear/admin/model/m_addFinancialYear.php');
$agentModelObj      = new m_addFinancialYear();

		$financialId 		= $_POST['rowid'];	
		$table='';		
		$j_array = array();
 
	$array   = array();


		$updates=$agentModelObj->updateData($financialId);
		while($updateResult=mysqli_fetch_array($updates)) 
			{
				$array['financialYearId']     =$updateResult['financialYearId'];
				$array['fromDate']   =date("d-m-Y", strtotime($updateResult['fromDate']));
				$array['toDate']   =date("d-m-Y", strtotime($updateResult['toDate']));
			 
	
	}
		echo json_encode($array);
	   
	   
	
	   
	 
?>
