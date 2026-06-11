<?php 
/***********Prepare the SQL connection to local server************/
$conn = mysqli_connect("localhost","aadil1_vansale","cyanuser123","aadil1_vansale");
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
die("Test");
/***********Prepare the SQL connection to local server Ends************/

/***********Function to fetch data from the remote API************/

function fetchData() {
    // $apiUrl = 'http://aadil1.info/soft/modules/api/insertToServer.php';
    $apiUrl = 'http://localhost/api/ConnectInvoiceSearchByDate/admin/includes/salesInvoiceConnect.php';
    echo "<br> apiUrl = ".$apiUrl."<br>";die("test");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($response === FALSE) {
        error_log('Failed to fetch API response: ' . $error);
        return array(
            'status' => 'error',
            'message' => 'Failed to fetch API response: ' . $error
        );
    } else {
        $data = json_decode($response, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            return array(
                'status' => 'error',
                'message' => 'Failed to decode JSON response: ' . json_last_error_msg()
            );
        }
        return $data;
    }
}
/***********Function to fetch data from the remote API Ends************/

/***********Fetch data and insert into the database************/
$data = fetchData();
/* if ($data['status'] == 'error') {
    die($data['message']);
} */
/*********** Check for and handle itemMasterDetails************/
echo json_encode($data); die("imperfect");
$itemmasterDetails = $data['itemmasterDetails'] ?? [];
if (!empty($itemmasterDetails)) {
    $conn->autocommit(FALSE);

    $sql = "INSERT INTO ItemMaster (itemMasterId, categoryId, SubcategoryId, brandId, countryId, partNo, wholsalePrice, maxretailPrice, agencyPrice, minretailsPrice, costPrice, vat, openingStock, stock, damageStock, expiryDate, branchId, importLocalStatus, status, 1_B_stock, 2_B_stock, 3_B_stock, minimunQty, reorderQty, maximunQty, profitLevel, description, generateBarcode, itemName, itemNameArabic, itemCode, minimumRate, packing, packingArabic, location, remarks, section, manufacturingDate, batchNo) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    foreach ($itemmasterDetails as $item) {
        $stmt->bind_param(
            "iiiiisdddddddddsisiiiiddddsssssdsssssss", 
            $item['itemMasterId'],
            $item['categoryId'],
            $item['SubcategoryId'],
            $item['brandId'],
            $item['countryId'],
            $item['partNo'],
            $item['wholsalePrice'],
            $item['maxretailPrice'],
            $item['agencyPrice'],
            $item['minretailsPrice'],
            $item['costPrice'],
            $item['vat'],
            $item['openingStock'],
            $item['stock'],
            $item['damageStock'],
            $item['expiryDate'],
            $item['branchId'],
            $item['importLocalStatus'],
            $item['status'],
            $item['branch1Stock'],
            $item['branch2Stock'],
            $item['branch3Stock'],
            $item['minimunQty'],
            $item['reorderQty'],
            $item['maximunQty'],
            $item['profitLevel'],
            $item['description'],
            $item['generateBarcode'],
            $item['itemName'],
            $item['itemNameArabic'],
            $item['itemCode'],
            $item['minimumRate '],
            $item['packing'], 
            $item['packingArabic'], 
            $item['location'], 
            $item['remarks'], 
            $item['section'], 
            $item['manufacturingDate'], 
            $item['batchNo']
        );

        $stmt->execute();
    }
    $stmt->close();
    $conn->commit();
}
/***********Check for and handle itemMasterDetails Ends************/

/***********Check for and handle itemunitDetails************/

$itemunitDetails = $data['itemunitDetails'] ?? [];
if (!empty($itemunitDetails)) {
    $conn->autocommit(FALSE);

    $sql2 = "INSERT INTO itemUnit (itemUnitId, unitId, multiple, itemMasterId, status) 
             VALUES (?, ?, ?, ?, ?)";

    $stmt2 = $conn->prepare($sql2);
    if ($stmt2 === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    foreach ($itemunitDetails as $item2) {
        $stmt2->bind_param(
            "iiiii", 
            $item2['itemUnitId'],
            $item2['unitId'],
            $item2['multiple'],
            $item2['itemMasterId'],
            $item2['statusUnitTable']
        );

        $stmt2->execute();
    }
    $stmt2->close();
    $conn->commit();
}
/***********Check for and handle itemunitDetails Ends************/

/***********Check for and handle unitDetails************/

$unitDetails = $data['unitDetails'] ?? [];
if (!empty($unitDetails)) {
    $conn->autocommit(FALSE);

    $sql3 = "INSERT INTO unit(unitId, unitName, status)
             VALUES (?, ?, ?)";

    $stmt3 = $conn->prepare($sql3);
    if ($stmt3 === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    foreach ($unitDetails as $item3) {
        $stmt3->bind_param(
            "isi", 
            $item3['unitId'],
            $item3['unitName'],
            $item3['status']
        );

        $stmt3->execute();
    }
    $stmt3->close();
    $conn->commit();
}
/***********Check for and handle unitDetails Ends************/

/***********Check for and handle stockDetails************/

$stockDetails = $data['stockDetails'] ?? [];
if (!empty($stockDetails)) {
    $conn->autocommit(FALSE);

    $sql4 = "INSERT INTO stock (stockId, itemMasterId, barcode, expiryDate, importLocalStatus, openingStockId, activeStatus, stock_1_0, stock_2_1, stock_3_2, stock_3_3, stock_2_4, stock_6_5, stock_2_7) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt4 = $conn->prepare($sql4);
    if ($stmt4 === false) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    foreach ($stockDetails as $item4) {
        $stmt4->bind_param(
            "iisssiiddddddd", 
            $item4['stockId'],
            $item4['itemMasterId'],
            $item4['barcode'],
            $item4['expiryDate'],
            $item4['importLocalStatus'],
            $item4['openingStockId'],
            $item4['activeStatus'],
            $item4['stock_1_0'],
            $item4['stock_2_1'],
            $item4['stock_3_2'],
            $item4['stock_3_3'],
            $item4['stock_2_4'],
            $item4['stock_6_5'],
            $item4['stock_2_7']
        );

        $stmt4->execute();
    }
    $stmt4->close();
    $conn->commit();
}
/***********Check for and handle stockDetails Ends************/

$conn->close();

?>
