<?php

require_once("../../../../modules/invoiceSearchByInvoiceNo/admin/models/Invoicesearchbyinvoiceno_model.php");

class InvoiceSearchByInvoiceNo {	

	public function getDetailsInvoiceNo($invoiceId){	
	
		$objhModel = new Invoicesearchbyinvoiceno_model();	
	
	
		$i				=	1;
		$tbodyExcel			=	'';
		$invoiceData	=	'';
		$theadExcel			=	'';
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
}
	$invoiceDetails		=	$objMSalesInvoice->getInvoiceDetails($invoiceId);
	$checkDiscount		=	$objMSalesInvoice->checkDiscount($invoiceId);

	$theadExcel	='<table border="0" width="100%" cellpadding="1" id="headerContent">
				
				<tr>
					<th width="45%" align="left" colspan="3">   </th>
					<td width="5%">&nbsp;</td>
					<th width="40%" colspan="3" style="text-align: right;"></th>
				</tr>
				<tr>
					<th align="left" colspan="3">     </th>
					<th></th>
					<th style="text-align: right;" colspan="3">  </th>
				</tr>
				<tr>
					<th align="left" colspan="3">CR NO </th>
					<th></th>
					<th style="text-align: right;" colspan="3"> س ت </th>
				</tr>
				<tr>
					<th align="left" colspan="3">VAT NO:</th>
					<th></th>
					<th style="text-align: right;" colspan="3"> رقم الضريبة </th>
				</tr>
			 </table>
	<br/><br/>
	<table border="0" width="100%" cellpadding="10" id="theadContent" style="font-size: 13px;">
	<thead>
		<tr>
			<td  colspan="7" width="100%" align="center"><b><u>VAT INVOICE (فاتورة الضريبية )</u></b></td>
		</tr>
		<tr>
			<td  width="50%" colspan="3">TO: '.$customerName.'<br/>'.$address .'</td>
			<td class="tdd" width="30%"></td>
			<td class="tdd" width="20%" colspan="3" align="right">INVOICE NO: '.$invoiceNo.'</td>
		</tr>
		<tr>
			<td class="tdd" colspan="3">VAT NO: '.$vatNumber.'</td>
			<td class="tdd"></td>
			<td colspan="3" align="right">INVOICE DATE: '.date_format(date_create($invoiceDate),"d-m-Y").'</td>
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
	$tbodyExcel .='<table width="100%" border="1" id="resultTable" style="font-size: 12px !important;">
				<thead>
			<tr>
				<td align="center" width="3%">#</td>
				<td width="12%">Barcode/Item(الاسم الصنف)</td>
				<td align="center" width="5%">Qty<br/>الكمية</td>
				<td align="center" width="5%">Unit<br/>وحدة</td>
				<td align="center" width="5%">Weight<br/>الوزن</td>
				<td align="center" width="8%" >Price (SR)<br/>السعر</td>
				<td align="center" width="8%">Amount (SR)<br/>المبلغ</td>
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
					$tbodyExcel.='<tr>
			<td align="center" width="3%">'.$i.'</td>
			<td width="12%">'.$invoiceDetailsRow['itemCode'].'/'.$invoiceDetailsRow['itemName'].'</td>
			
			<td align="center" width="5%">'.$invoiceDetailsRow['quantity'].'</td>
			<td align="center" width="5%">'.$invoiceDetailsRow['unitName'].'</td>
			<td align="center" width="5%">'.number_format($invoiceDetailsRow['netWeight'],2).'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['unitPrice'],2).'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['amount'],2).'</td>
			
		</tr>';
		/*<td align="center" width="5%">'.number_format($invoiceDetailsRow['discountPercent'],2).'</td>
			<td align="center" width="5%">'.$invoiceDetailsRow['vatPercent'].'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['vatAmount'],2).'</td>
			<td align="center" width="8%">'.number_format($invoiceDetailsRow['amountWithVat'],2).'</td>*/
			//}
				$i++;
		}
	
	$tbodyExcel.='<tr>
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
		$tbodyExcel.='<tr>
				<td colspan="6" align="right">Damage Goods Amount :</td>
				<td  align="right" >'.number_format($damagedGoodsAmount,2).'</td>
			</tr>';
	//}
$tbodyExcel.='<tr>
		<td colspan="6" align="right">VAT TAX('.$vatPercent.'%) /القيمة المضافة :</td>
		<td  align="right" >'.number_format($vatAmount,2).'</td>
	</tr>
	
	
	<tr>
		<td colspan="6" align="right">Total Incl Vat /المبلغ الإجمالي  :</td>
		<td  align="right" >'.number_format($netAmount,2).'</td>
	</tr></tbody></table>
	<table width="100%" style="font-size: 13px;" id="sdContent">
						<tr>
						<th  colspan="7">&nbsp;</th>
						</tr>
						<tr>
						<th  colspan="7">&nbsp;</th>
						</tr>
							<tr>
							<th colspan="3" style="text-align:center">SALESMAN(مندوب مبيعات)</th>
						
							<th colspan="4" style="text-align:center">CUSTOMERCUSTOMER(الزبون)</td>
							</tr>
					</table>
				';
				
	$invoiceData	=	array('tbodyExcel'=>$tbodyExcel,'theadExcel'=>$theadExcel);
	return $invoiceData;
	}
}



?>