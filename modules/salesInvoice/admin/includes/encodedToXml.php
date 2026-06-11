<?php
require_once("../../../../settings/connect_db.php");

// 79078   RK/INV/1615 	Simplified Reported	
// $invoiceId=79075;
// $invoiceId=79729;//M/INV/278
// $invoiceId=79767;
if (isset($_POST['invoiceId'])) {

    $invoiceId  =   $_POST['invoiceId']; 


$result=invoiceXmlEncodeValue($invoiceId);
while($data = mysqli_fetch_array($result)){

    $encodedData			    =	$data['xmlEncodeValue'];
    $invoiceNo			        =   $data['invoiceNo'];
    $invoiceDate                =   $data['invoiceDate'];
    $modifiedDate               =   str_replace("-", "", $invoiceDate);
    $time					    = 	$data['time'];
    $modifiedTime               =   str_replace(['.',':', ' pm', ' am',' PM',' AM',' Pm',' Am'], '', $time);
    $modifiedInvoiceNumber      =   preg_replace('/[^a-zA-Z0-9]/', '-', $invoiceNo);
    $xmlFileName                =   '300099808500003_'.$modifiedDate.'T'.$modifiedTime.'_'.$modifiedInvoiceNumber.'.xml';

    encodedValueToXml($encodedData,$xmlFileName);
    
}

}

// if(isset($_GET['invoiceId'])){
//     $invoiceId=$_GET['invoiceId'];
//     $encodedData=invoiceXmlEncodeValue($invoiceId);
// }

function invoiceXmlEncodeValue($invoiceId){
    global $con;
    $query="SELECT xmlEncodeValue,invoiceNo,invoiceDate,invoiceTime as time FROM invoice WHERE invoiceId='".$invoiceId."'";
    $result  = mysqli_query($con,$query);    
    return $result; 
}
// Encoded data




function encodedValueToXml($encodedData,$xmlFileName){
    // Decode the Base64 string
    $decodedData = base64_decode($encodedData);

    // Parse the XML with error handling
    libxml_use_internal_errors(true);
    $xml = simplexml_load_string($decodedData);

    if ($xml === false) {
        echo "Failed loading XML: ";
        foreach(libxml_get_errors() as $error) {
            echo "<br>", $error->message;
        }
        libxml_clear_errors();
    } else {
        // If parsing is successful, save the XML content to a file
        $folderPath = '../../../../modules/salesInvoice/admin/encodedToXml';  // Replace with the actual folder path
        $fileName = 'Decoded'.$xmlFileName;  // Replace with the desired file name

        $filePath = $folderPath . '/' . $fileName;

        // Save the XML content to the file
        file_put_contents($filePath, $xml->asXML());

        echo "XML saved successfully";
        
        // // Display the data with proper formatting
        // echo "<pre>";
        // print_r(htmlspecialchars($xml->asXML()));
        // echo "</pre>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <center>
            <form action="" method="post"><br><br>
                <label for="invoiceId">INVOICE ID</label><br><br>
                <input type="text" name="invoiceId" placeholder="Enter Invoice Id..">
                <input type="submit" value="SUBMIT">
            </form>

        </center>
    </div>
    

    
    
</body>
</html>