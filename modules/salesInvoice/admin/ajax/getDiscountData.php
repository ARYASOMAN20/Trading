<?php
require_once("../../../../modules/salesInvoice/admin/models/m_salesInvoice.php");
$objMSalesInvoice	= 	new M_salesInvoice();
$resultArray		=	'';


if(isset($_POST['discountName']))
{	
	 $discountName	=	$_POST['discountName'];
	 $discountData	=	$objMSalesInvoice->getDiscountData($discountName);
	 while($row=mysqli_fetch_array($discountData))
	 {
		$discountId			=	$row['discountId'];	
		$discountPercent	=	$row['discountPercent'];	
	 }
	 if($discountPercent==null)
	 {
		 $discountPercent	=	0;
	 }
	 $resultArray		=	array('discountId'=>$discountId,
								   'discountPercent'=>$discountPercent,
								);
}
echo  json_encode($resultArray);
?>