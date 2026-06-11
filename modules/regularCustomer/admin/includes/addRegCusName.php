<?php 

require_once("../../../../modules/regularCustomer/admin/class/m_customer.php");
require_once("../../../../modules/regularCustomer/admin/controller/c_customer.php");
require_once("../../../../settings/path.php");
require_once("../../../../libraries/class/utils.php"); 
$objC_customer     = new C_customer();
$objPath  		   = new Path();
$objM_addCustomer  = new M_customer();
$objUtils	       = new Utils();
$strListCreditPlan = $show_ListNames = '';
$maxCustomerNo         = $objC_customer->getMaxCustomerNo();
if (isset($_POST['submit']))
{
	$customer_Name  = $_POST['customerName'];
	$customer_Add   = $_POST['customerAddress'];
	$customer_Con1  = $_POST['contactNo_1'];
	$customer_Con2  = $_POST['contactNo_2'];
	$customerCode     = $_POST['customerCode'];
	$vatNumber      = $_POST['vatNumber'];

	$customerAddressArab  = $_POST['customerAddressArab'];
	$dueDate		=	$_POST['dueDate'];

	$streetName      = $_POST['streetName'];
	$buildingNo      = $_POST['buildingNo'];
	$addlNo     	 = $_POST['addlNo'];
	$postalCode      = $_POST['postalCode'];
	$city      		 = $_POST['city'];
	$district      	 = $_POST['district'];
	$country     	 = $_POST['country'];

	$streetNameArab      = $_POST['streetArab'];
	$buildingNoArab      = $_POST['buildingNoArab'];
	$addlNoArab     	 = $_POST['addlNoArab'];
	$postalCodeArab      = $_POST['postalCodeArab'];
	$cityArab      		 = $_POST['cityArab'];
	$districtArab      	 = $_POST['districtArab'];
	$countryArab     	 = $_POST['countryArab'];
	$vatArab     	 = $_POST['vatArab'];
	$customerNameArab    = $_POST['customerNameArab'];

	// $dueDate		=	'';
	$vesselCode     ='';
	$creditPlanId   = '0'; 
	$creditPlanName = '0'; 
	$creditLimit    =  '0';
	$profitItemDiscountPercent = '0';
	$openingReceiverAmount     = '0';
	$branchId       = $_POST['branchId'];
	$salesArea      = $_POST['salesArea'];
	$count  =  $objM_addCustomer->getCount($customerCode);
	if($count==0)
	{
			$ins_CustomerDetails = $objM_addCustomer->insertCustomerName($customer_Name,$customer_Add,$branchId,
	            $customer_Con1, $customer_Con2,$creditPlanId,$creditLimit,$profitItemDiscountPercent,
				$openingReceiverAmount,$vatNumber,$vesselCode,$dueDate,
				$salesArea,$customerCode,
				$customerAddressArab,$streetName,$buildingNo,$addlNo,$postalCode,$city,$district,$country,
				$streetNameArab,$buildingNoArab,$addlNoArab,$postalCodeArab,$cityArab,$districtArab,$countryArab,$vatArab,$customerNameArab);
		
		$secondLevelAccountId  = $objM_addCustomer->getSecondaryAccountId($branchId);
		$thirdLevelAccountId  = $objM_addCustomer->getThirdAccountId($salesArea);
        $subaccountNo  = $objM_addCustomer->getMaxSubAccountNo();			  
		$ins_subAccountHead=$objM_addCustomer->insertSubAccountHeadName($customer_Name,$ins_CustomerDetails,$secondLevelAccountId,$thirdLevelAccountId,$subaccountNo);

		   echo $message= "Sucess";
		   $objPath->setHeader('addRegCusName',$message);
	}else{
		echo $message= "Customer No Duplication";
		   $objPath->setHeader('addRegCusName',$message);
	}
		}
		
	$allBranch 	= $objC_customer->allBranch(null);
	
	
	
	
if(isset($_POST['insertAccounts'])){
	
	
	    $result = $objM_addCustomer->getCustomer();
		while($resData=mysqli_fetch_array($result))

	      {
			  $regularCustomerId   	=  $resData['regularCustomerId'];
			  $registeredBranchId   =  $resData['registeredBranchId'];
			  $salesAreaBranchId    =  $resData['salesAreaBranchId'];
			  $secondLevelAccountId  = $objM_addCustomer->getSecondaryAccountId($registeredBranchId);
			  $thirdLevelAccountId  = $objM_addCustomer->getThirdAccountId($salesAreaBranchId);
			  $objM_addCustomer->updateSubaccountTbl($secondLevelAccountId,$thirdLevelAccountId,$regularCustomerId);
		  }
	echo $message= "Sucess";
		   $objPath->setHeader('addRegCusName',$message);	  
}

if(isset($_POST['delete'])){
	$regularCustomerId = $_POST['regularCustomerId'];
 $getEntryOfCustomer = $objM_addCustomer->getEntryOfCustomer($regularCustomerId);
if($getEntryOfCustomer==0){
	$objM_addCustomer->deleteCustomer($regularCustomerId);
	echo $message= "Sucess";
   $objPath->setHeader('addRegCusName',$message);	  
}else{
		echo $message= "Cannot Delete";
   $objPath->setHeader('addRegCusName',$message);	  
}
	
}

 ?>
<script src="../../../../libraries/js/validationsScript.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>



<script>
$(document).ready(function()
{
	var $rows = $('#tableData tr');
	$('#searchByKeyWord').keyup(function() {
		var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
		$rows.show().filter(function() {
			var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
			return !~text.indexOf(val);
		}).hide();
	});
});
</script>
<script type="application/javascript"></script>
<script>
$(document).ready(function()
{
 $('#searchByKeyWord').keyup(function()
 {
  searchTable($(this).val());
 });
});

function searchTable(inputVal)
{
 var table = $('#tableData');
 //alert('tableId:'+table);
 table.find('tr').each(function(index, row)
 {
  var allCells = $(row).find('td');
  if(allCells.length > 0)
  {
   var found = false;
   allCells.each(function(index, td)
   {
    var regExp = new RegExp(inputVal, 'i');
    if(regExp.test($(td).text()))
    {
     found = true;
     return false;
    }
   });
   if(found == true)$(row).show();else $(row).hide();
  }
 });
} 
</script>
<!--<form method= "post">
<button type="submit" class=" btn btn-success" name="insertAccounts" style="background-color: #27c5a8;float: right;border-color:#fff"" title="PDF">
				<i class="fa fa-ban"></i>
			</button>
</form>-->
<form name="addRegularCustomer" method= "post" action = "" autocomplete= "off"> 
<div class="modal fade" id="addCustomerModal"  tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
           		</button>
        		<h4 class="modal-title">Add Customer</h4>
      		</div>
     		<div class="box box-success">
				<div class="box-body">
    
      				<div class="modal-body">
      					<div class="col-sm-12 col-md-12 col-lg-12">
      						<div class="row">
							  <div class="col-sm-4 col-md-4 col-lg-4">
										<div class="form-group">
											<label for="name">NAME<strong class="forMandatory">*</strong></label>
											<input name="customerName" autocomplete="off" type="text" required id="customerName" class="form-control input-sm" />
										</div>
									   <div class="form-group">
											<label for="phone1">ADDL NO :</label>
											<input type="text" name="addlNo" id="addlNo" autocomplete="off"  class="form-control input-sm" />        								
										</div>
										<div class="form-group">
											<label for="postalCode">POSTAL CODE</label>
											<input type="text" name="postalCode" id="postalCode" autocomplete="off"  class="form-control input-sm" />        								
										</div>
										<div class="form-group">
											<label for="city">CITY</label>
											<input type="text" name="city" id="city" autocomplete="off"  class="form-control input-sm" />        								
										</div>
										<div class="form-group">
											<label for="city">DISTRICT</label>
											<input type="text" name="district" id="district" autocomplete="off"  class="form-control input-sm" />        								
										</div>
										<div class="form-group">
											<label for="city">COUNTRY</label>
											<input type="text" name="country" id="country" autocomplete="off"  class="form-control input-sm" />        								
										</div>
										<div class="form-group">
											<label for="streetName">STREET NAME</label>
											<input type="text" autocomplete="off" name="streetName" class="form-control input-sm"  id="streetName" />
             							</div> 
										 <div class="form-group">
											<label for="vatNumber">VAT NUMBER</label>
											<input type="text" name="vatNumber" class="form-control input-sm" onKeyUp="checkNumeric(this.id)"  id="vatNumber" />                                                 
             							</div>
										 <div class="form-group">
       									<label for="vatNumber">BRANCH</label>
										<select class="form-control input-sm" name="branchId" id="branchId" required>
												
												<!-- <option value="" selected="selected"> Select</option> -->
												<!-- <option value="D">DAMMAM BRANCH</option>
												<option value="R">RIYAD BRANCH</option>
												<option value="M">MAKKAH BRANCH</option> -->
												<option value="J" selected>JEDDAH BRANCH</option>
										</select>
                                    </div>
           							</div>
            					<div class="col-sm-4 col-md-4 col-lg-4">
									<div class="form-group">
                						<label for="name">CUSTOMER NO<strong class="forMandatory">*</strong></label>
										<input name="customerCode" autocomplete="off" type="text" required id="customerCode" class="form-control input-sm" value="<?php echo $maxCustomerNo;?>" readonly/>
           							</div>
            						<div class="form-group">
           								<p>
           								  <label for="phone1">ADDRESS</label>
           								  <textarea name="customerAddress" autocomplete="off"  cols="19" rows="2.5" class="form-control input-sm"></textarea>
       								  </p>										 
            						</div>
									<div class="form-group">
           								<p>
           								  <label for="phone1">ADDRESS (ARABIC)</label>
           								  <textarea name="customerAddressArab" autocomplete="off"  cols="19" rows="2.5" class="form-control input-sm"></textarea>
       								  	</p>           								
            						</div>
									<div class="form-group">
       									<label for="phone2">MOBILE NO</label>
										<input type="text" autocomplete="off" name="contactNo_2" class="form-control input-sm" onKeyUp="checkNumeric(this.id)" maxlength="10" id="contactNo_2" />
             						</div>
									
									<div class="form-group">
              							<label for="address">PHONE 1<strong class="forMandatory">*</strong></label>
										<input type="text" autocomplete="off" onKeyUp="checkNumeric(this.id)" id="contactNo_1" required name="contactNo_1" class="form-control input-sm" />
									</div>										                         									
									<div class="form-group">
											<label for="buildingNo">BUILDING NO</label>
											<input type="text" name="buildingNo" class="form-control input-sm" id="buildingNo" />                                                 
										</div>	
									<div class="form-group">
           								<label for="city">BUILDING NO (ARABIC)</label>
           								<input type="text" name="buildingNoArab" id="country" autocomplete="off"  class="form-control input-sm" />        								
            						</div>
									<div class="form-group">
										<label for="vatNumber">DUE DATE</label>
										<input type="text" name="dueDate" class="form-control input-sm datepicker" id="dueDate" />													
									</div>	
									
            					</div>
								<div class="col-sm-4 col-md-4 col-lg-4">
									<div class="form-group">
                						<label for="name">NAME (ARABIC)<strong ></strong></label>
										<input name="customerNameArab" autocomplete="off" type="text" required 
                                        		 id="customerNameArab" class="form-control input-sm" />
           							</div>
									<div class="form-group">
           								<label for="phone1">ADDL NO : (ARABIC)</label>
           								<input type="text" name="addlNoArab" id="addlNo" autocomplete="off"  class="form-control input-sm" />        								
            						</div>
									<div class="form-group">
           								<label for="postalCode">POSTAL CODE (ARABIC)</label>
           								<input type="text" name="postalCodeArab" id="postalCode" autocomplete="off"  class="form-control input-sm" />        								
            						</div>
									<div class="form-group">
           								<label for="city">CITY (ARABIC)</label>
           								<input type="text" name="cityArab" id="city" autocomplete="off"  class="form-control input-sm" />        								
            						</div>
									<div class="form-group">
           								<label for="city">DISTRICT (ARABIC)</label>
           								<input type="text" name="districtArab" id="district" autocomplete="off"  class="form-control input-sm" />        								
            						</div>
									<div class="form-group">
           								<label for="city">COUNTRY (ARABIC)</label>
           								<input type="text" name="countryArab" id="country" autocomplete="off"  class="form-control input-sm" />        								
            						</div>
									<div class="form-group">
           								<label for="city">STREET NAME (ARABIC)</label>
           								<input type="text" name="streetArab" id="street" autocomplete="off"  class="form-control input-sm" />        								
            						</div>	
									<div class="form-group">
           								<p>
           								  <label for="phone1">VAT Number(Arabic)</label>
           								  <input name="vatArab" autocomplete="off"   class="form-control input-sm">
       								  	</p>           								
            						</div>									
									<div class="form-group">
       									<label for="vesselCode">SALES AREA</label>
										<select name="salesArea" id="salesArea" required class="form-control input-sm"  >
										
										</select>
             						</div>			           																							
            					</div> 
 								<!-- <div class="col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
                						<label for="name">CUSTOMER NO<strong class="forMandatory">*</strong></label>
										<input name="customerCode" autocomplete="off" type="text" required 
                                        		 id="customerCode" class="form-control input-sm" />
           							</div>
         							
                                    <div class="form-group">
              							<label for="address">PHONE 1<strong class="forMandatory">*</strong></label>
										<input type="text" autocomplete="off" onKeyUp="checkNumeric(this.id)"
                                        		 id="contactNo_1" required name="contactNo_1" class="form-control input-sm" />
            						</div>
                                    <div class="form-group">
       									<label for="phone2">PHONE 2</label>
										<input type="text" autocomplete="off" name="contactNo_2" class="form-control input-sm"
                                        		 onKeyUp="checkNumeric(this.id)" maxlength="10" id="contactNo_2" />
             						</div>
									 
									<div class="form-group">
       									<label for="vesselCode">Vessel Code</label>
										<input type="text" autocomplete="off" name="vesselCode" class="form-control input-sm"
                                        		  id="vesselCode" />
             						</div>
									<div class="form-group">
       									<label for="vatNumber">DUE DATE</label>
										<input type="text" name="dueDate" class="form-control input-sm" 
                                        		  id="dueDate" />
                                                 
             						</div>-->


									 <!-- <div class="form-group">
       									<label for="vatNumber">VAT NUMBER</label>
										<input type="text" name="vatNumber" class="form-control input-sm" 
                                        		 onKeyUp="checkNumeric(this.id)"  id="vatNumber" />
                                                 
             						</div>
									<div class="form-group">
       									<label for="vatNumber">BRANCH</label>
										<select class="form-control input-sm" name="branchId" id="branchId" onchange="getSalesArea();" required>
												
												<option value="" selected="selected"> Select</option>
												<option value="D">DAMMAM BRANCH</option>
												<option value="R">RIYAD BRANCH</option>
												<option value="M">MAKKAH BRANCH</option>
												<option value="J">JEDDAH BRANCH</option>
										</select>
                                    </div>
									 
									
           						</div>
            					<div class="col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
                						<label for="name">NAME<strong class="forMandatory">*</strong></label>
										<input name="customerName" autocomplete="off" type="text" required 
                                        		 id="customerName" class="form-control input-sm" />
           							</div>
            						<div class="form-group">
           								<p>
           								  <label for="phone1">ADDRESS</label>
           								  <textarea name="customerAddress" autocomplete="off"  cols="19" 
                                        		 rows="2.5" class="form-control input-sm"></textarea>
       								  </p>
           								<p>&nbsp;</p>
                                   
									<div class="form-group">
       									<label for="vesselCode">SALES AREA</label>
										<select name="salesArea" id="salesArea" required class="form-control input-sm"  >
										
										</select>
             						</div>
									
            						</div>
            					</div>  -->
                              
            				</div>
            				<div class="row">
            					<center>
            						<button type="submit" name="submit" id="submit" class="btn btn-success"> 
                                    	<i class="fa fa-save"></i> SAVE         
                                  	</button>
            					</center>
            				</div> 
            			</div>
					</div>
				</div>      
			</div>
		</div>
	</div>
</div>
</form>

<?php 
$show_ListNames = $objC_customer->listCustomerDetails();
?>
<div class="col-sm-12 col-md-12 col-lg-12">
<div class="panel panel-info">
	<div class="panel-heading"><i class="fa fa-list-ul"></i> <strong>Customer List</strong></div>
    <div class="panel-body">
		<table width="100%" id="table_id">
			<thead style="background-color:#d0e8d2">
         		<tr>
                    <th width="2%">#</th> 
					<th width="10%">CUST NO</th>   
                    <th width="20%">CUSTOMER NAME</th> 
                    <th width="16%">ADDRESS</th>   
                    <th width="9%">VAT NO</th>  
                    <th width="12%">PHONE NO_1</th> 
                     
                 
				   <th width="10%">BRANCH</th>
				   <th width="12%">SALESAREA</th> 
                   <th width="2%">EDIT</th>
                   <th width="2%">DELETE</th>
				</tr>
         	</thead>
          	<tbody>
             	<?php echo $show_ListNames; ?>
          	</tbody>
		
	</table>
	</div>
</div>
</div>



<!--

<div class="Customer_details">
<div class="Title">CUSTOMER DETAILS</div>

<form name="addRegularCustomer" method= "post" action = "" autocomplete= "off">
<table class="" border="2" cellpadding="5" cellspacing="1" style="border-collapse:collapse; font:12px 
  	Verdana, Arial, Helvetica, sans-serif;">
    <tr>
        <td align="left">NAME OF THE CUSTOMER</td>
        <td>:</td>
        <td><input type="text" class="other" placeholder="Enter the Customer Name" required name="customerName" value="" size="20"/>
            <span class="mandatory" style="color:red;">*</span>
        </td>
    </tr>
    <tr>
        <td align="left">ADDRESS OF THE CUSTOMER</td>
        <td>:</td>
        <td> <textarea name="customerAddress" class="" placeholder="Enter the Address" required cols="19" rows="5"></textarea>
             <span class="mandatory" style="color:red;">*</span>
        </td>
    </tr>  
    <tr>
        <td align="left">CONTACTNO_1</td>
        <td>:</td>
        <td><input type="text" onKeyUp="checkNumeric(this.id)" maxlength="10" id="contactNo_1" class="other"
            placeholder="Enter the Customer Contact No.1" required name="contactNo_1" value="" size="20"/>
            <span class="mandatory" style="color:red;">*</span>
        </td>
    </tr>
    <tr>
        <td align="left">CONTACTNO_2</td>
        <td>:</td>
        <td><input type="text" name="contactNo_2" onKeyUp="checkNumeric(this.id)" maxlength="10" id="contactNo_2"
             placeholder="Enter the Customer Contact No" value="" size="20" />
        </td>
    </tr>  
    <tr>
        <td><label for="creditPlan">CREDIT PLAN</label></td>
        <td>:</td>
        <td>
            <span class="forMandatory"></span>
            <select name="creditPlan" id="creditPlan" style="width: 130px" >
            <option value="0">Select</option>
            <?php //echo $strListCreditPlan;?>
            </select>
        </td>
    </tr>
    <tr>
        <td align="left">CREDIT LIMIT</td>
        <td>:</td>
        <td><input type="text" name="creditLimit" onKeyUp="checkNumeric(this.id)" maxlength="10" id="creditLimit"
             placeholder="Enter Credit limit" value="" size="20" />
        </td>
    </tr>
    <tr>
        <td align="left">PROFIT ITEM DISCOUNTPERCENT</td>
        <td>:</td>
        <td><input type="text" name="profitItemDiscountPercent" onKeyUp="checkNumeric(this.id)" maxlength="10" id="profitItemDiscountPercent"
             placeholder="Enter profit Item DiscountPercent" value="" size="20" />
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td align="right"><input type="submit" name="submit" id="submit" value="SAVE"></td>
    </tr>
</table>           
<table align="left" border="2" cellpadding="5" cellpadding="1" style="font-family:Arial, Helvetica, sans-serif; text-indent: 10px;">
 <p>&nbsp;  </p>
 <b>VIEW PAGE:</b>
<?php 
	$show_ListNames = $objC_customer->listCustomerDetails();
?>
 	<tr> <th>SL NO</th> 
    	 <th>CUSTOMER NAME</th> 
         <th>ADDRESS</th>   
		 <th>CUSTOMER NO</th>   
         <th>CONTACTNO_1</th>  
         <th>CONTACTNO_2</th>
         <th>CREDIT PLAN</th>
         <th>CREDIT LIMIT</th>
         <th>PROFIT ITEM DISCOUNTPERCENT</th> 
         <th></th></tr>
         <tbody>
         <?php echo $show_ListNames; ?>
          </tbody>
         </table>
         </form>
-->




<STYLE>
.dataTables_filter {
   float: left !important;
}

#table_id_paginate .paginate_button current{
	background-color:#000 !important;
}

#table_id_length{
	 margin-left:10%;
}

table.dataTable thead th {
    border-bottom: 0px solid #111;
}
 
table.dataTable tfoot td {
    border-top: 0px solid  #111;
}

table td ,table th {
	border:0.5px solid #e4e4da;
	border-collapse:collapse;
}

.paginate_button{
	background: #d9edf7 !important;
    border-radius: 50px !important;
	
}


form{
	margin-bottom:0px !important;}
	
#table_id th , #table_id td {
	font-size:13px !important;
}
#table_id td {
	padding : 2px !important;
}

</STYLE>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript"  src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">



<script>


function getSalesArea(){
	console.log('getSalesArea function called.');
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


$(document).ready( function () {
	$.noConflict();
    $('#table_id').DataTable({
		
		"dom": '<"toolbar">frltip',
		'aoColumnDefs': [{'bSortable': false,'aTargets':[1,2,8]}]
	});
   
   $("div.toolbar").html('<button type="button" style="float:right" class="btn btn-info" data-toggle="modal" data-target="#addCustomerModal">&nbsp; ADD</button>');
   getSalesArea();
});
</script>
