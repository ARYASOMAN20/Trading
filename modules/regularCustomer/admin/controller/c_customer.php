<?php
	require_once("../../../../modules/regularCustomer/admin/class/m_customer.php");
	require_once("../../../../settings/connect_db.php");
	require_once("../../../../settings/path.php"); 
	$objM_customer = new M_customer();
	$objPath  		   = new Path();

	class C_customer{
		// new
		function getMaxCustomerNo()
		{
			global $objM_customer;	
			$dataOfCustomer=$objM_customer->getMaxCustomerNo();
			return $dataOfCustomer;
		
		}
		// new ends
		function listCustomerDetails(){
			global $objM_customer;	
			global $con;
			global $objPath;
			
     		$showCustomerRecords = $tblCustomer = '';
			
       		$privilageId            =   	$_COOKIE['privillegeId'];
			$branchId        		=   	$_COOKIE['branchId'];
			
			if(($privilageId==1 || $privilageId==12)  and $branchId==0){
    		$showCustomerRecords = $objM_customer->listCustomerLimit();
			}else{
				$showCustomerRecords = $objM_customer->listCustomerLimitForBranch($branchId);
			}
			
			$i=1;
			
			while($rowListCustomer = $showCustomerRecords->fetch_array()) {
				 $branchName = null;
				if($rowListCustomer['registeredBranchId']=='D'){
				$branchName ='DAMMAM BRANCH';
			}else if($rowListCustomer['registeredBranchId']=='R'){
				$branchName ='RIYAD BRANCH';
			}else if($rowListCustomer['registeredBranchId']=='M'){
				$branchName ='MAKKAH BRANCH';
			}else if($rowListCustomer['registeredBranchId']=='J'){
				$branchName ='JEDDAH BRANCH';
			}
			
			$salesAreaBranchId		= $rowListCustomer['salesAreaBranchId'];
			$salesAress = $objM_customer->getSalesAreaName($salesAreaBranchId);
			
				$tblCustomer .= '<tr >
								  <td width="2%" align="center">' . $i . '</td>
								   <td width="10%">' . $rowListCustomer['customerNo'].'</td>
					   			  <td width="20%">' . $rowListCustomer['customerName'] . '</td>
								  <td width="16%">' . $rowListCustomer['address'] . '</td>
						  		 <td width="9%">' . $rowListCustomer['vatNumber'] . '</td>		
								  <td width="12%">' . $rowListCustomer['contactNo_1'] . '</td>
								  
								  <td width="10%">' . $branchName. '</td>
								  <td width="12%">' . $salesAress . '</td>
								  	<td width="2%" align="center"> 
								   
								   <a href="'.$objPath->setActionPassingValue('editRegCusName','regularCustomerId',
								  $rowListCustomer['regularCustomerId']).'" class="btn btn-sm" style="border-radius: 50%;background-color:#efefef"  >
										<i class="fa fa-edit" style="color:#1af516;"></i>
									</a>
									
									
								  </td>	

								  <td>
         
             <form action="'.$objPath->setAction('addRegCusName','addRegCusName').'" method="post">
                <input type="hidden" name="regularCustomerId" value="'.$rowListCustomer['regularCustomerId'].'"/>
               <button class="btn btn-sm" type="submit" name="delete" value="delete" style="border-radius: 50%;background-color:#efefef">
										<i class="fa fa-times" style="color:red;"></i>
									</button>
             </form>
            
    	</td>
								</tr>';
								
				$i++;
			}	
			     //for($i=1;$i<=$tpages;$i++) {
     				//echo "<a href='".$objPath->setActionPassingValue('addRegCusName','page1',
							//	 $i)."'>  $i  | </a>";
     		//}
			//echo "</p>";
			return $tblCustomer;
		}
		function currentBalanceList($fromDateNew,$toDateNew,$customerId){
			global $objM_customer;
			global $objPath;
			$i = 1;	$total = $currentBalance = 0; 
			$table = $customerNo = $customerName = '';
    		$currentBalanceReport = $objM_customer->currentBalanceList($fromDateNew,$toDateNew,$customerId);
			$count = mysqli_num_rows($currentBalanceReport);
			if($count == 0)
				$objPath->setHeader('currentBalanceForCustomer','No records found!!');
			while($rowListCurrentBalnce = mysqli_fetch_array($currentBalanceReport)) {
				$customerNo = $rowListCurrentBalnce['customerNo'];
				$customerName = $rowListCurrentBalnce['customerName'];
				$currentBalance = $rowListCurrentBalnce['currentBalanceReceiverAmount'];

				$table .= '<tr >
								    <td width="20%">' . $i. '</td>
					   			  <td width="20%">' . $rowListCurrentBalnce['amountdate'] . '</td>
								  <td width="10%">' . $rowListCurrentBalnce['amount'] . '</td>
								</tr>';
								
				$total = $total+$rowListCurrentBalnce['amount'] ;
				$i++;
			}	
			$arrayDetails = array('customerNo'=>$customerNo,'customerName'=>$customerName,'total'=>$total,'table'=>$table);
			return  $arrayDetails;    
		}
		
		function allBranch($id){
			global $objM_customer;
			$selectBox =null;
			if($id==null){
				
			$data = $objM_customer->allBranch();
				while($res = mysqli_fetch_array($data)){
					$selectBox .='<option value="'.$res['branchId'].'">'.$res['branchName'].'</option>';
				}
			}else{
				$data = $objM_customer->allBranch();
				while($res = mysqli_fetch_array($data)){
					if($id==$res['branchId']){
						$selected='selected';
					}else{
						$selected=null;
					}
					$selectBox .='<option value="'.$res['branchId'].'" '.$selected.'>'.$res['branchName'].'</option>';
				}
			}
			return $selectBox;
		}
	}
?>
