<?php 
require_once("../../../../settings/connect_db.php");

class counterSalesInvoiceReportByDateM {

    function getInvoiceDetails($fromDate,$toDate,$privilageId,$branchId){
        global $con;
        $fromDate=date("Y-m-d", strtotime($fromDate));
        $toDate=date("Y-m-d", strtotime($toDate));
        $query   = "SELECT I.invoiceId,I.invoiceNo,I.invoiceDate,RC.customerName,RC.customerNo,subAccountHeadId,I.totalAmount,I.discountPercent,I.discountAmount,I.totalAmountAfterDiscount,I.vatPercent,I.vatAmount,I.totalAmountWithVat
                    FROM invoice I 
                    inner JOIN regularCustomer RC ON I.regularCustomerId=RC.regularCustomerId
                    inner join subAccountHead on subAccountHead.subAccountClientId= RC.regularCustomerId
                    WHERE I.invoiceDate BETWEEN '".$fromDate."'  AND '".$toDate."'
                    AND I.status='1' and I.branchId='".$branchId."'  and I.privilageId='".$privilageId."' /*and RC.salesAreaBranchId='".$branchId."'*/
                    ORDER BY I.invoiceId ASC";

        $result  = mysqli_query($con,$query);

        // print_r($query);exit;

        return $result;

   }
   function searchData($invoiceId,$subAccountHeadId,$branchId){		
    $privilageId       	 	=   	$_COOKIE['privillegeId'];    
    global  $con;        
    $query   = "SELECT j_debit AS j_debit
                FROM accountJournal  
                inner join invoice I on I.invoiceId = accountJournal.j_invoiceId
                WHERE accountJournal.j_sub_account_id='".$subAccountHeadId."'                 
                    and j_invoiceId='".$invoiceId."' AND j_status=1                
                ";
    $result  = mysqli_query($con,$query);
   // print_r($query);
    return $result;

}

}
?>