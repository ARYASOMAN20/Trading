<?php
	require_once("../../../../settings/connect_db.php");
 	class DbUtils
 	{
		function isDuplicateButNotThis($columnName,$tableName,$whereColumnName1,$whereColumnName2,$columnValue1,$columnValue2)
    {
        global $con;
        $query = "SELECT ".$columnName."
                  FROM   ".$tableName."
                  WHERE  ".$whereColumnName1." = '".$columnValue1."' AND
                         ".$whereColumnName2." != '".$columnValue2."'  ";
        $result=mysqli_query($con,$query);
        return($result);
    }
    
		function loadDropDown($resultArray,$valueColumn,$nameColumn){
     		$strValue = "";
     		while($row = mysqli_fetch_array($resultArray)){
         		$strValue.= "<option value= '".$row[$valueColumn]."'>" 
 				.$row[$nameColumn].
				"</option>";     
       		 }
    		return $strValue; 
		}

		
		
		function isDuplicate($columnName,$tableName,$ColumnName2,$columnValue)
		{
			global $con;
			$query = "SELECT ".$columnName ."
						FROM ".$tableName."
						WHERE ".$ColumnName2." = '".$columnValue."' ";
			$result=mysqli_query($con,$query);
			return($result);
		}
		
		function areDuplicate($columnName,$tableName,$whereColumnName1,$whereColumnName2,$columnValue1,$columnValue2)
		{
			global $con;
			$query = "SELECT ".$columnName." 
						FROM ".$tableName."
						WHERE ".$whereColumnName1." = '".$columnValue1."'
						AND ".$whereColumnName2." = '".$columnValue2."' 
					";
			$result=mysqli_query($con,$query);
			return($result);
		}
		
		function areDuplicateWithStatus($columnName,$tableName,$whereColumnName1,$whereColumnName2,$columnValue1,$columnValue2)
		{
			global $con;
			$query = "SELECT ".$columnName ."
						FROM ".$tableName."
						WHERE ".$whereColumnName1." = '".$columnValue1."'
						AND ".$whereColumnName2." = '".$columnValue2."'
						AND status = '1'";
			$result=mysqli_query($con,$query);
			return($result);
		}
		
		function isDuplicateButNotThisWithStatus($columnName,$tableName,$whereColumnName1,$whereColumnName2,
														$columnValue1,$columnValue2)
		{
			global $con;
			$query = "SELECT ".$columnName." 
						FROM ".$tableName."
						WHERE ".$whereColumnName1." = '".$columnValue1."'
						AND ".$whereColumnName2." != '".$columnValue2."'
						AND status = '1'";
			$result=mysqli_query($con,$query);
			return($result);
		}
		
		function areDuplicateButNotThisWithStatus($columnName,$tableName,$whereColumnName1,$whereColumnName2, $whereColumnName3,
														$columnValue1,$columnValue2, $columnValue3)
		{
			global $con;
			$query = "SELECT ".$columnName ."
						FROM ".$tableName."
						WHERE ".$whereColumnName1." = '".$columnValue1."'
							AND ".$whereColumnName2." = '".$columnValue2."'
							AND ".$whereColumnName3." != '".$columnValue3."'
							AND status = '1'
					";
			$result=mysqli_query($con,$query);
			return($result);
		}
		
		function checkDuplicate($noOfColumnName,$tableName,$whereColumnArray,$selectColumnArray){
			global $con;
			$query = "SELECT ";
			$query.= implode("," ,$selectColumnArray);
			$query.= " FROM $tableName
				  	 WHERE ";
				 	 for($i = 0; $i < $noOfColumnName; $i++ ){
				 		 $query1 = $selectColumnArray[$i]." = "."'$whereColumnArray[$i]'";
				     	if($i < $noOfColumnName-1)
							$query1.= " AND ";
					 	$query.= $query1;	
				  	}
			//echo $query;
			$result=mysqli_query($con,$query);
			return($result);
		}
		
		function isDuplicateWithStatus($columnName,$tableName,$ColumnName2,$columnValue)
                {
                        global $con;
                        $query = "SELECT ".$columnName ."
                                                FROM ".$tableName."
                                                WHERE ".$ColumnName2." = '".$columnValue."'
                                                AND status = '1'";
                        $result=mysqli_query($con,$query);
                        return($result);
                }
	}
?>