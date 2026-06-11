<?php
	ob_start();
	class Path
	{
		function setHeader($destinationFileName, $message){
			$path = 'Location: ../../../../assets/system/php/dashboard/welcome.php?page='.$destinationFileName.'&message='.$message;
			header($path);
		}
		
		function setHeaderPassingValues($destinationFileName, $message, $count, $arrayConstants, $arrayValues){
			$path = 'Location: ../../../../assets/system/php/dashboard/welcome.php?page='.$destinationFileName.'&message='.$message;
			for($i=0; $i < $count; $i++)
				$path .= '&'.$arrayConstants[$i].'='.$arrayValues[$i];
			header($path);
		}
		function setHeaderPassingVal($destinationFileName, $count, $arrayConstants, $arrayValues){
			$path = 'Location: ../../../../assets/system/php/dashboard/welcome.php?page='.$destinationFileName.'';
			for($i=0; $i < $count; $i++)
				$path .= '&'.$arrayConstants[$i].'='.$arrayValues[$i];
			header($path);
		}
		function setAction($destinationFileName){
			return('welcome.php?page='.$destinationFileName);
		}
		
		function setActionPassingValue($destinationFileName, $messageName, $message){
			return('welcome.php?page='.$destinationFileName.'&'.$messageName.'='.$message);
		}
		
		function setActionPassingMultipleValues($destinationFileName,$count, $arrayConstants, $arrayValues){
            $path = 'welcome.php?page='.$destinationFileName.'&'.$arrayConstants[0].'='.$arrayValues[0];
            for($i=1; $i < $count; $i++)
                $path .= '&'.$arrayConstants[$i].'='.$arrayValues[$i];
            return($path);
        }
		
		function setPathForDownloadXLS($destinationFileName){
			return($destinationFileName.'.php');
		}
		
		function setPathForDownloadXLSModuleWise($destinationFileName)
                {
                        return($destinationFileName.'.php');
                }
	}
