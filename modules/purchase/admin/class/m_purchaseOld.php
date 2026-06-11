<?php
require_once("../../../../settings/connect_db.php");
class M_Purchase
{
	function getMaterialsForAutoComplete($materialsName)
	{
		global $con; 
		$query = "SELECT materialsId,materialsName,unitPrice,stock		       
				  FROM  materials 
				  WHERE materialsName LIKE '%".$materialsName."%'
				  ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	}
	function getMaterialUnits($materialsId)
	{
		global $con;
		$query = "SELECT unitId, unitName, fraction	       
				  FROM  unit 
				  WHERE materialsId = '".$materialsId."' ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		return $result;
	}
	function getMaxInvoiceNo()
	{
		global $con;
		$estimateNo = '';
		$query = "SELECT IFNULL(MAX(invoiceNo )+1,1) AS purchaseItemBillNo 
				  FROM  purchaseItemBill";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		if($listNo = mysqli_fetch_array($result))
			$invoiceNo = $listNo['purchaseItemBillNo'];
		return $invoiceNo;
	}
	function dropDownForvendorName()
	{
		global $con;
		$query = "SELECT vendorId, vendorName	       
				  FROM   vendor 
				";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		return $result;
	}
	
	
	function insertMaterialsData($materialName, $unitPrice, $stock ) { 
	
		global $con;
		$query = "INSERT INTO materials (materialsName, unitPrice, stock ) 
				  VALUES ( '".$materialName."', '". $unitPrice ."', '". $stock ."' ) ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		return mysqli_insert_id($con);
	}

	
	function insertUnitData($materialsId, $unitName, $fraction ) { 
	
		global $con;
		$query = "INSERT INTO unit (materialsId, unitName, fraction ) 
				  VALUES ( '".$materialsId."', '". $unitName ."', '". $fraction ."' ) ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		return mysqli_insert_id($con);
	}
	
	
	
	function insertPurchaseItemBill($invoiceNo, $invoiceDate, $vendorId, $billDiscount,$totalWithoutVat,$totalVatAmount,$totalWithVatAmount,$typeOfTransactionId, $userId) {
	
		global $con;
		$query = "INSERT INTO purchaseItemBill (invoiceNo, invoiceDate, vendorId, discount, billTotal,totalVatAmount,billTotalWithVat,typeOfTransactionId, userId ) 
				  VALUES ( '".$invoiceNo."', '". $invoiceDate ."', '". $vendorId ."', '". $billDiscount ."', 
				  		   '". $totalWithoutVat ."','". $totalVatAmount ."','". $totalWithVatAmount ."','". $typeOfTransactionId ."', '". $userId ."' ) ";
	
		$result = mysqli_query($con,$query);
		return mysqli_insert_id($con);
	}
	
	
	function insertPurchaseItem ($queryInput) { 
	
		global $con;
			$query = "INSERT INTO purchaseItem (purchaseItemBillId, materialsId, unitId, quantity, unitPrice,discountPercent,vatPercentage,vatAmount) 
				  VALUES ".$queryInput." ";
		//print_r($query);
		$result = mysqli_query($con,$query);
		return  mysqli_insert_id($con);
	
	}
	function updateMaterianidInPurchaseItem($newMaterialId,$purchaseItemId)
	{
		global $con;
		$query = "UPDATE purchaseItem 
				  SET materialsId ='".$newMaterialId."'
				  WHERE purchaseItemId = '". $purchaseItemId ."' ";
		//print_r($query);
		$result = mysqli_query($con,$query);
		return  mysqli_affected_rows($con);
		
	}
	
	
	
	function insertPurchaseAmount($purchaseItemBillId, $amountPaid, $paidDate ) {
	
		global $con;
		$query = "INSERT INTO purchaseAmount (purchaseItemBillId, amountPaid, paidDate) 
				  VALUES ( '".$purchaseItemBillId."', '". $amountPaid ."', '". $paidDate ."' ) ";
		//print_r($query);
		$result = mysqli_query($con,$query);
		return  mysqli_affected_rows($con);
	}
	
	
	function checkMaterialExistOrNot($newMaterial, $newUnitPrices) {
		
		global $con;
		$query = "SELECT COUNT(*) AS numOfRows		       
				  FROM  materials 
				  WHERE materialsName= '".$newMaterial."' AND unitPrice = '".$newUnitPrices."' ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		
		if($listNo = mysqli_fetch_array($result))
			$numOfRows = $listNo['numOfRows'];  
		return $numOfRows;
		
	}
	
	
	function updateMaterials($newMaterial, $newQuantity, $unitPrice) {
	
		global $con;
		$query = "UPDATE materials 
				  SET stock = stock + '". $newQuantity ."'
				  WHERE materialsName = '".$newMaterial."'  AND  unitPrice = '". $unitPrice ."' ";
		//print_r($query);
		$result = mysqli_query($con,$query);
		return  mysqli_affected_rows($con);
	}
	
	
	function checkInvoiceNoExistOrNot($invoiceNo) 
	{
		
		global $con;
		$query = "SELECT COUNT(*) AS numOfRows		       
				  FROM  purchaseItemBill 
				  WHERE invoiceNo = '".$invoiceNo."' ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		
		if($listNo = mysqli_fetch_array($result))
			$numOfRows = $listNo['numOfRows'];
		return $numOfRows;
		
	}
	
	
	function searchPurchaseItem($purchaseItemBillId) {
	
		global $con; 
		$query = "SELECT invoiceNo, invoiceDate, vendorName, discount, billTotal, materialsName, quantity,billTotal,totalVatAmount,billTotalWithVat,
						 vatPercentage,vatAmount,unitName ,PRI.unitPrice , fraction     
				  FROM  purchaseItemBill PRIB
				  INNER JOIN purchaseItem PRI ON PRI.purchaseItemBillId = PRIB.purchaseItemBillId 
				  							  AND PRI.purchaseItemBillId = '".$purchaseItemBillId."'
				  INNER JOIN materials ON PRI.materialsId = materials.materialsId 
				 
				  INNER JOIN vendor ON vendor.vendorId = PRIB.vendorId
				  Left JOIN unit ON unit.unitId = PRI.unitId
				  WHERE PRIB.purchaseItemBillId = '".$purchaseItemBillId."'
				  ";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		//echo "helo";
		return $result;
	// INNER JOIN purchaseAmount PA ON PA.purchaseItemBillId = PRIB.purchaseItemBillId  		   AND PA.purchaseItemBillId = '".$purchaseItemBillId."'
	//, amountPaid
	}
	
	
	function dropDownForPaymentType()
	{
		global $con;
		$query = "SELECT paymentTypeId, paymentTypeName	       
				  FROM   paymentType 
				";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		return $result;
	}
  public function SubaccountHead($id)
	{
		global $con;
		$query="SELECT subAccountHeadId  FROM subAccountHead   WHERE subAccountSupplierId='$id'";
		$subAccountHead=mysqli_query($con,$query);
		$subAccountHead_detail=mysqli_fetch_array($subAccountHead);	
		return $subAccountHead_detail;	 
	}
	function suppliername($vendorId)
	{
		global $con;
		$query = "SELECT  vendorName	       
				  FROM   vendor  WHERE vendorId='$vendorId'
				";
		//echo "<br>".$query."<br>";
		$result = mysqli_query($con,$query);
		$vendorName=mysqli_fetch_array($result);	
		return $vendorName;	 
	}
	function insertAccountjournal($purchaseItemBillId,$invoiceDate,$vendorId,$totalWithoutVat,$totalVatAmount,$totalWithVatAmount,$billDiscount)
	{
		global $con;
		$subAccountHeadId='';
		$subAccountData= $this->SubaccountHead($vendorId);
		$supplier=$this->suppliername($vendorId);
		$subAccountHeadId=$subAccountData['subAccountHeadId'];
		$suppliername=$supplier['vendorName'];
		$narration=$suppliername.' '.'of'.' '.$purchaseItemBillId;
		$query = "INSERT INTO accountJournal
		       ( j_debit, j_credit, j_account_id, j_sub_account_id, j_particulars, j_remarks, j_dateOfPayment, j_referenceId, j_invoiceId, j_narration) 
			 VALUES ( '', '". $totalWithVatAmount ."', '4','". $subAccountHeadId."','".$suppliername."',
						   '".$purchaseItemBillId."','".$invoiceDate."','3','".$purchaseItemBillId."','".$narration."'),
						   ('". $totalWithoutVat ."','','21','2','Purchase Amount',
						   '".$purchaseItemBillId."','".$invoiceDate."','3','".$purchaseItemBillId."','".$narration."'),
						   ( '". $totalVatAmount ."','', '58','22','Purchase  Vat Amount',
						   '".$purchaseItemBillId."','".$invoiceDate."','3','".$purchaseItemBillId."','".$narration."') ,
						   ( '', '".$billDiscount."', '17','372','Discount Received',
						   '".$purchaseItemBillId."','".$invoiceDate."','3','".$purchaseItemBillId."','".$narration."')";
		//print_r($query);
		$result = mysqli_query($con,$query);

	}
	
	
	
	
	
}
?>