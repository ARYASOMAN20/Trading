<?php 
require_once("../../../../settings/connect_db.php");
class m_addFinancialYear
{
    function listFinancialYear()
    {
        global $con;
        $query = "SELECT fromDate,toDate,financialYearId
                        FROM financialYear 
                         WHERE status='1'";
        $result =  mysqli_query($con,$query);
        return $result;  
    }
    function setFinancialYear($fromDate,$toDate)
    {
       global $con;
		$query="INSERT INTO  financialYear(fromDate,toDate) VALUES('$fromDate','$toDate')";
		$set=mysqli_query($con,$query);
		return mysqli_insert_id($con);
    }
  	public function updateData($financialId)
	{
		global $con;
		$query='SELECT * FROM financialYear WHERE financialYearId="'.$financialId.'"';
	 	$update_Category=mysqli_query($con,$query);
	 	return $update_Category;
	}
	
	public function update_List($financialId,$fromDate,$toDate)
	{
	 	global $con;
		$query='update financialYear set fromDate="'.$fromDate.'",toDate="'.$toDate.'"  where financialYearId="'.$financialId.'"';
		$set=mysqli_query($con,$query);
	}
}
?>