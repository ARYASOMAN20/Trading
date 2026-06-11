<?php
//echo "veen";
	require_once("../../../../modules/estimateQuotationReport/admin/model/m_EstimateQuotationReport.php");
	$objMEstimateQuotationReport = new M_EstimateQuotationReport();
	$j_array = array();
	$array   = array();
    if(isset($_GET['term'])){
    $q	   = $_GET['term'];
	$my_data      = $q;
	//$jobTypeId = $_GET['jobType'];
	$rowListEstimateNo = $objMEstimateQuotationReport->getEstimateNo($my_data);
	if($rowListEstimateNo){
		while($row = mysqli_fetch_array($rowListEstimateNo)){
			$array['value'] = $row['jobEstimateNo'];
			$array['key']   = $row['jobEstimateId'];
			array_push($j_array,$array);
		}
	}
	echo json_encode($j_array);
}

?>