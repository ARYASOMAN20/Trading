<?php 
require_once("../../../../settings/connect_db.php");

class M_Home {
	
	function listStockContainingLessThan10()
	{
	  global $con;
      $query = " SELECT COUNT(materialsId) AS count
               	 FROM materials 
			     WHERE stock < 10
						";
		$result  = mysqli_query($con,$query);
		return $result;


	}
	
	function listStocks()
	{
		global $con;
	 	 $query = "  SELECT materialsId,materialsName,unitPrice,stock
					 FROM materials
					 WHERE status = '1' AND  stock < 10";
		//echo '<br>'.$query.'<br />';
	 	$result = mysqli_query($con,$query);
	 	return $result;

	}
}
?>