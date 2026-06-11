 <?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{   
    
    /***************************GG(08/07/2024)***************************/
/***********Prepare the SQL connection to local server************/
//$conn = new mysqli("localhost", "root", "", "aadil1_vansaleLocal");
$conn = new mysqli("localhost", "root", "", "vansale");
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
/***********Prepare the SQL connection to local server Ends************/

/***********Function to fetch data from the remote API************/

function fetchData() {
    $apiUrl = 'http://aadil1.info/soft/modules/api/itemMasterDetails.php';
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
// echo  "<pre>";
// echo print_r($data);
// echo  "</pre>";
//die();

    /*********** Check for and handle itemMasterDetails************/

    $itemmasterDetails = $data['itemmasterDetails'] ?? [];
    

    if (!empty($itemmasterDetails)) 
    {
        // Start transaction
        $conn->autocommit(FALSE);

        // Prepare statement for selecting existing records
        $select_sql = "SELECT categoryId, SubcategoryId, brandId, countryId, partNo, wholsalePrice, maxretailPrice, agencyPrice, minretailsPrice, costPrice, vat, openingStock, stock, damageStock, expiryDate, branchId, importLocalStatus, status, 1_B_stock, 2_B_stock, 3_B_stock, minimunQty, reorderQty, maximunQty, profitLevel, description, generateBarcode, itemName, itemNameArabic, itemCode, minimumRate, packing, packingArabic, location, remarks, section, manufacturingDate, batchNo
                    FROM ItemMaster WHERE itemMasterId = ?";
        $select_stmt = $conn->prepare($select_sql);
        if ($select_stmt === false) 
        {
            die("Prepare failed for select statement: (" . $conn->errno . ") " . $conn->error);
        }

        // Prepare statement for inserting new records
        $insert_sql = "INSERT INTO ItemMaster (itemMasterId, categoryId, SubcategoryId, brandId, countryId, partNo, wholsalePrice, maxretailPrice, agencyPrice, minretailsPrice, costPrice, vat, openingStock, stock, damageStock, expiryDate, branchId, importLocalStatus, status, 1_B_stock, 2_B_stock, 3_B_stock, minimunQty, reorderQty, maximunQty, profitLevel, description, generateBarcode, itemName, itemNameArabic, itemCode, minimumRate, packing, packingArabic, location, remarks, section, manufacturingDate, batchNo) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        if ($insert_stmt === false) 
        {
            die("Prepare failed for insert statement: (" . $conn->errno . ") " . $conn->error);
        }
        
        foreach ($itemmasterDetails as $item) 
        {
            // Execute select statement to check if record exists
            $select_stmt->bind_param("i", $item['itemMasterId']);
            $select_stmt->execute();
            $result = $select_stmt->get_result();

            if ($result->num_rows > 0) 
            {
                // Record exists, update it
                $updateFields = [];
                $existingItem = $result->fetch_assoc();
                
                //This is because some keys in API and table fields have name differances
                $keyMappings = [
                    'branch1Stock' => '1_B_stock',
                    'branch2Stock' => '2_B_stock',
                    'branch3Stock' => '3_B_stock',
                ];
                

                foreach ($item as $key => $value) 
                {
                    $key = isset($keyMappings[$key]) ? $keyMappings[$key] : $key;
                    if (array_key_exists($key, $existingItem) && $existingItem[$key] != $value) 
                    {
                        $updateFields[$key] = $value;
                    }
                }

                if (!empty($updateFields)) 
                {
                    $setClause = [];
                    $params = [];
                    $types = '';

                    foreach ($updateFields as $field => $value) 
                    {
                        $setClause[] = "$field = ?";
                        $params[] = $value;
                        //$types .= 's'; // Assuming all fields to be updated are strings
                        // modification
                        if (in_array($field,['categoryId', 'SubcategoryId', 'brandId', 'countryId', 'branchId'])) 
                        {
                            $types .= 'i';
                        } 
                        elseif (in_array($field,['wholsalePrice', 'maxretailPrice', 'agencyPrice', 'minretailsPrice', 
                                                    'costPrice', 'vat', 'openingStock', 'stock', 'damageStock', '1_B_stock', 
                                                    '2_B_stock', '3_B_stock', 'minimunQty', 'reorderQty', 'maximunQty', 'profitLevel', 'minimumRate'
                                                ])) 
                        {
                            $types .= 'd';
                        } 
                        elseif (in_array($field, ['partNo', 'expiryDate', 'importLocalStatus', 'status', 'description', 'generateBarcode', 'itemName', 'itemNameArabic', 'itemCode', 'packing', 'packingArabic', 'location', 'remarks', 'section', 'manufacturingDate', 'batchNo'])) 
                        {
                            $types .= 's';
                        }
                        // modification ends
                    }

                    $params[] = $item['itemMasterId']; // add itemMasterId as the last parameter
                    $types .= 'i'; // itemMasterId is an integer

                    // Prepare update statement
                    $update_sql = "UPDATE ItemMaster SET " . implode(', ', $setClause) . " WHERE itemMasterId = ?";
                    // echo replacePlaceholders($update_sql, $params);
                    $update_stmt = $conn->prepare($update_sql);
                    if ($update_stmt === false) 
                    {
                        die("Prepare failed for update statement: (" . $conn->errno . ") " . $conn->error);
                    }
                    // print_r($update_stmt);
                    // Bind parameters for update statement
                    $update_stmt->bind_param($types, ...$params);
                    $update_stmt->execute();
                    $update_stmt->close();
                }
            } 
            else 
            {
                // Record does not exist, insert it
                $insert_stmt->bind_param(
                    "iiiiisdddddddddsissdddddddsssssdsssssss", 
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

                $insert_stmt->execute();
            }
        }

        $insert_stmt->close();
        $select_stmt->close();
        $conn->commit();
    }

    
    /***********Check for and handle itemMasterDetails Ends************/

    /***********Check for and handle itemunitDetails************/

    $itemunitDetails = $data['itemunitDetails'] ?? [];

    if (!empty($itemunitDetails)) 
    {
        $conn->autocommit(FALSE);

        // Prepare statement for selecting existing records
        $select_sql2 = "SELECT unitId, multiple, itemMasterId, status
                    FROM itemUnit WHERE itemUnitId = ?";
        $select_stmt2 = $conn->prepare($select_sql2);
        if ($select_stmt2 === false) 
        {
            die("Prepare failed for select statement: (" . $conn->errno . ") " . $conn->error);
        }

        // Prepare statement for inserting new records
        $insert_sql2 = "INSERT INTO itemUnit (itemUnitId, unitId, multiple, itemMasterId, status) 
                VALUES (?, ?, ?, ?, ?)";

        $insert_stmt2 = $conn->prepare($insert_sql2);
        if ($insert_stmt2 === false) 
        {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        foreach ($itemunitDetails as $item2) 
        {
            // Execute select statement to check if record exists
            $select_stmt2->bind_param("i", $item2['itemUnitId']);
            $select_stmt2->execute();
            $result = $select_stmt2->get_result();
            if ($result->num_rows > 0) 
            {
                // Record exists, update it
                $updateFields2 = [];
                $existingItem2 = $result->fetch_assoc();

                foreach ($item2 as $key => $value) 
                {
                    if ($key === 'statusUnitTable') 
                    {
                        $key = 'status';
                    }
                    if (array_key_exists($key, $existingItem2) && $existingItem2[$key] != $value) 
                    {
                        $updateFields2[$key] = $value;
                    }
                }
            

                if (!empty($updateFields2)) 
                {
                    $setClause2 = [];
                    $params2 = [];
                    $types2 = '';

                    foreach ($updateFields2 as $field => $value) 
                    {
                        $setClause2[] = "$field = ?";
                        $params2[] = $value;
                        //$types2 .= 's'; // Assuming all fields to be updated are strings
                        // modification starts
                        if (in_array($field, ['unitId', 'itemMasterId'])) 
                        {
                            $types2 .= 'i'; 
                        } 
                        elseif (in_array($field, ['multiple'])) 
                        {
                            $types2 .= 'd'; 
                        } 
                        elseif (in_array($field, ['status'])) 
                        {
                            $types2 .= 's'; 
                        }
                        // modification ends
                    }

                    $params2[] = $item2['itemUnitId']; 
                    $types2 .= 'i'; 
                    // Prepare update statement
                    $update_sql2 = "UPDATE itemUnit SET " . implode(', ', $setClause2) . " WHERE itemUnitId = ?";
                    // echo replacePlaceholders($update_sql2, $params2);
                    $update_stmt2 = $conn->prepare($update_sql2);
                    if ($update_stmt2 === false) 
                    {
                        die("Prepare failed for update statement: (" . $conn->errno . ") " . $conn->error);
                    }
                    
                    $update_stmt2->bind_param($types2, ...$params2);
                    $update_stmt2->execute();
                    $update_stmt2->close();
                }
            }
            else
            {
                $insert_stmt2->bind_param(
                    "iidis", 
                    $item2['itemUnitId'],
                    $item2['unitId'],
                    $item2['multiple'],
                    $item2['itemMasterId'],
                    $item2['statusUnitTable']
                );
                $insert_stmt2->execute();
            } 

            
        }
        $insert_stmt2->close();
        $select_stmt2->close();
        $conn->commit();
    }
    // die();
    /***********Check for and handle itemunitDetails Ends************/

    /***********Check for and handle unitDetails************/

    $unitDetails = $data['unitDetails'] ?? [];

    if (!empty($unitDetails)) 
    {
        $conn->autocommit(FALSE);

        // Prepare statement for selecting existing records
        $select_sql3 = "SELECT unitName, status
                    FROM unit WHERE unitId = ?";
        $select_stmt3 = $conn->prepare($select_sql3);
        if ($select_stmt3 === false) 
        {
            die("Prepare failed for select statement: (" . $conn->errno . ") " . $conn->error);
        }

        // Prepare statement for inserting new records
        $insert_sql3 = "INSERT INTO unit(unitId, unitName, status)
                VALUES (?, ?, ?)";

        $insert_stmt3 = $conn->prepare($insert_sql3);
        if ($insert_stmt3 === false) 
        {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        foreach ($unitDetails as $item3) 
        {
            // Execute select statement to check if record exists
            $select_stmt3->bind_param("i", $item3['unitId']);
            $select_stmt3->execute();
            $result = $select_stmt3->get_result();
    
            if ($result->num_rows > 0) 
            {
                // Record exists, update it
                $updateFields3 = [];
                $existingItem3 = $result->fetch_assoc();
    
    
                foreach ($item3 as $key => $value) 
                {
                    if (array_key_exists($key, $existingItem3) && $existingItem3[$key] != $value) 
                    {
                        $updateFields3[$key] = $value;
                    }
                }
                
    
                if (!empty($updateFields3)) 
                {
                    $setClause3 = [];
                    $params3 = [];
                    $types3 = '';
    
                    foreach ($updateFields3 as $field => $value) 
                    {
                        $setClause3[] = "$field = ?";
                        $params3[] = $value;
                        //$types3 .= 's'; // Assuming all fields to be updated are strings
                        // modification starts
                        if (in_array($field, ['unitName', 'status'])) 
                        {
                            $types3 .= 's'; 
                        } 
                        // modification ends
                    }
    
                    $params3[] = $item3['unitId']; 
                    $types3 .= 'i';
    
                    // Prepare update statement
                    $update_sql3 = "UPDATE unit SET " . implode(', ', $setClause3) . " WHERE unitId = ?";
                    // echo replacePlaceholders($update_sql3, $params3);
                    $update_stmt3 = $conn->prepare($update_sql3);
                    if ($update_stmt3 === false) 
                    {
                        die("Prepare failed for update statement: (" . $conn->errno . ") " . $conn->error);
                    }
                    
                    $update_stmt3->bind_param($types3, ...$params3);
                    $update_stmt3->execute();
                    $update_stmt3->close();
                }
            }
            else
            {
                $insert_stmt3->bind_param(
                    "iss", 
                    $item3['unitId'],
                    $item3['unitName'],
                    $item3['status']
                );
                $insert_stmt3->execute();
            }
        }
        $insert_stmt3->close();
        $select_stmt3->close();
        $conn->commit();
    }

    /***********Check for and handle unitDetails Ends************/

    /***********Check for and handle stockDetails************/

    $stockDetails = $data['stockDetails'] ?? [];
    if (!empty($stockDetails)) 
    {
        $conn->autocommit(FALSE);

        // Prepare statement for selecting existing records
        $select_sql4 = "SELECT itemMasterId, barcode, expiryDate, importLocalStatus, openingStockId, activeStatus, stock_1_0, stock_2_1, stock_3_2, stock_3_3, stock_2_4, stock_6_5, stock_2_7
                    FROM stock WHERE stockId = ?";
        $select_stmt4 = $conn->prepare($select_sql4);
        if ($select_stmt4 === false) 
        {
            die("Prepare failed for select statement: (" . $conn->errno . ") " . $conn->error);
        }

        // Prepare statement for inserting new records
        $insert_sql4 = "INSERT INTO stock (stockId, itemMasterId, barcode, expiryDate, importLocalStatus, openingStockId, activeStatus, stock_1_0, stock_2_1, stock_3_2, stock_3_3, stock_2_4, stock_6_5, stock_2_7) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $insert_stmt4 = $conn->prepare($insert_sql4);
        if ($insert_stmt4 === false) 
        {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }

        foreach ($stockDetails as $item4) 
        {
            // Execute select statement to check if record exists
            $select_stmt4->bind_param("i", $item4['stockId']);
            $select_stmt4->execute();
            $result = $select_stmt4->get_result();

            if ($result->num_rows > 0) 
            {
                // Record exists, update it
                $updateFields4 = [];
                $existingItem4 = $result->fetch_assoc();

                foreach ($item4 as $key => $value) 
                {
                    if (array_key_exists($key, $existingItem4) && $existingItem4[$key] != $value) 
                    {
                        $updateFields4[$key] = $value;
                    }
                }
            

                if (!empty($updateFields4)) 
                {
                    $setClause4 = [];
                    $params4 = [];
                    $types4 = '';

                    foreach ($updateFields4 as $field => $value) 
                    {
                        $setClause4[] = "$field = ?";
                        $params4[] = $value;
                        //$types4 .= 's'; // Assuming all fields to be updated are strings
                        // modification starts
                        if (in_array($field, ['itemMasterId', 'openingStockId', 'activeStatus'])) 
                        {
                            $types4 .= 'i'; 
                        } 
                        elseif (in_array($field, ['stock_1_0', 'stock_2_1', 'stock_3_2', 'stock_3_3', 'stock_2_4', 'stock_6_5', 'stock_2_7'])) 
                        {
                            $types4 .= 'd'; 
                        } 
                        elseif (in_array($field, ['barcode', 'expiryDate', 'importLocalStatus'])) 
                        {
                            $types4 .= 's'; 
                        }
                        
                        // modification ends
                    }

                    $params4[] = $item4['stockId']; 
                    $types4 .= 'i'; 

                    // Prepare update statement
                    $update_sql4 = "UPDATE stock SET " . implode(', ', $setClause4) . " WHERE stockId = ?";
                    // echo replacePlaceholders($update_sql4, $params4);
                    $update_stmt4 = $conn->prepare($update_sql4);
                    if ($update_stmt4 === false) 
                    {
                        die("Prepare failed for update statement: (" . $conn->errno . ") " . $conn->error);
                    }
                    
                    $update_stmt4->bind_param($types4, ...$params4);
                    $update_stmt4->execute();
                    $update_stmt4->close();
                }
            } 
            else
            {
                $insert_stmt4->bind_param(
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

                $insert_stmt4->execute();
            }
        }
        $insert_stmt4->close();
        $select_stmt4->close();
        $conn->commit();
    }
    /***********Check for and handle stockDetails Ends************/
   
    $conn->close();

    header("location:welcome.php?page=insertToLocalServerView"); 
    exit;
}
?>
