<?php
	require_once("../../../../modules/regularCustomer/admin/class/m_customer.php");
	require_once("../../../../modules/regularCustomer/admin/controller/c_customer.php");
	

	include("../../../../settings/connect_db.php");
	require_once("../../../../libraries/class/utils.php"); 
	require_once("../../../../settings/path.php");
	$objUtils	      = new Utils();
	$objM_customer_edit = new M_customer();
	$objC_customer     = new C_customer();

	$objPath    = new Path();
	if (isset($_GET['regularCustomerId']) > 0){
		$customerId 	= $_GET['regularCustomerId'];
		$showListCustomer = $objM_customer_edit->listCustomerEdit($customerId);
		while($resCustomer = mysqli_fetch_array($showListCustomer)){	
			$customerId 	  = $resCustomer['regularCustomerId'];	
			$customerName 	= $resCustomer['customerName'];
			$customerAdd 	 = $resCustomer['address'];
			$customerCon1 	= $resCustomer['contactNo_1'];
			$customerCon2 	= $resCustomer['contactNo_2'];
			$vatNumber 	    = $resCustomer['vatNumber'];
			$dueDate		= $resCustomer['dueDate'];	
			$customerNo		= $resCustomer['customerNo'];

			$streetName      = $resCustomer['streetName'];
			$buildingNo      = $resCustomer['buildingNo'];
			$addlNo     	 = $resCustomer['addlNo'];
			$postalCode      = $resCustomer['postalCode'];
			$city      		 = $resCustomer['city'];
			$district      	 = $resCustomer['district'];
			$country     	 = $resCustomer['country'];

			$streetNameArab      = $resCustomer['streetArabic'];
			$buildingNoArab      = $resCustomer['buildingArabic'];
			$addlNoArab     	 = $resCustomer['addlNoArabic'];
			$postalCodeArab      = $resCustomer['postalArabic'];
			$cityArab      		 = $resCustomer['cityArabic'];
			$districtArab      	 = $resCustomer['districtArabic'];
			$countryArab     	 = $resCustomer['countryArabic'];
			$vatArab     	 = $resCustomer['vatNoArabic'];
			$customerNameArab  = $resCustomer['customerNameArabic'];
              $addressArabic		= $resCustomer['addressArabic'];	

			$registeredBranchId		= $resCustomer['registeredBranchId'];	
				
			$allBranch 	= $objC_customer->allBranch($registeredBranchId);
            $salesAreaBranchId		= $resCustomer['salesAreaBranchId'];
			$salesAress = $objM_customer_edit->getSalesArea($registeredBranchId);
			$selectSalesAreaList = '<option value="">Select</option>';
			while($salesAresList= mysqli_fetch_array($salesAress)){
			if($salesAresList['branchId']==$salesAreaBranchId){
						$selected='selected';
					}else{
						$selected='';
					}
					$selectSalesAreaList .='<option value="'.$salesAresList['branchId'].'" '.$selected.'>'.$salesAresList['branchName'].'</option>';
				}
			$vesselCode 	='';
			//$vesselCode 	= $resCustomer['vesselCode'];
			//$creditLimit 	 = $resCustomer['creditLimit'];
			//$openingReceiverAmount 	 = $resCustomer['currentBalanceReceiverAmount'];
		}
		$strListCreditPlan = '';
		/*$listCreditPaln = $objM_customer_edit->listCreditPlanForCustomer();
		while($rowListCreditPaln = mysqli_fetch_array($listCreditPaln)){
			  $strListCreditPlan	  .= '<option value="'.$rowListCreditPaln['creditPlanId']."/".$rowListCreditPaln['creditPlanName'].'" > '
									.$rowListCreditPaln['creditPlanName'].
								  '</option>';
		} */
		/*if($creditPlanId>0){
			$showCreditPlanName = $objM_customer_edit->showCreditPlanName($creditPlanId);
			while($resCreditPlanName = mysqli_fetch_array($showCreditPlanName)){	
				$creditPlanName 	  = $resCreditPlanName['creditPlanName'];
				$selectedPlan        = '<option value="'.$creditPlanId."/".$creditPlanName.'" > '
									.$creditPlanName.
								  '</option>';
			}
		}*/
 	}
 	if (isset($_POST['submit'])){
		$customerId 	  = $_POST['regularCustomerId'];
		$customerName 	= $_POST['customerName'];
		$customerAdd  	 = $_POST['customerAddress'];
		$customerCon1 	= $_POST['contactNo_1'];
		$customerCon2 	= $_POST['contactNo_2'];
		$vatNumber 	   = $_POST['vatNumber'];
		$dueDate		=$_POST['dueDate'];
		$dueDate=date('Y-m-d',strtotime($dueDate));
		$branchId		=	$_POST['branchId'];
		$salesArea      = $_POST['salesArea'];
		$vesselCode 	   ='';
		$customerCode     = $_POST['customerCode'];

		$streetName      = $_POST['streetName'];
		$buildingNo      = $_POST['buildingNo'];
		$addlNo     	 = $_POST['addlNo'];
		$postalCode      = $_POST['postalCode'];
		$city      		 = $_POST['city'];
		$district      	 = $_POST['district'];
		$country     	 = $_POST['country'];
	$customerAddressArab= $_POST['customerAddressArab'];
		$streetNameArab      = $_POST['streetArab'];
		$buildingNoArab      = $_POST['buildingNoArab'];
		$addlNoArab     	 = $_POST['addlNoArab'];
		$postalCodeArab      = $_POST['postalCodeArab'];
		$cityArab      		 = $_POST['cityArab'];
		$districtArab      	 = $_POST['districtArab'];
		$countryArab     	 = $_POST['countryArab'];
		$vatArab     	 = $_POST['vatArab'];
		$customerNameArab    = $_POST['customerNameArab'];

		//$creditPlan      = $_POST['creditPlan'];
		//$openingReceiverAmount      = $_POST['openingReceiverAmount'];
		//$arrCreditPlan   = explode("/",$creditPlan);
		$creditPlanId    = '0';
		//$creditPlanName  = $arrCreditPlan[1];
		$creditLimit     = '0';
		$count  =  $objM_customer_edit->getCounts($customerCode,$customerId);
	if($count==0){
		$updateList = $objM_customer_edit->updateCustomerEdit($customerId, $customerName, $customerAdd, $branchId,
															  $customerCon1, $customerCon2,$creditPlanId,$creditLimit,$vatNumber,$dueDate,$salesArea,$customerCode,															
															  $streetName,
															  $buildingNo ,
															  $addlNo,
															  $postalCode,
															  $city ,
															  $district, 
															  $country,
															  $streetNameArab,
															  $buildingNoArab,
															  $addlNoArab,
															  $postalCodeArab,
															  $cityArab ,
															  $districtArab,
															  $countryArab,
															  $vatArab  ,
															  $customerNameArab,$customerAddressArab
															); 
			$secondLevelAccountId  = $objM_customer_edit->getSecondaryAccountId($branchId);
			  $thirdLevelAccountId  = $objM_customer_edit->getThirdAccountId($salesArea);												  
		  $update_subAccountHead=$objM_customer_edit->updateSubAccountName($customerName,$customerId,$secondLevelAccountId,$thirdLevelAccountId);
		echo $message ="Sucess";
   		$objPath->setHeader('addRegCusName', $message);
	}else{
		echo $message ="Customer No Duplication";
   		$objPath->setHeader('addRegCusName', $message);
	}
		}
?>
<form action="" method="post">
<div class="row">
	<div class="col-md-7">
		<div class="box box-solid box-primary">
			<div class="box-body">
			<div class="col-sm-12 col-md-12 col-lg-12">


			<div class="row">
 									<div class="col-sm-4 col-md-4 col-lg-4">
										<div class="form-group">
											<label for="name">NAME<strong class="forMandatory">*</strong></label>
											<input type="hidden" name="regularCustomerId" value="<?php echo $customerId; ?>"/>
											<input name="customerName" autocomplete="off" type="text" required id="customerName" class="form-control input-sm" value="<?php echo $customerName; ?>" />
										</div>
									   <div class="form-group">
											<label for="phone1">ADDL NO :</label>
											<input type="text" name="addlNo" id="addlNo" autocomplete="off"  class="form-control input-sm" value="<?php echo $addlNo; ?>" />        								
										</div>
										<div class="form-group">
											<label for="postalCode">POSTAL CODE</label>
											<input type="text" name="postalCode" id="postalCode" autocomplete="off"  class="form-control input-sm" value="<?php echo $postalCode; ?>" />        								
										</div>
										<div class="form-group">
											<label for="city">CITY</label>
											<input type="text" name="city" id="city" autocomplete="off"  class="form-control input-sm" value="<?php echo $city; ?>" />        								
										</div>
										<div class="form-group">
											<label for="city">DISTRICT</label>
											<input type="text" name="district" id="district" autocomplete="off"  class="form-control input-sm" value="<?php echo $district; ?>" />        								
										</div>
										<div class="form-group">
											<label for="city">COUNTRY</label>
											<input type="text" name="country" id="country" autocomplete="off"  class="form-control input-sm" value="<?php echo $country; ?>" />        								
										</div>
										<div class="form-group">
											<label for="streetName">STREET NAME</label>
											<input type="text" autocomplete="off" name="streetName" class="form-control input-sm"  id="streetName" value="<?php echo $streetName; ?>"/>
             							</div> 
										 <div class="form-group">
											<label for="vatNumber">VAT NUMBER</label>
											<input type="text" name="vatNumber" class="form-control input-sm" onKeyUp="checkNumeric(this.id)" value="<?php echo $vatNumber; ?>"  id="vatNumber" />                                                 
             							</div> 
										 <div class="form-group">
       						<label for="vatNumber">BRANCH</label>
							<select class="form-control input-sm" name="branchId" id="branchId" onchange="getSalesArea();">
												<option >Select</option>
												<option value="D" <?php if($registeredBranchId=='D')echo "selected"?> >DAMMAM BRANCH</option>
												<option value="R" <?php if($registeredBranchId=='R')echo "selected"?>>RIYAD BRANCH</option>
												<option value="M" <?php if($registeredBranchId=='M')echo "selected"?>>MAKKAH BRANCH</option>
												<option value="J" <?php if($registeredBranchId=='J')echo "selected"?>>JEDDAH BRANCH</option>
							</select>
                         </div>
           							</div>
            					<div class="col-sm-4 col-md-4 col-lg-4">
								<div class="form-group">
                						<label for="name">CUSTOMER NO<strong class="forMandatory">*</strong></label>
										<input name="customerCode" autocomplete="off" type="text" required id="customerCode" class="form-control input-sm" value="<?php echo $customerNo; ?>" />
           							</div>
            						<div class="form-group">
           								<p>
           								  <label for="phone1">ADDRESS</label>
           								  <textarea name="customerAddress" autocomplete="off"  cols="19" rows="2.5" class="form-control input-sm"><?php echo $customerAdd;?></textarea>
       								  </p>										 
            						</div>
									<div class="form-group">
           								<p>
           								  <label for="phone1">ADDRESS (ARABIC)</label>
           								  <textarea name="customerAddressArab" autocomplete="off"  cols="19" rows="2.5" class="form-control input-sm"><?php echo $addressArabic;?></textarea>
       								  	</p>           								
            						</div>
									<div class="form-group">
       									<label for="phone2">MOBILE NO</label>
										<input type="text" autocomplete="off" name="contactNo_2" class="form-control input-sm" onKeyUp="checkNumeric(this.id)" maxlength="10" id="contactNo_2" value="<?php echo $customerCon2; ?>" />
             						</div>
									
									<div class="form-group">
              							<label for="address">PHONE 1<strong class="forMandatory">*</strong></label>
										<input type="text" autocomplete="off" onKeyUp="checkNumeric(this.id)" id="contactNo_1" required name="contactNo_1" class="form-control input-sm" value="<?php echo $customerCon1; ?>" />
									</div>										                         									
									<div class="form-group">
											<label for="buildingNo">BUILDING NO</label>
											<input type="text" name="buildingNo" class="form-control input-sm" id="buildingNo" value="<?php echo $buildingNo; ?>" />                                                 
										</div>	
									<div class="form-group">
           								<label for="city">BUILDING NO (ARABIC)</label>
           								<input type="text" name="buildingNoArab" id="country" autocomplete="off"  class="form-control input-sm" value="<?php echo $buildingNoArab; ?>" />        								
            						</div>
									<div class="form-group">
										<label for="vatNumber">DUE DATE</label>
										<input type="text" name="dueDate" class="form-control input-sm datepicker" id="dueDate" value="<?php echo date('d-m-Y',strtotime($dueDate)); ?>"	/>													
									</div>	
            					</div>
								<div class="col-sm-4 col-md-4 col-lg-4">
									<div class="form-group">
                						<label for="name">NAME (ARABIC)<strong ></strong></label>
										<input name="customerNameArab" autocomplete="off" type="text"  
                                        		 id="customerNameArab" class="form-control input-sm" value="<?php echo $customerNameArab; ?>" />
           							</div>
									<div class="form-group">
           								<label for="phone1">ADDL NO : (ARABIC)</label>
           								<input type="text" name="addlNoArab" id="addlNo" autocomplete="off"  class="form-control input-sm" value="<?php echo $addlNoArab; ?>" />        								
            						</div>
									<div class="form-group">
           								<label for="postalCode">POSTAL CODE (ARABIC)</label>
           								<input type="text" name="postalCodeArab" id="postalCode" autocomplete="off"  class="form-control input-sm" value="<?php echo $postalCodeArab; ?>" />        								
            						</div>
									<div class="form-group">
           								<label for="city">CITY (ARABIC)</label>
           								<input type="text" name="cityArab" id="city" autocomplete="off"  class="form-control input-sm" value="<?php echo $cityArab; ?>" />        								
            						</div>
									<div class="form-group">
           								<label for="city">DISTRICT (ARABIC)</label>
           								<input type="text" name="districtArab" id="district" autocomplete="off"  class="form-control input-sm" value="<?php echo $districtArab; ?>" />        								
            						</div>
									<div class="form-group">
           								<label for="city">COUNTRY (ARABIC)</label>
           								<input type="text" name="countryArab" id="country" autocomplete="off"  class="form-control input-sm" value="<?php echo $countryArab; ?>" />        								
            						</div>
									<div class="form-group">
           								<label for="city">STREET NAME (ARABIC)</label>
           								<input type="text" name="streetArab" id="street" autocomplete="off"  class="form-control input-sm" value="<?php echo $streetNameArab; ?>" />        								
            						</div>	
									<div class="form-group">
           								<p>
           								  <label for="phone1">VAT Number(Arabic)</label>
           								  <input name="vatArab" autocomplete="off"   class="form-control input-sm" value="<?php echo $vatArab; ?>" >
       								  	</p>           								
            						</div>	
									<div class="form-group">
						<label for="vesselCode">SALES AREA</label>
       									<select name="salesArea" id="salesArea" required class="form-control input-sm"  >
										<?php echo $selectSalesAreaList;?>
										</select>
             						</div>								
														           																							
            					</div>                              
            				</div>


			<!-- <div class="form-group">
                						<label for="name">CUSTOMER NO<strong class="forMandatory">*</strong></label>
										<input name="customerCode" autocomplete="off" type="text" required 
                                        		 id="customerCode" class="form-control input-sm" value="<?php echo $customerNo;?>" />
           							</div>
									</div>
				<div class="col-md-3">
                	<div class="form-group">
						<label>CUSTOMER NAME</label> 
                    	<span class="mandatory" style="color:red;">*</span>
						<input type="hidden" name="regularCustomerId" value="<?php echo $customerId; ?>"/>
                        <input type="text" class="form-control input-sm" required 
            				name="customerName" value="<?php echo $customerName; ?>"/>
                    </div>
              	</div>
                <div class="col-md-3">
                    <div class="form-group">
						<label>PHONE NO.1</label> 
    	                <span class="mandatory" style="color:red;">*</span>
        	            <input type="text" name="contactNo_1" class="form-control input-sm" 
            				onKeyUp="checkNumeric(this.id)" required maxlength="10" id="contactNo_1" 
            				value="<?php echo $customerCon1; ?>"/>
    				</div>
            	</div>
                <div class="col-md-3">
                    <div class="form-group">
						<label>PHONE NO.2</label>
                    	<input type="text" name="contactNo_2" class="form-control input-sm" 
                			onKeyUp="checkNumeric(this.id)" maxlength="10" id="contactNo_2" 
                				value="<?php echo $customerCon2; ?>">
					</div>
					
				</div>
				<div class="col-md-12">
                	<div class="form-group">
						<label>CUSTOMER ADDRESS</label> 
                    	
                    	<textarea name="customerAddress" class="form-control input-sm" 
            				cols="19" rows="5"><?php echo $customerAdd;?></textarea>
					</div>
                </div>
				 <div class="col-md-3">
                    <div class="form-group">
						<label>VAT NUMBER</label>
                    	<input type="text" name="vatNumber" class="form-control input-sm" 
                			onKeyUp="checkNumeric(this.id)" id="vatNumber" 
                				value="<?php echo $vatNumber; ?>">
					</div>
					</div>
				<div class="col-md-3">
					<div class="form-group">
       						<label for="vatNumber">BRANCH</label>
							<select class="form-control input-sm" name="branchId" id="branchId" onchange="getSalesArea();">
												<option >Select</option>
												<option value="D" <?php if($registeredBranchId=='D')echo "selected"?> >DAMMAM BRANCH</option>
												<option value="R" <?php if($registeredBranchId=='R')echo "selected"?>>RIYAD BRANCH</option>
												<option value="M" <?php if($registeredBranchId=='M')echo "selected"?>>MAKKAH BRANCH</option>
												<option value="J" <?php if($registeredBranchId=='J')echo "selected"?>>JEDDAH BRANCH</option>
							</select>
                         </div>
				</div>
					 <div class="col-md-3">
					<div class="form-group">
					<label for="vesselCode">SALES AREA</label>
       									<select name="salesArea" id="salesArea" required class="form-control input-sm"  >
										<?php echo $selectSalesAreaList;?>
										</select>
             						</div>
				</div> -->
                <div class="col-md-12">
                    <div class="form-group">
                        <center>
                            <button type="submit" name="submit" class="btn btn-success"> 
                                <i class="fa fa-save"></i>UPDATE
                            </button>
                        </center>
                    </div>
				</div>
            </div>
		</div>
	</div>
</div>
</form> 
<script>

function getSalesArea(){
	var branchId =  $('#branchId').val();
	$("#salesArea").val('');
    //var companyItemCode = $("#companyItemCode").val();
    $.ajax({
        type:"POST",
        url: "../../../../modules/regularCustomer/admin/ajax/getSalesArea.php",
                    data:{branchId:branchId},
        success:function(response)
	
         {
			// alert(response);
           $("#salesArea").html(response);
     }   
    });
}


</script>

