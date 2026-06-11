<?php

require_once('../../../../modules/regularCustomer/admin/class/customerVoucherModel.php');
include_once("../../../../libraries/class/constants.php");
require_once('../../../../modules/accounts/admin/class/mAccount.php');
require_once("../../../../settings/path.php");

$objCustomerVoucherModel = new customerVoucherModel();
$objPath                     = new Path();
//require('../../../../libraries/class/utils.php');
//$objUtils       = new Utils();

class customerVoucherController
{
    function searchByCustomerId($customerId)
    {
        global $objCustomerVoucherModel;
        
        $currentBalanceReceiverAmount              = '';
       
        $resSearchByCustomerId = $objCustomerVoucherModel->searchByCustomerId($customerId);
        if (mysqli_num_rows($resSearchByCustomerId) > 0) {
            if ($customerDetails = mysqli_fetch_array($resSearchByCustomerId)) {
                $currentBalanceReceiverAmount         = $customerDetails['currentBalanceReceiverAmount'];
				$regularCustomerId         = $customerDetails['regularCustomerId'];
               
            }
        } else {
            //    header("Location: ../../../../modules/schoolMaster/readmission/includes/readmission.php?message=Invalid Admission No");
            //echo "No Data";
           // $objPath->setHeader('readmission', 'Invalid Admission No', 'schoolMaster');
        }
        return array(
            'currentBalanceReceiverAmount' => $currentBalanceReceiverAmount,
			'regularCustomerId' => $regularCustomerId
           
        );
    }
	
	
	
	
	function saveCustomerDetails($customerName,$regularCustomerId, $currentBalanceReceiverAmount, $amount, $formatedDate)
	{
		global $objPath;
		global $objCustomerVoucherModel;
		
		$objM_account  			= new M_account();
		
		$debitAccountCustomerId = ACC_DEFAULT_CASH;
		$creditAccountCustomerId = $objM_account->getAccountRegisterId($customerName);
		$remarks='';
		$entryType = ACC_JOURNAL_ENTRY_TYPE_PAY_TO_VENDOR;
		$userId =1;
		
		 if($currentBalanceReceiverAmount >= $amount)
	 	{
			
			$resJournal = $objM_account->insertJournalAndUpdateAccountregister($creditAccountCustomerId,$debitAccountCustomerId,$amount,$formatedDate,$remarks,$entryType,$userId);
               
		
		 	$currentBalance=$currentBalanceReceiverAmount - $amount;
		 
		 	$objCustomerVoucherModel->updateCustomerDetails($regularCustomerId, $currentBalance);
			$objCustomerVoucherModel->saveCustomerDetails($regularCustomerId, $amount, $formatedDate);
		    $message		= "SUCCESS";
			$objPath->setHeader('customerVoucher', $message);
		 	//echo '<font color="#00CC33"><b>SUCCESS</b></font>';
		}
		else
		{
			echo '<font color="#FF0000"><b><i> Please Check Balance Amount</i></b></font>';	
		}
	}
	

	
}
?>