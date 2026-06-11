<?php
require_once("../../../../modules/insertToLocalServer/admin/models/displayDataModel.php");
require_once("../../../../settings/connect_db.php");

class C_dispSyncData
{
	
	private function fetchData() 
	{
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

	public function  getItemMasterDetailsTable($branchId)
	{
		$itemMasterDetailsTable	=	'';
		$i 						=	1;
		$objItemmastermodel		=	new M_dispSyncData();
		$itemMasterData			=	$objItemmastermodel->getItemMasterDetailsTable($branchId);
		while($row=mysqli_fetch_array($itemMasterData))
		{	
			if (!empty($row['expiryDate']) && $row['expiryDate'] !== '0000-00-00') {
				$formattedDate = DateTime::createFromFormat('Y-m-d', $row['expiryDate'])->format('d-m-Y');
			} else {
				$formattedDate = ''; // Handle the case where the date is not valid
			}
			$itemMasterId		=	$row['itemMasterId'];
			$nunRows			=	$objItemmastermodel->checkInItemTransferDetailsTable($itemMasterId);
			$itemMasterDetailsTable	.=	'<tr>
											<td>'.$i.'</td>
											<td>'.$row['itemCode'].'</td>
											<td>'.$row['itemName'].'</td>
											<td>'.$row['categoryName'].'</td>
											<td>'.$row['unitName'].'</td>
											<td>'.number_format($row['minretailsPrice'], 2, '.', '').'</td>
											
											<td>
												'.$row['stockBranch'].'
											</td>
											<td>';
					if($nunRows==0)
					{						
					$itemMasterDetailsTable	.=	$formattedDate;
					}												
						$itemMasterDetailsTable	.=	'</td>
										</tr>';
			$i=$i+1;							
		}
		return $itemMasterDetailsTable;
	}

	
	
}

?>