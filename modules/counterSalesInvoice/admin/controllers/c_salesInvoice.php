<?php
require_once("../../../../modules/counterSalesInvoice/admin/models/m_salesInvoice.php");
include "../../../../modules/salesInvoice/admin/includes/qrCodeGenerator/qrlib.php";    $filename ='';

class C_salesInvoice
{
	function getMaxInvoiceNo()
	{
		$objMSalesInvoice	= 	new M_salesInvoice();
		$privilageId       	=   	$_COOKIE['privillegeId'];
		
		$invoiceNoData		=	$objMSalesInvoice->getMaxInvoiceNo();
		$branchCode			=	$objMSalesInvoice->getBranchCode();
		if(mysqli_num_rows($invoiceNoData)>0)
			{
			while($row=mysqli_fetch_array($invoiceNoData))
			{
				
					$maxOfIncoiceNo	=	$row['maxOfIncoiceNo'];
					$maxInvoiceNo	=	$maxOfIncoiceNo+1;
					/*$invoiceNoArray	=	explode("/",$lastIncoiceNo);
					
					if(count($invoiceNoArray)==3)
					{
						$maxInvoiceNo	=	$invoiceNoArray[2];
						$maxInvoiceNo	=	$maxInvoiceNo+1;
					}else{
						$maxInvoiceNo	=	1;
					}*/
				
				
				
			}
			}else{
				$maxInvoiceNo	=	1;
			}
		
		
			 $invoiceNo	=	$branchCode.'/INV/'.$maxInvoiceNo;
		
		
		return $invoiceNo;
	}
	function getMaxOfinvoiceNumericNo()
	{
		$objMSalesInvoice	= 	new M_salesInvoice();
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		
		$invoiceNoData		=	$objMSalesInvoice->getMaxInvoiceNo();
		if(mysqli_num_rows($invoiceNoData)>0)
			{
			while($row=mysqli_fetch_array($invoiceNoData))
			{
				
					$maxOfIncoiceNo	=	$row['maxOfIncoiceNo'];
					$maxInvoiceNo	=	$maxOfIncoiceNo+1;
			}
			}else{
				$maxInvoiceNo	=	1;
			}		
		
		return $maxInvoiceNo;
	}
	function getPrevInvoiceNo()
	{
		$objMSalesInvoice	= 	new M_salesInvoice();		
		$invoiceNoData		=	$objMSalesInvoice->getMaxInvoiceNo();
		$branchCode			=	$objMSalesInvoice->getBranchCode();
		if(mysqli_num_rows($invoiceNoData)>0)
			{
			while($row=mysqli_fetch_array($invoiceNoData))
			{
				$maxOfIncoiceNo	=	$row['maxOfIncoiceNo'];
				if($maxOfIncoiceNo==null)
				{
					$lastIncoiceNo	=	'';
				
				}else{
					$lastIncoiceNo	=	$branchCode.'/INV/'.$maxOfIncoiceNo;	
				}					
			}
			}else{
				$lastIncoiceNo	= '';
			}
		
		
			return $lastIncoiceNo;
	}
	function getVesselData()
	{
		$vesselOptionValue	=	'';
		$objMSalesInvoice	= 	new M_salesInvoice();
		$vesselData			=	$objMSalesInvoice->getVesselData();
		while($vesselDataRow	=	mysqli_fetch_array($vesselData))
		{
			$vesselOptionValue	.='<option value="'.$vesselDataRow['vesselId'].'">'.$vesselDataRow['vesselName'].'</option>';
		}
		return $vesselOptionValue;
	}
	
	
	function getBranchId($userId){
		$branchId        	=	'';
		$objMSalesInvoice	= 	new M_salesInvoice();
		$getBranch			=	$objMSalesInvoice->getBranchId($userId);
		while($brachData	=	mysqli_fetch_array($getBranch))
		{
			$branchId	    = $brachData['branchId'];
		}
		return $branchId;
		
	}
	
	
	
	function insertToInvoiceTable($invoiceNo,$regularCustomerId,$invoiceDate,$poNo,$quotationNo,$currencyId,$vesselId,
								$totalAmount,$discountInPercent,$discountInAmount,$totalAfterDiscount,$vatPercent,$vatAmount,
								$netAmount,$transactionType,$deliveryNoteId,$exRate,$netAmountWithExRate,$userId,$branchId,
								$discountId,$privilageId,$damagedGoodsReturn,$damagedGoodsAmount,$customerPhone,$customerName,
								$cuttingCharge,$invType,$maxOfinvoiceNumericNo,$roundOff,$roundAmount,$vatNumber,$zakatInvoiceType)
	{
		$objMSalesInvoice	= 	new M_salesInvoice();
		$invoiceId			=	$objMSalesInvoice->insertToInvoiceTable($invoiceNo,$regularCustomerId,$invoiceDate,$poNo,$quotationNo,$currencyId,$vesselId,
													$totalAmount,$discountInPercent,$discountInAmount,$totalAfterDiscount,$vatPercent,$vatAmount,$netAmount,
													$transactionType,$deliveryNoteId,$exRate,$netAmountWithExRate,$userId,$branchId,$discountId,$privilageId,
													$damagedGoodsReturn,$damagedGoodsAmount,$customerPhone,$customerName,$cuttingCharge,$invType,$maxOfinvoiceNumericNo,$roundOff,$roundAmount,$vatNumber,$zakatInvoiceType);
													
		return 	$invoiceId;
	}
	function insertToInvoiceDetails($invoiceId,$itemMasterId,$itemUnitId,$unitFraction,$quantityRow,$unitPriceRow,$discountPercentRow,$amountAfterDiscountRow,$itemCodeRow,$descriptionRow,$packageSizeRow,$vatPercentRow,$vatAmountRow,$amountWithWithVatRow,$amountWithOutDiscountRow,$branchId,$privilageId,$discountIdRow,$discountAmountRow,$stockId,$netWeightRow)
	{
		$objMSalesInvoice	= 	new M_salesInvoice();
		$invoiceDetailsId	=	$objMSalesInvoice->insertToInvoiceDetails($invoiceId,$itemMasterId,$itemUnitId,$quantityRow,$unitPriceRow,$discountPercentRow,$amountAfterDiscountRow,$itemCodeRow,$descriptionRow,$packageSizeRow,$vatPercentRow,$vatAmountRow,$amountWithWithVatRow,$amountWithOutDiscountRow,$discountIdRow,$discountAmountRow,$stockId,$netWeightRow);
		if($invoiceDetailsId>0)
		{
	
			$objMSalesInvoice->updateStockInStockTable($stockId,$netWeightRow);	
		}
		return $invoiceDetailsId;
	}	
	
	function getRemainingStock($branchId,$privilageId,$stockIdRow)
	{
		$objMSalesInvoice	= 	new M_salesInvoice();
		$remainingStock	    =	$objMSalesInvoice->getRemainingStock($branchId,$privilageId,$stockIdRow);
		return $remainingStock;
		
	}
	
	function insertItemTransferDetails($invoiceDate,$invoiceNo,$itemMasterId,$quantityRow,$itemUnitId,$unitFraction,$invoiceDetailsId,$customerName,$branchId,$stock,$privilageId,$userId,$netWeightRow,$stockIdRow){ 
		
		$objMSalesInvoice   = 	new M_salesInvoice();
		$stockQuantity	    =	$netWeightRow;//$quantityRow*$unitFraction;
		$objMSalesInvoice->insertItemTransferDetails($invoiceDate,$invoiceNo,$itemMasterId,$quantityRow,$itemUnitId,$stockQuantity,$invoiceDetailsId,$customerName,$branchId,$stock,$privilageId,$userId,$stockIdRow);
		//return $numOfRows;	
	}
	
	function checkInvoiceNoExistOrNot($invoiceNo)
	{
		$objMSalesInvoice	= 	new M_salesInvoice();
		$numOfRows			=	$objMSalesInvoice->checkInvoiceNoExistOrNot($invoiceNo);
		return $numOfRows;
	}
	function getDeliveryNoteDetails($deliveryNoteId)
	{
		$tbody				=	'';
		$i					=	1;
		$currencyOptionValue=	'';
		$vesselOptionValue	=	'';
		$totalWithOutvat	=	0;
		$vatAmount			=	0;
		$objMSalesInvoice	= 	new M_salesInvoice();
		$deliveryNoteBasicDetails		=	$objMSalesInvoice->deliveryNoteBasicDetails($deliveryNoteId);
		if(mysqli_num_rows($deliveryNoteBasicDetails)>0)
		{
			$PurchasePriceOfItem =0;
			$deliveryNoteDetails			=	$objMSalesInvoice->getDeliveryNoteDetails($deliveryNoteId);
		while($deliveryNoteBasicDetailsRow	=	mysqli_fetch_array($deliveryNoteBasicDetails))
		{
				$regularCustomerId		=	$deliveryNoteBasicDetailsRow['regularCustomerId'];
				$customerName			=	$deliveryNoteBasicDetailsRow['customerName'];
				$customerNo				=	$deliveryNoteBasicDetailsRow['customerNo'];
				$vatNumber				=	$deliveryNoteBasicDetailsRow['vatNumber'];				
				$quotation				=	$deliveryNoteBasicDetailsRow['quotation'];	
				$poNo					=	$deliveryNoteBasicDetailsRow['poNo'];	
				$modeOfPayment			=	$deliveryNoteBasicDetailsRow['modeOfPayment'];
				$currencyId				=	$deliveryNoteBasicDetailsRow['currencyId'];
				$vesselId				=	$deliveryNoteBasicDetailsRow['vesselId'];
				$currencyData			=	$objMSalesInvoice->getCurrencyData();	
				$vesselData				=	$objMSalesInvoice->getVesselData();
				$exRate					=	$objMSalesInvoice->getExchangeRate($currencyId);
				while($currencyDataRow	=	mysqli_fetch_array($currencyData))
				{
					if($currencyDataRow['currencyId'] == $currencyId)
					{
						$currencyOptionValue.='<option value="'.$currencyDataRow['currencyId'].'/'.$currencyDataRow['exRate'].'" selected >'.$currencyDataRow['currencyName'].'</option>';
					}else{
						$currencyOptionValue.='<option value="'.$currencyDataRow['currencyId'].'/'.$currencyDataRow['exRate']
						.'" >'.$currencyDataRow['currencyName'].'</option>';

					}
					
				}
				while($vesselDataRow	=	mysqli_fetch_array($vesselData))
				{

					if($vesselDataRow['vesselId'] == $vesselId)
					{
						$vesselOptionValue.='<option value="'.$vesselDataRow['vesselId'].'" selected >'.$vesselDataRow['vesselName'].'</option>';
					}else{
						$vesselOptionValue.='<option value="'.$vesselDataRow['vesselId'].'" >'.$vesselDataRow['vesselName'].'</option>';

					}
					
				}
		
		}
		while($deliveryNoteDetailsRow	=	mysqli_fetch_array($deliveryNoteDetails))
		{
			$quantity			=	$deliveryNoteDetailsRow['quantity'];
			$unitPrice			=	$deliveryNoteDetailsRow['unitPrice'];
			$rowTotalAmount		=	$quantity*$unitPrice;	
			$totalWithOutvat	=	$totalWithOutvat+$rowTotalAmount;
			$itemMasterId		=	$deliveryNoteDetailsRow['itemMasterId'];
			
			$resCustomerList 	= 	$objMSalesInvoice->getPurchasePrice($itemMasterId);
					
					$unitPurchasePrice              =  0;
					$sumOfPurchasePrice             =  0;
                    $count=mysqli_num_rows($resCustomerList);
				 
					while($row = mysqli_fetch_array($resCustomerList))
					{
						//$unitPurchasePrice              =   $row['purchasePrice'];
                        $sumOfPurchasePrice             =   $sumOfPurchasePrice+$row['purchasePrice'];
                        					
					}
					
					
			$resCustomerList1 	= 	$objMSalesInvoice->getCostPrice($itemMasterId);	
			
			if($resCustomerList1>0 || $count==0){
				$count=$count+1;
			}
			$PurchasePriceOfItem =($sumOfPurchasePrice+$resCustomerList1)/$count;
            //echo $count;
			//echo $sumOfPurchasePrice+$resCustomerList;
			//exit;

				
			
			$tbody.='<tr>
					<td style="width:3% !important">'.$i.'</td>
					<td style="width:8% !important"><input type="hidden" value="'.$i.'" id="sNo'.$i.'" class="sNo"><input type="hidden" id="itemCodeRow'.$i.'" style="width:100% !important" class="form-control input-sm itemCodeRow" value="'.$deliveryNoteDetailsRow['customerItemCode'].'" readonly=""><input type="hidden"  id="itemMasterId'.$i.'" class="form-control input-sm itemMasterId" value="'.$itemMasterId.'">'.$deliveryNoteDetailsRow['customerItemCode'].'</td>
					<td style="width:11% !important"><input style="width:100% !important" type="hidden"  id="descriptionRow'.$i.'" value="'.$deliveryNoteDetailsRow['title'].'" class=" input-sm descriptionRow" readonly="">'.$deliveryNoteDetailsRow['title'].'</td>
					<td style="width:8% !important"><input type="hidden" id="packageSizeRow'.$i.'" value="'.$deliveryNoteDetailsRow['packageSize'].'" class="packageSizeRow" />'.$deliveryNoteDetailsRow['packageSize'].'</td>
					<td style="width:9% !important"><input style="width:100% !important" type="text"  id="quantityRow'.$i.'" onkeyup="checkNumber(this.id); calculateRowTotal('.$i.');" value="'.$quantity.'" class=" input-sm quantityRow"></td>
					<td style="width:9% !important"><select style="width:100% !important" class="input-sm form-group itemUnitRow"  id="itemUnitRow'.$i.'" required="" ><option value="'.$deliveryNoteDetailsRow['itemUnitId'].'-'.$deliveryNoteDetailsRow['multiple'].'" selected >'.$deliveryNoteDetailsRow['unitName'].'</option></select></td>
					<td style="width:9% !important"><input style="width:100% !important"  value="'.$unitPrice.'" id="unitPriceRow'.$i.'" onkeyup="checkNumber(this.id); calculateRowTotal('.$i.');" type="text" class=" input-sm amountRowTotal"></td>
					<td style="width:9% !important"><input style="width:100% !important" type="text" name="amountWithOutDiscount" id="amountWithOutDiscount'.$i.'" value="'.$rowTotalAmount.'" class=" input-sm amountRowWithOutDiscount" readonly/> <input style="width:100% !important"  value="'.$rowTotalAmount.'" id="amountAfterDiscountRow'.$i.'" type="text" class=" input-sm amountAfterDiscountRowTotal" readonly=""></td>
					<td style="width:9% !important"><input style="width:100% !important"  value="0" id="discountPercentRow'.$i.'" type="text" class=" input-sm discountRowTotal" onkeyup="checkNumber(this.id);calculateRowTotal('.$i.');"></td>
					<td style="width:9% !important"><input style="width:100% !important"  value="0" type="text" id="vatPercentRow'.$i.'" onkeyup="checkNumber(this.id); calculateRowTotal('.$i.');" class=" input-sm vatPercentRow" />
					<input style="width:100% !important"  value="0" type="text" id="vatAmountRow'.$i.'"  class=" input-sm vatAmountRowTotal" readonly/>
					</td>			
					<td style="width:9% !important"><input style="width:100% !important"  value="'.$rowTotalAmount.'" id="amountWithWithVatRow'.$i.'" type="text" class=" input-sm amountWithWithVatRowTotal" readonly="" /></td>
					<td style="width:4% !important"><input type="hidden" id="purchasePrice'.$i.'" class="purchasePrice" value="'.number_format($PurchasePriceOfItem, 2, '.', '').'">'.number_format($PurchasePriceOfItem, 2, '.', '').'</td>
					<td style="width:3% !important"><!--<button type="button" onclick="deleteRow(this)" class="btn btn-danger btnSubmit btn-xs"><i class="fa fa-times"></i></button>--></td>
					</tr>';
			$i++;
		}
		//$vatAmount			=	($totalWithOutvat*5)/100;
		$vatAmount				=	0;
		$totalWithVat			=	$totalWithOutvat+$vatAmount;	
		$deliveryNoteDetails	=	array('tbody'=>$tbody,
										  'regularCustomerId'=>$regularCustomerId,
										  'customerName'=>$customerName,
										  'customerNo'=>$customerNo,
										  'vatNumber'=>$vatNumber,
										  'quotation'=>$quotation,
										  'poNo'=>$poNo,
										  'modeOfPayment'=>$modeOfPayment,
										  'currencyOptionValue'=>$currencyOptionValue,
										  'vesselId'=>$vesselId,
										  'vesselOptionValue'=>$vesselOptionValue,
										  'totalWithOutvat'=>number_format($totalWithOutvat, 2, '.', ''),
										  'vatAmount'=>$vatAmount,
										  'totalWithVat'=>number_format($totalWithVat, 2, '.', ''),
										  'exRate'=>$exRate
											);
		return $deliveryNoteDetails;
		}else{
			$tbody		=		'<tr><td colspan="11" align="center">Delivery Note Not Completed!!!</td></tr>';
			$deliveryNoteDetails	=	array('tbody'=>$tbody,
										 'regularCustomerId'=>'',
										  'customerName'=>'',
										  'customerNo'=>'',
										  'vatNumber'=>'',
										  'quotation'=>'',
										  'poNo'=>'',
										  'modeOfPayment'=>'',
										  'currencyOptionValue'=>'',
										  'vesselId'=>'',
										  'vesselOptionValue'=>'',
										  'totalWithOutvat'=>'',
										  'vatAmount'=>'',
										  'totalWithVat'=>'',
										   'exRate'=>''
											);
			return $deliveryNoteDetails;
		}
		
	}
	function getInvoiceDetails($invoiceId)
	{

		$i				=	1;
		$tbody			=	'';
		$invoiceData	=	'';
		$thead			=	'';
		$codeContent=$branchId='';
		$invoiceNo					=	'';
		$invoiceDate				=	'';
		$customerName				=	'';
		$vatNumber					=	'';
		$vesselName					=	'';
		$poNo						=	'';
		$dueDate                    =$privilageIdFromDb =$privilageId=   '';
		$totalAmount				=	0;
		$discountAmount				=	0;	
		$discountPercent			=	0;
		$totalAmountAfterDiscount	=	0;
		$vatPercent					=	0;
		$vatAmount					=	0;
		$totalAmountWithVat			=	0;	
		$netAmount					=	0;
		$address         			=	'';
		$damagedGoodsAmount         =	0;
		$qtyTotal         			=	0;
		$netWtTotal         		=	0;
		$time                       ='';
		$warehouseCustName          =  '';
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$filename ='../../../../modules/salesInvoice/admin/includes/qrCodeGenerator/temp/';
		$objMSalesInvoice	= 	new M_salesInvoice();
		$invoiceAmountDetails =	$objMSalesInvoice->getInvoiceBasicDetails($invoiceId);
while($invoiceAmtDetailsRow	=	mysqli_fetch_array($invoiceAmountDetails))
	{
	$invoiceNo					=	$invoiceAmtDetailsRow['invoiceNo'];
	$invoiceDate				=	$invoiceAmtDetailsRow['invoiceDate'];
	$customerName				=	$invoiceAmtDetailsRow['customerName'];
	$vatNumber					=	$invoiceAmtDetailsRow['vatNumber'];
	$vesselName					=	$invoiceAmtDetailsRow['vesselName'];
	$totalAmount				=	$invoiceAmtDetailsRow['totalAmount'];		
	$discountAmount				=	$invoiceAmtDetailsRow['discountAmount'];	
	$discountPercent			=	$invoiceAmtDetailsRow['discountPercent'];	
	$totalAmountAfterDiscount	=	$invoiceAmtDetailsRow['totalAmountAfterDiscount'];
	$vatPercent					=	$invoiceAmtDetailsRow['vatPercent'];
	$vatAmount					=	$invoiceAmtDetailsRow['vatAmount'];
	$totalAmountWithVat			=	$totalAmount+$vatAmount;	
	$netAmount					=	$invoiceAmtDetailsRow['totalAmountWithVat'];
	$poNo						=	$invoiceAmtDetailsRow['poNo'];
	$dueDate                    =   $invoiceAmtDetailsRow['dueDate'];
	$damagedGoodsAmount         =   $invoiceAmtDetailsRow['damagedGoodsAmount'];
	$address         			=   $invoiceAmtDetailsRow['address'];
	$warehouseCustName         	=   $invoiceAmtDetailsRow['warehouseCustName'];
	$time					= 	$invoiceAmtDetailsRow['time'];
	$time_in_24  = date("H:i", strtotime($time));
	
	$customerNameArabic 			= 	$invoiceAmtDetailsRow['customerNameArabic'];
	$streetName      				= 	$invoiceAmtDetailsRow['streetName'];
	$buildingNo      				= 	$invoiceAmtDetailsRow['buildingNo'];
	$addlNo     	 				= 	$invoiceAmtDetailsRow['addlNo'];
	$postalCode      				= 	$invoiceAmtDetailsRow['postalCode'];
	$city      		 				= 	$invoiceAmtDetailsRow['city'];
	$district      	 				= 	$invoiceAmtDetailsRow['district'];
	$country     	 				= 	$invoiceAmtDetailsRow['country'];
	$vatNoArab						=   $invoiceAmtDetailsRow['vatNoArabic'];
	$streetNameArab					=   $invoiceAmtDetailsRow['streetArabic'];
	$buildingNoArab					=   $invoiceAmtDetailsRow['buildingArabic'];
	$addlNoArab					    =   $invoiceAmtDetailsRow['addlNoArabic'];
	$postalCodeArab					=   $invoiceAmtDetailsRow['postalArabic'];
	$cityArab					    =   $invoiceAmtDetailsRow['cityArabic'];
	$districtArab					=   $invoiceAmtDetailsRow['districtArabic'];
	$countryArab					=   $invoiceAmtDetailsRow['countryArabic'];
	$transactionType                =   $invoiceAmtDetailsRow['transactionType'];
	$invoiceRefId                   =   $invoiceAmtDetailsRow['invoiceRefId'];
	$qrValue                   		=   $invoiceAmtDetailsRow['qrValue'];
	$zakatInvoiceType				= 	$invoiceAmtDetailsRow['zakatInvoiceType'];
	$branchId                   	=   $invoiceAmtDetailsRow['branchId'];
	$privilageIdFromDb             = 	$invoiceAmtDetailsRow['privilageId'];
}


$salesman                        = 	$objMSalesInvoice->getSalesman($branchId);

/*
$codeContent='Company Name : ABDULLAH MOHAMMED ALGHAMDI TRD.EST'."\n";
$codeContent.='Company Vat No : 300099808500003'."\n";
$codeContent.=' Invoice No : '.$invoiceNo.''."\n";
$codeContent.=' Invoice Date : '. implode("-",array_reverse(explode("-",$invoiceDate))).' '.$time.''."\n".
'Vat Amt : '. number_format($vatAmount,2,'.','') .''."\n".
'Total With Vat: '.number_format($netAmount,2,'.','') .'';

$qr = base64_encode($codeContent);
$filePath = $filename.$invoiceId;
QRcode::png($qr, $filename.$invoiceId,'L',2, 2);  
$qrImage = file_get_contents($filePath); 
$img = '<img src="data:image/png;base64,'.base64_encode($qrImage).'" />';   
*/


		$tag1 = $this->gethexadecimalvalueforstring('01','Naf Al Abeer Food Trading Est.');
	    $b1 = pack("H*" , $tag1);
	    $tag2 =  $this->gethexadecimalvalueforstring('02','');
	    $b2 = pack("H*" , $tag2);
		$tag3 = $this->gethexadecimalvalueforstring('03',$invoiceDate.'T'.$time_in_24.'Z');
		$b3 = pack("H*" , $tag3);
		$tag4 =  $this->gethexadecimalvalueforstring('04',$netAmount);
		$b4 = pack("H*" , $tag4);
		$tag5 =  $this->gethexadecimalvalueforstring('05',$vatAmount);
		$b5 = pack("H*" , $tag5);
		if($qrValue != "")
		{
			$arr = $qrValue;
		}
		else
		{
			$arr = base64_encode($b1.$b2.$b3.$b4.$b5);
		}
		
		QRcode::png($arr, $filename.$invoiceId.'.png','L',2, 2);  
	
	
	$path = $filename.$invoiceId.'.png';
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = file_get_contents($path);
	$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
	unlink($filename.$invoiceId.'.png');
	
if($privilageId==2 || $privilageIdFromDb=2 || $privilageId==6)
{
	$customerName				=	$warehouseCustName ;
}
	$invoiceDetails		=	$objMSalesInvoice->getInvoiceDetails($invoiceId);
	$checkDiscount		=	$objMSalesInvoice->checkDiscount($invoiceId);

	$thead	='<table border="0" width="100%" cellpadding="1" class="hideDiv">
				<tr>
					<td align="center" colspan="3">
						<img src="../../../../modules/salesInvoice/admin/includes/logo.jpg"  width="250" height="60">
					</td>
				</tr>
				<tr>
					<th width="45%" align="left"> <br/></th>
					<td width="5%">&nbsp;</td>
					<th width="40%" style="text-align: right;"><b> </b></th>
				</tr>
				<tr>
					<th align="left"></th>
					<th></th>
					<th style="text-align: right;"> <b> </b></th>
				</tr>
				
				<tr>
					<th align="left"></th>
					<th></th>
					<th style="text-align: right;"><b>   </b></th>
				</tr>
				<tr>
					<th align="left">VAT NO:</th>
					<th></th>
					<th style="text-align: right;"> <b>     </b></th>
				</tr>
			 </table>
	<br/><br/>
	<table border="0" width="100%" cellpadding="10"  style="font-size: 13px;">
	<thead>
		<tr>
			<td  colspan="3" width="100%" align="center"><b><u>VAT INVOICE(فاتورة الضريبية )</u></b></td>
		</tr>
		<tr>
			<td  width="50%">TO: '.$customerName.'<br/>'.$address .'</td>
			<td class="tdd" width="25%"></td>
			<td class="tdd" width="25%">INVOICE NO: '.$invoiceNo.'</td>
		</tr>
		<tr>
			<td class="tdd">VAT NO: '.$vatNumber.'</td>
			<td class="tdd"></td>
			<td>INVOICE DATE: '.date_format(date_create($invoiceDate),"d-m-Y").'</td>
		</tr>
		<!--<tr>
			<td>PO No:'.$poNo.'</td>
			<td>DUE DATE</td>
			<td>'.$dueDate.'</td>
		</tr>-->
		<!--<tr>
			<td></td>
			<td>DELIVERY DATE</td>
			<td>'.date_format(date_create($invoiceDate),"d-m-Y").'</td>
		</tr>
		<tr>
			<td>DEL.ADD : '.$vesselName.'</td>
			<td></td>
			<td</td>
		</tr>-->
	</thead>
</table><br/>';

/*if($checkDiscount==0)
{
	$tbody .='<table width="100%" border="1" style="border-collapse:collapse">
				<thead>
			<tr>
				<td align="center" width="3%">#</td>
				<td width="12%">Barcode/Item</td>
				<td align="center" width="5%">Qty</td>
				<td align="center" width="5%">Unit</td>
				<td align="center" width="8%" >Price</td>
				<td align="center" width="8%">Amount</td>
				<!--<td align="center" width="5%">Dis%</td>
				<td align="center" width="5%">Vat%</td>-->
				<td align="center" width="8%">Vat Amt</td>
				<td align="center" width="8%">Amt With Vat</td>
			</tr>	
		</thead>
	<tbody>';
}else{*/
if($invoiceRefId==''){
	$tbody .='<table width="100%" border="1"  style="font-size: 12px !important;border-collapse:collapse">
				<thead>
			<tr>
				<td align="center" width="3%">#</td>
				<td width="12%">Barcode/Item(الاسم الصنف)</td>
				<td align="center" width="5%">Qty<br/>الكمية </td>
				<td align="center" width="5%">Unit<br/>وحدة</td>
				<td align="center" width="5%">Weight<br/>الوزن </td>
				<td align="center" width="8%" >Price (SR)<br/>السعر</td>
				<td align="center" width="8%">Amount (SR)<br/>المبلغ </td>
				<td align="center" width="5%">Vat(SR)<br/>ﺿﺮﻳﺒﺔ</td>
				<td align="center" width="8%">Amt With Vat(SR)<br/>اﻟﻤﺒﻠﻎ اﻹﺟﻤﺎﻟ</td>
				<!--<td align="center" width="5%">Disc</td>
				<td align="center" width="5%">Vat%</td>
				<td align="center" width="8%">Vat Amt</td>
				<td align="center" width="8%">Amt With Vat</td>-->
			</tr>	
		</thead>
	<tbody>';
}else{
    	$tbody .='<table width="100%" border="1"  style="font-size: 12px !important;border-collapse:collapse">
				<thead>
			<tr>
				<td align="center" width="3%">#</td>
				<td width="12%">Barcode/Item(الاسم الصنف)</td>
				<td align="center" width="5%">Qty<br/>الكمية </td>
				<td align="center" width="5%">Unit<br/>وحدة</td>
				<td align="center" width="5%">Weight<br/>الوزن </td>
				<td align="center" width="8%" >Price (SR)<br/>السعر</td>
				<td align="center" width="8%">Amount (SR)<br/>المبلغ </td>
				<!--<td align="center" width="5%">Disc</td>
				<td align="center" width="5%">Vat%</td>
				<td align="center" width="8%">Vat Amt</td>
				<td align="center" width="8%">Amt With Vat</td>-->
			</tr>	
		</thead>
	<tbody>';
    
}
//}	



	while($invoiceDetailsRow	=	mysqli_fetch_array($invoiceDetails))
		{
			/*if($checkDiscount==0)
			{
				$tbody.='<tr>
			<td align="center" width="3%">'.$i.'</td>
			<td width="12%">'.$invoiceDetailsRow['itemCode'].'</td>
		
			<td align="center" width="5%">'.$invoiceDetailsRow['quantity'].'</td>
			<td align="center" width="5%">'.$invoiceDetailsRow['unitName'].'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['unitPrice'],2).'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['amount'],2).'</td>
			<!--<td align="center" width="5%">'.$invoiceDetailsRow['discountPercent'].'</td>
			<td align="center" width="5%">'.$invoiceDetailsRow['vatPercent'].'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['vatAmount'],2).'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['amountWithVat'],2).'</td>-->
		</tr>';
			}else{*/
			if($invoiceRefId==''){
					$tbody.='<tr>
			<td align="center" width="3%">'.$i.'</td>
			<td width="12%">'.$invoiceDetailsRow['itemCode'].'/'.$invoiceDetailsRow['itemName'].'('.$invoiceDetailsRow['itemNameArabic'].')</td>
			
			<td align="right" width="5%">'.$invoiceDetailsRow['quantity'].'</td>
			<td align="center" width="5%">'.$invoiceDetailsRow['unitName'].'</td>
			<td align="right" width="5%">'.number_format($invoiceDetailsRow['netWeight'],2).'</td>
			<td align="right" width="8%">'.number_format($invoiceDetailsRow['unitPrice'],2).'</td>
			<td align="right" width="8%">'.number_format($invoiceDetailsRow['amount'],2).'</td>
				<td align="right" width="8%">'.number_format($invoiceDetailsRow['vatAmount'],2).'</td>
			<td align="right" width="8%">'.number_format($invoiceDetailsRow['amountWithVat'],2).'</td>
			
			
			
		</tr>';
		/*<td align="center" width="5%">'.number_format($invoiceDetailsRow['discountPercent'],2).'</td>
			<td align="center" width="5%">'.$invoiceDetailsRow['vatPercent'].'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['vatAmount'],2).'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['amountWithVat'],2).'</td>*/
			//}
				$i++;
				$qtyTotal         			=	$qtyTotal +$invoiceDetailsRow['quantity'];
				$netWtTotal         		=	$netWtTotal +$invoiceDetailsRow['netWeight'];
			}else{
			    	$tbody.='<tr>
			<td align="center" width="3%">'.$i.'</td>
			<td width="12%">'.$invoiceDetailsRow['itemCode'].'/'.$invoiceDetailsRow['itemName'].'('.$invoiceDetailsRow['itemNameArabic'].')</td>
			
			<td align="right" width="5%">'.$invoiceDetailsRow['quantity'].'</td>
			<td align="center" width="5%">'.$invoiceDetailsRow['unitName'].'</td>
			<td align="right" width="5%">'.number_format($invoiceDetailsRow['netWeight'],2).'</td>
			<td align="right" width="8%">'.number_format($invoiceDetailsRow['unitPrice'],2).'</td>
			<td align="right" width="8%">'.number_format($invoiceDetailsRow['amount'],2).'</td>
			<!--<td align="center" width="5%">'.number_format($invoiceDetailsRow['discountPercent'],2).'</td>
			<td align="center" width="5%">'.$invoiceDetailsRow['vatPercent'].'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['vatAmount'],2).'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['amountWithVat'],2).'</td>-->
		</tr>';
			//}
				$i++;
				$qtyTotal         			=	$qtyTotal +$invoiceDetailsRow['quantity'];
				$netWtTotal         		=	$netWtTotal +$invoiceDetailsRow['netWeight'];
			    
			}
		}
		if($invoiceRefId==''){
	$tbody.='<tr>	
		<td>&nbsp;</td>
		<td align="right">Total</td>
		<td align="right">'.$qtyTotal.'</td>
		<td>&nbsp;</td>
		<td align="right">'.number_format($netWtTotal,2).'</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
			<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr><tr>
		<td colspan="8" align="right">Total Excl VAT/الأجمالي بدون القيمة المضافة</td>
		<td   align="right" >'.number_format($totalAmount,2).'</td>
	</tr>
	<tr>
		<td colspan="8" align="right">Discount('.$discountPercent.'%)</td>
		<td  align="right" >'.number_format($discountAmount,2).'</td>
	</tr>
	<tr>
		<td colspan="8" align="right">Total After Discount :</td>
		<td  align="right" >'.number_format($totalAmountAfterDiscount,2).'</td>
	</tr>';
	
$tbody.='<tr>
		<td colspan="8" align="right">VAT TAX('.$vatPercent.'%) /القيمة المضافة :</td>
		<td  align="right" >'.number_format($vatAmount,2).'</td>
	</tr>
	
	
	<tr>
		<td colspan="8" align="right">Total Incl Vat /المبلغ الإجمالي  :</td>
		<td  align="right" ><b>'.number_format($netAmount,2).'</b></td>
	</tr>';
		}else{
		   	$tbody.='<tr>	
		<td>&nbsp;</td>
		<td align="right">Total</td>
		<td align="right">'.$qtyTotal.'</td>
		<td>&nbsp;</td>
		<td align="right">'.number_format($netWtTotal,2).'</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr><tr>
		<td colspan="6" align="right">Total Excl VAT/الأجمالي بدون القيمة المضافة</td>
		<td   align="right" >'.number_format($totalAmount,2).'</td>
	</tr>
	<tr>
		<td colspan="6" align="right">Discount('.$discountPercent.'%)</td>
		<td  align="right" >'.number_format($discountAmount,2).'</td>
	</tr>
	<tr>
		<td colspan="6" align="right">Total After Discount :</td>
		<td  align="right" >'.number_format($totalAmountAfterDiscount,2).'</td>
	</tr>';
	
$tbody.='<tr>
		<td colspan="6" align="right">VAT TAX('.$vatPercent.'%) /القيمة المضافة :</td>
		<td  align="right" >'.number_format($vatAmount,2).'</td>
	</tr>
	 
	
	<tr>
		<td colspan="6" align="right">Total Incl Vat /المبلغ الإجمالي  :</td>
		<td  align="right" ><b>'.number_format($netAmount,2).'</b></td>
	</tr>'; 
		    
		}
	
	
	
		$tbody.='</tbody></table>
	
		<br>
	<div width="100%" height="10%" style="border:0px solid black;">
	<table width="100%" border="0" style="border-collapse:collapse;font-size:11px;">
		<tr>
			<td align="center" colspan="3" style="padding-left:1em;text-align:left;border-bottom:1px solid black;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;letter-spacing:0.1em;"><b>BANK DETAILS</td>

			<td rowspan="5" align="center" style="border-right:1px solid black;border-bottom:1px solid black;border-left:1px solid black;border-top:1px solid black;"><img src="'.$base64.'" height="100px" width="100px" ></td>

		</tr>
		<!--<tr>
			<td align="center" colspan="3" style="padding-left:1em;text-align:left;border-bottom:1px solid black;border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;letter-spacing:0.1em;"><b>ABDULLAH MOHAMMED ALGHAMDI TRD.EST </td>
		</tr>--> 
		<tr>
			<td align="" style="padding-left:1em;border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid black;"><b>BANK</td>
			<td align="" style="padding-left:1em;border-right:1px solid black;border-bottom:1px solid black;"><b>Account No</td>
			<td align="" style="padding-left:1em;border-right:1px solid black;border-bottom:1px solid black;"><b>IBAN No</td>
		</tr>
		<tr>
			<td  style="padding-left:1em;border-right:1px solid black;border-left:1px solid black;"> </td>
			<td style="padding-left:1em;border-right:1px solid black;"></td>
			<td style="padding-left:1em;border-right:1px solid black;">     </td>
		</tr>
		<tr>
			<td style="padding-left:1em;border-right:1px solid black;border-left:1px solid black;">  </td>
			<td style="padding-left:1em;border-right:1px solid black;border-bottom:0px solid black;"></td>
			<td style="padding-left:1em;border-right:1px solid black;">     </td>
		</tr>
		<tr>
			<td style="padding-left:1em;border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid black;"> </td>
			<td style="padding-left:1em;border-right:1px solid black;border-bottom:1px solid black;"></td>
			<td style="padding-left:1em;border-right:1px solid black;border-bottom:1px solid black;"></td>
		</tr>
	</table>
	</div>
<!--	<table width="100%" style="font-size: 13px;height:25%">
						<tr>
						<th  colspan="12">&nbsp;</th>
						</tr>
						<tr>
						<th colspan="12" style="text-align:center;position: absolute; left:80mm;width:25%">
			<img src="'.$base64.'" width="120px" height="120px">
		</th>
						
						</tr>
							<tr>
							<th colspan="6" style="text-align:center">SALESMAN(مندوب مبيعات)</th>
						
							<th colspan="6" style="text-align:center">CUSTOMER(الزبون)</tk>
							</tr>
					</table>-->
				';
				
	$invoiceData	=	array('tbody'=>$tbody,'thead'=>$thead,'img'=>$base64,'customerName'=>$customerName,
	'address'=>$address,'invoiceNo'=>$invoiceNo,'vatNumber'=>$vatNumber,'invoiceDate'=>$invoiceDate,
	'nameArabic'=>$customerNameArabic,
	'streetName'=>$streetName,'buildingNo'=>$buildingNo,'addlNo'=>$addlNo,'postalCode'=>$postalCode,'city'=>$city,'district'=>$district,'country'=>$country,
	'streetArabic'=>$streetNameArab,'buildingArabic'=>$buildingNoArab,'addlNoArabic'=>$addlNoArab,'cityArabic'=>$cityArab,
	'countryArabic'=>$countryArab,'postalArabic'=>$postalCodeArab,'vatNoArabic'=>$vatNoArab,'districtArabic'=>$districtArab,'transactionType'=>$transactionType, 'zakatInvoiceType'=>$zakatInvoiceType,'salesman'=>$salesman);
	return $invoiceData;
}
function getInvoiceDetailsThermalprint($invoiceId)
{
	$i				=	1;
	$tbody			=	'';
	$invoiceData	=	'';
	$thead			=	'';
	$codeContent ='';
	$invoiceNo					=	'';
	$invoiceDate				=	'';
	$customerName				=	'';
	$vatNumber					=	'';
	$vesselName					=	'';
	$poNo						=	'';
	$dueDate                    =   '';
	$totalAmount				=	0;
	$discountAmount				=	0;	
	$discountPercent			=	0;
	$totalAmountAfterDiscount	=	0;
	$vatPercent					=	0;
	$vatAmount					=	0;
	$totalAmountWithVat			=	0;	
	$netAmount					=	0;
	$address         			=	'';
	$damagedGoodsAmount         =	0;
	$qtyTotal         			=	0;
	$netWtTotal         		=	0;
	$time                       ='';
	$warehouseCustName          =  '';
	$filename ='../../../../modules/salesInvoice/admin/includes/qrCodeGenerator/temp/';

$privilageId       	 	=   	$_COOKIE['privillegeId'];
$branchId        		=   	$_COOKIE['branchId'];
$userId					=	$_COOKIE['userId'];
$mainBranch        		= 	$_COOKIE['mainBranch'];

	$objMSalesInvoice	= 	new M_salesInvoice();
	$invoiceAmountDetails =	$objMSalesInvoice->getInvoiceBasicDetails($invoiceId);
	$userName				=	$objMSalesInvoice->getUserName($userId);


while($invoiceAmtDetailsRow	=	mysqli_fetch_array($invoiceAmountDetails))
{
$invoiceNo					=	$invoiceAmtDetailsRow['invoiceNo'];
$invoiceDate				=	$invoiceAmtDetailsRow['invoiceDate'];
$customerName				=	$invoiceAmtDetailsRow['customerName'];
$vatNumber					=	$invoiceAmtDetailsRow['vatNumber'];
$vesselName					=	$invoiceAmtDetailsRow['vesselName'];
$totalAmount				=	$invoiceAmtDetailsRow['totalAmount'];		
$discountAmount				=	$invoiceAmtDetailsRow['discountAmount'];	
$discountPercent			=	$invoiceAmtDetailsRow['discountPercent'];	
$totalAmountAfterDiscount	=	$invoiceAmtDetailsRow['totalAmountAfterDiscount'];
$vatPercent					=	$invoiceAmtDetailsRow['vatPercent'];
$vatAmount					=	$invoiceAmtDetailsRow['vatAmount'];
$totalAmountWithVat			=	$totalAmount+$vatAmount;	
$netAmount					=	$invoiceAmtDetailsRow['totalAmountWithVat'];
$poNo						=	$invoiceAmtDetailsRow['poNo'];
$dueDate                    =   $invoiceAmtDetailsRow['dueDate'];
$damagedGoodsAmount         =   $invoiceAmtDetailsRow['damagedGoodsAmount'];
$cuttingCharge         		=   $invoiceAmtDetailsRow['cuttingCharge'];
$address         			=   $invoiceAmtDetailsRow['address'];
$warehouseCustName         	=   $invoiceAmtDetailsRow['warehouseCustName'];
$time					= 	$invoiceAmtDetailsRow['time'];
$time_in_24  = date("H:i", strtotime($time));
}

/*
$codeContent='Company Name : ABDULLAH MOHAMMED ALGHAMDI TRD.EST'."\n";
$codeContent.='Company Vat No : 300099808500003'."\n";
$codeContent.=' Invoice No : '.$invoiceNo.''."\n";
$codeContent.=' Invoice Date : '. implode("-",array_reverse(explode("-",$invoiceDate))).' '.$time.''."\n".
'Vat Amt : '. number_format($vatAmount,2,'.','') .''."\n".
'Total With Vat: '.number_format($netAmount,2,'.','') .'';

$qr = base64_encode($codeContent);
$filePath = $filename.$invoiceId;
QRcode::png($qr, $filename.$invoiceId,'L',2, 2);  
$qrImage = file_get_contents($filePath); 
$img = '<img src="data:image/png;base64,'.base64_encode($qrImage).'" />';   
*/

$tag1 = $this->gethexadecimalvalueforstring('01','Naf Al Abeer Food Trading Est.');
	$b1 = pack("H*" , $tag1);
	$tag2 =  $this->gethexadecimalvalueforstring('02','');
	$b2 = pack("H*" , $tag2);
	$tag3 = $this->gethexadecimalvalueforstring('03',$invoiceDate.'T'.$time_in_24.'Z');
	$b3 = pack("H*" , $tag3);
	$tag4 =  $this->gethexadecimalvalueforstring('04',$netAmount);
	$b4 = pack("H*" , $tag4);
	$tag5 =  $this->gethexadecimalvalueforstring('05',$vatAmount);
	$b5 = pack("H*" , $tag5);
	
	

	$arr = base64_encode($b1.$b2.$b3.$b4.$b5);
	QRcode::png($arr, $filename.$invoiceId.'.png','L',2, 2);  


$path = $filename.$invoiceId.'.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
unlink($filename.$invoiceId.'.png');

if($privilageId==2 || $privilageId==6)
{
$customerName				=	$warehouseCustName ;
}
$invoiceDetails		=	$objMSalesInvoice->getInvoiceDetails($invoiceId);
$checkDiscount		=	$objMSalesInvoice->checkDiscount($invoiceId);

$thead	='<table border="0" width="100%" cellpadding="1" class="hideDiv divFullWidth" >
			
			<tr>
				<th width="46%" align="left">  <br> <br></th>
				<td width="5%">&nbsp;</td>
				<th width="40%" style="text-align: right;"><b>         <br>   </b></th>
			</tr>
			<tr>
				<th align="left"></th>
				<th></th>
				<th style="text-align: right;"><b></b></th>
			</tr>
			<tr class="companyHeader">
						<th align="center" width="100%">
							Naf Al Abeer Food Trading Est / 
						</th>
					</tr>
					<tr class="companyHeader">
						<th align="center" width="100%">
							مؤسسة ناف العبير لتجارة المواد الغذائية.
						</th>
					</tr>
			<table>
			<table border="0" width="100%" cellpadding="1" class="hideDiv divFullWidth" >';
if($privilageId==2&&$mainBranch=='M')
	{
		$thead	.='	<tr>
				<th align="left" width="50%%">CR NO </th>
				<!--<th></th>-->
				<th style="text-align: right;"><b>الرقم سجل تجاري</b></th>
			</tr>
			<tr>
				<th align="left">VAT NO: </th>
				<!--<th width="35%"></th>-->
				<th style="text-align: right;"><b> رقم الضريبة</b></th>
			</tr>
			';
	}
	else{
		$thead	.='	
			<tr>
				<th align="left" width="50%">CR NO:</th>
				<!--<th></th>-->
				<th style="text-align: right;" width="50%">الرقم سجل تجاري</th>
			</tr>
			<tr>
				<th align="left">VAT NO:</th>
				<!--<th width="35%"></th>-->
				<th style="text-align: right;">رقم الضريبة</th>
			</tr>
			';
	}
$thead	.='</table>
<br/><br/>
<table border="0" width="100%" cellpadding="10"  style="font-size: 13px;" class="divFullWidth">
<thead>
	<tr>
		<td  colspan="3" width="100%" align="center"><b><u>VAT INVOICE(فاتورة الضريبية )</u></b></td>
	</tr>
	<tr>
		<td  width="48%" style="padding:0 0 2PX 0;">TO: '.$customerName.'<br/>'.$address .'</td>
		<!--<td class="tdd" ></td>-->
		<td width="51%" style="padding:0 0 2PX 0;" align="right">INV NO: '.$invoiceNo.'</td>
	</tr>
	<tr>
		<td class="tdd" style="padding:0 0 2PX 0;">VAT NO:'.$vatNumber.'</td>
		<!--<td class="tdd"></td>-->
		<td width="49%" style="padding:0 0 2PX 0;" align="right">INV DATE: '.date_format(date_create($invoiceDate),"d-m-Y").'</td>
	</tr>
	<!--<tr>
		<td>PO No:'.$poNo.'</td>
		<td>DUE DATE</td>
		<td>'.$dueDate.'</td>
	</tr>-->
	<!--<tr>
		<td></td>
		<td>DELIVERY DATE</td>
		<td>'.date_format(date_create($invoiceDate),"d-m-Y").'</td>
	</tr>
	<tr>
		<td>DEL.ADD : '.$vesselName.'</td>
		<td></td>
		<td</td>
	</tr>-->
</thead>
</table><br/>';

/*if($checkDiscount==0)
{
$tbody .='<table width="100%" border="1" style="border-collapse:collapse">
			<thead>
		<tr>
			<td align="center" width="3%">#</td>
			<td width="12%">Barcode/Item</td>
			<td align="center" width="5%">Qty</td>
			<td align="center" width="5%">Unit</td>
			<td align="center" width="8%" >Price</td>
			<td align="center" width="8%">Amount</td>
			<!--<td align="center" width="5%">Dis%</td>
			<td align="center" width="5%">Vat%</td>-->
			<td align="center" width="8%">Vat Amt</td>
			<td align="center" width="8%">Amt With Vat</td>
		</tr>	
	</thead>
<tbody>';
}else{*/
$tbody .='<table width="100%" border="1"  style="font-size: 12px !important; border-collapse:collapse;" class="divFullWidth">
			<thead>
		<tr>
			<td align="center" width="3%">#</td>
			<td width="17%" align="center">Barcode/Item<br>الاسم الصنف</td>
			<td align="center" width="5%">Qty<br/>الكمية </td>
			<td align="center" width="5%">Unit<br/>وحدة</td>
			<!--<td align="center" width="5%">Weight<br/>الوزن </td>-->
			<td align="center" width="8%" >Price<br/>(SR)<br/>السعر</td>
			<td align="center" width="8%">Amount (SR)<br/>المبلغ </td>
			<!--<td align="center" width="5%">Disc</td>
			<td align="center" width="5%">Vat%</td>
			<td align="center" width="8%">Vat Amt</td>
			<td align="center" width="8%">Amt With Vat</td>-->
		</tr>	
	</thead>
<tbody>';
//}	



while($invoiceDetailsRow	=	mysqli_fetch_array($invoiceDetails))
	{
		/*if($checkDiscount==0)
		{
			$tbody.='<tr>
		<td align="center" width="3%">'.$i.'</td>
		<td width="12%">'.$invoiceDetailsRow['itemCode'].'</td>
	
		<td align="center" width="5%">'.$invoiceDetailsRow['quantity'].'</td>
		<td align="center" width="5%">'.$invoiceDetailsRow['unitName'].'</td>
		<td align="center" width="8%">'.number_format($invoiceDetailsRow['unitPrice'],2).'</td>
		<td align="center" width="8%">'.number_format($invoiceDetailsRow['amount'],2).'</td>
		<!--<td align="center" width="5%">'.$invoiceDetailsRow['discountPercent'].'</td>
		<td align="center" width="5%">'.$invoiceDetailsRow['vatPercent'].'</td>
		<td align="center" width="8%">'.number_format($invoiceDetailsRow['vatAmount'],2).'</td>
		<td align="center" width="8%">'.number_format($invoiceDetailsRow['amountWithVat'],2).'</td>-->
	</tr>';
		}else{*/
				$tbody.='<tr>
		<td align="center" width="3%">'.$i.'</td>
		<td width="17%">'.$invoiceDetailsRow['itemCode'].'/'.$invoiceDetailsRow['itemName'].'('.$invoiceDetailsRow['itemNameArabic'].')</td>
		
		<td align="right" width="5%">'.$invoiceDetailsRow['quantity'].'</td>
		<td align="center" width="5%">'.$invoiceDetailsRow['unitName'].'</td>
		<!--<td align="right" width="5%">'.number_format($invoiceDetailsRow['netWeight'],2).'</td>-->
		<td align="right" width="8%">'.number_format($invoiceDetailsRow['unitPrice'],2).'</td>
		<td align="right" width="8%">'.number_format($invoiceDetailsRow['amount'],2).'</td>
		
	</tr>';

	/*<!--<td align="center" width="5%">'.number_format($invoiceDetailsRow['discountPercent'],2).'</td>
		<td align="center" width="5%">'.$invoiceDetailsRow['vatPercent'].'</td>
		<td align="center" width="8%">'.number_format($invoiceDetailsRow['vatAmount'],2).'</td>
		<td align="center" width="8%">'.number_format($invoiceDetailsRow['amountWithVat'],2).'</td>-->*/
		//}
			$i++;
			$qtyTotal         			=	$qtyTotal +$invoiceDetailsRow['quantity'];
			$netWtTotal         		=	$netWtTotal +$invoiceDetailsRow['netWeight'];
	}

$tbody.='<tr>	
	<td>&nbsp;</td>
	<td align="right">Total</td>
	<td align="right">'.$qtyTotal.'</td>
	<td>&nbsp;</td>
	
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr><tr>
	<td colspan="5" align="right">Total Excl VAT/ الأجمالي بدون القيمة المضافة :</td>
	<td   align="right" >'.number_format($totalAmount,2).'</td>
</tr>
<tr>
	<td colspan="5" align="right">Discount('.$discountPercent.'%) :</td>
	<td  align="right" >'.number_format($discountAmount,2).'</td>
</tr>
<tr>
	<td colspan="5" align="right">Total After Discount :</td>
	<td  align="right" >'.number_format($totalAmountAfterDiscount,2).'</td>
</tr>';
//if($damagedGoodsAmount>0)
//{
	/*$tbody.='<tr>
			<td colspan="6" align="right">Damage Goods Amount :</td>
			<td  align="right" >'.number_format($damagedGoodsAmount,2).'</td>
		</tr>';*/
//}
if($privilageId==2&&$mainBranch=='M')
	{
		$tbody.='<tr>
			<td colspan="5" align="right">Cutting Charge :</td>
			<td  align="right" >'.number_format($cuttingCharge,2).'</td>
		</tr>';
	}
$tbody.='<tr>
	<td colspan="5" align="right">VAT TAX('.$vatPercent.'%) /القيمة المضافة :</td>
	<td  align="right" >'.number_format($vatAmount,2).'</td>
</tr>


<tr>
	<td colspan="5" align="right">Total Incl Vat /المبلغ الإجمالي  :</td>
	<td  align="right" ><b>'.number_format($netAmount,2).'</b></td>
</tr></tbody></table><br>
<table width="100%" style="font-size: 13px;" border="0">
					<tr>
					<td colspan="12" align="center">
						<img src="'.$base64.'" width="120px" height="120px" style="margin-top:1px !important;">
					</td>
					</tr>
					<tr>
					<th  colspan="12">&nbsp;</th>
					</tr>
						<tr>
						<th colspan="6" style="text-align:center">SALESMAN(مندوب مبيعات)</th>
					
						<th colspan="6" style="text-align:center">CUSTOMER(الزبون)</tk>
						</tr>';
				if($privilageId==2&&$mainBranch=='M')
				{		
			$tbody.='	<tr>
							<th colspan="5" style="text-align:left">USER: '.$userName.'</th>
						</tr>';
				}
						
				$tbody.='</table>
			';	
$invoiceData	=	array('tbody'=>$tbody,'thead'=>$thead);
return $invoiceData;
}
function getSalesPaymentVoucherNo()
{
	$objMSalesInvoice			= 	new M_salesInvoice();
    $salesPaymentVoucherNo1		=	$objMSalesInvoice->getSalesPaymentVoucherNo();
	while($salesPaymentVoucherNoRow	=	mysqli_fetch_array($salesPaymentVoucherNo1))
				{
					$salesPaymentVoucherNo	=	$salesPaymentVoucherNoRow['salesPaymentVoucherNo'];
				}
	return 	$salesPaymentVoucherNo;		
}
function insertToCustomerSalesPayment($invoiceId,$invoiceDate,$netAmount,$salesPaymentVoucherNo,$exRate,$userId)
{
	$objMSalesInvoice			= 	new M_salesInvoice();
	//$netAmount					=	number_format(($netAmount*$exRate),2,'.','');
    $customerSalesPaymentId		=	$objMSalesInvoice->insertToCustomerSalesPayment($invoiceId,$invoiceDate,$netAmount,$salesPaymentVoucherNo,$userId);
	return $customerSalesPaymentId;
}
function checkDeliveryNoteDuplication($deliveryNoteId)
{
	$objMSalesInvoice			= 	new M_salesInvoice();
    $deliveryNoteExist			=	$objMSalesInvoice->checkDeliveryNoteDuplication($deliveryNoteId);
	return $deliveryNoteExist;
}
	/*-----------------------------------------------Accounts Starts-------------------------------------*/
		 function getSubAccountId($regularCustomerId)
		 {
			 $subAccountHeadId	=	'';
			$objMSalesInvoice	= 	new M_salesInvoice();
        	$getSubAccountData			=	$objMSalesInvoice->getSubAccountId($regularCustomerId);
			while($getSubAccountDataRow	=	mysqli_fetch_array($getSubAccountData))
				{
					$subAccountHeadId	=	$getSubAccountDataRow['subAccountHeadId'];
				}
				return $subAccountHeadId;
         }
		
		function insertToAccountJournel($invoiceDate,$netAmount,$subAccountHeadId,$invoiceNo,$customerName,$invoiceId,$discountInAmount,$totalAfterDiscount,$vatAmount,$transactionType,$salesPaymentVoucherNo,$exRate,$totalCostValue,$damagedGoodsAmount,$cuttingCharge,$regularCustomerId)
		{
			
			
			$objMSalesInvoice	= 	new M_salesInvoice();
			if($damagedGoodsAmount==''||$damagedGoodsAmount==null)
			{
				$damagedGoodsAmount	=	0;
			}
			$accountJournalCreditAmount	=	$totalAfterDiscount-$damagedGoodsAmount;
			$debitAmount		=	number_format(($netAmount*$exRate), 2, '.', '');
			$discountInAmount	=	number_format(($discountInAmount*$exRate), 2, '.', '');
			$accountJournalCreditAmount	=	number_format(($accountJournalCreditAmount*$exRate), 2, '.', '');
			$netAmount			=	number_format(($netAmount*$exRate), 2, '.', '');
			$vatAmount			=	number_format(($vatAmount*$exRate), 2, '.', '');
			//$totalCostValue     =   number_format(($totalCostValue*$exRate), 2, '.', '');
			$cuttingCharge      =   number_format(($cuttingCharge*$exRate), 2, '.', '');
			
        	$insertNetAmountToAccountJournelDebit			=	$objMSalesInvoice->insertNetAmountToAccountJournelDebit($invoiceDate,$debitAmount,$subAccountHeadId,$invoiceNo,$customerName,$invoiceId,$regularCustomerId);
			$insertDiscountToAccountJournelDebit			=	$objMSalesInvoice->insertDiscountToAccountJournelDebit($invoiceDate,$discountInAmount,$invoiceNo,$customerName,$invoiceId);
			$insertWuthoutVatTotalToAccountJournelCredit	=	$objMSalesInvoice->insertWuthoutVatTotalToAccountJournelCredit($invoiceDate,$accountJournalCreditAmount,$invoiceNo,$invoiceId);
			$insertVatAmountToAccountJournelCredit			=	$objMSalesInvoice->insertVatAmountToAccountJournelCredit($invoiceDate,$vatAmount,$invoiceNo,$invoiceId);
			// commented on 11-09-24 because no cutting charge in this project
			// $insertCuttingChargeToAccountJournelDebit		=	$objMSalesInvoice->insertCuttingChargeToAccountJournelDebit($invoiceDate,$cuttingCharge,$invoiceNo,$customerName,$invoiceId);
			// ends
			$insertCostAndStockValue                        =   $objMSalesInvoice->insertCostAndStockValue($invoiceDate,$customerName,$totalCostValue,$invoiceNo,$invoiceId);
			$privilageId       	 	=   	$_COOKIE['privillegeId'];
			if($regularCustomerId>0)
			{
				if($transactionType==1)
				{
				$insertSalesPaymentToAccountJurnalCredit		=	$objMSalesInvoice->insertSalesPaymentToAccountJurnalCredit($subAccountHeadId,$customerName,$netAmount,$invoiceDate,$salesPaymentVoucherNo,$invoiceNo,$invoiceId);
				$insertSalesPaymentToAccountJurnalDebit			=	$objMSalesInvoice->insertSalesPaymentToAccountJurnalDebit($netAmount,$invoiceDate,$salesPaymentVoucherNo,$invoiceNo,$invoiceId);	
				}
			}
			
			return $insertNetAmountToAccountJournelDebit;
		}
	
	/*-----------------------------------------------Accounts Ends-------------------------------------*/



	function getInvoiceDetailsDot($invoiceId)
	{

		$i				=	1;
		$tbody			=	'';
		$tbody1         = '';
		$invoiceData	=	'';
		$thead			=	'';
		$codeContent = '';
		$invoiceNo					=	'';
		$invoiceDate				=	'';
		$customerName				=	'';
		$vatNumber					=	'';
		$vesselName					=	'';
		$poNo						=	'';
		$dueDate                    =   '';
		$totalAmount				=	0;
		$discountAmount				=	0;	
		$discountPercent			=	0;
		$totalAmountAfterDiscount	=	0;
		$vatPercent					=	0;
		$vatAmount					=	0;
		$totalAmountWithVat			=	0;	
		$netAmount					=	0;
		$address         			=	'';
		$damagedGoodsAmount         =	0;
		$qtyTotal         			=	0;
		$netWtTotal         		=	0;
		$time                       ='';
		$warehouseCustName          =  '';
		$img ='';
		$privilageId       	 	=   	$_COOKIE['privillegeId'];
		$filename ='../../../../modules/salesInvoice/admin/includes/qrCodeGenerator/temp/'; 
		$objMSalesInvoice	= 	new M_salesInvoice();
		$invoiceAmountDetails =	$objMSalesInvoice->getInvoiceBasicDetails($invoiceId);
while($invoiceAmtDetailsRow	=	mysqli_fetch_array($invoiceAmountDetails))
	{
	$invoiceNo					=	$invoiceAmtDetailsRow['invoiceNo'];
	$invoiceDate				=	$invoiceAmtDetailsRow['invoiceDate'];
	$customerName				=	$invoiceAmtDetailsRow['customerName'];
	$vatNumber					=	$invoiceAmtDetailsRow['vatNumber'];
	$vesselName					=	$invoiceAmtDetailsRow['vesselName'];
	$totalAmount				=	$invoiceAmtDetailsRow['totalAmount'];		
	$discountAmount				=	$invoiceAmtDetailsRow['discountAmount'];	
	$discountPercent			=	$invoiceAmtDetailsRow['discountPercent'];	
	$totalAmountAfterDiscount	=	$invoiceAmtDetailsRow['totalAmountAfterDiscount'];
	$vatPercent					=	$invoiceAmtDetailsRow['vatPercent'];
	$vatAmount					=	$invoiceAmtDetailsRow['vatAmount'];
	$totalAmountWithVat			=	$totalAmount+$vatAmount;	
	$netAmount					=	$invoiceAmtDetailsRow['totalAmountWithVat'];
	$poNo						=	$invoiceAmtDetailsRow['poNo'];
	$dueDate                    =   $invoiceAmtDetailsRow['dueDate'];
	$damagedGoodsAmount         =   $invoiceAmtDetailsRow['damagedGoodsAmount'];
	$address         			=   $invoiceAmtDetailsRow['address'];
	$warehouseCustName         	=   $invoiceAmtDetailsRow['warehouseCustName'];
	$time					= 	$invoiceAmtDetailsRow['time'];
	$time_in_24  = date("H:i", strtotime($time));
}

//ob_start();
/*
$codeContent='Company Name : ABDULLAH MOHAMMED ALGHAMDI TRD.EST'."\n";
$codeContent.='Company Vat No : 300099808500003'."\n";
$codeContent.=' Invoice No : '.$invoiceNo.''."\n";
$codeContent.=' Invoice Date : '. implode("-",array_reverse(explode("-",$invoiceDate))).' '.$time.''."\n".
'Vat Amt : '. number_format($vatAmount,2,'.','') .''."\n".
'Total With Vat: '.number_format($netAmount,2,'.','') .'';

$qr = base64_encode($codeContent);
$filePath = $filename.$invoiceId;
QRcode::png($qr, $filename.$invoiceId,'L',2, 2);  
$qrImage = file_get_contents($filePath); 
$img = '<img src="data:image/png;base64,'.base64_encode($qrImage).'" />';
*/

		$tag1 = $this->gethexadecimalvalueforstring('01','ABDULLAH MOHAMMED ALGHAMDI TRD.EST');
	    $b1 = pack("H*" , $tag1);
	    $tag2 =  $this->gethexadecimalvalueforstring('02','300099808500003');
	    $b2 = pack("H*" , $tag2);
		$tag3 = $this->gethexadecimalvalueforstring('03',$invoiceDate.'T'.$time_in_24.'Z');
		$b3 = pack("H*" , $tag3);
		$tag4 =  $this->gethexadecimalvalueforstring('04',$netAmount);
		$b4 = pack("H*" , $tag4);
		$tag5 =  $this->gethexadecimalvalueforstring('05',$vatAmount);
		$b5 = pack("H*" , $tag5);
		
		
 
		$arr = base64_encode($b1.$b2.$b3.$b4.$b5);
		QRcode::png($arr, $filename.$invoiceId.'.png','L',2, 2);  
	
	
	$path = $filename.$invoiceId.'.png';
	$type = pathinfo($path, PATHINFO_EXTENSION);
	$data = file_get_contents($path);
	$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
	unlink($filename.$invoiceId.'.png');
//$imageString = base64_encode( ob_get_contents() );
//ob_end_clean();


/*QRcode::png('Company Name : ABDULLAH MOHAMMED ALGHAMDI TRD.EST 
					Company Vat No : 300099808500003
					 Invoice No : '.$invoiceNo.'
					 Invoice Date : '. implode("-",array_reverse(explode("-",$invoiceDate))).' '.$time.'
					 Vat Amt : '. number_format($vatAmount,2,'.','') .'
					 Total With Vat: '.number_format($netAmount,2,'.','') .'
		', $filename.$invoiceId.'.png','L',2, 2);   */
	
if($privilageId==2 || $privilageId==6)
{
	$customerName				=	$warehouseCustName ;
}
	$invoiceDetails		=	$objMSalesInvoice->getInvoiceDetails($invoiceId);
	$checkDiscount		=	$objMSalesInvoice->checkDiscount($invoiceId);

	$thead	='<table border="0" width="100%" cellpadding="1" class="hideDiv">
				<tr>
					<td align="center" colspan="3">
						<img src="../../../../modules/salesInvoice/admin/includes/logo.jpg"  width="250" height="60">
					</td>
				</tr>
				<tr>
					<th width="45%" align="left">ABDULLAH MOHAMMED ALGHAMDI TRD.EST <br/>(AL ABEER COLDSTORES)</th>
					<td width="5%">&nbsp;</td>
					<th width="40%" style="text-align: right;"><b>( مؤسسة عبد الله محمد الغامدي التجاریة( ثلاجات العبیر </b></th>
				</tr>
				<tr>
					<th align="left">PBNO 34558 JEDDAH 21478 TEL:012 2897999</th>
					<th></th>
					<th style="text-align: right;"> <b>ص  ب: ٣٤٥٥٨     جدة:  ٢١٤٧٨   تليفون  :٢٨٩٧٩٩٩   ٠١٢</b></th>
				</tr>
				
				<tr>
					<th align="left">CR NO 4030142624</th>
					<th></th>
					<th style="text-align: right;"><b> س  ت  : ١٤٢٦٢٤ ٤٠٣٠</b></th>
				</tr>
				<tr>
					<th align="left">VAT NO:300099808500003</th>
					<th></th>
					<th style="text-align: right;"> <b>رقم الضريبة:    ٣٠٠٠٩٩٨٠٨٥٠٠٠٠٣</b></th>
				</tr>
			 </table>
	<br/><br/>
	<table border="0" width="100%" cellpadding="10"  style="font-size: 13px;">
	<thead>
		<tr>
			<td  colspan="3" width="100%" align="center"><b><u>VAT INVOICE(فاتورة الضريبية )</u></b></td>
		</tr>
		<tr>
			<td  width="50%">TO: '.$customerName.'<br/>'.$address .'</td>
			<td class="tdd" width="25%"></td>
			<td class="tdd" width="25%">INVOICE NO: '.$invoiceNo.'</td>
		</tr>
		<tr>
			<td class="tdd">VAT NO: '.$vatNumber.'</td>
			<td class="tdd"></td>
			<td>INVOICE DATE: '.date_format(date_create($invoiceDate),"d-m-Y").'</td>
		</tr>
		<!--<tr>
			<td>PO No:'.$poNo.'</td>
			<td>DUE DATE</td>
			<td>'.$dueDate.'</td>
		</tr>-->
		<!--<tr>
			<td></td>
			<td>DELIVERY DATE</td>
			<td>'.date_format(date_create($invoiceDate),"d-m-Y").'</td>
		</tr>
		<tr>
			<td>DEL.ADD : '.$vesselName.'</td>
			<td></td>
			<td</td>
		</tr>-->
	</thead>
</table><br/>';

/*if($checkDiscount==0)
{
	$tbody .='<table width="100%" border="1" style="border-collapse:collapse">
				<thead>
			<tr>
				<td align="center" width="3%">#</td>
				<td width="12%">Barcode/Item</td>
				<td align="center" width="5%">Qty</td>
				<td align="center" width="5%">Unit</td>
				<td align="center" width="8%" >Price</td>
				<td align="center" width="8%">Amount</td>
				<!--<td align="center" width="5%">Dis%</td>
				<td align="center" width="5%">Vat%</td>-->
				<td align="center" width="8%">Vat Amt</td>
				<td align="center" width="8%">Amt With Vat</td>
			</tr>	
		</thead>
	<tbody>';
}else{*/
	$tbody .='<table width="100%" border="1"  style="font-size: 12px !important;margin-left:15px;margin-right:15px">
				<thead>
			<tr>
				<td align="center" width="3%">#</td>
				<td width="12%">Barcode/Item(الاسم الصنف)</td>
				<td align="center" width="5%">Qty<br/>الكمية </td>
				<td align="center" width="5%">Unit<br/>وحدة</td>
				<td align="center" width="5%">Weight<br/>الوزن </td>
				<td align="center" width="8%" >Price (SR)<br/>السعر</td>
				<td align="center" width="8%">Amount (SR)<br/>المبلغ </td>
				<!--<td align="center" width="5%">Disc</td>
				<td align="center" width="5%">Vat%</td>
				<td align="center" width="8%">Vat Amt</td>
				<td align="center" width="8%">Amt With Vat</td>-->
			</tr>	
		</thead>
	<tbody>';
//}	



	while($invoiceDetailsRow	=	mysqli_fetch_array($invoiceDetails))
		{
			/*if($checkDiscount==0)
			{
				$tbody.='<tr>
			<td align="center" width="3%">'.$i.'</td>
			<td width="12%">'.$invoiceDetailsRow['itemCode'].'</td>
		
			<td align="center" width="5%">'.$invoiceDetailsRow['quantity'].'</td>
			<td align="center" width="5%">'.$invoiceDetailsRow['unitName'].'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['unitPrice'],2).'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['amount'],2).'</td>
			<!--<td align="center" width="5%">'.$invoiceDetailsRow['discountPercent'].'</td>
			<td align="center" width="5%">'.$invoiceDetailsRow['vatPercent'].'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['vatAmount'],2).'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['amountWithVat'],2).'</td>-->
		</tr>';
			}else{*/
					$tbody1.='
					
					<tr>
			<td align="center" width="8%">'.$i.'</td>
			<td width="37%">'.$invoiceDetailsRow['itemCode'].'/'.$invoiceDetailsRow['itemName'].'('.$invoiceDetailsRow['itemNameArabic'].')</td>
			
			<td align="center" width="7%">'.$invoiceDetailsRow['quantity'].'</td>
			<td align="center" width="12%" >'.$invoiceDetailsRow['unitName'].'</td>
			<td align="right" width="10%">'.number_format($invoiceDetailsRow['netWeight'],2).'</td>
			<td align="right" width="12%">'.number_format($invoiceDetailsRow['unitPrice'],2).'</td>
			<td align="right">'.number_format($invoiceDetailsRow['amount'],2).'</td>
			<!--<td align="center" width="5%">'.number_format($invoiceDetailsRow['discountPercent'],2).'</td>
			<td align="center" width="5%">'.$invoiceDetailsRow['vatPercent'].'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['vatAmount'],2).'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['amountWithVat'],2).'</td>-->
		</tr>
		
		';
			//}
				$i++;
				$qtyTotal         			=	$qtyTotal +$invoiceDetailsRow['quantity'];
				$netWtTotal         		=	$netWtTotal +$invoiceDetailsRow['netWeight'];
		}
	
	$tbody.='<tr>	
		<td>&nbsp;</td>
		<td align="right">Total</td>
		<td align="right">'.$qtyTotal.'</td>
		<td>&nbsp;</td>
		<td align="right">'.number_format($netWtTotal,2).'</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr><tr>
		<td colspan="6" align="right">Total Excl VAT/الأجمالي بدون القيمة المضافة</td>
		<td   align="right" >'.number_format($totalAmount,2).'</td>
	</tr>
	<tr>
		<td colspan="6" align="right">Discount('.$discountPercent.'%)</td>
		<td  align="right" >'.number_format($discountAmount,2).'</td>
	</tr>
	<tr>
		<td colspan="6" align="right">Total After Discount :</td>
		<td  align="right" >'.number_format($totalAmountAfterDiscount,2).'</td>
	</tr>';
	//if($damagedGoodsAmount>0)
	//{ 
		$tbody.='<tr>
				<td colspan="6" align="right">Damage Goods Amount :</td>
				<td  align="right" >'.number_format($damagedGoodsAmount,2).'</td>
			</tr>';
	//}
$tbody.='<tr>
		<td colspan="6" align="right">VAT TAX('.$vatPercent.'%) /القيمة المضافة :</td>
		<td  align="right" >'.number_format($vatAmount,2).'</td>
	</tr>
	
	
	<tr>
		<td colspan="6" align="right">Total Incl Vat /المبلغ الإجمالي  :</td>
		<td  align="right" ><b>'.number_format($netAmount,2).'</b></td>
	</tr></tbody></table>
	<table width="100%" style="font-size: 13px;height:25%">
						<tr>
						<th  colspan="12">&nbsp;</th>
						</tr>
						<tr>
						<th colspan="12" style="text-align:center;position: absolute; left:80mm;width:25%">
			<!--<img src="'.$filename.$invoiceId.'.png">-->
		</th>
						
						</tr>
							<tr>
							<th colspan="6" style="text-align:center">SALESMAN(مندوب مبيعات)</th>
						
							<th colspan="6" style="text-align:center">CUSTOMER(الزبون)</tk>
							</tr>
					</table>
				';




		$tbody2.='
		
		
		<!--<div width="80%" style="position:absolute; top:32%; left:2%;border:1px solid black;">
		
		
		<div style="border:1px solid black;position:relative; top:62%; left:2%;">
		<table width="100%" border="1">
		  <tr>
		  <td colspan="6" rowspan="7" align="right">
		 
		  </td>
		  </tr>
		  <tr>
		  <td  align="right" colspan="6"><b>'.number_format($totalAmount,2).'</b></td>
		  </tr>
		  <tr>
		  <td  align="right" colspan="6"><b>'.number_format($discount,2).'</b></td>
		  </tr>
		  <tr>
		  <td  align="right" colspan="6"><b>'.number_format($totalAmountAfterDiscount,2).'</b></td> 
		  </tr>
		  <tr>
		  <td  align="right" colspan="6"><b>'.number_format($damagedGoodsAmount,2).'</b></td> 
		  </tr> 
		  <tr>
		  <td  align="right" colspan="6"><b>'.number_format($vatAmount,2).'</b></td> 
		  </tr>
		   <tr>
		   <td align="right" colspan="6"><b>'.number_format($netAmount,2).'</b></td>
		   </tr>
		   </table>
		</div>
		</div>-->
    
	
		<div width="100%" height="35%" style="border:0px solid black;padding-top:0%;" >
	      
		   
		
		
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		
		<table width="100%" height="100%"  border="0" style="border-collapse:collapse;margin-top:1mm;">
		<thead>
		<tr>
	   <th width="12%"></th>
	   <th width="35%"></th>
	   <th></th>
	   <th></th>
	   <th></th>
	   <th></th>
	   <th></th> 
	   <th></th> 
	   </tr>
	   
		</thead>
	   
	   
	   <tbody>
	   <tr>
		<td  rowspan="7" colspan="2" align="right" style="padding-top:0%;padding-right:4%;">
	   <img src="'.$base64.'" height="100px" width="100px">
	   
		</td>
		</tr>
		<tr>
		<td  align="right" colspan="6" style="padding:1%;"><b>'.number_format($totalAmount,2).'</b></td>
		  </tr>
		  <tr>
		  <td  align="right" colspan="6"  style="padding:0%;padding-top:1%;"><b>'.number_format($discount,2).'</b></td>
		  </tr>
		  <tr>
		  <td  align="right" colspan="6"  style="padding:0%;padding-top:1%;"><b>'.number_format($totalAmountAfterDiscount,2).'</b></td> 
		  </tr>
		  <tr>
		  <td  align="right" colspan="6"  style="padding:1%;"><b>'.number_format($damagedGoodsAmount,2).'</b></td> 
		  </tr> 
		  <tr>
		  <td colspan="3" align="center"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;15%</b></td>
		  <td  align="right" colspan="3"  style="padding:0%;padding-top:1%;"><b>'.number_format($vatAmount,2).'</b></td> 
		  </tr>
		   <tr>
		   <td align="right"  colspan="6" style="padding:1%;"><b>'.number_format($netAmount,2).'</b></td>
		   </tr>
		   </tbody>
		   </table>
		</div>
 
		 
	';
				
	$invoiceData	=	array('tbody1'=>$tbody1,'thead'=>$thead,'customerName'=>$customerName,'address'=>$address,'invoiceNo'=>$invoiceNo,
                             'vatNo'=>$vatNumber,'invoiceDate'=>$invoiceDate,'img'=>$img,'totalExcl'=>$totalAmount,'discount'=>$discountAmount,
							'totalAfterDiscount'=>$totalAmountAfterDiscount,'damage'=>$damagedGoodsAmount,'vatTax'=>$vatAmount,'totalIncl'=>$netAmount,
						'tbody2'=>$tbody2);
	return $invoiceData;
}

 function gethexadecimalvalueforstring($tagNo,$string){
    $hexadecimalvalueofstring = bin2hex($string);
    $countLength              = strlen($string);
	$hexadecimalvalueof = dechex($countLength);
	if(strlen($hexadecimalvalueof)%2==0){
		$value                    = $tagNo.$hexadecimalvalueof.$hexadecimalvalueofstring;
	}else{
			$value                    = $tagNo.'0'.$hexadecimalvalueof.$hexadecimalvalueofstring;
	}
	
  return  $value;
}

// add customer

function getMaxCustomerNo(){
	$objMSalesInvoice	= 	new M_salesInvoice();	
	$dataOfCustomer=$objMSalesInvoice->getMaxCustomerNo();
	return $dataOfCustomer;

}




}

?>