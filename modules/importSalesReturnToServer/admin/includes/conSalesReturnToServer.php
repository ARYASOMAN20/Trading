<?php

header('Content-Type: application/JSON');	
$con = mysqli_connect("localhost", "root", "", "vansale") or die("cannot connect");

if(isset($_GET['selectedInvoiceIds'])){
 $invoiceId1		=	$_GET['selectedInvoiceIds'];
 $arayexplode       =   explode(',',$invoiceId1);
 $printType1        = 	$_GET['referenceval'];
if(count($arayexplode)>0){
    
for($j=0;$j<count($arayexplode);$j++){
	$invoiceId='';
    $invoiceId  = $arayexplode[$j];
    
	$data=array();
// Check Connected Status
$query6 = "SELECT * FROM salesreturncountersale WHERE salesReturnItemWiseId='".$invoiceId."' AND connectedStatus=0";
$result6  = mysqli_query($con,$query6);
if ($result6) {
    // Get the number of rows
    $numRows = mysqli_num_rows($result6);
}

if($numRows==1)
{
   $query = "SELECT INV.*,customerName
                                FROM salesreturncountersale INV
                                INNER JOIN regularCustomer  ON regularCustomer.regularCustomerId=INV.regularCustomerId 
															
                                WHERE INV.salesReturnItemWiseId='".$invoiceId."'
                                AND INV.status=1
                                ORDER BY INV.salesReturnItemWiseId";
    $result  = mysqli_query($con,$query);


while ($dataFetchDetails = mysqli_fetch_array($result))
{
    $invoiceNo=$dataFetchDetails['salesReturnNo'];
    $invoiceId= $dataFetchDetails['invoiceId'];
    $invoiceNumericNo=$dataFetchDetails['numberSalesReturnNo'];
    $invoiceTime=$dataFetchDetails['returnInvoiceTime'];
    $regularCustomerId = $dataFetchDetails['regularCustomerId'];
    $deliveryNoteId = 0;
    $invoiceDate = $dataFetchDetails['salesReturnDate'];
    $poNo = 0;
    $quotationNo = 0;
    $currencyId = $dataFetchDetails['currencyId'];
    $totalAmount = $dataFetchDetails['totalAmount'];
    $discountId = 0;
    $discountAmount = $dataFetchDetails['discountInAmount'];
    $discountPercent = $dataFetchDetails['discountInPercent'];
    $totalAmountAfterDiscount = $dataFetchDetails['totalAfterDiscount'];
    $vatPercent = $dataFetchDetails['vatPercent'];
    $vatAmount = $dataFetchDetails['vatAmount'];
    $totalAmountWithVat = $dataFetchDetails['netAmount'];
    $exRate = $dataFetchDetails['exRate'];
    $netAmountWithExRate = $dataFetchDetails['netAmountWithExRate'];
    $round = $dataFetchDetails['round'];
    $roundAmount = $dataFetchDetails['roundAmount'];
    $transactionType = $dataFetchDetails['transactionType'];
    $damagedGoodsReturn = '';
    $damagedGoodsAmount = $dataFetchDetails['damagedGoodsAmount'];
    $cuttingCharge = 0;
    $customerName = $dataFetchDetails['customerName'];
    $customerPhone = '';
    $customerVatNo = '';
    $wholesaleOrRetail = '';
    $userId = $dataFetchDetails['userId'];
    $branchId = $dataFetchDetails['branchId'];
    $mainBranch = $dataFetchDetails['mainBranch'];
    $privilageId = $dataFetchDetails['privilageId'];
    $appStatus = $dataFetchDetails['appStatus'];
    $time = $dataFetchDetails['returnInvoiceTime'];
	$salesReturnItemWiseId= $dataFetchDetails['salesReturnItemWiseId'];
}

// Invoice Details

// Invoice Details
$query3 = "SELECT * FROM salesReturnCounterSaleDetails WHERE salesReturnItemWiseId='".$salesReturnItemWiseId."' AND status=1 ORDER BY salesReturnItemWiseDetailsId";
$result3  = mysqli_query($con,$query3);

while ($dataFetchDetails3 = mysqli_fetch_array($result3))
{
    $itemMasterId           =   $dataFetchDetails3['itemMasterId'];
    $stockId                =   $dataFetchDetails3['stockId'];
    $itemCode               =  '';
    $description            =  '';
    $itemUnitId             =   $dataFetchDetails3['itemUnitId'];
    $quantity               =   $dataFetchDetails3['quantityRow'];
    $netWeight              =   $dataFetchDetails3['netWeightRow'];
    $unitPrice              =   $dataFetchDetails3['unitPriceRow'];
    $vatPercent             =   $dataFetchDetails3['vatPercentage'];
    $vatAmountDetails       =   $dataFetchDetails3['vatAmount'];
    $discountId             =   0;
    $discountPercentDetails =   0;
    $discountAmountDetails  =   0;
    $amount                 =   $dataFetchDetails3['rowTotal'];
    $unitFraction           =   $dataFetchDetails3['unitFraction'];
    $amountWithVat          =   $dataFetchDetails3['rowTotalWithVat'];
	$amountAfterDiscount    =0;

    
    $data['invoiceBody'][] = array('itemMasterId'=>$itemMasterId,'stockId'=>$stockId,'itemCode'=>$itemCode,'description'=>$description,'itemUnitId'=>$itemUnitId,'quantity'=>$quantity,'netWeight'=>$netWeight,'unitPrice'=>$unitPrice,'vatPercent'=>$vatPercent,'vatAmountDetails'=>$vatAmountDetails,'discountId'=>$discountId,'discountPercentDetails'=>$discountPercentDetails,'discountAmountDetails'=>$discountAmountDetails,'amount'=>$amount,'amountAfterDiscount'=>$amountAfterDiscount,'amountWithVat'=>$amountWithVat,'unitFraction'=>$unitFraction);
}
   /* /// Stock
$query2 = "SELECT itemMasterId,barcode,expiryDate,stock_".$privilageId."_".$branchId." AS stockVal FROM stock WHERE itemMasterId='".$itemMasterId."'";
$result2  = mysqli_query($con,$query2);


while ($dataFetchDetails2 = mysqli_fetch_array($result2))
{
$itemMasterId   =   $dataFetchDetails2['itemMasterId']; 
$barcode        =   $dataFetchDetails2['barcode'];
$expiryDate     =   $dataFetchDetails2['expiryDate'];
$stockVal       =   $dataFetchDetails2['stockVal']; 

$data['stock'][] = array('itemMasterId'=>$itemMasterId,'barcode'=>$barcode,'expiryDate'=>$expiryDate,'stockVal'=>$stockVal,'privilageId'=>$privilageId,'branchId'=>$branchId);
}
// Stock
}
// Invoice Details

/// Account Journal
$query1 = "SELECT * FROM accountJournal
                    WHERE j_invoiceId='".$invoiceId."'
                    AND (j_referenceId=1 or j_referenceId=2)
                    ORDER BY j_id";
    $result1  = mysqli_query($con,$query1);


while ($dataFetchDetails1 = mysqli_fetch_array($result1))
{
    $j_debit             =   $dataFetchDetails1['j_debit'];
    $j_credit            =   $dataFetchDetails1['j_credit'];
    $j_account_id        =   $dataFetchDetails1['j_account_id'];
    $j_sub_account_id    =   $dataFetchDetails1['j_sub_account_id'];
    $j_particulars       =   $dataFetchDetails1['j_particulars'];
    $j_remarks           =   $dataFetchDetails1['j_remarks'];
    $j_dateOfPayment     =   $dataFetchDetails1['j_dateOfPayment'];
    $j_referenceId       =   $dataFetchDetails1['j_referenceId'];
    $j_invoiceId         =   $dataFetchDetails1['j_invoiceId'];
    $j_voucherNo         =   $dataFetchDetails1['j_voucherNo'];
    $j_narration         =   $dataFetchDetails1['j_narration'];
    $j_mainBranch        =   $dataFetchDetails1['j_mainBranch'];
    $j_branchId          =   $dataFetchDetails1['j_branchId'];
    $j_privillageId      =   $dataFetchDetails1['j_privillageId'];
    $j_userId            =   $dataFetchDetails1['j_userId'];

    
    $data['accountJournal'][] = array('j_debit'=>$j_debit,'j_credit'=>$j_credit,'j_account_id'=>$j_account_id,'j_sub_account_id'=>$j_sub_account_id,'j_particulars'=>$j_particulars,'j_remarks'=>$j_remarks,'j_dateOfPayment'=>$j_dateOfPayment,'j_referenceId'=>$j_referenceId,'j_invoiceId'=>$j_invoiceId,'j_voucherNo'=>$j_voucherNo,'j_narration'=>$j_narration,'j_mainBranch'=>$j_mainBranch,'j_branchId'=>$j_branchId,'j_privillageId'=>$j_privillageId,'j_userId'=>$j_userId);
}
// Account Journal
	
/// customerSalesPayment
$query4 = "SELECT * FROM customerSalesPayment WHERE invoiceId='".$invoiceId."' AND status=1 ORDER BY customerSalesPaymentId";
$result4  = mysqli_query($con,$query4);

while ($dataFetchDetails4 = mysqli_fetch_array($result4))
{
    $regularCustomerId1      =   $dataFetchDetails4['regularCustomerId'];
    $paymentModeId          =   $dataFetchDetails4['paymentModeId'];
    $chequeId               =   $dataFetchDetails4['chequeId'];
    $bankId                 =   $dataFetchDetails4['bankId'];
    $amountDate             =   $dataFetchDetails4['amountDate'];
    $receiptTime            =   $dataFetchDetails4['receiptTime'];
    $amountPaid             =   $dataFetchDetails4['amountPaid'];
    $totalAmount1            =   $dataFetchDetails4['totalAmount'];
    $remainingBalance       =   $dataFetchDetails4['remainingBalance'];
    $salesPaymentVoucherNo  =   $dataFetchDetails4['salesPaymentVoucherNo'];
    $userId                 =   $dataFetchDetails4['userId'];
    $privilageId            =   $dataFetchDetails4['privilageId'];
    $branchId               =   $dataFetchDetails4['branchId'];
    $mainBranch             =   $dataFetchDetails4['mainBranch'];
    $remarks                =   $dataFetchDetails4['remarks'];
    $appStatus              =   $dataFetchDetails4['appStatus'];
    $updatedStatus          =   $dataFetchDetails4['updatedStatus'];
    $openingBalanceStatus   =   $dataFetchDetails4['openingBalanceStatus'];
    $refNo                  =   $dataFetchDetails4['refNo'];
    $refId                  =   $dataFetchDetails4['refId'];
    $status                 =   $dataFetchDetails4['status'];

    
    $data['customerSalesPayment'][] = array('regularCustomerId'=>$regularCustomerId1,'paymentModeId'=>$paymentModeId,'chequeId'=>$chequeId,'bankId'=>$bankId,'amountDate'=>$amountDate,'receiptTime'=>$receiptTime,'amountPaid'=>$amountPaid,'totalAmount'=>$totalAmount1,'remainingBalance'=>$remainingBalance,'salesPaymentVoucherNo'=>$salesPaymentVoucherNo,'userId'=>$userId,'privilageId'=>$privilageId,'branchId'=>$branchId,'mainBranch'=>$mainBranch,'remarks'=>$remarks,'appStatus'=>$appStatus,'updatedStatus'=>$updatedStatus,'openingBalanceStatus'=>$openingBalanceStatus,'refNo'=>$refNo,'refId'=>$refId);
}
// customerSalesPayment
*/


    $data['invoiceHead'] = array('invoiceNo'=>$invoiceNo,'invoiceId'=>$invoiceId,'invoiceNumericNo'=>$invoiceNumericNo,'invoiceTime'=>$invoiceTime,'regularCustomerId'=>$regularCustomerId,'deliveryNoteId'=>$deliveryNoteId,'invoiceDate'=>$invoiceDate,'poNo'=>$poNo,'quotationNo'=>$quotationNo,'currencyId'=>$currencyId,'totalAmount'=>$totalAmount,'discountId'=>$discountId,'discountAmount'=>$discountAmount,'discountPercent'=>$discountPercent,'totalAmountAfterDiscount'=>$totalAmountAfterDiscount,'vatPercent'=>$vatPercent,'vatAmount'=>$vatAmount,'totalAmountWithVat'=>$totalAmountWithVat,'exRate'=>$exRate,'netAmountWithExRate'=>$netAmountWithExRate,'round'=>$round,'roundAmount'=>$roundAmount,'transactionType'=>$transactionType,'damagedGoodsReturn'=>$damagedGoodsReturn,'damagedGoodsAmount'=>$damagedGoodsAmount,'cuttingCharge'=>$cuttingCharge,'customerName'=>$customerName,'customerPhone'=>$customerPhone,'customerVatNo'=>$customerVatNo,'wholesaleOrRetail'=>$wholesaleOrRetail,'userId'=>$userId,'branchId'=>$branchId,'mainBranch'=>$mainBranch,'privilageId'=>$privilageId,'appStatus'=>$appStatus,'time'=>$time,'salesReturnItemWiseId'=>$salesReturnItemWiseId);


  //  echo "<br>----------------------<br>";
    //print_r($data);
  //  echo "<br>----------------------<br>";


    /// Check status for Already Connected Invoice
    // $query5 = "UPDATE invoice SET connectedStatus=1 WHERE invoiceId='".$invoiceId."'";
    // $result  = mysqli_query($con,$query5);
    /// Check status for Already Connected Invoice

    $query5 = "UPDATE salesreturncountersale SET connectedStatus=1 WHERE salesReturnItemWiseId='".$salesReturnItemWiseId."'";
    $result  = mysqli_query($con,$query5);

    // Call the function
    sendDataToServer($data);

    //new
    //sendDataToServer($data); // Get the message from the AI function
    //echo $responseMsg;
    //$_COOKIE['message'] = $message; // Store it in the session
    // header("location:http://localhost/modules/salesInvoiceConnect.php");
    header("location:http://".$_SERVER['HTTP_HOST']."/naf/assets/system/php/dashboard/welcome.php?page=salesReturnConnect");
    //exit();
}

else
{
    echo "<script> alert('Already Connected!!!'); </script>";
}
}
}

else
{
    echo "<script> alert('No Invoice Select!!!'); </script>";
}
}


function sendDataToServer($data) {
    $url = 'http://aadil1.info/soft/modules/api/saveSalesReturnDoing.php';
    $jsonData = json_encode($data);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonData)
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        echo 'Response:' . $response;
    }

    curl_close($ch);
}

?>