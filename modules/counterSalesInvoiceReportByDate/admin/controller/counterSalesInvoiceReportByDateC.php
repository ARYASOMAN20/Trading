<?php
require_once("../../../../modules/counterSalesInvoiceReportByDate/admin/class/counterSalesInvoiceReportByDateM.php");
$counterSalesInvoiceReportM = new  counterSalesInvoiceReportByDateM();

class counterSalesInvoiceReportByDateC { 
    function search($fromDate,$toDate,$privilageId,$branchId)
	{ 
        global $counterSalesInvoiceReportM;
        $privilageId       	 	=   	$_COOKIE['privillegeId'];
        if($privilageId==6)
            {
        $tbody =null;
        $i=1;
        $total_billTotalWithVat = $netAmount = $total_returnAmount= $total_netAmount =$total_vatAmount=$total_totalAmountAfterDiscount=$total_totalAmount=$total_discountAmount=0;	
        
        $resOfSerach = $counterSalesInvoiceReportM->getInvoiceDetails($fromDate,$toDate,$privilageId,$branchId);
        $totalAmountWithVat = 0;

        // I.totalAmount,I.discountPercent,I.discountAmount,I.totalAmountAfterDiscount,I.vatPercent,I.vatAmount,I.totalAmountWithVat
            while ($dataFetchDetails = mysqli_fetch_array($resOfSerach))
            {
                $invoiceId      = $dataFetchDetails['invoiceId'];
                $invoiceNo      =$dataFetchDetails['invoiceNo'];
                $invoiceDate    =$dataFetchDetails['invoiceDate'];
            
                $customerName   =$dataFetchDetails['customerName'];
                $customerNo     = $dataFetchDetails['customerNo'];
                $subAccountHeadId = $dataFetchDetails['subAccountHeadId'];

                $totalAmount        = $dataFetchDetails['totalAmount'];
                $discountPercent    = $dataFetchDetails['discountPercent'];
                $discountAmount     = $dataFetchDetails['discountAmount'];
                $totalAmountAfterDiscount = $dataFetchDetails['totalAmountAfterDiscount'];
                $vatPercent         = $dataFetchDetails['vatPercent'];
                $vatAmount          = $dataFetchDetails['vatAmount'];
                $invoiceTotalAmountWithVat = $dataFetchDetails['totalAmountWithVat'];



        //         $resOfSerachs = $counterSalesInvoiceReportM->searchData($invoiceId,$subAccountHeadId,$branchId);
        // $totalAmountWithVat = 0;
        // while ($dataFetchDetail = mysqli_fetch_array($resOfSerachs))
        //     {
        //         $totalAmountWithVat=$dataFetchDetail['j_debit'];
            
            if($invoiceDate!='')
                $date   = date("d-m-Y", strtotime($invoiceDate));
            else
                
            $date = '';
            if($invoiceTotalAmountWithVat>0){
            $tbody.='<tr>
                    <td align="center"  style="text-align: center !important;">'.$i.'</td>
                    <td align="center"  style="text-align: center !important;">'.$invoiceNo.'</td>
                    <td align="center"  style="text-align: center !important;">'.$date.'</td>
                
                    <td align="center"  style="text-align: center !important;">'.$customerName.'</td>
                    
                    <td align="right"  style="text-align: right !important;">'.$totalAmount.'</td>


                    <td align="right"  style="text-align: right !important;">'.number_format($discountAmount,2).'</td>
                    <td align="right"  style="text-align: right !important;">'.$totalAmountAfterDiscount.'</td>                   
                    <td align="right"  style="text-align: right !important;">'.$vatAmount.'</td>

                        
                    
                    <td  align="right" style="text-align: right !important;">'.number_format($invoiceTotalAmountWithVat,2).' </td>
                        
                </tr>';
                $i++;   
                

                $total_totalAmount      =$total_totalAmount+$totalAmount;
                $total_discountAmount   =$total_discountAmount+$discountAmount;
                $total_totalAmountAfterDiscount=$total_totalAmountAfterDiscount+$totalAmountAfterDiscount;
                $total_vatAmount        =$total_vatAmount+$vatAmount;
                $total_billTotalWithVat =$total_billTotalWithVat+$invoiceTotalAmountWithVat;


            }
        // }	
            }	
                $tbody.='<tr>
                    <th  colspan="4" style="text-align: right !important;">Total</th>

                    <th  align="right" style="text-align: right !important;">'.number_format($total_totalAmount,2).' </th>
                    <th  align="right" style="text-align: right !important;">'.number_format($total_discountAmount,2).' </th>
                    <th  align="right" style="text-align: right !important;">'.number_format($total_totalAmountAfterDiscount,2).' </th>


                    
                    <th  align="right" style="text-align: right !important;">'.number_format($total_vatAmount,2).' </th>
                    
                    <th  align="right" style="text-align: right !important;">'.number_format($total_billTotalWithVat,2).' </th>
                    
                </tr>';				
            

                
            

        return	$tbody;
			
			
	}
}

}
?>