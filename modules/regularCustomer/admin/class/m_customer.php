<?php
require_once("../../../../settings/connect_db.php");
require_once("../../../../modules/regularCustomer/admin/controller/c_customer.php");
	class M_customer{
		// new
		// add customer
		function getMaxCustomerNo()
		{
			global $con;
			$query ='SELECT IFNULL((MAX(customerNo)+1),1)AS customerNo FROM  regularCustomer WHERE salesAreaBranchId=5';
			$result = mysqli_query($con,$query);
			while($row=mysqli_fetch_array($result))
			{
				$customerNo	=	$row['customerNo'];
			}
			return  $customerNo;
		}
		// new ends
		function listCustomerLimit(){
			global $con;
	    	$query   = "SELECT R.regularCustomerId, R.customerName, R.address, R.contactNo_1, R.contactNo_2, 
			                   R.customerNo,R.creditLimit,R.profitItemDiscountPercent,
							   R.currentBalanceReceiverAmount,R.vatNumber,R.dueDate,R.registeredBranchId,R.salesAreaBranchId
						FROM regularCustomer R
						left join branch B on R.salesAreaBranchId = B.branchId WHERE R.status=1
						ORDER BY R.regularCustomerId DESC LIMIT 500";
			$result  = mysqli_query($con,$query);
			return $result;
		}
		
		
		function listCustomerLimitForBranch($branch){
			global $con;
	    	$query   = "SELECT R.regularCustomerId, R.customerName, R.address, R.contactNo_1, R.contactNo_2, 
			                   R.customerNo,R.creditLimit,R.profitItemDiscountPercent,
							   R.currentBalanceReceiverAmount,R.vatNumber,R.dueDate,B.branchName,R.registeredBranchId,R.salesAreaBranchId
						FROM regularCustomer R
						left join branch B on R.salesAreaBranchId = B.branchId
						where R.salesAreaBranchId ='".$branch."' AND R.status=1
						ORDER BY R.regularCustomerId DESC";
			$result  = mysqli_query($con,$query);
			return $result;
		}
		
		
		function listCustomer(){
			global $con;
	    	$query   = "SELECT regularCustomerId, customerName, address, contactNo_1, contactNo_2, customerNo,vatNumber FROM 
						regularCustomer";
			$result  = mysqli_query($con,$query);
			return $result;
		}
		
		function insertCustomerName($customer_Name,$customer_Add,$branchId,$customer_Con1,$customer_Con2,
		                            $creditPlanId,$creditLimit,$profitItemDiscountPercent,$openingReceiverAmount,$vatNumber,$vesselCode,$dueDate,$salesArea,$customerCode,
				$customerAddressArab,$streetName,$buildingNo,$addlNo,$postalCode,$city,$district,$country,
				$streetNameArab,$buildingNoArab,$addlNoArab,$postalCodeArab,$cityArab,$districtArab,$countryArab,$vatArab,$customerNameArab){
			global $con;
			//echo $customerNo = $this ->incrementCustomerNo();
		 	$query    = "INSERT INTO regularCustomer (customerNo, customerName, address, registeredBranchId, contactNo_1,contactNo_2,
						creditPlanId,creditLimit,profitItemDiscountPercent,openingReceiverAmount,currentBalanceReceiverAmount,vatNumber,dueDate,salesAreaBranchId,
						customerNameArabic,addressArabic,vatNoArabic,streetName,streetArabic,buildingNo,buildingArabic,addlNo,
						addlNoArabic,postalCode,postalArabic,city,cityArabic,district,districtArabic,country,countryArabic)
			   			values
                           ('".$customerCode."',
							 '".$customer_Name."',
							 '".$customer_Add."',
							 '".$branchId."',
							 '".$customer_Con1."',
							 '".$customer_Con2."',
							 '".$creditPlanId."',
							 '".$creditLimit."',
							 '".$profitItemDiscountPercent."',
							 '".$openingReceiverAmount."',
							 '".$openingReceiverAmount."',
							 '".$vatNumber."',
							 '".$dueDate."',
							 '".$salesArea."',
							 '".$customerNameArab."',
							 '".$customerAddressArab."',
							 '".$vatArab."',
							 '".$streetName."',
							 '".$streetNameArab."',
							 '".$buildingNo."',
							 '".$buildingNoArab."',
							 '".$addlNo."',
							 '".$addlNoArab."',
							 '".$postalCode."',
							 '".$postalCodeArab."',
							 '".$city."',
							 '".$cityArab."',
							 '".$district."',
							 '".$districtArab."',
							 '".$country."',
							 '".$countryArab."'
							 )";
		  	 $result   = mysqli_query($con,$query);
			 $lastid = mysqli_insert_id($con);
			 return $lastid;		  
		}
		
		function profitItemDiscountPercent($customerId){
			global $con;
	    	$query   = 	"SELECT customerNo,customerName,profitItemDiscountPercent
			               FROM regularCustomer 
						   WHERE regularCustomerId = '".$customerId."'";
			$result  = mysqli_query($con,$query);
			return $result;
		}
		 function listCustomerEdit($customerId){
			global $con;
	    	$query   = 	"SELECT *
			               FROM regularCustomer 
						   WHERE regularCustomerId = '".$customerId."'";
			$result  = mysqli_query($con,$query);
			return $result;
		}
		function updateCustomerItemDiscount($customerId,$profitItemDiscountPercent){
			global $con;
	    	$query   =   "UPDATE regularCustomer 
						 SET profitItemDiscountPercent='".$profitItemDiscountPercent."'
						 WHERE regularCustomerId='".$customerId."'";
			$result  = mysqli_query($con,$query);
			return $result;
		}
		 function updateCustomerEdit($customerId, $customerName, $customerAdd,$branchId, $customerCon1, $customerCon2,
		                             $creditPlanId,$creditLimit,$vatNumber,$dueDate,$salesArea,$customerCode,
									 $streetName,
									 $buildingNo ,
									 $addlNo,
									 $postalCode,
									 $city ,
									 $district, 
									 $country,
									 $streetNameArab,
									 $buildingNoArab,
									 $addlNoArab,
									 $postalCodeArab,
									 $cityArab ,
									 $districtArab,
									 $countryArab,
									 $vatArab  ,
									 $customerNameArab,$customerAddressArab){
			global $con;
	    	$query   =   "UPDATE regularCustomer 
						 SET customerName='".$customerName."', address='".$customerAdd."',
						     contactNo_1='".$customerCon1."', contactNo_2='".$customerCon2."',
							 creditPlanId='".$creditPlanId."', creditLimit='".$creditLimit."',
							  vatNumber='".$vatNumber."' ,dueDate='".$dueDate."',registeredBranchId='".$branchId."',
							  salesAreaBranchId='".$salesArea."',customerNo='".$customerCode."',
							  vatNoArabic='".$vatArab."', customerNameArabic='".$customerNameArab."',
							  vatNumber='".$vatNumber."' ,
							  streetName='".$streetName."',
							  streetArabic='".$streetNameArab."',
							  buildingNo='".$buildingNo."',
							  buildingArabic='".$buildingNoArab."',
							  addlNo='".$addlNo."',addlNoArabic='".$addlNoArab."',postalCode='".$postalCode."',
							  postalArabic='".$postalCodeArab."',city='".$city."',
							  cityArabic='".$cityArab."',district='".$district."',
							  districtArabic='".$districtArab."',country='".$country."',
							  countryArabic='".$countryArab."',addressArabic='".$customerAddressArab."'
						 WHERE regularCustomerId='".$customerId."'";
						
			$result  = mysqli_query($con,$query);
		
			return $result;
		}
		function listCreditPlanForCustomer(){
			global $con;
	    	$query   = "SELECT creditPlanId,creditPlanName, planForVendorOrCustomer
			            FROM creditPlan
						WHERE planForVendorOrCustomer='c'";
			$result  = mysqli_query($con,$query);
			return $result;
		}
		function showCreditPlanName($creditPlanId){
			global $con;
	    	$query   = "SELECT creditPlanName
			            FROM creditPlan
						WHERE creditPlanId='".$creditPlanId."'";
			$result  = mysqli_query($con,$query);
			return $result;
		}
		 function currentBalanceList($fromDate,$toDate,$customerId){
			global $con;
	    	$query   = 	"SELECT CR.amountdate,IFNULL(SUM(CR.amount),0) AS amount, R.customerNo, R.customerName, 
			                      R.currentBalanceReceiverAmount
			               FROM currentBalanceCustomerTrack CR,regularCustomer R
						   WHERE CR.regularCustomerId = '".$customerId."'
						   AND CR.regularCustomerId = R.regularCustomerId
						   AND CR.amountdate BETWEEN '".$fromDate."' AND '".$toDate."'  
						   GROUP BY CR.amountdate ";
			$result  = mysqli_query($con,$query);
			return $result;
		}
		function insertSubAccountHeadName($customer_Name,$ins_CustomerDetails,$secondLevelAccountId,$thirdLevelAccountId,$subaccountNo)
		{
		   	global $con;
			//echo $customerNo = $this ->incrementCustomerNo();
		 	$query = "INSERT INTO subAccountHead (accountHeadId,primaryAccountHeadId,subAccountHeadName,subAccountClientId,status,secondLevelAccountHeadId,thirdLevelAccountHeadId,subAccountNo) 
					values('1','2',
					'".$customer_Name."',
					'".$ins_CustomerDetails."',
					'0',
					'".$secondLevelAccountId."',
					'".$thirdLevelAccountId."',
					'".$subaccountNo."')";	
				 $result   = mysqli_query($con,$query);
				 return $result;
		}
		function updateSubAccountName($customerName,$customerId,$secondLevelAccountId,$thirdLevelAccountId)
		{
		   	global $con;
			$query="UPDATE subAccountHead 
					SET subAccountHeadName='".$customerName."',secondLevelAccountHeadId='".$secondLevelAccountId."',thirdLevelAccountHeadId='".$thirdLevelAccountId."'
					WHERE 	subAccountClientId='".$customerId."'";	
				 $result   = mysqli_query($con,$query);
				// print_r($query);
				 //return $result;
		}			

		public function customerCodeCheck($customerCode)
		{		global $con;	
		$query  = "SELECT customerNo FROM regularCustomer WHERE customerNo='".$customerNo."'"  ;
		$result = mysqli_query($con, $query);	
		$customerNo=mysqli_fetch_array($result);	
		if( $customerNo==NULL)		{		
		echo('PROSEED');			}	
		else{			
		echo('CUSTOMER CODE  EXIST');		
		}				
		}
		
		public function allBranch()
		{		
			global $con;	
			$query  = "SELECT * FROM branch WHERE status='1'" ;
			$result = mysqli_query($con, $query);	
			return $result;	
		
		}
		
		function getSalesArea($branchId){
			global $con;	
			$query  = "SELECT branchName,branchId FROM branch WHERE status='1' and (privillageId='3'  or privillageId='2' or privillageId='6' ) and mainBranch='".$branchId."'" ;
			$result = mysqli_query($con, $query);	
			return $result;	
			
		}
		
		function getCount($customerCode){
			global $con;	
		$query  = "SELECT customerNo FROM regularCustomer WHERE customerNo='".$customerCode."'"  ;
		$result = mysqli_query($con, $query);	
		return mysqli_num_rows($result);
		}
		function getCounts($customerCode,$customerId)
		{
			global $con;	
		$query  = "SELECT customerNo FROM regularCustomer WHERE customerNo='".$customerCode."' and regularCustomerId!='".$customerId."'"  ;
		$result = mysqli_query($con, $query);	
		return mysqli_num_rows($result);
			
		}
		
		function getSalesAreaName($salesAreaBranchId){
			global $con;	
		$query  = "SELECT branchName FROM branch WHERE branchId='".$salesAreaBranchId."'"  ;
		$result = mysqli_query($con, $query);	
		$branchName=mysqli_fetch_array($result);	
			$name=$branchName['branchName'];
	    return $name;		
			
		}
		
		function getCustomer(){
			
			global $con;
	    	$query   = 	"SELECT *
			               FROM regularCustomer 
						   ";
			$result  = mysqli_query($con,$query);
			return $result;
		}
		
	function getSecondaryAccountId($branch){
		global $con;
		$secondLevelAccountHeadId='';
		$query ='SELECT secondLevelAccountHeadId
			FROM  secondLevelAccountHead
			WHERE mainBranchId="'.$branch.'"';
			
	    $result  = mysqli_query($con,$query);
		while($secondAccountId=mysqli_fetch_array($result))
		{
			$secondLevelAccountHeadId = $secondAccountId['secondLevelAccountHeadId'];
		}
		return $secondLevelAccountHeadId;
	}
	
	function getThirdAccountId($salesAreaBranchId){
		
			global $con;
		$thirdLevelAccountHeadId='';
		$query ='SELECT thirdLevelAccountHeadId
			FROM  thirdLevelAccountHead
			WHERE sealAreaId="'.$salesAreaBranchId.'"';
			
	    $result  = mysqli_query($con,$query);
		while($secondAccountId=mysqli_fetch_array($result))
		{
			$thirdLevelAccountHeadId = $secondAccountId['thirdLevelAccountHeadId'];
		}
		return $thirdLevelAccountHeadId;
		
		
		
	}
	
	function updateSubaccountTbl($secondLevelAccountId,$thirdLevelAccountId,$regularCustomerId)
	{
		global $con;
		$query='update subAccountHead set secondLevelAccountHeadId="'.$secondLevelAccountId.'",thirdLevelAccountHeadId="'.$thirdLevelAccountId.'" where subAccountClientId="'.$regularCustomerId.'"';
		$set=mysqli_query($con,$query); 
		
	}
	
	function getMaxSubAccountNo(){
		$subAccountNo='';
		global $con;
		$thirdLevelAccountHeadId='';
		$query ='SELECT MAX(subAccountNo) AS subAccountNo
			FROM  subAccountHead
			';
			
	    $result  = mysqli_query($con,$query);
		while($secondAccountId=mysqli_fetch_array($result))
		{
			$subAccountNo = $secondAccountId['subAccountNo'];
		}
		return $subAccountNo = $subAccountNo+1;
		
	}

	function getEntryOfCustomer($customerId){
	    
	    $subAccountData     = $this->getSubacountId($customerId);
	    $subAccountHeadId   = $subAccountData['subAccountHeadId'];
	    global $con; 
		 $query = "SELECT j_id
				  FROM  accountJournal 
				  WHERE j_sub_account_id = '".$subAccountHeadId."' 
				 ";
			  
		$result = mysqli_query($con,$query);
		$numrows	=	mysqli_num_rows($result);
		return  $numrows;
	}
	
	function deleteCustomer($regularCustomerId){
	    	global $con;
		$query='update regularCustomer set status=0 where regularCustomerId="'.$regularCustomerId.'"';
		$set=mysqli_query($con,$query);
		
	}

	function getSubacountId($regularCustomerId){
	    
	    global $con;
		  $query = "SELECT subAccountHeadId  
				   FROM    subAccountHead 
				   WHERE subAccountClientId='".$regularCustomerId."'
				  ";		  
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
			$subAccountHead_detail=mysqli_fetch_array($result);	
		return $subAccountHead_detail;	
	}
	}
?>
