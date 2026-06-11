<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Handle preflight request
    header("HTTP/1.1 200 OK");
    exit();
}

header('Content-Type: application/json');

// Database connection settings
$host = 'localhost';
$db = 'aadil1_vansale'; // Replace with your database name
$user = 'aadil1_vansale'; // Replace with your database username
$pass = 'cyanuser123'; // Replace with your database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle database connection error
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit();
}

// Get the raw POST data
$input = file_get_contents('php://input');

// Log the raw input for debugging (optional)
file_put_contents('php://stderr', print_r($input, TRUE));

// Decode the JSON data
$data = json_decode($input, true);

if (json_last_error() === JSON_ERROR_NONE) {
    // Log the decoded data for debugging (optional)
    file_put_contents('php://stderr', print_r($data, TRUE));

    try {
        // Begin a transaction
        $pdo->beginTransaction();
   
    /// SET MAXIMUM INVOICE NUMBER START--------

    $privilageId = $data['invoiceHead']['privilageId'];
    $branchId    = $data['invoiceHead']['branchId'];

    global $con;
    $query5 = "SELECT MAX(invoiceNumericNo) as maxOfInvoiceNo FROM invoice WHERE branchId=".$branchId." AND privilageId=".$privilageId." AND status='1'";

// Check the values of $branchId and $privilageId
echo "branchId: $branchId, privilageId: $privilageId<br>";

// Prepare the query
$stmt = $pdo->prepare($query5);
$stmt->bindParam(':branchId', $branchId);
$stmt->bindParam(':privilageId', $privilageId);

// Execute the query
$stmt->execute();

// Fetch the result
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Debug output
echo "<pre>";
print_r($result);
echo "</pre>";

// Check the result and `maxOfInvoiceNo` key
if ($result && isset($result['maxOfInvoiceNo'])) {
    $maxOfInvoiceNo = $result['maxOfInvoiceNo'];
    $maxInvoiceNo = $maxOfInvoiceNo + 1;
} else {
    $maxInvoiceNo = 1;
}

    /// Get BranchCode
    $query6 = "SELECT salesmanCode 
    FROM branch WHERE branchId = :branchId AND privillageId = :privilageId";

        $stmt = $pdo->prepare($query6);
        $stmt->bindParam(':branchId', $branchId);
        $stmt->bindParam(':privilageId', $privilageId);
        $stmt->execute();

        $resultBranch = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultBranch) {
            $branchCode = $resultBranch['salesmanCode'];
        }

    /// Get BranchCode

    $invoiceNo	=	$branchCode.'/INV/'.$maxInvoiceNo;

    // echo "Next Invoice Number: " . $invoiceNo;
    // die("ënded");

    /// SET MAXIMUM INVOICE NUMBER ENDS----------


    /// SET MAXIMUM VOUCHER NUMBER FOR CUSTOMER SALES PAYMENT START--------

    $privilageId = $data['invoiceHead']['privilageId'];
    $branchId    = $data['invoiceHead']['branchId'];

    global $con;
    $query6 = "SELECT IFNULL(MAX(salesPaymentVoucherNo)+1,1) AS salesPaymentVoucherNo  
				   FROM    customerSalesPayment 
				    where privilageId='".$privilageId."' AND  branchId='".$branchId."'";

// Check the values of $branchId and $privilageId
//echo "branchId: $branchId, privilageId: $privilageId<br>";

// Prepare the query
$stmt = $pdo->prepare($query6);
$stmt->bindParam(':branchId', $branchId);
$stmt->bindParam(':privilageId', $privilageId);

// Execute the query
$stmt->execute();

// Fetch the result
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Debug output
echo "<pre>";
print_r($result);
echo "</pre>";

// Check the result and `maxOfInvoiceNo` key
if ($result) {
    $salesPaymentVoucherNo = $result['salesPaymentVoucherNo'];
   
} else {
    $salesPaymentVoucherNo = 1;
}

$exRate  = $data['invoiceHead']['exRate'];
$totalCostValue =0;

$netAmountWithExRateAcc 	= 	number_format(($exRate*$data['invoiceHead']['totalAmountAfterDiscount']),2,'.','');
		$totalAmountWithExRateAcc 	=	number_format(($exRate*($data['invoiceHead']['totalAmount']-$data['invoiceHead']['damagedGoodsAmount'])),2,'.','');
		$vatAmountWithExRateAcc 	=	number_format(($exRate*$data['invoiceHead']['vatAmount']),2,'.','');
		$discountWithExRateAcc 		=	number_format(($exRate*$data['invoiceHead']['discountAmount']),2,'.','');
		$totalAmountWithVatWithExRate =  number_format(($exRate*$data['invoiceHead']['totalAmountWithVat']),2,'.','');
 

    /// SET MAXIMUM VOUCHER NUMBER FOR CUSTOMER SALES PAYMENT ENDS----------

        // Insert data into the invoice table
        $stmtInvoice = $pdo->prepare("
            INSERT INTO invoice (
                invoiceNo, invoiceNoRef, invoiceNumericNo, invoiceTime, regularCustomerId, deliveryNoteId, 
                invoiceDate, poNo, quotationNo, currencyId, totalAmount, discountId, discountAmount, 
                discountPercent, totalAmountAfterDiscount, vatPercent, vatAmount, totalAmountWithVat, 
                exRate, netAmountWithExRate, round, roundAmount, transactionType, damagedGoodsReturn, 
                damagedGoodsAmount, cuttingCharge, customerName, customerPhone, customerVatNo, 
                wholesaleOrRetail, userId, branchId, mainBranch, privilageId, appStatus, time
            ) VALUES (
                :invoiceNo, :invoiceNoRef, :invoiceNumericNo, :invoiceTime, :regularCustomerId, :deliveryNoteId, 
                :invoiceDate, :poNo, :quotationNo, :currencyId, :totalAmount, :discountId, :discountAmount, 
                :discountPercent, :totalAmountAfterDiscount, :vatPercent, :vatAmount, :totalAmountWithVat, 
                :exRate, :netAmountWithExRate, :round, :roundAmount, :transactionType, :damagedGoodsReturn, 
                :damagedGoodsAmount, :cuttingCharge, :customerName, :customerPhone, :customerVatNo, 
                :wholesaleOrRetail, :userId, :branchId, :mainBranch, :privilageId, :appStatus, :time
            )
        ");

        // Bind parameters for invoice table
        $stmtInvoice->bindParam(':invoiceNo', $invoiceNo);
        $stmtInvoice->bindParam(':invoiceNoRef', $data['invoiceHead']['invoiceNo']);
        $stmtInvoice->bindParam(':invoiceNumericNo', $maxInvoiceNo);
        $stmtInvoice->bindParam(':invoiceTime', $data['invoiceHead']['invoiceTime']);
        $stmtInvoice->bindParam(':regularCustomerId', $data['invoiceHead']['regularCustomerId']);
        $stmtInvoice->bindParam(':deliveryNoteId', $data['invoiceHead']['deliveryNoteId']);
        $stmtInvoice->bindParam(':invoiceDate', $data['invoiceHead']['invoiceDate']);
        $stmtInvoice->bindParam(':poNo', $data['invoiceHead']['poNo']);
        $stmtInvoice->bindParam(':quotationNo', $data['invoiceHead']['quotationNo']);
        $stmtInvoice->bindParam(':currencyId', $data['invoiceHead']['currencyId']);
        $stmtInvoice->bindParam(':totalAmount', $data['invoiceHead']['totalAmount']);
        $stmtInvoice->bindParam(':discountId', $data['invoiceHead']['discountId']);
        $stmtInvoice->bindParam(':discountAmount', $data['invoiceHead']['discountAmount']);
        $stmtInvoice->bindParam(':discountPercent', $data['invoiceHead']['discountPercent']);
        $stmtInvoice->bindParam(':totalAmountAfterDiscount', $data['invoiceHead']['totalAmountAfterDiscount']);
        $stmtInvoice->bindParam(':vatPercent', $data['invoiceHead']['vatPercent']);
        $stmtInvoice->bindParam(':vatAmount', $data['invoiceHead']['vatAmount']);
        $stmtInvoice->bindParam(':totalAmountWithVat', $data['invoiceHead']['totalAmountWithVat']);
        $stmtInvoice->bindParam(':exRate', $data['invoiceHead']['exRate']);
        $stmtInvoice->bindParam(':netAmountWithExRate', $data['invoiceHead']['netAmountWithExRate']);
        $stmtInvoice->bindParam(':round', $data['invoiceHead']['round']);
        $stmtInvoice->bindParam(':roundAmount', $data['invoiceHead']['roundAmount']);
        $stmtInvoice->bindParam(':transactionType', $data['invoiceHead']['transactionType']);
        $stmtInvoice->bindParam(':damagedGoodsReturn', $data['invoiceHead']['damagedGoodsReturn']);
        $stmtInvoice->bindParam(':damagedGoodsAmount', $data['invoiceHead']['damagedGoodsAmount']);
        $stmtInvoice->bindParam(':cuttingCharge', $data['invoiceHead']['cuttingCharge']);
        $stmtInvoice->bindParam(':customerName', $data['invoiceHead']['customerName']);
        $stmtInvoice->bindParam(':customerPhone', $data['invoiceHead']['customerPhone']);
        $stmtInvoice->bindParam(':customerVatNo', $data['invoiceHead']['customerVatNo']);
        $stmtInvoice->bindParam(':wholesaleOrRetail', $data['invoiceHead']['wholesaleOrRetail']);
        $stmtInvoice->bindParam(':userId', $data['invoiceHead']['userId']);
        $stmtInvoice->bindParam(':branchId', $data['invoiceHead']['branchId']);
        $stmtInvoice->bindParam(':mainBranch', $data['invoiceHead']['mainBranch']);
        $stmtInvoice->bindParam(':privilageId', $data['invoiceHead']['privilageId']);
        $stmtInvoice->bindParam(':appStatus', $data['invoiceHead']['appStatus']);
        $stmtInvoice->bindParam(':time', $data['invoiceHead']['time']);
        // Execute the statement for invoice table
        $stmtInvoice->execute();
        
        // Get the last inserted invoice ID
        $invoiceId = $pdo->lastInsertId();

        // Prepare the INSERT statement for invoiceDetails table
        $stmtDetails = $pdo->prepare("
            INSERT INTO invoiceDetails (
                invoiceId, itemMasterId, stockId, itemCode, description, itemUnitId, quantity, netWeight, unitPrice, vatPercent, vatAmount, discountId, discountPercent, discountAmount, amount, amountAfterDiscount, amountWithVat
            ) VALUES (
                :invoiceId, :itemMasterId, :stockId, :itemCode, :description, :itemUnitId, 
                :quantity, :netWeight, :unitPrice, :vatPercent, :vatAmount, :discountId, 
                :discountPercent, :discountAmount, :amount, :amountAfterDiscount, :amountWithVat
            )
        ");
		
		// Prepare the INSERT statement for itemTransferDetails  table
        $itemTransferDetails = $pdo->prepare("
            INSERT INTO itemTransferDetails(
                invoiceDetailsId,date,transactionNo,vendorOrCustomerName, itemMasterId, stockId, itemUnitId,quantity, totalQuanity, expiryDate, transactionType, type, branchId, privilageId, mainBranch, stockStatus, remainingStock, userId
            ) VALUES (
                :invoiceDetailsId,:date,:transactionNo,:vendorOrCustomerName, :itemMasterId, :stockId, :itemUnitId, :quantity,
                :totalQuanity, :expiryDate, :transactionType, :type, :branchId, :privilageId, 
                :mainBranch, :stockStatus, :remainingStock, :userId
            )
        ");

        // Iterate through each row in invoiceBody and insert rows into invoiceDetails table
        foreach ($data['invoiceBody'] as $item) {
            // Bind parameters for invoiceDetails table
            $stmtDetails->bindParam(':invoiceId', $invoiceId);
            $stmtDetails->bindParam(':itemMasterId', $item['itemMasterId']);
            $stmtDetails->bindParam(':stockId', $item['stockId']);
            $stmtDetails->bindParam(':itemCode', $item['itemCode']);
            $stmtDetails->bindParam(':description', $item['description']);
            $stmtDetails->bindParam(':itemUnitId', $item['itemUnitId']);
            $stmtDetails->bindParam(':quantity', $item['quantity']);
            $stmtDetails->bindParam(':netWeight', $item['netWeight']);
            $stmtDetails->bindParam(':unitPrice', $item['unitPrice']);
            $stmtDetails->bindParam(':vatPercent', $item['vatPercent']);
            $stmtDetails->bindParam(':vatAmount', $item['vatAmountDetails']); // Adjusted to match your data structure
            $stmtDetails->bindParam(':discountId', $item['discountId']);
            $stmtDetails->bindParam(':discountPercent', $item['discountPercentDetails']); // Adjusted to match your data structure
            $stmtDetails->bindParam(':discountAmount', $item['discountAmountDetails']); // Adjusted to match your data structure
            $stmtDetails->bindParam(':amount', $item['amount']);
            $stmtDetails->bindParam(':amountAfterDiscount', $item['amountAfterDiscount']);
            $stmtDetails->bindParam(':amountWithVat', $item['amountWithVat']);

            // Execute the statement for each item in invoiceDetails table
            $stmtDetails->execute();
        
		 $invoiceDetailId = $pdo->lastInsertId();
		
		 

       
			
	//check stockid exist or not
	
	/* $querystock = "SELECT stockId 
					FROM stock WHERE stockId = :stockId";

        $stmt = $pdo->prepare($querystock);
        $stmt->bindParam(':stockId', $item['stockId']);
       
        $stmt->execute();
		$rows = $stmt->fetchAll();
        $num_rows = count($rows);	
		if($num_rows==0){
						
		// Iterate through each row in stock and insert rows into stock table
				foreach ($data['stock'] as $item3) {
					// Get privilageId and branchId from $item3 within the loop
					$privilageId = $item3['privilageId'];
					$branchId = $item3['branchId'];
					
					// Construct the column name dynamically
					$columnName = "stock_" . $privilageId . "_" . $branchId;
					
					// Prepare the INSERT statement for stock table
					$stmtstock = $pdo->prepare("
						INSERT INTO stock (
							itemMasterId, barcode, expiryDate, $columnName
						) VALUES (
							:itemMasterId, :barcode, :expiryDate, :stockVal
						)
					");
					
					// Bind parameters for stock table
					$stmtstock->bindParam(':itemMasterId', $item3['itemMasterId']);
					$stmtstock->bindParam(':barcode', $item3['barcode']);
					$stmtstock->bindParam(':expiryDate', $item3['expiryDate']);
					$stmtstock->bindParam(':stockVal', $item3['stockVal']);
					
					// Execute the statement for this item in stock table
					$stmtstock->execute();
				}
			
		}else{*/
		// Construct the column name dynamically
			$columnName = "stock_" . $privilageId . "_" . $branchId;
			$newStockName = $item['netWeight'];
			$updateQuery = "UPDATE stock SET  $columnName = $columnName - :decreaseAmount   WHERE stockId = :stockId";

			$stmt = $pdo->prepare($updateQuery);
			$stmt->bindParam(':decreaseAmount', $newStockName);
			$stmt->bindParam(':stockId', $item['stockId']);

			$stmt->execute();
		//}
		
		$columnName = "stock_" . $privilageId . "_" . $branchId;
		 $getstockval = "SELECT $columnName as stockval
                         FROM stock WHERE stockId = :stockId";

        $stmt1 = $pdo->prepare($getstockval);
        $stmt1->bindParam(':stockId',$item['stockId']);
       
        $stmt1->execute();

        $resultBranch = $stmt1->fetch(PDO::FETCH_ASSOC);

        if ($resultBranch) {
            $stockval = $resultBranch['stockval'];
        }
	$itemMasterId= $item['itemMasterId'];
		
	 // Iterate through each row in invoiceBody and insert rows into itemTransferDetails table
       
            // Bind parameters for itemTransferDetails table
            $itemTransferDetails->bindParam(':invoiceDetailsId', $invoiceDetailId);
			$itemTransferDetails->bindParam(':date', $data['invoiceHead']['invoiceDate']);
		    $itemTransferDetails->bindParam(':transactionNo', $invoiceNo);
			$itemTransferDetails->bindParam(':vendorOrCustomerName', $data['invoiceHead']['customerName']);
            $itemTransferDetails->bindParam(':itemMasterId', $item['itemMasterId']);
            $itemTransferDetails->bindParam(':stockId', $item['stockId']);
            $itemTransferDetails->bindParam(':itemUnitId', $item['itemUnitId']);
			$itemTransferDetails->bindParam(':quantity', $item['quantity']);
            $itemTransferDetails->bindParam(':totalQuanity', $item['netWeight']);
            $itemTransferDetails->bindParam(':expiryDate', $item['expiryDate']);
            $itemTransferDetails->bindValue(':transactionType','Sales');
            $itemTransferDetails->bindValue(':type', '1');
            $itemTransferDetails->bindParam(':branchId', $data['invoiceHead']['branchId']); // Adjusted to match your data structure
            $itemTransferDetails->bindParam(':privilageId', $data['invoiceHead']['privilageId']);
            $itemTransferDetails->bindParam(':mainBranch',$data['invoiceHead']['mainBranch']); // Adjusted to match your data structure
            $itemTransferDetails->bindValue(':stockStatus', 'OUT'); // Adjusted to match your data structure
            $itemTransferDetails->bindParam(':remainingStock', $stockval);
            $itemTransferDetails->bindParam(':userId', $data['invoiceHead']['userId']);
           
            // Execute the statement for each item in itemTransferDetails table
            $itemTransferDetails->execute();
				
			
        
		
		
/*
        // Prepare the INSERT statement for accountJournal table
        $stmtAccountJournal = $pdo->prepare("
            INSERT INTO accountJournal (
                j_debit, j_credit, j_account_id, j_sub_account_id, j_particulars, j_remarks, j_dateOfPayment, j_referenceId, j_invoiceId, j_voucherNo, j_narration, j_cashReceiptPostingId, j_openingBalPostingId, j_openingPostingVendorId, j_openingBalanceSubAccountId, j_mainBranch, j_branchId, j_privillageId, j_userId
            ) VALUES (
                :j_debit, :j_credit, :j_account_id, :j_sub_account_id, :j_particulars, :j_remarks, :j_dateOfPayment, :j_referenceId, :j_invoiceId, :j_voucherNo, :j_narration, :j_cashReceiptPostingId, :j_openingBalPostingId, :j_openingPostingVendorId, :j_openingBalanceSubAccountId, :j_mainBranch, :j_branchId, :j_privillageId, :j_userId
            )
        ");

        // Iterate through each row in accountJournal and insert rows into accountJournal table
        foreach ($data['accountJournal'] as $item1) {
			if($item1['j_referenceId']==1 and $item1['j_sub_account_id']==20)
				$naration = 'Sales Account of '.$invoiceNo;
			else if($item1['j_referenceId']==1 and $item1['j_sub_account_id']==21)
				$naration = 'Sales Vat Amount of '.$invoiceNo;
			else if($item1['j_referenceId']==1 and $item1['j_sub_account_id']==3137)
				$naration = 'Cutting Charge of '.$invoiceNo;
			else if($item1['j_referenceId']==1 and $item1['j_sub_account_id']==2394)
				$naration = 'CASH CUSTOMER From Invoice No  '.$invoiceNo;
			else if($item1['j_referenceId']==1 and $item1['j_sub_account_id']==2393)
				$naration = 'CASH CUSTOMER From Invoice No  '.$invoiceNo;
			else if($item1['j_referenceId']==1 and $item1['j_sub_account_id']==4683)
				$naration = 'Sales Invoice of CASH CUSTOMER By Invoice No  '.$invoiceNo;
			else if($item1['j_referenceId']==2 and $item1['j_sub_account_id']==4674)
				$naration = 'Cash From Invoice No  '.$invoiceNo;
			else if($item1['j_referenceId']==2 and $item1['j_sub_account_id']==4683)
				$naration = 'CASH CUSTOMER From Invoice No '.$invoiceNo;
			else
				$naration = 'CASH CUSTOMER From Invoice No '.$invoiceNo;
			
            // Bind parameters for accountJournal table
            $stmtAccountJournal->bindParam(':j_debit', $item1['j_debit']);
            $stmtAccountJournal->bindParam(':j_credit', $item1['j_credit']);
            $stmtAccountJournal->bindParam(':j_account_id', $item1['j_account_id']);
            $stmtAccountJournal->bindParam(':j_sub_account_id', $item1['j_sub_account_id']);
            $stmtAccountJournal->bindParam(':j_particulars', $item1['j_particulars']);
            $stmtAccountJournal->bindParam(':j_remarks', $invoiceNo);
            $stmtAccountJournal->bindParam(':j_dateOfPayment', $item1['j_dateOfPayment']);
            $stmtAccountJournal->bindParam(':j_referenceId', $item1['j_referenceId']);
            $stmtAccountJournal->bindParam(':j_invoiceId', $invoiceId);
            $stmtAccountJournal->bindParam(':j_voucherNo', $item1['j_voucherNo']);
            $stmtAccountJournal->bindParam(':j_narration', $naration);
            $stmtAccountJournal->bindParam(':j_cashReceiptPostingId', $item1['j_cashReceiptPostingId']);
            $stmtAccountJournal->bindParam(':j_openingBalPostingId', $item1['j_openingBalPostingId']);
            $stmtAccountJournal->bindParam(':j_openingPostingVendorId', $item1['j_openingPostingVendorId']);
            $stmtAccountJournal->bindParam(':j_openingBalanceSubAccountId', $item1['j_openingBalanceSubAccountId']);
            $stmtAccountJournal->bindParam(':j_mainBranch', $item1['j_mainBranch']);
            $stmtAccountJournal->bindParam(':j_branchId', $item1['j_branchId']);
            $stmtAccountJournal->bindParam(':j_privillageId', $item1['j_privillageId']);
            $stmtAccountJournal->bindParam(':j_userId', $item1['j_userId']);

            // Execute the statement for this item in accountJournal table
            $stmtAccountJournal->execute();
        }

        // Prepare the INSERT statement for customerSalesPayment table
        $stmtCustomerSalesPayment = $pdo->prepare("
            INSERT INTO customerSalesPayment (
                invoiceId, regularCustomerId, paymentModeId, chequeId, bankId, amountDate, receiptTime, amountPaid, totalAmount, remainingBalance, salesPaymentVoucherNo, userId, privilageId, branchId, mainBranch, remarks, status, appStatus, updatedStatus, openingBalanceStatus, refNo, refId
            ) VALUES (
                :invoiceId, :regularCustomerId, :paymentModeId, :chequeId, :bankId, :amountDate, :receiptTime, :amountPaid, :totalAmount, :remainingBalance, :salesPaymentVoucherNo, :userId, :privilageId, :branchId, :mainBranch, :remarks, :status, :appStatus, :updatedStatus, :openingBalanceStatus, :refNo, :refId
            )
        ");

        // Iterate through each row in customerSalesPayment and insert rows into customerSalesPayment table
        foreach ($data['customerSalesPayment'] as $item2) {
            // Bind parameters for customerSalesPayment table
            $stmtCustomerSalesPayment->bindParam(':invoiceId', $invoiceId);
            $stmtCustomerSalesPayment->bindParam(':regularCustomerId', $item2['regularCustomerId']);
            $stmtCustomerSalesPayment->bindParam(':paymentModeId', $item2['paymentModeId']);
            $stmtCustomerSalesPayment->bindParam(':chequeId', $item2['chequeId']);
            $stmtCustomerSalesPayment->bindParam(':bankId', $item2['bankId']);
            $stmtCustomerSalesPayment->bindParam(':amountDate', $item2['amountDate']);
            $stmtCustomerSalesPayment->bindParam(':receiptTime', $item2['receiptTime']);
            $stmtCustomerSalesPayment->bindParam(':amountPaid', $item2['amountPaid']);
            $stmtCustomerSalesPayment->bindParam(':totalAmount', $item2['totalAmount']);
            $stmtCustomerSalesPayment->bindParam(':remainingBalance', $item2['remainingBalance']);
            $stmtCustomerSalesPayment->bindParam(':salesPaymentVoucherNo', $salesPaymentVoucherNo);
            $stmtCustomerSalesPayment->bindParam(':userId', $item2['userId']);
            $stmtCustomerSalesPayment->bindParam(':privilageId', $item2['privilageId']);
            $stmtCustomerSalesPayment->bindParam(':branchId', $item2['branchId']);
            $stmtCustomerSalesPayment->bindParam(':mainBranch', $item2['mainBranch']);
            $stmtCustomerSalesPayment->bindParam(':remarks', $item2['remarks']);
            $stmtCustomerSalesPayment->bindParam(':status', $item2['status']);
            $stmtCustomerSalesPayment->bindParam(':appStatus', $item2['appStatus']);
            $stmtCustomerSalesPayment->bindParam(':updatedStatus', $item2['updatedStatus']);
            $stmtCustomerSalesPayment->bindParam(':openingBalanceStatus', $item2['openingBalanceStatus']);
            $stmtCustomerSalesPayment->bindParam(':refNo', $item2['salesPaymentVoucherNo']);
            $stmtCustomerSalesPayment->bindParam(':refId', $item2['refId']);

            // Execute the statement for this item in customerSalesPayment table
            $stmtCustomerSalesPayment->execute();
        }

*/


$querycheck = "SELECT importLocalStatus FROM itemMaster where itemMasterId='$itemMasterId'";
		
		$stmt = $pdo->prepare($querycheck);
        $stmt->execute();

        $resultBranch = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultBranch) {
            $importLocalStatus = $resultBranch['importLocalStatus'];
        }
		
		
		
		$purchasePrices     	= 	0;
		$costPriceInKg   		= 	0;
			$count=0;
		if($importLocalStatus=='IMP')	
		{	
			$query = "SELECT costPerCtnRow FROM importPurchaseDetails				 
						WHERE itemMasterId = '".$itemMasterId."' AND status=1";
					
			$stmt = $pdo->prepare($query);
            $stmt->execute();
	        $rows = $stmt->fetchAll();
            $num_rows = count($rows);
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$purchasePrices = $purchasePrices + $row['costPerCtnRow'];
				}			
			
	$query = "SELECT costPrice  FROM  itemMaster 
						WHERE itemMasterId = '".$itemMasterId."'  AND status=1";
				  
			$stmt = $pdo->prepare($query);
            $stmt->execute();
			 $result = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$costPriceItemMaster = $result['costPrice'];
			
			 $query = "SELECT multiple FROM itemUnit  
						INNER JOIN unit ON itemUnit.unitId=unit.unitId
						WHERE itemUnit.itemMasterId='".$itemMasterId."'
						AND unit.unitName='CARTON'";
							
				
				
				$stmt = $pdo->prepare($query);
                $stmt->execute();
			 $resultEmptyStockDisplay = $stmt->fetch(PDO::FETCH_ASSOC);
			
				$multiple = $resultEmptyStockDisplay['multiple'];
				
				$costPriceInKg	    	=   $costPriceItemMaster; 	
				
				if($costPriceInKg>0 || $count==0)
				{
					 $count=$count+1;
				}
			 $PurchasePriceOfItem =($purchasePrices+$costPriceInKg)/$count;
			 $PurchasePriceOfItem	=	number_format($PurchasePriceOfItem, 2, '.', '');	

		}else{
			
			$query = "SELECT purchasePriceWithOutDiscount/netWeight AS purchasePrice       
				  FROM  purchaseItem 
				  inner join purchaseItemBill PIB ON PIB.purchaseItemBillId=purchaseItem.purchaseItemBillId
				  WHERE materialsId = '".$itemMasterId."' 
				  AND purchaseItem.status=1
				  ORDER BY purchaseItemId DESC LIMIT 1";
				  
				$stmt = $pdo->prepare($query);
                $stmt->execute();
			
			
			 $rows = $stmt->fetchAll();
            $num_rows = count($rows);
			if($num_rows>0)
			{
				 $resultEmptyStockDis = $stmt->fetch(PDO::FETCH_ASSOC);
				$PurchasePriceOfItem	=	number_format($resultEmptyStockDis['purchasePrice'], 2, '.', '');	
				
			}else{
							
				$query = "SELECT costPrice  FROM  itemMaster 
							WHERE itemMasterId = '".$itemMasterId."'  AND status=1";
				  
			$stmt = $pdo->prepare($query);
                $stmt->execute();
				 $resultEmptyStock = $stmt->fetch(PDO::FETCH_ASSOC);
			
			
			$costPriceItemMaster = $resultEmptyStock['costPrice'];
				
				$costPriceInKg	    	=   $costPriceItemMaster; 	
				
				$PurchasePriceOfItem	=	number_format($costPriceInKg, 2, '.', '');
			}
		}
		
		$totalCostValue = $totalCostValue+$item['netWeight']*$PurchasePriceOfItem;
		
	}



	$totalCostValueWithExRate = number_format($totalCostValue,2,'.','');

/*--------------------------------- Accounts Starts -----------------*/
	
		$j_referenceId		=	1;
		$j_account_id		=	1;
	$customerName  = $data['invoiceHead']['customerName'];
	$invoiceDate   =$data['invoiceHead']['invoiceDate'];
	$branchId  =$data['invoiceHead']['branchId'];
	$privilageId  =$data['invoiceHead']['privilageId'];
	$mainBranch  =$data['invoiceHead']['mainBranch'];
	$userId  =$data['invoiceHead']['userId'];
	
		$j_narration="Sales Invoice of ".$data['invoiceHead']['customerName']." By Invoice No ".$invoiceNo."";

		$j_narrationV="Sales Vat Amount  of ".$invoiceNo."";

		$j_narrationS=" Sales Account of ".$invoiceNo."";

		$query = "SELECT subAccountHeadId FROM    subAccountHead WHERE subAccountClientId='".$data['invoiceHead']['regularCustomerId']."'";
		$stmt = $pdo->prepare($query);
                $stmt->execute();
				 $getSubAccountData = $stmt->fetch(PDO::FETCH_ASSOC);
		
	
		$j_sub_account_id 		=	$getSubAccountData['subAccountHeadId'];
	
	 $query = "INSERT INTO accountJournal 
			(j_debit,j_credit,j_account_id,j_sub_account_id,j_particulars,j_remarks,j_dateOfPayment,
			j_referenceId,j_narration,j_invoiceId,j_branchId,j_privillageId,j_userId,j_mainBranch) 
			
			VALUES('".$totalAmountWithVatWithExRate."','','".$j_account_id."','".$j_sub_account_id."','".$customerName."',
			'".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narration."',
			'".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."'),
			
			('','".$totalAmountWithExRateAcc."','16','20','Sales Account',
			'".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narrationS."',
			'".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."'),
			
			('','".$vatAmountWithExRateAcc."','6','21','Sales Vat Amount',
			'".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narrationV."',
			'".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."'),
			
			('".$discountWithExRateAcc."','','18','382','Discount Allowed',
			'".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narration."',
			'".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."'),
			
			( '', '".$totalCostValueWithExRate."', '1','2394','Stock',
			 '".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narration."',
			 '".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."'),
				
			( '".$totalCostValueWithExRate."','','18','2393','Cost',
			'".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narration."',
			'".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')";	
			
			$stmt = $pdo->prepare($query);
                $stmt->execute();
			
			
	if($data['invoiceHead']['transactionType']==1){
	/*--------------- customerSalesPayment ----------------------------------------*/

			$query = "INSERT INTO customerSalesPayment
					(invoiceId,paymentModeId,amountDate,amountPaid,salesPaymentVoucherNo,
					userId,privilageId,branchId,mainBranch)
					VALUES('".$invoiceId."','1','".$invoiceDate."','".$data['invoiceHead']['totalAmountWithVat']."','".$salesPaymentVoucherNo."',
					'".$userId."','".$privilageId."','".$branchId."','".$mainBranch."')";		  
			
		$stmt = $pdo->prepare($query);
                $stmt->execute();
						
			/*--------------- customerSalesPayment ------------------------------------------*/
      
	  
	  	$j_referenceId	=	'2';
			

			$query = "SELECT subAccountHeadId,accountHeadId,subAccountHeadName FROM subAccountHead
						WHERE subAccountSalesareaId='$branchId'";
			
			$stmt = $pdo->prepare($query);
                $stmt->execute();
			 $branchAccountsRow = $stmt->fetch(PDO::FETCH_ASSOC);
			$branchAccountId 		=	$branchAccountsRow['accountHeadId'];
			$branchSubAccountId 	=	$branchAccountsRow['subAccountHeadId'];
			$branchName 			=	$branchAccountsRow['subAccountHeadName'];
			

			$j_narrationC="Cash payment of Invoice No ".$invoiceNo."";
			
			
		$query = "INSERT INTO accountJournal 
			(j_debit,j_credit,j_account_id,j_sub_account_id,j_particulars,j_remarks,j_dateOfPayment,
			j_referenceId,j_narration,j_invoiceId,j_branchId,j_privillageId,j_userId,j_mainBranch)
			
			VALUES('".$totalAmountWithVatWithExRate."','','".$branchAccountId."','".$branchSubAccountId."','".$branchName."',
			'".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narrationC."','".$invoiceId."',
			'".$branchId."','".$privilageId."','".$userId."','".$mainBranch."'),
			
			('','".$totalAmountWithVatWithExRate."','1','".$j_sub_account_id."','".$customerName."',
			'".$invoiceNo."','".$invoiceDate."','".$j_referenceId."','".$j_narrationC."',
			'".$invoiceId."','".$branchId."','".$privilageId."','".$userId."','".$mainBranch."')";
			
			$stmt = $pdo->prepare($query);
                $stmt->execute();
	  
	  
	}		


        // Commit the transaction
        $pdo->commit();

        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        // Roll back the transaction if something failed
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => 'Transaction failed: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data']);
}
?>