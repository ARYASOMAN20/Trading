<?php
require_once('../../../../settings/path.php');
require_once('../../../../modules/regularCustomer/admin/controller/customerVoucherController.php');
require('../../../../libraries/class/utils.php');
		

$objUtils       = new Utils();
$objCustomerVoucherController = new customerVoucherController();

if (isset($_POST['search'])) {
    $customerId       = $_POST['customerId'];
    $arrSearchResult   = $objCustomerVoucherController->searchByCustomerId($customerId);
    $currentBalanceReceiverAmount         = $arrSearchResult['currentBalanceReceiverAmount'];
	$regularCustomerId        			= $arrSearchResult['regularCustomerId'];
   
}

if (isset($_POST['save'])) {

    $regularCustomerId          	  = $_POST['regularCustomerId'];
	$customerNo = $_POST['customerNo1'];
	$customers = explode('|',$customerNo);
	$customerName = $customers[1];
    $currentBalanceReceiverAmount   = $_POST['currentBalanceReceiverAmount'];
    $amount   						 = $_POST['amount'];
    //$date               				= $_POST['date'];
   	$date          				   = $_POST['date'];
   	$objUtils->strDate = $date;
   	$formatedDate       = $objUtils->formatDate();
	
	   
 	$saveCustomerDetails = $objCustomerVoucherController->saveCustomerDetails($customerName,$regularCustomerId, $currentBalanceReceiverAmount, $amount, $formatedDate);
    //$formatedDate = $objStudent_readmissionController->formatDate($date);
}
?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="../../../../libraries/js/validationsScript.js"></script>



<script>
$(function(){
 $("#customerNo").autocomplete({
   source: function(request, response) {
     var item1 = $('#customerNo').val();
     $.getJSON("../../../../modules/receipt/admin/ajax/custNoAutoComplete1.php", {
		 term  : $('#customerNo').val()}, 
              response
	 );
	
  },
      minLength: 0,
      focus: function( event, ui ) {
    //$("#model").autocomplete("search", "");
        $("#customerNo").html( ui.item.value );
        return false;
      },
      select: function( event, ui ) {
        $( "#customerNo" ).val( ui.item.value );
		$( "#customerNo1" ).val( ui.item.value );
        $("#customerId").val( ui.item.key );
        return false;
      } 

   });
 
});

window.onload = function()
{ 
 displayCalender("date"); 
}


function CheckCreditBalance(creditBalance)
{
	
	var creditBalance = document.getElementById("currentBalanceReceiverAmount").value;
	var typingAmount  = document.getElementById("amount").value;
	if(parseFloat(creditBalance) >= parseFloat(typingAmount)){
		
		
		//alert("ok");
		return true;
	}
	else
	{
		//return false;
		alert("Possible Amount is "+creditBalance);
		document.getElementById("amount").value =0;
	}
}

</script>



<h4></h4>


	<div class="col-sm-8 col-md-8 col-lg-8">
    	<div class="widget-box widget-color-blue">
        	<div class="widget-header">
            	<h5 class="widget-title bigger lighter ui-sortable-handle"><b>
                CUSTOMER VOUCHER
                </b></h5>
            </div>
            <div class="widget-body">
             <form  method="post" action="">
            	<div class="row">
                	
                        <div class="form-group" id="container" style="padding-top: 10px;" >
                            <label class="col-sm-2 control-label no-padding-right" style="width: 19%;">
                              <?php $objPath->getLabel('CUSTOMER NO', $lang); ?> <span style="color:#F00" class="mandatory">*</span>
                            </label> 
                            <div class="col-sm-5 input-group">
                               <input type="text" name="customerNo" id="customerNo" onkeyup="checkValidCustomerNo(this.value);" class="form-control input-sm" maxlength="30" autocomplete="off"/>
                               <input name="customerId" type="hidden" id="customerId" value=""/>
                                <span class="input-group-btn">
                                    <button type="submit" name="search" id="search" class="btn btn-sm btn-info" 
                                    		style="padding:5px 8px 5px 8px !important;">
                                        <i class="fa fa-search"></i>  
                                    </button>
                                </span>
                            </div>  
                        </div>
                  
                    </div>
                    
                  
                    </form>



<?php if (isset($_POST['search'])) {?>


<form action="" method="POST">
 <div class="row">
                            <div class="col-sm-8 col-md-8 col-lg-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"></h3>
                </div>
                <div class="panel-body">
               <input type="hidden" name="regularCustomerId" id="regularCustomerId" value="<?php echo $regularCustomerId;?>"   class="form-control input-sm"> 
                <div class="form-group">
                  <label>Current Balance</label><span class="mandatory"></span>
                  <input type="text" name="currentBalanceReceiverAmount" id="currentBalanceReceiverAmount" value="<?php echo $currentBalanceReceiverAmount;?>"  class="form-control input-sm" readonly>
                  <input name="customerNo1" type="hidden" id="customerNo1" value="<?php echo  $_POST['customerNo']?>"/>
               </div>
                    <div class="form-group">
                        <label for="date">Date</label> <span style="color:#F00" class="mandatory">*</span>
                              <input name="date" type="text" class="form-control input-sm datepicker" id="date" required="required" >
                    </div>
                    <div class="form-group" >
                        <label for="applicationNo">Amount</label>
                        <span style="color:#F00" class="mandatory">*</span>
                        <input type="text"   name="amount" id="amount" class="form-control input-sm"
                autocomplete="off" onkeyup="CheckCreditBalance(this.id)">

                 
                    </div>
                     <div class="form-group">
                    <button type="submit" name="save" id="save" class="btn btn-sm btn-info" 
                                    		style="padding:5px 8px 5px 8px !important;">
                                       Update  
                                    </button>
                                    </div>
                    </div>
                    </div>
                    </div>
                    </div>
                 
                    </div>
                    </div>
                    </div>
   </form>











<?php /*?>


<form action="" method="POST">
<div class="col-md-5">
 <input type="hidden" name="regularCustomerId" id="regularCustomerId" value="<?php echo $regularCustomerId;?>"   class="form-control input-sm">
<div class="form-group">
                  <label>Current Balance</label> <span class="mandatory"></span>
                  <input type="text" name="currentBalanceReceiverAmount" id="currentBalanceReceiverAmount" value="<?php echo $currentBalanceReceiverAmount;?>"  class="form-control input-sm">
               </div>
               
 <div class="form-group">
                  <label>Amount</label> <span class="mandatory"></span>
                  <input type="text" name="amount" id="amount"   class="form-control input-sm">
               </div>
 <div class="form-group">
                  <label>Date</label> <span class="mandatory"></span>
                  <input type="date" name="date" id="date"   class="form-control input-sm">
               </div> 
     <div class="form-group">           
               <button type="submit"   id="save" name="save"  class="btn btn-success">
         <i class="fa fa-plus"></i> SAVE
         </button>
        </div> 
 </div> 
 
 </form>                   <?php */?>      
<?php } ?>


<?php /*?>


 
<div class="row">
   <div class="col-sm-4 col-md-4 col-lg-4">
      <div class="box box-solid box-primary">
         <div class="box-header">
            <h3 class="box-title">Search Student</h3>
         </div>
         <div class="box-body">
            <form method="post" name="searchStudentForm" action="<?php echo $objPath->setAction('readmission','schoolMaster')?>">
               <div class="form-group">
                  <label for="admission number">Admission Number</label> <span style="color:#F00" class="mandatory">*</span>
                  <input type="text" name="admissionNumber" id="admissionNumber" placeholder="" class="form-control input-sm"    required  >
               </div>
               <div class="form-group">
                  <button name="search" type="submit" class="btn btn-primary" id="search" value="Search">
                  <i class="fa fa-search"></i> Search                    </button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<?php if (isset($_POST['search'])) {?>
<form action="" method="POST">
 <div class="row">
   <div class="col-sm-6 col-md-6 col-lg-6">
      <div class="box box-solid box-info">
         <div class="box-header">
            <h3 class="box-title">BASIC DETAILS</h3>
         </div>
         <div class="box-body">
            <form method="post" name="searchStudentForm" action=" <?php echo $objPath->setAction('readmission','schoolMaster')?>">
               <input type="hidden" name="studentId" id="studentId" value="<?php echo $studentId;?>"  class="form-control input-sm">
               <div class="form-group">
                  <label>Name Of Student </label> <span class="mandatory"></span>
                  <input type="text" name="studentName" id="studentName" value="<?php echo $studentName;?>"  class="form-control input-sm" disabled="disabled">
               </div>
               <div class="form-group">
                  <label>Class Semester</label> <span class="mandatory"></span>
                  <input type="text" name="classSemester" id="classSemester" value="<?php echo $classSemesterName;?>" disabled="disabled" class="form-control input-sm" >
               </div>
               <div class="form-group">
                  <label>Division</label> <span class="mandatory"></span>
                  <input type="text" name="division" id="division" value="<?php echo $divisionName;?>" disabled="disabled" class="form-control input-sm" >
               </div>
               <div class="form-group">
                  <label>Nationality</label> <span class="mandatory"></span>
                  <input type="text" name="nationality" id="nationality" value="<?php echo $nationality;?>" disabled="disabled" class="form-control input-sm">
               </div>
               <div class="form-group">
                  <label>Company Paid Status </label> <span class="mandatory"></span>
                  <input type="text" name="companyPaidStatus" id="companyPaidStatus" value="<?php echo $companyPaidStatus;?>" readonly class="form-control input-sm">
               </div>
         </div>
      </div>
   </div>
  <div class="col-sm-6 col-md-6 col-lg-6">
   <div class="box box-solid box-success">
      <div class="box-header">
         <h3 class="box-title">RE-ADMISSION DETAILS</h3>
      </div>
      <div class="box-body">
         <div class="form-group">
            <label>Academic Period</label> <span class="mandatory" style="color:#F00">*</span>
            <select name="academicPeriodId" id="academicPeriodId" required="required" class="form-control input-sm">
               <option value="">select</option>
               <?= $objStudent_readmissionController->ListAllAcademicPeriod();?>                        
            </select>
         </div>
         <div class="form-group">
            <label>Class Semester</label> <span class="mandatory" style="color:#F00">*</span>
            <select name="classSemesterId" id="classSemesterId" onchange="listDivisionByClass()" required="required" class="form-control input-sm">
               <option value="">select</option>
               <?= $objStudent_readmissionController->ListAllClassSemester();?>                        
            </select>
         </div>
         <div class="form-group">
            <label>Division</label> <span class="mandatory" style="color:#F00">*</span>
            <select name="divisionId" id="divisionId" class="form-control input-sm" required="required">
               <option value="">Select</option>
            </select>
         </div>
         <div class="form-group">
            <label>Readmission Date</label> <span class="mandatory" style="color:#F00">*</span>
            <input type="text" name="readmissionDate" id="readmissionDate"  placeholder="" class="form-control input-sm" required="required">
         </div>
         <button type="submit"   id="save" name="save"  class="btn btn-success">
         <i class="fa fa-plus"></i> SAVE
         </button>
         </form>
      </div>
   </div>
</div>
</div>
</div>
<?php } ?><?php */?>