<?php

	$customerCode = $_GET['customerCode'];	

 require_once('../../../../modules/regularCustomer/admin/class/m_customer.php');

	$objModuleModel = new M_customer();	

	$customerCodeExist=$objModuleModel->customerCodeCheck($customerCode);

	

?>


