<?php    

    include "qrlib.php";    
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    $filename = $PNG_TEMP_DIR.'test.png';
    
	if (isset($_REQUEST['data'])) { 
    
        $filename = $PNG_TEMP_DIR.'test.png';
        QRcode::png('hello !!!!', $filename,'L',4, 2);    
        
    }
        
   echo '<img src="temp/test.png" />';  
    



    