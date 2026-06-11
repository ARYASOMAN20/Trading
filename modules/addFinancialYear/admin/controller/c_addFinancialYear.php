<?php 
require_once('../../../../modules/addFinancialYear/admin/model/m_addFinancialYear.php');
$agentModelObj      = new m_addFinancialYear();

class c_addFinancialYear
{
    function listFinancialYear()
    {
        global $agentModelObj;
        $result     =     $agentModelObj->listFinancialYear();
        $tbody= ''; $i=1;
        while ($row = mysqli_fetch_array($result))
        {
            $id=$row['financialYearId'];
            $tbody .= '<tr>
                        <td>'.$i.'</td>
                         <td>'.date("d-m-Y",strtotime($row['fromDate'])).'</td>
                        <td>'.date("d-m-Y",strtotime($row['toDate'])).'</td>
                       
                        <td>
         
             <form method="post">
                
				<button class="btn btn-sm" data-toggle="modal" type="button" name="update" onclick="getData('.$id.')" value="update" style="border-radius: 50%;background-color: green;" data-target="#brandModalEdit">
										<i class="fa fa-edit" style="color:#1af516;"></i>
									</button>
                
             </form>
            
    	</td>
    		
                        </tr>';
            $i++;
        }
        return $tbody;
    }
    
    function setFinancialYear($fromDate,$toDate){
        
         global $agentModelObj;
        $result     =     $agentModelObj->setFinancialYear($fromDate,$toDate);
        return $result;
    }
    
    
 
     function update_List($financialId,$fromDate,$toDate){
         
          global $agentModelObj;
        $result     =     $agentModelObj->update_List($financialId,$fromDate,$toDate);
        return $result;
     }
    

}
?>