<?php
	
require_once("../../../../modules/counterSalesInvoice/admin/models/m_salesInvoice.php");
$objsalesInvoice = new M_salesInvoice();	

       
    $customerNo  = $objsalesInvoice->getmaxCustomerNo();
    $customer_Name      = $_POST['customerName'];
	$customer_Add       = $_POST['customerAddress'];
	$customer_Con1      = $_POST['contactNo_1'];
	$customer_Con2      = $_POST['contactNo_2'];
	$customerCode       =  $customerNo;//$_POST['customerCode'];
	$vatNumber          = $_POST['vatNumber'];

	$customerAddressArab  = $_POST['customerAddressArab'];
	$dueDate		    =	date("Y-m-d", strtotime($_POST['dueDate']));   

	$streetName         = $_POST['streetName'];
	$buildingNo         = $_POST['buildingNo'];
	$addlNo     	    = $_POST['addlNo'];
	$postalCode         = $_POST['postalCode'];
	$city      		    = $_POST['city'];
	$district      	    = $_POST['district'];
	$country     	    = $_POST['country'];

	$streetNameArab      = $_POST['streetArab'];
	$buildingNoArab      = $_POST['buildingNoArab'];
	$addlNoArab     	 = $_POST['addlNoArab'];
	$postalCodeArab      = $_POST['postalCodeArab'];
	$cityArab      		 = $_POST['cityArab'];
	$districtArab      	 = $_POST['districtArab'];
	$countryArab     	 = $_POST['countryArab'];
	$vatArab     	     = $_POST['vatArab'];
	$customerNameArab    = $_POST['customerNameArab'];
    $branchId            = $_POST['branchId'];
	$salesArea           = $_POST['salesArea'];

    $vesselCode         =   '';
	$creditPlanId       =   '0'; 
	$creditPlanName     =   '0'; 
	$creditLimit        =   '0';
	$profitItemDiscountPercent = '0';
	$openingReceiverAmount     = '0';

    $count  =  $objsalesInvoice->getCount($customerCode);
		
    if($count==0)
	{
        $regularCustomerId      =   $objsalesInvoice->insertCustomerName($customer_Name,$customer_Add,$branchId,$customer_Con1,$customer_Con2,$creditPlanId,$creditLimit,$profitItemDiscountPercent,$openingReceiverAmount,$vatNumber,$vesselCode,$dueDate,$salesArea,$customerCode,$customerAddressArab,$streetName,$buildingNo,$addlNo,$postalCode,$city,$district,$country,$streetNameArab,$buildingNoArab,$addlNoArab,$postalCodeArab,$cityArab,$districtArab,$countryArab,$vatArab,$customerNameArab);

        $secondLevelAccountId   = $objsalesInvoice->getSecondaryAccountId($branchId);
        $thirdLevelAccountId    = $objsalesInvoice->getThirdAccountId($salesArea);
        $subaccountNo           = $objsalesInvoice->getMaxSubAccountNo();

        $ins_subAccountHead     =   $objsalesInvoice->insertSubAccountHeadName($customer_Name,$regularCustomerId,$secondLevelAccountId,$thirdLevelAccountId,$subaccountNo);
		
		 	$data['result']= "1";
			
		}else{

            $data['result']= "0"; 	
			
	
		}
		
	
		$getCustomerName=$objsalesInvoice->getCustomerName($regularCustomerId);
		while ($getCustomerNameList = mysqli_fetch_array($getCustomerName)){
			$customerNo     =   $getCustomerNameList['customerNo'];
		 	$customerName   =   $getCustomerNameList['customerName'];
             $vatNumber     =   $getCustomerNameList['vatNumber'];
             $contactNo_1   =   $getCustomerNameList['contactNo_1'];
		 }	
		    $data['customerNo']         =   $customerNo;
		    $data['customerName']       =   $customerName;
		    $data['regularCustomerId']  =   $regularCustomerId;
            $data['vatNumber']          =   $vatNumber;
            $data['contactNo_1']        =   $contactNo_1;

            

		
		echo json_encode($data);
 

?>